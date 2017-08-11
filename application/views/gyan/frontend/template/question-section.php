 <section class="container tab-section">
       <h1 class="text-capital text-center">Earn better grades with <span class="blue-color">24/7 homework help</span> </h1>
        <h2 class="text-center grey-50">Get step-by-step answers from expert tutors.</h2>
        <div class="level-section">
             <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Level One <br><span>Post quick questions and get answers from multiple tutors</span></a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Level Two <br><span>Get one-on-one help working with an assigned turor</span></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
				<?php
					if(isset($error_message))
					{
						echo '<div class="error-message message-box">'.$error_message.'</div>';
					}
				?>
				<form method="post" action="<?php echo base_url();?>secure/post_question" name="question-form" id="question-form">
					
					<div role="tabpanel" class="tab-pane active" id="home">
						<?php echo $this->ckeditor->editor('question');?>
						<div class="form-group">
							<input class="form-control" style="width:140px" type="file">
						</div>
					   
						<div class="field-set">
								 <div class="form-group">
									<select class="form-control" name="subject">
										<option value="">Select Subject</option>
										<?php
											if($subjects->num_rows())
											{
												foreach($subjects->result() as $key=>$value)
												{
													echo '<option value="'.$value->id.'">'.$value->subject.'</option>';
												}
											}
											
										?>
									</select>
								</div>
							<div class="btn-holder">
								 <button type="submit" class="btn btn-primary btn-lg btn-block">GET ANSWERED</button>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="profile">...</div>
				</form>
            </div>

        </div>
    </section>