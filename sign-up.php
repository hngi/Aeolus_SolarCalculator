<?php

session_start();

if (isset($_SESSION['loggedin'])) {
	sleep(1);
	header('Location: /dashboard.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Login | Solar Calculator &rsaquo; HNG 6 Team Aeolus</title>

	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Open+Sans:400,600|Roboto:300,400,500&display=swap" rel="stylesheet"> 

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="./assets/dashboard.css">

	<link rel="icon" href="./assets/S-ico.png">
</head>
<body>
	<div class="body-wrapper pb-5 mb-5">
		<div class="innerbody">
			<header class="header">
				<div class="header-wrapper">
					<a href="/"><div class="logo">
						<svg height="33" viewBox="0 0 45 59" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M22.3722 11.76C20.2922 11.76 18.6389 12.2667 17.4122 13.28C16.2389 14.24 15.6522 15.5467 15.6522 17.2C15.6522 18.8 16.3722 20.08 17.8122 21.04C19.3055 22 22.6922 23.1467 27.9722 24.48C33.3055 25.76 37.4389 27.7067 40.3722 30.32C43.3055 32.9333 44.7722 36.7467 44.7722 41.76C44.7722 46.7733 42.8789 50.8533 39.0922 54C35.3589 57.0933 30.4255 58.64 24.2922 58.64C15.4389 58.64 7.46552 55.36 0.372188 48.8L7.81219 39.68C13.8389 44.96 19.4122 47.6 24.5322 47.6C26.8255 47.6 28.6122 47.12 29.8922 46.16C31.2255 45.1467 31.8922 43.8133 31.8922 42.16C31.8922 40.4533 31.1989 39.12 29.8122 38.16C28.4255 37.1467 25.6789 36.1333 21.5722 35.12C15.0655 33.5733 10.2922 31.5733 7.25219 29.12C4.26552 26.6133 2.77219 22.72 2.77219 17.44C2.77219 12.1067 4.66552 8 8.45219 5.12C12.2922 2.24 17.0655 0.799997 22.7722 0.799997C26.5055 0.799997 30.2389 1.44 33.9722 2.72C37.7055 4 40.9589 5.81333 43.7322 8.16L37.4122 17.28C32.5589 13.6 27.5455 11.76 22.3722 11.76Z" fill="#0099FF"/>
						</svg>
					</div></a>
				</div>
			</header>
			<main>
				<div class="container mt-5 pt-5">
					<div class="row">
						<div class="col-md-5 mx-auto">
							<div class="alert alert-danger d-none" role="alert" id="err-msg"></div>
							<form id="xhlogin" class="needs-validation" novalidate autocomplete="off">
								<div class="form-row">
								    <div class="col-md-12 mb-3">
								        <label for="name">Name</label>
								        <input type="text" name="name" class="form-control" id="name" placeholder="ex. John Doe" required>
								        <div class="invalid-feedback">
								            Please provide your name
								        </div>
								    </div>
								    <div class="col-md-12 mb-3">
								        <label for="email">Email</label>
								        <input type="email" name="email" class="form-control" id="email" placeholder="my@email.com" required>
								        <div class="invalid-feedback" id="email-if">
								            Please provide your registered email address
								        </div>
								    </div>
								    <div class="col-md-12 mb-3">
								        <label for="password">Password</label>
								        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
								        <div class="invalid-feedback">
								            Please provide your password
								        </div>
								    </div>
								</div>
								<div class="mt-4">
									<button type="button" id="login" class="btn w-100 btn-primary btn-md mb-3">
										<span id="lgntxt">
											Sign Up
										</span>
										<span id="spinlgn" class="d-none spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									</button>
									<button type="button" class="btn w-100 btn-primary mb-1" style="background-color:#dd4b39;border-color:#dd4b39">Continue with Google</button>
									<div class="text-center"><small>
										Already have an account? <a href="/my-account.php">Access your account</a>
									</small></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
	// Example starter JavaScript for disabling form submissions if there are invalid fields
	$(function() {

		$('#email').on('blur keyup', validate_email);

		function validate_email(e) {

			var email = $('#email').val();

			var $t = $(e.currentTarget);
			var $e = $(e.originalEvent);

			$t.addClass('loading').removeClass('invalid error success');

			var data = {
				email: email
			};


			$.ajax({
				type: 'POST',
				url: '/api/email-exists.php',
				data: data,
				dataType: "JSON",
				cache: false,
				success: function(response){
					if (response.code == 'd030') {
						$t.removeClass('loading');
					} else if (response.code == 'f030') {
						$t.addClass('invalid error').removeClass('loading');
						$('#email-if').css({'display':'block'}).text('Email address is not valid')
					} else if (response.code == 109) {
						$t.addClass('invalid error').removeClass('loading');
						$('#email-if').css({'display':'block'}).text('The email has already been taken')
					} else {
						if (response.code == 110) {
							$('#email-if').css({'display':'none'})
							$t.addClass('success').removeClass('loading invalid error');
						}	
					}
				}
			});
		}

		$.fn.isValid = function(){
			return this[0].checkValidity()
		}

		form = $('form#xhlogin');

		form.on('click', function(e) {
			e.preventDefault();
			e.stopPropagation();

	        if (form.isValid() === false) {
	        } else {
				$('#lgntxt').hide();
				$('#spinlgn').removeClass('d-none');

				let form = document.forms['xhlogin'];

				let fd = new FormData(form);

				let data = {};

				for (let [key, prop] of fd) {
				  data[key] = prop;
				}

				assets = JSON.stringify(data, null, 2);

				var regcol = {
					name: $('#name').val(),
					email: $('#email').val(),
					password: $('#password').val()
				};

				$.ajax({
					type: 'post',
					url: '/api/register.php',
					data: regcol,
					dataType: "JSON",
					success: function(json){
						if (json.status == false) {
							$('#lgntxt').show();
							$('#spinlgn').addClass('d-none');
							$('#err-msg').html('We are unable to register you. Try again.');
							$('#err-msg').removeClass('d-none');
						}
						if (json.status == true) {
							$('#lgntxt').show();
							$('#spinlgn').addClass('d-none');
							$('#err-msg').html('<strong>Success:</strong>&nbsp;You are now registered. Redirecting to login.');
							$('#err-msg').addClass('alert-success').removeClass('alert-danger d-none');

							setTimeout(function(){ window.location = '/my-account.php'; }, 3000);
						}
					}
				});
	        }
			form.addClass('was-validated');
		});		
	})
	</script>
</body>
</html>