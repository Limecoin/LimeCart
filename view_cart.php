<?php

session_start();
include_once("config.php");
require_once("jsonRPCClient.php");
//DEBUG
if ($debug == True) {
  echo "[DEBUG TURNED ON, SHOWING ERRORS!]";
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
}else{
}
$showCoinAddress = "False";

try{
	$orderName = $_POST["name"];
	$shippingAddress = $_POST["formatted_address"];
	$showCoinAddress = $_POST["showCoinAddress"];
	$email = $_POST["email"];
}catch(Exception $e){
	$orderName = "John Doe";
	$shippingAddress = "No Address Supplied";
	$showCoinAddress = "False";
	$email = "no@email.com";
}

?>
<!DOCTYPE html>
<html>
<head>
<?
$bitcoin = new jsonRPCClient("http://$rpcuser:$rpcpass@$rpcserver:$rpcport/"); 

if($showCoinAddress == True){
	if ($debug == True) {
		$newAddress = "DEBUGGED TURNED ON";		  
	}else{
		$newAddress = $bitcoin->getnewaddress("");  
		//$newAddress = "Lfxu6TjMXJsfSyce1ufWj2uVcoAALrRhmS";
	}
}else{
	$newAddress = "Click Submit Above For Address";
}
//END DEBUG 
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View shopping cart</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<style>
      html, body, #map-canvas {
        height: 400px;
		width: 500px;
        margin: 10px;
        padding: 10px;
		align-left: 100%;
		align-right: 40%
      }
</style>
  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <script src="jquery.geocomplete.js"></script>

    <script>
      $(function(){
        $("#geocomplete").geocomplete({
          map: ".map_canvas",
          details: "form",
          types: ["geocode", "establishment"],
        });

        $("#find").click(function(){
          $("#geocomplete").trigger("geocode");
        });
      });
    </script>
</head>
<body>

