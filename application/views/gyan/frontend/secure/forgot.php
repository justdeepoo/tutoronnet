<?php $CI->partial($CI->theme.'/frontend/template/head');?>
<body>

<?php $CI->partial($CI->theme.'/frontend/secure/left-side');?>
<div class="wrapper col-lg-7 col-md-7 col-sm-6 col-xs-12 login-right">
    <div class="register-section">Already have an account?  &nbsp;&nbsp;&nbsp; <a href="<?php echo $this->root_path;?>secure/login/" class="btn btn-default">SIGN IN</a></div>
    <div class="center-col">
        <div class="login-form">
             <h2>Forgot your password?</h2>
            <p>Enter your email address below and we'll get you back on track.</p>
            <div class="form-container">
                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" class="form-control" placeholder="joe@gmail.com">
                </div>

                <button type="submit" class="btn btn-primary btn-lg">REQUEST RESET LINK</button>
            </div>
		</div>
    </div>
</div>

<?php $CI->partial($CI->theme.'/frontend/secure/footer');?>