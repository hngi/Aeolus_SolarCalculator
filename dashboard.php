<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Solar Calculator &rsaquo; HNG 6 Team Aeolus</title>

	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Open+Sans:400,600|Roboto:300,400,500&display=swap" rel="stylesheet"> 

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="./assets/dashboard.css">

	<link rel="icon" href="https://res.cloudinary.com/andikan/image/upload/v1570152012/S-ico_gvjpel.png">
</head>
<body>
	<div class="body-wrapper">
		<div class="innerbody">
			<header class="header">
				<div class="header-wrapper">
					<a href="/"><div class="logo">
						<svg height="33" viewBox="0 0 45 59" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M22.3722 11.76C20.2922 11.76 18.6389 12.2667 17.4122 13.28C16.2389 14.24 15.6522 15.5467 15.6522 17.2C15.6522 18.8 16.3722 20.08 17.8122 21.04C19.3055 22 22.6922 23.1467 27.9722 24.48C33.3055 25.76 37.4389 27.7067 40.3722 30.32C43.3055 32.9333 44.7722 36.7467 44.7722 41.76C44.7722 46.7733 42.8789 50.8533 39.0922 54C35.3589 57.0933 30.4255 58.64 24.2922 58.64C15.4389 58.64 7.46552 55.36 0.372188 48.8L7.81219 39.68C13.8389 44.96 19.4122 47.6 24.5322 47.6C26.8255 47.6 28.6122 47.12 29.8922 46.16C31.2255 45.1467 31.8922 43.8133 31.8922 42.16C31.8922 40.4533 31.1989 39.12 29.8122 38.16C28.4255 37.1467 25.6789 36.1333 21.5722 35.12C15.0655 33.5733 10.2922 31.5733 7.25219 29.12C4.26552 26.6133 2.77219 22.72 2.77219 17.44C2.77219 12.1067 4.66552 8 8.45219 5.12C12.2922 2.24 17.0655 0.799997 22.7722 0.799997C26.5055 0.799997 30.2389 1.44 33.9722 2.72C37.7055 4 40.9589 5.81333 43.7322 8.16L37.4122 17.28C32.5589 13.6 27.5455 11.76 22.3722 11.76Z" fill="#0099FF"/>
						</svg>
					</div></a>
					<div class="extra-link d-none">
						<div class="text-right text-capitalize">
							<a href="#" class="btn btn-primary btn-sm">Login</a>
							<a href="#" class="btn btn-warning btn-sm">Register</a>
						</div>
					</div>
				</div>
			</header>
			<main>
				<div class="new-container mx-auto d-none">
					<a href="#" class="btn btn-primary btn-sm">Create New Calculation</a><br>
				</div>
				<div class="app mt-5 pt-3 pb-5">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-lg-3 mb-5">
										<div class="form-layout wbg">
											<div class="f-head">New Appliance</div>
											<form>
												<div class="form-row" id="load-calc">
													<div class="row mt-5">
														<div class="form-group col-sm-12 mb-3">
															<label for="name">Appliance Name</label>
															<input type="text" id="name" class="form-control" placeholder="Radio" name="apname" value="Radio">
														</div>
														<div class="form-group col-sm-12 col-md-6 mb-3">
															<label for="qty">Quantity</label>
															<input type="number" id="qty" class="form-control" value="1" name="qty">
														</div>
														<div class="form-group col-sm-12 col-md-6 mb-3">
															<label for="watts">Wattage</label>
															<input type="number" id="watts" class="form-control" name="watts" value="100">

														</div>
														<div class="form-group col-sm-12 mb-3">
															<label for="hrs">Duration in Hours</label>
															<input type="number" max="24" id="hrs" class="form-control" placeholder="Maximum Hour is 24" name="hrs" value="24">
														</div>
													</div>
												</div>
												<div class="text-right mt-3 mb-2">
													<button id="clearform" type="button" class="btn btn-sm btn-warning">Reset</button>
													<input class="btn btn-sm btn-primary" type="submit" id="addTa" value="Add Appliance">
												</div>
											</form>
										</div>
									</div>
									<div class="col-lg-9">
										<div class="wbg">
											<div class="form-layout">
												<div class="mb-4">
													<h4>
														Total Consumption &mdash; <span id="totalword"></span>
														<input type="hidden" name="total" id="total_rate" value="0">
													</h4>
												</div>
												<div id="tda" class="table-responsive">
													<table class="table table-striped" id="apptable">
													  <thead>
													    <tr class="d-flex">
													      <th scope="col" class="col-3">Name</th>
													      <th scope="col" class="col-2">Units</th>
													      <th scope="col" class="col-2">Watts</th>
													      <th scope="col" class="col-2">Hours On/Day</th>
													      <th scope="col" class="col-2">Watt Hours/Day</th>
													      <th scope="col" class="col-1">Action</th>
													    </tr>
													  </thead>
													  <tbody id="dinam"></tbody>
													</table>
												</div>
												<div class="extra-btn py-2 mt-3 text-md-right">
													<a href="#" class="btn btn-success btn-md mb-2 d-none">Save Calculations</a>
													<button type="button" class="btn btn-mail btn-md mb-2" id="exprcal">Export Calculations to mail</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Export</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form>
		          <div class="form-group">
		            <label for="name" class="col-form-label">Full Name:</label>
		            <input type="text" class="form-control" id="fname">
		          </div>
		          <div class="form-group">
		            <label for="mail" class="col-form-label">Email Address:</label>
		            <input type="email" class="form-control" id="mail">
		          </div>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button id="send-email" type="button" class="btn btn-primary">Send message</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="./assets/dashboard.js"></script>
</body>
</html>