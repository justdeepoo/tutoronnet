
<!-- Testimonials Section End -->
<footer class="row-padding">
    <section class="container">
       <section class="row footer-top">
           <aside class="col-lg-3 col-md-4 col-sm-4">
               <h4>ABOUT US</h4>
               <p class="grey-50">Skilled is also likely to be focused on fast and bright
                   teaching, it's a great type of courses to...</p>
               <P class="about-link">
                  <a href="#"><span class="fa fa-envelope"></span>sendquestions@tutorsonnet.com</a>
                   <a href="#"><span class="fa fa-fax"></span>+1 ( 480 ) 247-4440</a>
               </P>
           </aside>
           <aside class="col-lg-9 col-md-8 col-sm-7 right-links">
               <h4>NEW COURSES</h4>
               <section class="row">
                   <aside class="col-md-3">
                       <a href="#"><span class="fa fa-angle-right"></span>Accounting</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Finance</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Statistics</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Economics</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Operations Management</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Marketing</a>
                   </aside>
                   <aside class="col-md-3">
                       <a href="#"><span class="fa fa-angle-right"></span>Java</a>
                       <a href="#"><span class="fa fa-angle-right"></span>C++</a>
                       <a href="#"><span class="fa fa-angle-right"></span>C</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Visual Basic</a>
                       <a href="#"><span class="fa fa-angle-right"></span>C# (C Sharp)</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Matlab Programming</a>
                   </aside>
                   <aside class="col-md-3">
                       <a href="#"><span class="fa fa-angle-right"></span>Database</a>
                       <a href="#"><span class="fa fa-angle-right"></span>ER Diagrams</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Oracle</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Microsoft (MS) Access</a>
                       <a href="#"><span class="fa fa-angle-right"></span>JavaScript</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Shell Scripting</a>
                   </aside>
                   <aside class="col-md-3">
                       <a href="#"><span class="fa fa-angle-right"></span>Math</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Chemistry</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Physics</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Dissertations</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Case Study</a>
                       <a href="#"><span class="fa fa-angle-right"></span>Project Management</a>
                   </aside>
               </section>
           </aside>
       </section>
    </section>

    <section class="footer-btm">
        <section class="footer-links">
            <section class="container text-center">
                <a href="#">HOME</a>
                <a href="#">ABOUT US</a>
                <a href="#">HOMEWORK HELP</a>
                <a href="#">ONLINE TUTORING</a>
                <a href="#">GET A QUOTE</a>
                <a href="#">CAREERS</a>
                <a href="#">TERMS & CONDITIONS</a>
                <a href="#">CONTACT US</a>
                <a href="#">SITE MAP</a>
             </section>
        </section>
        <section class="container">
          <p>© Copyright 2007 - 2016 - Tutors On Net. All Rights reserved <span class="pull-right"><img src="<?php echo $this->MEDIA_URl;?>payment.png"> </span> </p>
        </section>
    </section>
</footer>





<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo $this->JS_URl;?>bootstrap.min.js"></script>
<script>
    $(function(){
        function initToolbarBootstrapBindings() {
            var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                        'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                        'Times New Roman', 'Verdana'],
                    fontTarget = $('[title=Font]').siblings('.dropdown-menu');
            $.each(fonts, function (idx, fontName) {
                fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
            });
            $('a[title]').tooltip({container:'body'});
            $('.dropdown-menu input').click(function() {return false;})
                    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
                    .keydown('esc', function () {this.value='';$(this).change();});

            $('[data-role=magic-overlay]').each(function () {
                var overlay = $(this), target = $(overlay.data('target'));
                overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
            });
            if ("onwebkitspeechchange"  in document.createElement("input")) {
                var editorOffset = $('#editor').offset();
                $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
            } else {
                $('#voiceBtn').hide();
            }
        };

        initToolbarBootstrapBindings();
        $('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
        window.prettyPrint && prettyPrint();
    });
    $(document).ready(function() {
        var sideslider = $('[data-toggle=collapse-side]');
        var sel = sideslider.attr('data-target');
        var sel2 = sideslider.attr('data-target-2');
        sideslider.click(function(event){
            $(sel).toggleClass('in');
            $(sel2).toggleClass('out');
        });
    });

    // mobile menu slide from the left
    $("#mobileBtn").click(function(){
         $("#mobileNav").toggleClass("slidenav");
        $(".overlay").fadeToggle("700");

     });

    $(".overlay").click(function(){
        $("#mobileNav").toggleClass("slidenav");
        $(".overlay").fadeToggle("700");

    });

</script>
</body>
</html>