<div id="products-wrapper">
 <h1>Checkout..</h1>
 <div class="view-cart">
 	<?php
    $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	if(isset($_SESSION["products"]))
    {
	    $total = 0;
		echo '<form method="post" action="">';
		echo '<ul>';
		$cart_items = 0;
		foreach ($_SESSION["products"] as $cart_itm)
        {
           $product_code = $cart_itm["code"];
		   $results = $mysqli->query("SELECT product_name,product_desc, price FROM products WHERE product_code='$product_code' LIMIT 1");
		   $obj = $results->fetch_object();
		   
		    echo '<li class="cart-itm">';
			echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';
			echo '<div class="p-price">'.$currency.$obj->price.'</div>';
            echo '<div class="product-info">';
			echo '<h3>'.$obj->product_name.' (Code :'.$product_code.')</h3> ';
            echo '<div class="p-qty">Qty : '.$cart_itm["qty"].'</div>';
            echo '<div>'.$obj->product_desc.'</div>';
			echo '</div>';
            echo '</li>';
			$subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
			$total = ($total + $subtotal);

			echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$obj->product_name.'" />';
			echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_code.'" />';
			echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$obj->product_desc.'" />';
			echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
			$cart_items ++;
			$productName = $productName + " " + $obj->product_name;
        }
    	echo '</ul>';
		if($donation == True){
			$fee = $fee + $donationAmount;
			}
		$feeDue = $fee / $total;
		$totalDue = $feeDue + $total;
		echo '<span class="check-out-txt">';
		echo '<strong>Cart Total: </strong>'.$currency.$total.'<br>';
		echo '<strong>Handling Fee: </strong>'.$currency.$feeDue.'<br>';
		echo "<strong>Total Due: </strong>$currency <font color=\"green\">$totalDue</font><br>";
	    echo "<img style=\"margin-top:20px; margin-left:5px;\" src=\"/images/$coinLogo\"  height=\"100\" width=\"120\"><br>";

		
		$num = 0;
		while($num < 40){
			echo '<p><br></p>';
			$num = $num + 1;
		}		
		$total = $totalDue;
		echo '</span>';
		echo "<center>Send, <strong>$total LimeCoins LC</strong> to the below address, then remain on the page untill payment confirms. Click button to check confirmations. </center>";
		echo '<div style="witdth:200px; height:300px;" class="map_canvas"></div>';
		?>

    <form method="post" action="">
	<center>
	  <br>
	  Enter shipping details below if merchant requires for this product.<br>
      <? echo "<input style=\"width:300px;\" id=\"geocomplete\" type=\"text\" placeholder=\"Type in an address\" value=\"$shippingAddress\" />"; ?>
      <input id="find" type="button" value="find" />
	  <p></p>
	</center>

      <fieldset style="border:0px;">
        <h3>Shipping Details (If required)</h3>
		<br>
        <label>Name&nbsp;</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="name" type="text" value="<?echo $orderName;?>">  <font color="red">*</font>
		<br><br>
		<label>Email&nbsp;</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="email" type="text" value="<?echo $email;?>">  <font color="red">*</font>
		<br><br>
        <label>Formatted Address&nbsp;</label><input name="formatted_address" type="text" value="<?echo $shippingAddress;?>" readonly='true' style="background-color : #d1d1d1; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Street Number&nbsp;</label><input name="street_number" type="text" value="" readonly='true' style="background-color : #d1d1d1; ">
		<br>
        <label>Postal Code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input name="postal_code" type="text" value="" readonly='true' style="background-color : #d1d1d1; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Locality&nbsp;</label><input name="locality" type="text" value="" readonly='true' style="background-color : #d1d1d1; ">
		<br>
        <label>Sub Locality&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input name="sublocality" type="text" value="" readonly='true' style="background-color : #d1d1d1; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Country&nbsp;</label><input name="country" type="text" value="" readonly='true' style="background-color : #d1d1d1; ">
		<br>
        <label>Country Code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input name="country_short" type="text" value="" readonly='true' style="background-color : #d1d1d1; "> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>State&nbsp;</label><input name="administrative_area_level_1" type="text" value="" readonly='true' style="background-color : #d1d1d1; ">
        <p><br></p><input name="showCoinAddress" type="hidden" value="True" readonly='true' style="background-color : #d1d1d1; "><input type="submit" name="submit" value="Submit" />
      </fieldset>
    </form>
		<?
		// $shippingAddress = "";formatted_address
		//echo "<center><br><div id=\"map-canvas\"></div><br></center>";

		echo "<br><br><center> <input type=\"text\" id=\"text3\" placeholder=\"$newAddress\" value=\"$newAddress\"> </center><br><br> "; 
		
		?>
		
		<style> 
		#text3  
		{ 
		background: #333; 
		color: #00CC00; 
		width: 300px; 
		padding: 6px 15px 6px 35px; 
		border-radius: 20px; 
		box-shadow: 0 1px 0 #339966 inset; 
		transition:500ms all ease; 
		outline:0; 
		} 
		#text3:hover 
		{ 
		width:400px; 
		color: #66FF99;
		background: #009900; 
		} 
		</style>
		
		<?

		echo '</form>';
		
		
    }else{
		echo 'Your Cart is empty, go fill it ...';
	}
	
     echo "<center><img style=\"margin-right:23%; float:right\" src=\"https://api.qrserver.com/v1/create-qr-code/?size=135x135&data=Address[$newAddress]Amount[$total]&color=66FF99&bgcolor=009900\"&margin=5\>"; 
	   ?>

	   <style type="text/css">
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:9px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tg th{font-family:Arial, sans-serif;font-size:9px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tg .tg-s5t7{font-weight:bold;font-size:12px;font-family:Verdana, Geneva, sans-serif !important;;background-color:#9aff99;color:#009901;text-align:center}
		.tg .tg-e3zv{font-weight:bold}
		</style>
		<table style="margin-left:19%;"class="tg">
		  <tr>
			<th class="tg-s5t7" colspan="5">Confirmations </th>
		  </tr>
		  <tr>
			<td class="tg-e3zv">Status:<br></td>
			<td class="tg-031e" colspan="4">&nbsp;Waiting <br></td>
		  </tr>
		  <tr>
			<td class="tg-e3zv">TX Complete:</td>
			<td class="tg-031e" colspan="4">&nbsp;<div id="confirmations"></div></td>
		  </tr>
		</table>
		</center>
		<p><br><br></p>
		<center>Please Stay on this page until confirmations are complete, use button below to confirm.<p><br></p></center>
		
		<center>
		<?echo "<img style=\"margin-top:0px; margin-left:0px;\" src=\"/images/cart.png\"  height=\"100\" width=\"120\">"; ?>
		<br>
		<button type="button" onclick="loadXMLDoc()">Check Confirmations</button>
		</center>
	</div>
	  <br><br>
	 
	   <? echo "<p><br>&nbsp&nbsp<br></p>";?>
	   <center><h5> <p>Powered by <a href="http://github.com/limecoin/limecart">LimeCart</a>, open source limecoin shopping cart system... </center></h5>
       <center><h5>Donate to LimeCart Project: <font color="gray">Lf2Jc3fk19CA2YZbZQeYc2ar13Hkmr2ggw</font> [LC]</p> </center></h5>

</div>

<p><br></p>
<script>
$.ajax({
  url: "test.html",
  cache: false
})

function loadXMLDoc()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("confirmations").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","checkConfirmations.php?address=<?echo $newAddress;?>&total=<?echo $total;?>&donate=<?echo $donationAmount;?>&product=<?echo $productName;?>&done=False&shippingaddress=<?echo $shippingAddress;?>&name=<?echo $orderName;?>&email=<?echo $email;?>",true);
xmlhttp.send();
}
</script>
</body>
</html>
