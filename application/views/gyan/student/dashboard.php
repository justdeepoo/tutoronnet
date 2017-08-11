
      

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->





        <!-- Main content -->
        <section class="content">





        <div class="row">
          <?php
            if($this->session->flashdata('message')){?>
            <div class="col-lg-12">
              <div class="alert alert-success"><?php echo $this->session->flashdata('message');?></div>
            </div>
            <?php }
            ?>
            <div class="col-lg-8 col-md-8 col-sm-8">

            <div class="box">
              <h2 class="bdr-heading text-purple">Type your question</h2>

              <form method="post" action="<?php echo base_url();?>secure/post_question" name="question-form" id="question-form">
                <div>

                  <div class="col-lg-12">
                    <textarea cols="" class="mandate form-control" id="question" name="question" placeholder="Type your question...." rows="5" data-valid-type="nEmpty" style="width: 100%"></textarea>
                  </div>
                  <div class="tools col-lg-12">
                      <div class="col-md-3 pad-0">
                        <select id="subject" class="mandate form-control" data-valid-type="nEmpty" name="subject">
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
                      <div class="col-md-6">
                        <input type="file" name="doc" id="doc" data-valid-type="nEmpty" class="form-control mandate">
                      </div>
                      <div class="col-md-3 pad-0">
                          <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </form>

            </div>

          </div>



            <div class="col-lg-12">

              <div class="box">
                
                <div class="col-lg-12 row">
                    <div class="col-md-12">
                        <h2 class="bdr-heading text-purple">My Recent Questions </h2>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                  <?php
                    if($questions->num_rows())
                      {
                        foreach ($questions as $key => $question) {?>
                            <div class="question-sections">
                                <div class="col-lg-12">
                                  <div class="">
                                     <div class="question-title">I need help in accounting. I want to understood every things from A-z.</div>
                                  </div>
                                  <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 part">
                                  <div class="col-md-6">Subject : Accounting</div>
                                  <div class="col-md-6">Deadline : July-12, 2017</div>
                                  <div class="clearfix"></div>
                                </div>
                                 <div class="col-md-12 part">
                                    <div class="col-md-6">Price : $3.00</div>
                                    <div class="col-md-3">Status : N/A</div>
                                    <div class="col-md-3"><button type="button" class="btn label-btn-primary pull-right">View Question</button></div>
                                    <div class="clearfix"></div>
                                 </div>
                                <div class="clearfix"></div>
                              </div>
                        <?php 
                        }
                        ?>
                        
                      <?php }
                      else{?>
                           <div class="question-sections">
                                <div class="col-lg-12">
                                  No question submited yet.
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        <?php
                        }?>
                  

                  
              </div>




            </div>




          </div>
          
          <div class="col-lg-4 col-md-4 col-sm-4 hide">

            <div class="box">
              <h2 class="bdr-heading text-purple">Total Fund Received</h2>
              <p class="text-center"><img src="dist/img/dollor.png" alt="..."></p>

              <h1 class="text-center text-purple slick-font">$1595.00</h1>
              <p class="text-center"><a href="#" class="text-purple">View All</a> </p>

            </div>

          </div>
          
          <div class="clearfix"></div>
        </section>
      </div>
      <div class="clearfix"></div>
     