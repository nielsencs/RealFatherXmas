<?php
// Contact-form spam checks (Carl, 2026-11-24). Suspect messages are still
// delivered, but marked so the mail server files them in Junk: a genuine
// enquiry caught by mistake can always be found there.

const RFX_FORM_MIN_SECONDS = 4;      // humans take longer than this
const RFX_FORM_SPAM_SCORE = 6.0;     // same line as ordinary email

/** Reasons this submission looks like spam; empty = looks genuine. */
function rfxFormSpamReasons(array $f, ?int $secondsOnPage, ?callable $scorer = null): array
{
    $reasons = [];
    $message = (string)($f['message'] ?? '');
    $all = implode(' ', [$f['name'] ?? '', $f['subject'] ?? '', $message]);

    if ($secondsOnPage === null) {
        $reasons[] = 'sent without opening the form page';
    } elseif ($secondsOnPage < RFX_FORM_MIN_SECONDS) {
        $reasons[] = "sent {$secondsOnPage}s after the page opened";
    }

    // Judge the alphabet on the message alone: an English subject line
    // must not hide a message in another script.
    preg_match_all('/\p{L}/u', $message, $letters);
    preg_match_all('/[\p{Latin}]/u', $message, $latin);
    $n = count($letters[0]);
    if ($n > 0 && (count($latin[0]) / $n) < 0.7) {
        $reasons[] = 'mostly in a non-Latin alphabet';
    }

    if (preg_match('/\b\p{L}{18,}\b/u', $all)) {
        $reasons[] = 'contains a nonsense word';
    }

    if (preg_match('~https?://|www\.~i', $message)) {
        $reasons[] = 'contains a web link';
    }

    if ($scorer) {
        $score = $scorer($f);
        if ($score !== null && $score >= RFX_FORM_SPAM_SCORE) {
            $reasons[] = 'spam filter score ' . round($score, 1);
        }
    }
    return $reasons;
}

/** Spam score from the server's filter (Rspamd), or null if unavailable. */
function rfxRspamdScore(array $f, string $clientIp): ?float
{
    if (!function_exists('curl_init')) {
        return null;
    }
    $clean = fn($v) => trim(preg_replace('/[\r\n]+/', ' ', (string)$v));
    $mail = 'From: ' . $clean($f['name'] ?? '') . ' <' . $clean($f['email'] ?? '') . ">\r\n"
        . "To: elves@realfatherxmas.com\r\n"
        . 'Subject: ' . $clean($f['subject'] ?? '') . "\r\n"
        . 'Message-ID: <' . bin2hex(random_bytes(8)) . "@form.realfatherxmas.com>\r\n"
        . "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\n\r\n"
        . (string)($f['message'] ?? '') . "\r\n";
    $ch = curl_init('http://127.0.0.1:11333/checkv2');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $mail,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 3,
        CURLOPT_HTTPHEADER => [
            'IP: ' . $clientIp,
            'Pass: all',
            'Settings: {symbols_disabled = ["GREYLIST"]}',
        ],
    ]);
    $out = curl_exec($ch);
    curl_close($ch);
    $json = is_string($out) ? json_decode($out, true) : null;
    return isset($json['score']) ? (float)$json['score'] : null;
}
