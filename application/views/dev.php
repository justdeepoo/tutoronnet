<style>

a {
  text-decoration: none;
  color:#fff;
}

.wrapper {
  position:relative;
  overflow:hidden;
}

.btn {
  position:abosulte;
  width:120px;
  background-color:red;
  border-radius:5px;
  padding: 5px 10px;
  display: inline-block;
  text-align:center;
}

.hide {
  position:absolute;
  left:0px;
  width:140px;
  opacity: 0;
  filter:alpha(opacity: 0);
  height:30px;
  display: inline-block;
  cursor: pointer;
  padding-top:30px; /* for cursor:pointer */
}

/*********************/

a.file-wrapper {
  position:relative;
  width:120px;
  height: 20px;
  background-color:red;
  border-radius:5px;
  padding: 5px 10px;
  display: inline-block;
  text-align:center;
  overflow:hidden;
}

a.file-wrapper:hover {
  background-color: orange;
}

a.file-wrapper > input[type="file"] {
  opacity: 0;
  filter: alpha(opacity=0);
  position:absolute;
  top: 0;
  right: 0;
}




</style>


<div class="uploader">
	<a href="#" class="file-wrapper">
	Upload document
	<input type="file" >
</a>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
	$(function(){
    $(".fakeFile").each(function(){
        var $this = $(this),
            $browse = $this.children(".browse"),
            $file = $this.prev("input");
        if(/*@cc_on!@*/false) {
            $file
                .parent().addClass("isIE")
                .end()
                .bind({
                    click: function(e){ $(this).blur(); },
                    mousedown: function(){ $browse.addClass("active"); },
                    mouseup: function(){ $browse.removeClass("active"); },
                    mouseover: function(){ $browse.addClass("hover"); },
                    mouseout: function(){ $browse.removeClass("hover active"); },
                    change: function(){ $(this).next().children(".text").text($(this).val()); }
                });
        } else {
            $this.bind({
                click: function(e){ $file.trigger("click"); },
                mousedown: function(){ $browse.addClass("active"); },
                mouseup: function(){ $browse.removeClass("active"); },
                mouseover: function(){ $browse.addClass("hover"); },
                mouseout: function(){ $browse.removeClass("hover active"); }
            });
            $file.change(function(){
                $this.children(".text").text($(this).val());
            });
        }
    });
});

</script>