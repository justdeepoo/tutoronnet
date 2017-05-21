<?php $CI->partial($CI->theme.'/frontend/template/head');?>
<body>
<div class="overlay" style="display: none;"></div>
<section class="top-section-bar">
    <section class="container">
       <p class="pull-left">Have any question<span><i class="fa fa-fax"></i> +1 ( 480 ) 247-4440</span><span><i class="fa fa-envelope"></i>sendquestions@tutorsonnet.com</span></p>
        <p class="pull-right social-icon"><span class="fa fa-facebook-square"></span><span class="fa fa-twitter-square"></span><span class="fa fa-linkedin-square"></span></p>
    </section>
</section>
<header class="top-header">
    <section class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" id="mobileBtn">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo $this->MEDIA_URl;?>brand-logo.png"> </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="mobile-slide" id="mobileNav">
                 <ul class="nav navbar-nav navbar-right">
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false">Find Study Resources <i class="fa fa-angle-down"></i></a>
                         <ul class="dropdown-menu dropdown-menu-left">
                             <li><a href="#">By Subjects</a></li>
                          </ul>
                     </li>
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Assignment Help <i class="fa fa-angle-down"></i></a>
                         <ul class="dropdown-menu dropdown-menu-left">
                             <li><a href="#">Ask a Tutor a Question</a></li>
                          </ul>
                     </li>

                    <li><a href="<?php echo $this->root_path;?>secure/login/">Login</a></li>
                     <li><a href="<?php echo $this->root_path;?>secure/signup/">Signup</a></li>
                 </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    </section>
    <section class="banner-content">
        <section class="content">
            <section class="container text-center">
                <h1>BEST ONLINE TUTORING<br><span>THE EASIER WAY</span></h1>
             </section>
        </section>

    </section>
</header>
<!-- Level Section Start -->
<section class="row-padding bg-white">
   <?php $CI->partial($CI->theme.'/frontend/template/question-section');?>
</section>
<!-- Level Section End Here -->

<!-- Homework and Assignment Section -->
<section class="row-padding">
    <h1 class="text-capital text-center">Homework / Assignment Help</h1>
    <h2 class="text-center grey-50">Give and get helpful advice on which courses to take and on how to succeed in those courses.</h2>
    <section class="container mar-tp-60">
    <section class="row">
        <aside class="col-lg-4 col-md-4 col-sm-4 home-col">
            <section class="img-holder">
                <img src="<?php echo $this->MEDIA_URl;?>/hw-01.jpg" width="100%" class="img-responsive">
            </section>
            <section class="bg-white padding-25 small-shadow">
            <p class="text-bold pull-left"><span class="grey-50">BY</span>  <span class="blue-color">SUNIL KUMAR</span> </p>
            <p class="text-bold pull-right"><i class="fa fa-calendar"></i> <span class="grey-50">SEPETMBER 25, 2016</span> </p>
                <p class="clearfix"></p>
            <h4>NULLA CURSUS LOREM GRAVIDA AC MASSA SED IPSUM</h4>
                <p class="grey-50">Lorem Ipsum is simply dummy text of the
                    printing and typesetting industry. Lorem
                    Ipsum has been the industry's standard
                    dummy text ever since the 1500s</p>
                <section class="btn-holder text-center">
                    <button type="button" class="btn btn-primary">GET HELP</button>
                </section>
            </section>
        </aside>
        <aside class="col-lg-4 col-md-4 col-sm-4 home-col">
            <section class="img-holder">
                <img src="<?php echo $this->MEDIA_URl;?>/hw-02.jpg" width="100%" class="img-responsive">
            </section>
            <section class="bg-white padding-25 small-shadow">
                <p class="text-bold pull-left"><span class="grey-50">BY</span>  <span class="blue-color">SUNIL KUMAR</span> </p>
                <p class="text-bold pull-right"><i class="fa fa-calendar"></i> <span class="grey-50">SEPETMBER 25, 2016</span> </p>
                <p class="clearfix"></p>
                <h4>NULLA CURSUS LOREM GRAVIDA AC MASSA SED IPSUM</h4>
                <p class="grey-50">Lorem Ipsum is simply dummy text of the
                    printing and typesetting industry. Lorem
                    Ipsum has been the industry's standard
                    dummy text ever since the 1500s</p>
                <section class="btn-holder text-center">
                    <button type="button" class="btn btn-primary">GET HELP</button>
                </section>
            </section>
        </aside>
        <aside class="col-lg-4 col-md-4 col-sm-4 home-col">
            <section class="img-holder">
                <img src="<?php echo $this->MEDIA_URl;?>/hw-03.jpg" width="100%" class="img-responsive">
            </section>
            <section class="bg-white padding-25 small-shadow">
                <p class="text-bold pull-left"><span class="grey-50">BY</span>  <span class="blue-color">SUNIL KUMAR</span> </p>
                <p class="text-bold pull-right"><i class="fa fa-calendar"></i> <span class="grey-50">SEPETMBER 25, 2016</span> </p>
                <p class="clearfix"></p>
                <h4>NULLA CURSUS LOREM GRAVIDA AC MASSA SED IPSUM</h4>
                <p class="grey-50">Lorem Ipsum is simply dummy text of the
                    printing and typesetting industry. Lorem
                    Ipsum has been the industry's standard
                    dummy text ever since the 1500s</p>
                <section class="btn-holder text-center">
                    <button type="button" class="btn btn-primary">GET HELP</button>
                </section>
            </section>
        </aside>
    </section>
    </section>
</section>

<!-- Homework and Assignment Section End -->

<!-- Search Section Start -->
<section class="search-col row-padding">
    <section class="container">
        <h1 class="text-capital text-center white-clr">Search Study Materials</h1>
        <section class="search-text">
        <input type="text" class="form-control" placeholder="Find Course-Specific study resources linke notes and test meterials">
            <button type="button" class="btn btn-primary btn-lg">SEARCH</button>
        </section>
    </section>
</section>
<!-- Search Section Start End -->

<!-- Testimonials Section -->
<section class="row-padding bg-white">
    <section class="container">
        <h1 class="text-center">WHAT PEOPLE SAY</h1>
        <h2 class="grey-50 text-center">How real people said about Tutors On Net</h2>
        <div class="col-md-12" data-wow-delay="0.2s">
            <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                <!-- Bottom Carousel Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#quote-carousel" data-slide-to="0" class="active"><img class="img-responsive " src="<?php echo $this->MEDIA_URl;?>/128.jpg" alt="">
                    </li>
                    <li data-target="#quote-carousel" data-slide-to="1" class=""><img class="img-responsive" src="<?php echo $this->MEDIA_URl;?>/128.jpg" alt="">
                    </li>
                    <li data-target="#quote-carousel" data-slide-to="2" class=""><img class="img-responsive" src="<?php echo $this->MEDIA_URl;?>/128.jpg" alt="">
                    </li>
                </ol>

                <!-- Carousel Slides / Quotes -->
                <div class="carousel-inner text-center">

                    <!-- Quote 1 -->
                    <div class="item active">
                        <blockquote>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">

                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                                    <small>Someone famous</small>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                    <!-- Quote 2 -->
                    <div class="item">
                        <blockquote>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">

                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                                    <small>Someone famous</small>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                    <!-- Quote 3 -->
                    <div class="item">
                        <blockquote>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">

                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. .</p>
                                    <small>Someone famous</small>
                                </div>
                            </div>
                        </blockquote>
                    </div>
                </div>

                <!-- Carousel Buttons Next/Prev -->
                <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
                <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
            </div>
        </div>
    </section>
</section>
