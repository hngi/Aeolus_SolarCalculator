$('#google-button').on('click', function() {
	// Initialize with your OAuth.io app public key
	OAuth.initialize('K1PQlRVXc63StttFrZGj4V68dpY');
  // Use popup for oauth
  // Alternative is redirect
  OAuth.popup('google').then(google => {
    console.log(google);
    // Retrieves user data from oauth provider
    console.log(google.me());
	});
})