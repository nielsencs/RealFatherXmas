<?php
// php tests/formSpamCheck.php [dir-of-.eml]  - checks the form spam rules.
require __DIR__ . '/../site/formSpam.php';
$fail = 0;
function check($ok, $label) { global $fail; echo ($ok ? 'PASS ' : 'FAIL ') . $label . "\n"; if (!$ok) $fail++; }

$genuine = ['name' => 'Sarah Jones', 'email' => 'sarah@example.com', 'subject' => 'School fair',
    'message' => 'Hello, we are holding our school Christmas fair on Saturday 12 December in Stockport. Could Father Christmas visit the grotto from 11am to 2pm? Thanks, Sarah'];
check(rfxFormSpamReasons($genuine, 60) === [], 'genuine enquiry passes');
check(rfxFormSpamReasons($genuine + ['x' => 1], 2) !== [], 'too fast is suspect');
check(rfxFormSpamReasons($genuine, null) !== [], 'no page-open time is suspect');
check(rfxFormSpamReasons(['name' => 'R', 'message' => 'Hi, მინდოდა ვიცოდე თქვენი ფასი.'], 60) !== [], 'Georgian is suspect');
check(rfxFormSpamReasons(['name' => 'R', 'subject' => 'Hello i wrote about your the price', 'message' => 'হাই, আমি আপনার মূল্য জানতে চেয়েছিলাম.'], 60) !== [], 'Bengali under an English subject is suspect');
check(rfxFormSpamReasons(['name' => 'Ana', 'message' => 'Déjà vu, Zoë and Siân visit Dürer'], 60) === [], 'accented Latin passes');
check(rfxFormSpamReasons(['name' => 'X', 'message' => 'Gfihudwgfyehjwowjifwhu fuehiq'], 60) !== [], 'nonsense word is suspect');
check(rfxFormSpamReasons(['name' => 'X', 'message' => 'see https://example.com'], 60) !== [], 'link is suspect');
check(rfxFormSpamReasons($genuine, 60, fn() => 7.0) !== [], 'high filter score is suspect');
check(rfxFormSpamReasons($genuine, 60, fn() => null) === [], 'filter down: no false alarm');

// Optional: real spam captured from the mailbox (not in the repo).
if (isset($argv[1])) {
    $caught = 0; $total = 0;
    foreach (glob($argv[1] . '/spam*.eml') as $file) {
        $raw = file_get_contents($file);
        preg_match('/^Name: (.*)$/m', $raw, $n); preg_match('/^Email: (.*)$/m', $raw, $e);
        preg_match('/^Subject: (.*)$/m', $raw, $s);
        $msg = trim(substr($raw, strpos($raw, "\nMessage:\n") + 10));
        $f = ['name' => $n[1] ?? '', 'email' => $e[1] ?? '', 'subject' => $s[1] ?? '', 'message' => $msg];
        $r = rfxFormSpamReasons($f, 60, fn($f) => rfxRspamdScore($f, '8.8.4.4'));
        $total++; if ($r) $caught++;
        if (!$r) echo "  missed: " . mb_substr(preg_replace('/\s+/', ' ', $msg), 0, 60) . "\n";
    }
    echo "Real form spam caught (without the timing check): $caught of $total\n";
}
exit($fail ? 1 : 0);
