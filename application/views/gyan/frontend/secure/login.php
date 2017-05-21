<?php $CI->partial($CI->theme.'/frontend/template/head');?>
<body>

<?php $CI->partial($CI->theme.'/frontend/secure/left-side');?>
<div class="wrapper col-lg-7 col-md-7 col-sm-6 col-xs-12 login-right">
    <div class="register-section">Don't have an account yet? &nbsp;&nbsp;&nbsp; <a href="<?php echo $this->root_path;?>secure/signup/" class="btn btn-default">GET STARTED</a></div>
    <div class="center-col">
        <div class="login-form">
             <h2>Sign in to Tutors On Net</h2>
            <p>Enter your details below</p>
            <div class="form-container">
                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" class="form-control" placeholder="joe@gmail.com">
                </div>
                <div class="form-group">
                    <label>PASSWORD</label>
                    <a href="<?php echo $this->root_path;?>secure/forgot-password/" class="pull-right">Forgot Password?</a>
                    <input type="password" class="form-control" placeholder="Enter Your Password">
                </div>

                <button type="submit" class="btn btn-primary btn-lg">SIGN IN</button>
            </div>

            <div class="social-login">
                <p>Login using your social account</p>
                <h4 class="text-center">
                    <a href=""><img src="<?php echo $this->MEDIA_URl;?>facebook-login.png"> </a>
                    <a href=""><img src="<?php echo $this->MEDIA_URl;?>google-login.png"> </a>
                </h4>
            </div>

        </div>
    </div>
</div>

<?php $CI->partial($CI->theme.'/frontend/secure/footer');?>