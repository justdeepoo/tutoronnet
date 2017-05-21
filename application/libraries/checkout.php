<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
 <form method="post" action="process.php" id="checkout_form">
 <input type="hidden" name="amount" value="<?php echo $_REQUEST['amount'];?>">
      <fieldset>
        <div>
          <label>Credit Card Number</label>
          <input type="text" class="text required creditcard" size="15" name="x_card_num" value="6011000000000012"></input>
        </div>
        <div>
          <label>Exp.</label>
          <input type="text" class="text required" size="4" name="x_exp_date" value="04/15"></input>
        </div>
        <div>
          <label>CCV</label>
          <input type="text" class="text required" size="4" name="x_card_code" value="782"></input>
        </div>
      </fieldset>
      <fieldset>
        <div>
          <label>First Name</label>
          <input type="text" class="text required" size="15" name="x_first_name" value=""></input>
        </div>
        <div>
          <label>Last Name</label>
          <input type="text" class="text required" size="14" name="x_last_name" value=""></input>
        </div>
      </fieldset>
      <fieldset>
        <div>
          <label>Address</label>
          <input type="text" class="text required" size="26" name="x_address" value=""></input>
        </div>
        <div>
          <label>City</label>
          <input type="text" class="text required" size="15" name="x_city" value=""></input>
        </div>
      </fieldset>
      <fieldset>
        <div>
          <label>State</label>
          <input type="text" class="text required" size="4" name="x_state" value=""></input>
        </div>
        <div>
          <label>Zip Code</label>
          <input type="text" class="text required" size="9" name="x_zip" value=""></input>
        </div>
        <div>
          <label>Country</label>
          <input type="text" class="text required" size="22" name="x_country" value=""></input>
        </div>
      </fieldset>
      <input type="submit" value="BUY" class="submit buy">
    </form>
</body>
</html>