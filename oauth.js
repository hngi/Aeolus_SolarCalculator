$('#google-button').on('click', function() {
	// Initialize with your OAuth.io app public key
	OAuth.initialize('AIzaSyA1MQ2XPfFzyhWP0sxnixXupaOKFK0tcLs');
  // Use popup for oauth
  // Alternative is redirect
  OAuth.popup('google').then(google => {
    console.log(google);
    // Retrieves user data from oauth provider
    console.log(google.me());
	});
})