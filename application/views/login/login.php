<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Halaman Login | Pencarian Puskesmas Online Area Parepare</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="<?=base_url()?>login_assets/images/icons/favicon.ico"/>
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/vendor/bootstrap/css/bootstrap.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/vendor/animate/animate.css">
		<!--===============================================================================================-->	
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/vendor/css-hamburgers/hamburgers.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/vendor/animsition/css/animsition.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/vendor/select2/select2.min.css">
		<!--===============================================================================================-->	
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/vendor/daterangepicker/daterangepicker.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/css/util.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>login_assets/css/main.css">
		<style type="text/css">
	      .swal-modal .swal-text{
	        text-align: center
	      }
	    </style>
		<!--===============================================================================================-->
	</head>

	<body style="background-color: #666666;">
		
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<form class="login100-form validate-form" method="post">
						<span class="login100-form-title p-b-43">
							Halaman Login
						</span>
						
						
						<div class="wrap-input100 validate-input">
							<input class="input100" type="text" name="username" id="username">
							<span class="focus-input100"></span>
							<span class="label-input100">Username</span>
						</div>
						
						
						<div class="wrap-input100 validate-input">
							<input class="input100" type="password" name="password" id="password">
							<span class="focus-input100"></span>
							<span class="label-input100">Password</span>
						</div>

						<div class="container-login100-form-btn">
							<button type="button" id="button_login" class="login100-form-btn" onclick="loginnya()">
								Login
							</button>
						</div>

					</form>

					<div class="login100-more" style="background-image: url('login_assets/images/bg-01.jpg');">
					</div>
				</div>
			</div>
		</div>
		
		

		
		
		<!--===============================================================================================-->
		<script src="<?=base_url()?>login_assets/vendor/jquery/jquery-3.2.1.min.js"></script>
		<!--===============================================================================================-->
		<script src="<?=base_url()?>login_assets/vendor/animsition/js/animsition.min.js"></script>
		<!--===============================================================================================-->
		<script src="<?=base_url()?>login_assets/vendor/bootstrap/js/popper.js"></script>
		<script src="<?=base_url()?>login_assets/vendor/bootstrap/js/bootstrap.min.js"></script>
		<!--===============================================================================================-->
		<script src="<?=base_url()?>login_assets/vendor/select2/select2.min.js"></script>
		<!--===============================================================================================-->
		<script src="<?=base_url()?>login_assets/vendor/daterangepicker/moment.min.js"></script>
		<script src="<?=base_url()?>login_assets/vendor/daterangepicker/daterangepicker.js"></script>
		<!--===============================================================================================-->
		<script src="<?=base_url()?>login_assets/vendor/countdowntime/countdowntime.js"></script>
		<script src="<?=base_url()?>sweet-alert/sweetalert.js"></script>
		<!--===============================================================================================-->
		<script src="<?=base_url()?>sweet-alert/toastr/toastr.min.js"></script>
	  <link rel="stylesheet" type="text/css" href="<?=base_url()?>sweet-alert/toastr/toastr.min.css">
		<!--===============================================================================================-->
		<script src="<?=base_url()?>sweet-alert/block/jquery.blockUI.js"></script> 

		<script src="<?=base_url()?>sweet-alert/url.js"></script>


		<script src="<?=base_url()?>login_assets/login.js"></script>

		<script src="<?=base_url()?>login_assets/js/main.js"></script>

		
	</body>
</html>