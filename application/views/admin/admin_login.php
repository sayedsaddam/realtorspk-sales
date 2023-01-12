<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <title>Login | Realtors PK</title>
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
                <h1 class="mt-4 font-weight-bold">Realtors PK<br> Portal Login</h1>
                <p>Enter the verification code sent to you via email to proceed.</p>
                <?php if($otp_sent = $this->session->flashdata('otp_sent')): ?>
                    <div class="alert alert-primary">
                        <?php echo $otp_sent; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="main">
            <div class="col-md-6 col-sm-12">
                <div class="login-form">
                    <form action="<?= base_url('admin/login'); ?>" method="post">
                        <div class="form-group">
                            <label for="security_code">Security Code</label>
                            <input name="otp" type="password" class="form-control" placeholder="Security code" maxlength="6" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Continue</button>
                    </form>
                </div>
                <?php if($failed = $this->session->flashdata('login_failed')): ?>
                    <div class="alert alert-danger mt-3">
                        <?= $failed; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
