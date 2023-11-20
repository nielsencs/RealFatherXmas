// Load the API client and authenticate with your API key or OAuth 2.0 client ID
gapi.load('client', function() {
    const API_KEY = 'AIzaSyDbOhFJIKFUzqN2NXJAatJs2oYUFwpjNQE'
    const CLIENT_ID = '123758879436-3pof414llg0877db7mujrbeojugcaeuc.apps.googleusercontent.com'

    gapi.client.init({
      apiKey: API_KEY,
      discoveryDocs: ['https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest'],
      clientId: CLIENT_ID,
      scope: 'https://www.googleapis.com/auth/calendar.readonly'
    }).then(function() {
      // Call the Google Calendar API to retrieve the events
      return gapi.client.calendar.events.list({
        'calendarId': 'YOUR_CALENDAR_ID',
        'timeMin': (new Date()).toISOString(),
        'showDeleted': false,
        'singleEvents': true,
        'maxResults': 10,
        'orderBy': 'startTime'
      });
    }).then(function(response) {
      var events = response.result.items;
      // Format the events into an HTML table and display it on your website
      var table = '<table>';
      table += '<thead><tr><th>Event</th><th>Date</th></tr></thead>';
      table += '<tbody>';
      for (var i = 0; i < events.length; i++) {
        var event = events[i];
        var startDate = event.start.dateTime || event.start.date;
        var endDate = event.end.dateTime || event.end.date;
        table += '<tr><td>' + event.summary + '</td><td>' + startDate + ' - ' + endDate + '</td></tr>';
      }
      table += '</tbody></table>';
      document.getElementById('calendar').innerHTML = table;
    });
  });
