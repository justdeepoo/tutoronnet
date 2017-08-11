<?php $CI->partial($CI->theme.'/frontend/template/head');?>
<body>

<?php $CI->partial($CI->theme.'/frontend/secure/left-side');?>
<div class="wrapper col-lg-7 col-md-7 col-sm-6 col-xs-12 login-right">
    <div class="register-section">Don't have an account yet? &nbsp;&nbsp;&nbsp; <a href="<?php echo $this->root_path;?>secure/signup/" class="btn btn-default">GET STARTED</a></div>
    <div class="center-col">
        <form method="post" name="login-form" id="login-form" action="#">
            <div class="login-form">
                 <h2>Sign in to Tutors On Net</h2>
                <p>Enter your details below</p>
                <div class="form-container">
                    <div class="alert hide"></div>
                    <div class="form-group">
                        <label>EMAIL ADDRESS</label>
                        <input type="email" name="email" id="email" class="form-control mandate" data-valid-type="nEmpty email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label>PASSWORD</label>
                        <a href="<?php echo $this->root_path;?>secure/forgot-password/" class="pull-right">Forgot Password?</a>
                        <input type="password" data-valid-type="nEmpty" name="password" id="password" class="form-control mandate" placeholder="Enter Your Password">
                    </div>

                    <input name="submitted" value="true" type="hidden">
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
        </form>
    </div>
</div>

<?php $CI->partial($CI->theme.'/frontend/secure/footer');?>