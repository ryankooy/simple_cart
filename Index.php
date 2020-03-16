<?php
session_start();
include_once("Config.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart</title>
<style>
body {
	font-family: "trebuchet ms", verdana, sans-serif;
	font-size: 15px;
	line-height: 1.5em;
	color: #333;
	background-color: skyblue;
	margin: auto;
	padding: 0;
	text-align: center;
	width: 60%;
	display: block;
}
button {
	width: 100%;
	background-color: darkslategray;
	color: white;
	border: 1 solid white;
}
fieldset {
	border: 1px solid white;
	width: 300px;
	text-align: center;
	display: inline;
	background-color: paleturquoise;
}
</style>
</head>
<body>
<div class="products">
<h1>Our Products</h1>
<?php
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$results = $mysqli->query("SELECT product_code, product_name, product_desc, price FROM products ORDER BY id ASC");
if($results){ 
$products_item = '<div class="products">';
while($obj = $results->fetch_object())
{
$products_item .= <<<EOT
	<div class="product">
	<form method="post" action="cart_update.php">
	<div class="product-content"><h3>{$obj->product_name}</h3>
	<fieldset>
	<div class="product-info">
	Price {$currency}{$obj->price}	
	<br>
	<label>
		<span>Model</span>
		<select name="product_color">
		<option value="Black">4028DM30</option>
		<option value="Silver">2940DM30</option>
		</select>
	</label>
	|
	<label>
		<span>Quantity</span>
		<input type="text" size="2" maxlength="2" name="product_qty" value="1" />
	</label>
	<input type="hidden" name="product_code" value="{$obj->product_code}" />
	<input type="hidden" name="type" value="add" />
	<input type="hidden" name="return_url" value="{$current_url}" />
	<div><button type="submit" class="add_to_cart">Add</button></div>
	</fieldset>
	</div></div>
	</form>
	</div>
EOT;
}
$products_item .= '</div>';
echo $products_item;
}
?>
</div>

<div class="shopping-cart">
<h1>Your Shopping Cart</h1>
<?php
if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
{
	echo '<div class="cart-view-table-front" id="view-cart">';
	echo '<fieldset>';
	echo '<form method="post" action="cart_update.php">';
	echo '<table width="100%"  cellpadding="6" cellspacing="0">';
	echo '<tbody>';

	$total =0;
	$b = 0;
	foreach ($_SESSION["cart_products"] as $cart_itm)
	{
		$product_name = $cart_itm["product_name"];
		$product_qty = $cart_itm["product_qty"];
		$product_price = $cart_itm["product_price"];
		$product_code = $cart_itm["product_code"];
		$product_color = $cart_itm["product_color"];
		$bg_color = ($b++%2==1) ? 'odd' : 'even'; //zebra stripe
		echo '<tr class="'.$bg_color.'">';
		echo '<td>Qty <input type="text" size="2" maxlength="2" name="product_qty['.$product_code.']" value="'.$product_qty.'" /></td>';
		echo '<td>'.$product_name.'</td>';
		echo '<td><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /> Remove</td>';
		echo '</tr>';
		echo '</fieldset>';
		$subtotal = ($product_price * $product_qty);
		$total = ($total + $subtotal);
	}
	echo '<td colspan="4">';
	echo '<button type="submit">Update</button><br><button>Checkout</button>';
	echo '</td>';
	echo '</tbody>';
	echo '</table>';
	
	$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
	echo '</form>';
	echo '</fieldset>';
	echo '</div>';

}
?>
</div>
</body>
</html>