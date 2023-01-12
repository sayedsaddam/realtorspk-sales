<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <title><?= $title; ?></title>
</head>
<style>
body {
    font-family: "Lato", sans-serif;
}   
.main-head{
    height: 150px;
    background: #FFF;  
}
.sidenav {
    height: 100%;
    background-color: purple;
    overflow-x: hidden;
    padding-top: 70px;
}
.main {
    padding: 0px 10px;
}
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
}
@media screen and (max-width: 450px) {
    .login-form{
        margin-top: 10%;
    }
    .register-form{
        margin-top: 10%;
    }
}
@media screen and (min-width: 768px){
    .main{
        margin-left: 40%; 
    }
    .sidenav{
        width: 40%;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
    }
    .login-form{
        margin-top: 80%;
    }
    .register-form{
        margin-top: 20%;
    }
}
.login-main-text{
    margin-top: 20%;
    padding: 60px;
    color: #fff;
}
.login-main-text h2{
    font-weight: 300;
}
.btn-black{
    background-color: #000 !important;
    color: #fff;
}
.btn-primary{
	background-color: purple;
}
.btn-primary:hover{
	background-color: #551aba;
}
</style>
<body>
    <div class="container">
        <div class="sidenav">
            <div class="login-main-text">
                <h1 class="mt-4 font-weight-bold">Realtors PK <br><span class="font-weight-light">Credentials Verification</span></h1>
                <p>Provide your credentials to further proceed with the login.</p>
                <?php if($failed = $this->session->flashdata('login_failed')): ?>
                    <div class="alert alert-danger">
                        <?php echo $failed; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="main">
            <div class="col-md-6 col-sm-12">
                <div class="login-form">
                    <form action="<?= base_url('admin/authenticate'); ?>" method="post">
                        <div class="form-group">
                            <input name="email" type="email" class="form-control" placeholder="Enter your email (Official email)..." required value="<?= set_value('email'); ?>">
                            <small class="text-danger"><?= form_error('email'); ?></small>
                        </div>
                        <div class="form-group">
                            <input name="password" type="password" class="form-control" id="passField" placeholder="Enter your password ..." required>
                            <small class="text-danger"><?= form_error('password'); ?></small>
                        </div>
						<div class="form-check mb-2">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" onclick="showPassword()">Show Password
							</label>
						</div>
                        <button type="submit" class="btn btn-primary btn-block">Continue</button>
                        <small>This might be a little hectic for you, but trust us, we're doing this just for security purposes.</small>
                    </form>
                </div>
                <?php if($not_found = $this->session->flashdata('not_found')): ?>
                    <div class="alert alert-danger mt-4">
                        <p><?= $not_found; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
	<script>
		function showPassword(){
			let passField = document.getElementById("passField");
			if(passField.type === "password"){
				passField.type = "text";
			}else{
				passField.type = "password";
			}
		}
	</script>
</body>
</html>
