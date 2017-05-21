<?php $CI->partial($CI->theme.'/frontend/template/head');?>
<body>

<?php $CI->partial($CI->theme.'/frontend/secure/left-side');?>
	<div class="wrapper col-lg-7 col-md-7 col-sm-6 col-xs-12 login-right">
		<div class="register-section">
			Already have an account?   <a href="<?php echo $this->root_path;?>secure/login/" class="btn btn-default">SIGN IN</a>
		</div>
    <div class="clearfix"></div>

	<div class="center-col">	<br>
        <div class="login-form">
            <h2>Create a free account now to get started.</h2>
            
            <div class="form-container">
                <h4>I am currently a</h4>
                <div class="form-group">
					<label class="radio-inline">
						<input type="radio" name="user_type"   value="2">STUDENT
					</label>
					<label class="radio-inline">
						<input type="radio" name="user_type" value="3">TUTOR
					</label>
                </div>
                <h5>&nbsp;</h5>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email address">
                </div>
                <div class="form-group" style="margin-bottom: 0px">
					<div class="row">
						<div class="col-md-6" style="padding-bottom: 0px">
							<label>First Name</label>
							<input type="text" class="form-control" name="first_name" placeholder="Enter your first name">
						</div>
						<div class="col-md-6" style="padding-bottom: 0px">
							<label>Last Name</label>
							<input type="text" class="form-control" name="last_name" placeholder="Enter your last name">
						</div>
					</div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                     <input type="password" class="form-control" name="password" placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <label>School</label>
                    <select class="form-control" name="grade">
                        <option>Select your school</option>
                    </select>
                </div>
                <div class="form-group">
                    <p>
						<small>By creating an account you agree to Tutor on Net 
						<a href="/privary-policy/">Privacy Policy</a> and 
						<a href="/terms-of-use/">Terms of Use</a>.</small>
					</p>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">CREATE ACCOUNT</button>
            </div>

        </div>
    </div>
</div>
<?php $CI->partial($CI->theme.'/frontend/secure/footer');?>