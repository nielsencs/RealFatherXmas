// Load the API client and authenticate with your API key or OAuth 2.0 client ID
gapi.load('client', function() {
    API_KEY = 'AIzaSyDbOhFJIKFUzqN2NXJAatJs2oYUFwpjNQE'

    gapi.client.init({
      apiKey: API_KEY,
      discoveryDocs: ['https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest'],
      clientId: 'YOUR_CLIENT_ID',
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
      // Format the events into HTML and display them on your website
      // ...
    });
  });
  