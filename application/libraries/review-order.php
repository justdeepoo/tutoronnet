<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="review" id="review" action="checkout.php" method="post">
<div>Selected Items:</div>

<div style="float:left">Item Name:</div><div style="float:left"><?php echo $_REQUEST['item'];?></div>
<input type="hidden" name="amount" value="<?php echo $_REQUEST['price'];?>">
<div style="clear:both"></div>
<div style="float:left">Price:</div><div style="float:left"><?php echo $_REQUEST['price'];?></div>
<div style="clear:both"></div>
<div><input type="submit" name="review"  value="authorizd.net"/></div>
</form>
</body>
</html>