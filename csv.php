<?php
if ($_GET["licensee_id"]!=156355 && $_GET["licensee_id"]!=294927)
{
// <sitemin orig_code>
exit;
}

set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_PARSE);
set_include_path($_SERVER["DOCUMENT_ROOT"].'/phpseclib');
require_once('Net/SFTP.php');

$sourcePath = $_SERVER["DOCUMENT_ROOT"]. "/../tmp/";
$destinationPath = '/';

include_once($_SERVER["DOCUMENT_ROOT"]. "/../includes/db.inc");
@include_once($_SERVER["DOCUMENT_ROOT"]. "/../includes/lib.inc");

include_once($_SERVER["DOCUMENT_ROOT"]. "/../includes/mcrypt.inc");

require_once($_SERVER['DOCUMENT_ROOT']."/../includes/classes/phpmailer.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/../includes/classes/logwriter.class.php");

mysql_connect((strlen($mysql_host) ? $mysql_host : "localhost"), $mysql_username, $mysql_password);
if (!mysql_select_db($mysql_db)) // no report
{
echo "Failed - unable to connect to database\n";
exit;
}

$tmp=explode(".", strtolower($_SERVER["HTTP_HOST"]));
define("WSDOMAIN", implode(".", array_slice($tmp, 1)));
define("WORKSPACE", implode(".", array_slice($tmp, 1, -2)));


define('SFTP_HOST','cfsgroupinc-ftp.exavault.com');
define('SFTP_PORT',22);
define('SFTP_USER','PrizerWebCart');
define('SFTP_PASS','YZOKmD2m9SG1P86a5QeC');

function array_to_csv_download($array, $filename = "export.csv", $delimiter=";",$sourcePath) {
	$f = fopen($sourcePath.$filename, 'w');
	$csv = "";
	foreach ($array as $line) {
		$csv.=  implode(',',$line); //$line[0].','.$line[1]."\n";
		$csv.="\n";
	}
	fwrite ($f,$csv);
	fclose ($f);
}

function removeOrdersFromSFTP() {
$host = SFTP_HOST;
$port = SFTP_PORT;
$user = SFTP_USER;
$pass = SFTP_PASS;

$sftp = new Net_SFTP($host);
if (!$sftp->login($user,$pass)) {
exit('Login Failed');
}
$result = mysql_query("select * from bluestar_sent_orders");
if(mysql_num_rows($result) > 0) {
while($row = mysql_fetch_assoc($result)) {
$sftp->delete('/'.$row['order_id'].'.xml');
}
}
mysql_query("delete from bluestar_sent_orders");
return true;
}


if(isset($_GET['is_remove']) && $_GET['is_remove'] == '1') {
removeOrdersFromSFTP();
exit;
}


function uploadFileToSFTP($sourcePath,$destinationPath,$fileName,$orderID) {
$host = SFTP_HOST;
$port = SFTP_PORT;
$user = SFTP_USER;
$pass = SFTP_PASS;

$sftp = new Net_SFTP($host);
if (!$sftp->login($user,$pass)) {
exit('Login Failed');
}
$sftp->put($destinationPath.$fileName,$sourcePath.$fileName, NET_SFTP_LOCAL_FILE);
mysql_query("insert into bluestar_sent_orders (order_id) values (".$orderID.") ");
return true;
}


$orderData = mysql_query_to_array($localorders, optimize_subqueries("select * from orders where status = 'open' and order_id in (select order_id from order_details where exact_product_id in (select exact_product_id from exact_products where product_id in (select product_id from products where entity_id2=".$_GET["licensee_id"]."))) "), "orders", "order_id", array("address_id", "address_id2", "phone_number_id", "email_id", "shipping_method_group_id", "user_id"));


$totalOrders = count($localorders['orders']);

//echo $totalOrders; die;

if($totalOrders>0) {

	//echo '<pre>'; print_r($localorders['orders']); exit;

foreach($localorders['orders'] as $key => $value) {
$order_id = $key;

//echo $order_id; die;
//echo '<pre>'; print_r($value); exit;

if(isset($_GET['licensee_id']) && $_GET['licensee_id']!=294927) {
	$result = mysql_query("select * from bluestar_sent_orders where order_id =".$order_id);
	$countExistingRow = 0;
	$existingOrder = mysql_num_rows($result);

	if($existingOrder == 1) {
		continue;
	}	
}


//echo '<pre>'; print_r($existingOrder); exit;

if (!empty($value))
{
$allOrders = $localorders;
foreach($localorders['orders'] as $removekey => $removeValue) {
if($removekey != $order_id) {
unset($allOrders['orders'][$removekey]);
}
}
$local = $allOrders;

mysql_query_to_array($local, "select * from states order by country_id, name", "states", "state_id", array("country_id", 'abbrev'));
mysql_query_to_array($local, "select * from countries order by country_id", "countries", "country_id", array('abbrev'));

mysql_query_to_array($local, "select * from transactions where ". make_in_clause("order_id", array_keys((array) $local["orders"])). " order by created", "transactions", "transaction_id", array("order_id"));
mysql_query_to_array($local, "select * from transaction_details where ". make_in_clause("transaction_id", array_keys((array) $local["transactions"])), "transaction_details", "transaction_detail_id", array("chart_of_account_id", "transaction_id"));
mysql_query_to_array($local, "select * from chart_of_accounts where ". make_in_clause("chart_of_account_id", array_keys((array) $local["rev"]["transaction_details"]["chart_of_account_id"])), "chart_of_accounts", "chart_of_account_id");

mysql_query_to_array($local, "select cc_log.cc_log_id, cc_log.order_id, trans_types.name as trans_type, trans_response_codes.description as trans_response, cc_log.authnet_trans_number, cc_log.created, transaction_details.amount from cc_log left join trans_types on cc_log.trans_type_id=trans_types.trans_type_id left join trans_response_codes on cc_log.trans_response_code_id=trans_response_codes.trans_response_code_id left join transaction_details on cc_log.transaction_detail_id=transaction_details.transaction_detail_id where ". make_in_clause("cc_log.order_id", array_keys((array) $local["orders"])). " order by created", "cc_log", "cc_log_id", array("order_id"));

mysql_query_to_array($local, "select * from phone_numbers where ". make_in_clause("phone_number_id", array_keys((array) $local["rev"]["orders"]["phone_number_id"])), "phone_numbers", "phone_number_id");
mysql_query_to_array($local, "select * from emails where ". make_in_clause("email_id", array_keys((array) $local["rev"]["orders"]["email_id"])), "emails", "email_id");

mysql_query_to_array($local, "select * from payment_methods where ". make_in_clause("user_id", array_keys((array) $local["rev"]["orders"]["user_id"])), "payment_methods", "payment_method_id");

mysql_query_to_array($local, "select shipping_method_group_id, name from ship_method_group_lang_map where ". make_in_clause("shipping_method_group_id", array_keys((array) $local["rev"]["orders"]["shipping_method_group_id"])). " and language_id=". $GLOBALS["myenv"]["sessions"]["language_id"], "shipping_method_groups", "shipping_method_group_id");
mysql_query_to_array($local, "select * from order_entity_limits where ". make_in_clause("order_id", array_keys((array) $local["orders"])). " and entity_id=". $GLOBALS["myenv"]["entities"]["entity_id"]. " and which_limit in (${quot}max_ship_credit${quot}, ${quot}add_ship_absorb${quot}, ${quot}ship_discount${quot}, ${quot}ship_handling${quot}, \"ship_refund\")", "order_entity_limits", "order_entity_limit_id", array("order_id", "which_limit"));
mysql_query_to_array($local, "select * from order_entity_settings where ". make_in_clause("order_id", array_keys((array) $local["orders"])). " and entity_id=". $GLOBALS["myenv"]["entities"]["entity_id"], "order_entity_settings", "order_entity_setting_id", array("order_id"));
mysql_query_to_array($local, "select * from order_shipping_refund_comments where ". make_in_clause("order_id", array_keys((array) $local["orders"]))." and entity_id2 in (".$GLOBALS["myenv"]["entities"]["entity_id"].", 0)", "order_shipping_refund_comments", "order_shipping_refund_comment_id", array("order_id"));
mysql_query_to_array($local, "select shipping_methods.shipping_method_id, shippers.name as shipper, shipping_methods.name as method from shipping_methods left join shippers on shipping_methods.shipper_id=shippers.shipper_id", "shipping_methods", "shipping_method_id", array("order_id"));

mysql_query_to_array($local, "select * from order_details where ". make_in_clause("order_id", array_keys((array) $local["orders"])), "order_details", "order_detail_id", array("exact_product_id", "order_id", "entity_id"));
mysql_query_to_array($local, "select * from order_detail_discounts where ". make_in_clause("order_detail_id", array_keys((array) $local["order_details"])), "order_detail_discounts", "order_detail_discount_id", array("order_detail_id"));
mysql_query_to_array($local, "select * from order_shipment_details where ". make_in_clause("order_detail_id", array_keys((array) $local["order_details"])), "order_shipment_details", "order_shipment_detail_id", array("order_shipment_id", "order_detail_id"));
mysql_query_to_array($local, "select * from order_shipments where ". make_in_clause("order_shipment_id", array_keys((array) $local["rev"]["order_shipment_details"]["order_shipment_id"])), "order_shipments", "order_shipment_id", "order_id");
mysql_query_to_array($local, "select * from order_status_log where ". make_in_clause("order_detail_id", array_keys((array) $local["order_details"])), "order_status_log", "order_status_log_id", array("order_detail_id"));
mysql_query_to_array($local, "select * from exact_products where ". make_in_clause("exact_product_id", array_keys((array) $local["rev"]["order_details"]["exact_product_id"])), "exact_products", "exact_product_id", array("product_id"));
mysql_query_to_array($local, "select * from exact_product_config_map where ". make_in_clause("exact_product_id", array_keys((array) $local["exact_products"])), "exact_product_config_map", "exact_product_config_map_id", array("product_config_id", "exact_product_id"));
mysql_query_to_array($local, "select * from product_configs where ". make_in_clause("product_config_id", array_keys((array) $local["rev"]["exact_product_config_map"]["product_config_id"])), "product_configs", "product_config_id", array("product_config_cat_id"));
mysql_query_to_array($local, "select * from product_config_language_map where ". make_in_clause("product_config_id", array_keys((array) $local["product_configs"])). " and language_id=". $GLOBALS["myenv"]["sessions"]["language_id"], "product_config_language_map", "product_config_language_map_id", array("product_config_id"));
mysql_query_to_array($local, "select * from product_config_cats where ". make_in_clause("product_config_cat_id", array_keys((array) $local["rev"]["product_configs"]["product_config_cat_id"]))." and product_config_cats.entity_id in (0,".$GLOBALS["myenv"]["entities"]["entity_id"].")", "product_config_cats", "product_config_cat_id");
mysql_query_to_array($local, "select * from product_config_cat_lang_map where ". make_in_clause("product_config_cat_id", array_keys((array) $local["product_config_cats"])). " and language_id=". $GLOBALS["myenv"]["sessions"]["language_id"], "product_config_cat_lang_map", "product_config_cat_lang_map_id", array("product_config_cat_id"));
mysql_query_to_array($local, "select * from products where ". make_in_clause("product_id", array_keys((array) $local["rev"]["exact_products"]["product_id"])), "products", "product_id", array("entity_id", "entity_id2"));
mysql_query_to_array($local, "select * from product_config_cat_seq where ". make_in_clause("product_id", array_keys((array) $local["products"])). " and which_seq=${squot}menu${squot} order by seq", "product_config_cat_seq", "product_config_cat_seq_id", array("product_id"));
// mysql_query_to_array($local, "select * from product_config_seq where ". make_in_clause("product_id", array_keys((array) $local["products"])). " order by seq", "product_config_seq", "product_config_seq_id", array("product_id"));
mysql_query_to_array($local, "select * from product_language_map where ". make_in_clause("product_id", array_keys((array) $local["products"])), "product_language_map", "product_language_map_id", array("product_id"));

//. " and language_id=". $GLOBALS["myenv"]["sessions"]["language_id"]

// brands, licensees, retailers
mysql_query_to_array($local, "select * from entities where ". make_in_clause("entity_id", array_merge(array_keys((array) $local["rev"]["products"]["entity_id"]), array_keys((array) $local["rev"]["products"]["entity_id2"]), array_keys((array) $local["rev"]["order_details"]["entity_id"]))), "entities", "entity_id", array("user_id"));
mysql_query_to_array($local, "select * from users where ". make_in_clause("user_id", array_keys((array) $local["rev"]["entities"]["user_id"])), "users", "user_id", array("address_id"));

// everyone
mysql_query_to_array($local, "select addresses.*, (case when addresses.state_id>0 then states.name else addresses.state end) state2, states.abbrev state3, countries.name country from addresses left join states on addresses.state_id=states.state_id left join countries on addresses.country_id=countries.country_id where ". make_in_clause("addresses.address_id", array_merge(array_keys((array) $local["rev"]["users"]["address_id"]), array_keys((array) $local["rev"]["orders"]["address_id"]), array_keys((array) $local["rev"]["orders"]["address_id2"]))), "addresses", "address_id");

mysql_query_to_array($local, "select order_prompt_values.order_prompt_value_id, order_prompt_group_values.order_detail_id, if(order_prompt_group_values.order_prompt_trigger_id=1, ${quot}order${quot}, ${quot}item${quot}) as display_where, order_prompt_group_values.order_prompt_group_id, order_prompt_group_values.name, order_prompt_values.prompt, order_prompt_values.value from order_prompt_group_values left join order_prompt_values on order_prompt_group_values.order_prompt_group_value_id=order_prompt_values.order_prompt_group_value_id where ". make_in_clause("order_prompt_group_values.order_detail_id", array_keys((array) $local["order_details"])). " order by order_prompt_group_values.seq, order_prompt_values.seq", "order_prompt_values", "order_prompt_value_id", array(array("display_where", "order_detail_id"), array("display_where", "order_detail_id", "order_prompt_group_id"), array("display_where", "order_prompt_group_id")));

mysql_query_to_array($local, "select * from order_comments where ". make_in_clause("order_id", array_keys((array) $local["orders"])). " order by created desc", "order_comments", "order_comment_id", array("order_id"));
mysql_query_to_array($local, "select * from order_ots_customer_type where ". make_in_clause("order_id", array_keys((array) $local["orders"])), "order_ots_customer_type", "order_ots_customer_type_id", array("order_id"));

//bg custom PFD
mysql_query_to_array($local, "select * from order_detail_bodyglove_custom_pfd where ". make_in_clause("order_detail_id", array_keys((array) $local["order_details"])), "order_detail_bodyglove_custom_pfd", "order_detail_bodyglove_custom_pfd_id", array("order_detail_id"));

mysql_query_to_array($local, "select * from order_detail_ci_custom_board where ". make_in_clause("order_detail_id", array_keys((array) $local["order_details"])), "order_detail_ci_custom_board", "order_detail_ci_custom_board_id", array("order_detail_id", "ci_project_id"));

mysql_query_to_array($local, "select shipping_method_group_id, name from ship_method_group_lang_map where ". make_in_clause("shipping_method_group_id", array_keys((array) $local["rev"]["orders"]["shipping_method_group_id"])), "shipping_method_groups", "shipping_method_group_id");

mysql_query_to_array($GLOBALS["myenv"], optimize_subqueries("select settings.abbrev as name, entity_settings.value from settings left join entity_settings on settings.setting_id=entity_settings.setting_id where settings.entity_type_id=". (int) $GLOBALS["myenv"]["entity_types"]["entity_type_id"]. " and entity_settings.entity_id=". (int) $GLOBALS["myenv"]["entities"]["entity_id"]. " union select settings.abbrev as name, settings.default_value as value from settings where entity_type_id=". (int) $GLOBALS["myenv"]["entity_types"]["entity_type_id"]. " and setting_id not in (select setting_id from entity_settings where entity_id=". (int) $GLOBALS["myenv"]["entities"]["entity_id"]. ")"), "settings", "name");


$productItemName = array();
$configuration = array();
$sku = array();
$skuAlt = array();
$skuAlt2 = array();
$brand = array();
$licensee = array();
$retailer = array();
$pricePerUnit = array();
$taxable = array();
$quantity = array();
$orders_record = &$local["orders"][$order_id];

$shipping_method_group_id = $orders_record["shipping_method_group_id"];
$shipping_method_groups_record=&$local["shipping_method_groups"][$shipping_method_group_id];
$shippingMethodName = htmlentities_win($shipping_method_groups_record["name"]);

$subtotal = 0;
$subtotal_taxable=0;
$shipping_amount=0;
$handlingAmount=0;

/*echo '<pre>'; print_r($local["rev"]["order_details"]["order_id"]);
echo '<pre>'; print_r($local["order_details"][6745226]);
echo '<pre>'; print_r($local["order_details"][6745307]);
echo '<pre>'; print_r($GLOBALS["myenv"]["sessions"]["language_id"]);
exit;*/
//echo '<pre>'; print_r($local["order_details"][6745226]); exit;

foreach ((array) $local["rev"]["order_details"]["order_id"][$order_id] as $order_detail_id)
{
$order_details_record=&$local["order_details"][$order_detail_id];
$exact_product_id=$order_details_record["exact_product_id"];
$exact_products_record=&$local["exact_products"][$exact_product_id];
$product_id=$exact_products_record["product_id"];
$products_record=&$local["products"][$product_id];
foreach ((array) $local["rev"]["product_language_map"]["product_id"][$product_id] as $product_language_map_id)
{
$product_language_map_record=&$local["product_language_map"][$product_language_map_id];
$product_name=$product_language_map_record["name"];

}
$productItemName[] = htmlentities_win($product_name);

$full_sku = $local["exact_products"][$order_details_record["exact_product_id"]]["full_sku"];
$sku[] = htmlentities($full_sku);
$alt_sku = $local["exact_products"][$order_details_record["exact_product_id"]]["alt_sku"];
$skuAlt[] = htmlentities($alt_sku);
$alt_sku_inventory = $local["exact_products"][$order_details_record["exact_product_id"]]["alt_sku_inventory"];
$skuAlt2[] = htmlentities($alt_sku_inventory);

$entity_id=$products_record["entity_id"];
$entities_record=&$local["entities"][$entity_id];
$user_id=$entities_record["user_id"];
$users_record=&$local["users"][$user_id];
$address_id=$users_record["address_id"];
$addresses_record=&$local["addresses"][$address_id];

$brand[] = $addresses_record["company_name"];

$entity_id=$products_record["entity_id2"];
$entities_record=&$local["entities"][$entity_id];
$user_id=$entities_record["user_id"];
$users_record=&$local["users"][$user_id];
$address_id=$users_record["address_id"];
$addresses_record=&$local["addresses"][$address_id];

$licensee[] = htmlentities_win($addresses_record["company_name"]);


$entity_id=$order_details_record["entity_id"];
$entities_record=&$local["entities"][$entity_id];
$user_id=$entities_record["user_id"];
$users_record=&$local["users"][$user_id];
$address_id=$users_record["address_id"];
$addresses_record=&$local["addresses"][$address_id];
$retailer[] = htmlentities_win($addresses_record["company_name"]);
$quantity[] = $order_details_record["quantity"];

/*$order_detail_discounts_record = &$local["order_detail_discounts"][$order_detail_id];*/
$order_detail_discounts_record = $local["order_details"][$order_detail_id];
$amount = $order_detail_discounts_record["price_each"]/100;
$pricePerUnit[] = $amount;
$limits = get_order_limits($order_id, array_keys((array)$local["rev"]["products"]["entity_id2"]));
$subtotal+=($order_detail_discounts_record["quantity"]*$amount); // /100
$subtotal_taxable=$limits["taxable_shipping"][156355];
$shipping_amount=$limits["shipping"][156355]/100;
$handlingAmount=$limits["handling"][156355]/100;
}

$address_id = $orders_record["address_id2"];
$addresses_record=&$local["addresses"][$address_id];

$shippingAddressID = $orders_record["address_id"];
$shipping_addresses_record=&$local["addresses"][$shippingAddressID];

$billingFirstName = $addresses_record["first_name"];
$billingLastName = $addresses_record["last_name"];
$billingCompanyName = $addresses_record["company_name"];
$billingAddress1 = $addresses_record["address1"];
$billingAddress2 = $addresses_record["address2"];
$billingCity = $addresses_record["city"];
$billingState = $addresses_record["state"];
$billingPostalCode = $addresses_record["postal_code"];
$billingCountry = $addresses_record["country"];

$shippingFirstName = $shipping_addresses_record["first_name"];
$shippingLastName = $shipping_addresses_record["last_name"];
$shippingCompanyName = $shipping_addresses_record["company_name"];
$shippingAddress1 = $shipping_addresses_record["address1"];
$shippingAddress2 = $shipping_addresses_record["address2"];
$shippingCity = $shipping_addresses_record["city"];
$shippingState = $shipping_addresses_record["state"];
$shippingPostalCode = $shipping_addresses_record["postal_code"];
$shippingCountry = $shipping_addresses_record["country"];


$orderID = $order_id;
$orderDate = $local['orders'][$order_id]['created'];
$status = 'open';
$customerID = $local['orders'][$order_id]['user_id'];

$phone_number_id=$orders_record["phone_number_id"];
$phone_numbers_record=&$local["phone_numbers"][$phone_number_id];
$phoneNumber = $phone_numbers_record['extension'];
$description = $phone_numbers_record['description'];
$countryCode = $phone_numbers_record['country_code'];

//echo '<pre>'; print_r($phone_numbers_record); exit;

$email_id=$orders_record["email_id"];
$emails_record=&$local["emails"][$email_id];

$email = $emails_record["email"];
$emailOptin = 'yes';
$activity= '';

$option = $shippingMethodName;
$method = 'UPS - Standard';

$subTotal = '$'.$subtotal;
$shippingAmount = '$'.$shipping_amount;
$handling = '$'.$handlingAmount;
$tax = '$'.$subtotal_taxable;
$finalamount = $subtotal+$shipping_amount+$handlingAmount+$subtotal_taxable;
$total = '$'.$finalamount;

$xml = new SimpleXMLElement('<orders/>');
$track = $xml->addChild('order');
$track->addAttribute("id",$orderID);
$track->addChild('date',$orderDate);
$track->addChild('status',$status);

$orders = $track->addChild('items');

//echo '<pre>'; print_r($productItemName); exit;

for($n = 0;$n<count($productItemName);$n++) {
$item = $orders->addChild('item');
$item->addChild('name',$productItemName[$n]);
$item->addChild('configuration');
$item->addChild('sku',$sku[$n]);
$item->addChild('sku_alt',$skuAlt[$n]);
$item->addChild('sku_alt2',$skuAlt2[$n]);
$item->addChild('brand',$brand[$n]);
$item->addChild('licensee',$licensee[$n]);
$item->addChild('retailer',$retailer[$n]);
$item->addChild('price_per_unit',$pricePerUnit[$n]);
$item->addChild('taxable','');
$item->addChild('quantity',$quantity[$n]);
$item->addChild('shipping_method',$shippingMethodName);
$item->addChild('notes');
}

$customer = $track->addChild('customer');
$customer->addAttribute("id",$customerID);


$billingAddress = $customer->addChild('billing_address');
$billingAddress->addChild('first_name',$billingFirstName);
$billingAddress->addChild('last_name',$billingLastName);
$billingAddress->addChild('company_name',$billingCompanyName);
$billingAddress->addChild('address1',$billingAddress1);
$billingAddress->addChild('address2',$billingAddress2);
$billingAddress->addChild('city',$billingCity);
$billingAddress->addChild('state',$billingState);
$billingAddress->addChild('postal_code',$billingPostalCode);
$billingAddress->addChild('country',$billingCountry);

$shippingAddress = $customer->addChild('shipping_address');
$shippingAddress->addChild('first_name',$shippingFirstName);
$shippingAddress->addChild('last_name',$shippingLastName);
$shippingAddress->addChild('company_name',$shippingCompanyName);
$shippingAddress->addChild('address1',$shippingAddress1);
$shippingAddress->addChild('address2',$shippingAddress2);
$shippingAddress->addChild('city',$shippingCity);
$shippingAddress->addChild('state',$shippingState);
$shippingAddress->addChild('postal_code',$shippingPostalCode);
$shippingAddress->addChild('country',$shippingCountry);

$phone = $customer->addChild('phone');
$phone->addChild('country_code',$countryCode);
$phone->addChild('number',$phoneNumber);
$phone->addChild('description',$description);

$customer->addChild('email',$email);
$customer->addChild('email_optin',$emailOptin);

$shipping = $track->addChild('shipping');
$shipping->addChild('option',$option);
$shipping->addChild('method',$method);
$shipping->addChild('activity',$activity);

$track->addChild('distributor_code');
$track->addChild('consumer_code');

$totals = $track->addChild('totals');
$totals->addChild('subtotal',$subTotal);

$expenses = $totals->addChild('expenses');
$expenses->addChild('type','shipping');
$expenses->addChild('amount',$shippingAmount);

$expensesHandling = $totals->addChild('expenses');
$expensesHandling->addChild('type','handling');
$expensesHandling->addChild('amount',$handling);

//$totals->addChild('shipping',$shippingAmount);
//$totals->addChild('handling',$handling);
$totals->addChild('tax',$tax);
$totals->addChild('total',$total);


Header('Content-type: text/xml');
$xmlString = $xml->asXML();

/*if($order_id == '5384094') {
echo $xmlString; die;
}*/


$fileName = $orderID.'.xml';
$dom = new DOMDocument;
$dom->preserveWhiteSpace = FALSE;
$dom->loadXML($xmlString);
$dom->save($sourcePath.$fileName);

//uploadFileToSFTP($sourcePath,$destinationPath,$fileName,$orderID);



$csvFileName = $orderID.'.csv';
$data_array = array();
$csvColumns = array(
		'Order ID',
		'Order Date',
		'Order Status',
		'Ship Name',
		//'Ship Last Name',
		'Ship Company Name',
		'Ship Address',
		'Ship Address',
		'Ship City',
		'Ship State',
		'Ship Postal Code',
		'Ship Country',
		'Bill Name',
		//'Bill Last Name',
		'Bill Company Name',
		'Bill Address',
		'Bill Address',
		'Bill City',
		'Bill State',
		'Bill Postal Code',
		'Bill Country',
		//'Phone Country Code',
		//'Phone Area Code',
		'Phone Number',
		'Phone Extension',
		'Phone Description',
		'Phone Opt-In',
		'Email',
		'Email Opt-In',
		'Quantity',
		'Brand Name',
		'Retailer Name',
		'Product Name',
		'SKU',
		'Complete SKU',
		'Alt SKU',
		'Alt SKU2',
		'Color',
		'Pole Length',
		'Size',
		'Retail Price Each',
		'Sales Price Each',
		'Promo Code',
		'Subtotal',
		'Shipping',
		'Handling',
		'Sales Tax',
		'Grand Total',
		'Shipping Option'
	);

$data_array[0] = $csvColumns;
// $data_array = array (
// array ('Order #',$orderID),
// array ('Order Date',$orderDate),
// array ('Order Status',$status),
// array ('Customer Name',$billingFirstName),
// array ('Billing Address 1',$billingAddress1),
// array ('Billing Address 2',$billingAddress2),
// array ('Phone Number',$phoneNumber),
// array ('Email',$email),
// array ('Shipping Address 1',$shippingAddress1),
// array ('Shipping Address 2',$shippingAddress2),
// );

for($n = 0;$n<count($productItemName);$n++) {
	/*array_push($data_array,array('Name',$productItemName[$n]));
	array_push($data_array,array('SKU',$sku[$n]));
	array_push($data_array,array('SKU ALT',$skuAlt[$n]));
	array_push($data_array,array('SKU ALT2',$skuAlt2[$n]));
	array_push($data_array,array('Brand',$brand[$n]));
	array_push($data_array,array('Licensee',$licensee[$n]));
	array_push($data_array,array('Retailer',$retailer[$n]));
	array_push($data_array,array('Price Per Unit',$pricePerUnit[$n]));
	array_push($data_array,array('Quantity',$quantity[$n]));
	array_push($data_array,array('Shipping Method',$shippingMethodName));*/
	$data_array[$n+1][] = $orderID;
	$data_array[$n+1][] = $orderDate;
	$data_array[$n+1][] = $status;
	$data_array[$n+1][] = $billingFirstName.' '.$billingLastName;
	//$data_array[$n+1][] = $billingLastName;
	$data_array[$n+1][] = $shippingCompanyName;
	$data_array[$n+1][] = $shippingAddress1;
	$data_array[$n+1][] = $shippingAddress2;
	$data_array[$n+1][] = $shippingCity;
	$data_array[$n+1][] = $shippingState;
	$data_array[$n+1][] = $shippingPostalCode;
	$data_array[$n+1][] = $shippingCountry;

	$data_array[$n+1][] = $billingFirstName.' '.$billingLastName;
	//$data_array[$n+1][] = $billingLastName;
	$data_array[$n+1][] = $billingCompanyName;
	$data_array[$n+1][] = $billingAddress1;
	$data_array[$n+1][] = $billingAddress2;
	$data_array[$n+1][] = $billingCity;
	$data_array[$n+1][] = $billingState;
	$data_array[$n+1][] = $billingPostalCode;
	$data_array[$n+1][] = $billingCountry;

	//$data_array[$n+1][] = $countryCode;
	//$data_array[$n+1][] = '';
	$data_array[$n+1][] = str_replace(' ','',str_replace('-','',$phone_numbers_record['area_code'].$phone_numbers_record['number_']));        
	$data_array[$n+1][] = '';      
	$data_array[$n+1][] = $description;
	$data_array[$n+1][] = 'no';
	$data_array[$n+1][] = $email;
	$data_array[$n+1][] = $emailOptin;

	$data_array[$n+1][] = $quantity[$n];
	$data_array[$n+1][] = $brand[$n];
	$data_array[$n+1][] = $retailer[$n];

	$data_array[$n+1][] = $productItemName[$n];
	$data_array[$n+1][] = $sku[$n];
	$data_array[$n+1][] = $sku[$n];
	$data_array[$n+1][] = $skuAlt[$n];
	$data_array[$n+1][] = $skuAlt2[$n];

	$data_array[$n+1][] = ''; //color
	$data_array[$n+1][] = ''; //pole length
	$data_array[$n+1][] = ''; //size
	$data_array[$n+1][] = $pricePerUnit[$n]; //Retail Price Each
	$data_array[$n+1][] = $pricePerUnit[$n]; //Sales Price Each
	$data_array[$n+1][] = ''; //Promo Code
 	$data_array[$n+1][] = $subTotal; //Subtotal
 	$data_array[$n+1][] = $shipping_amount; //Shipping
 	$data_array[$n+1][] = $handlingAmount; //Handling
 	$data_array[$n+1][] = $subtotal_taxable; //sales tax
 	$data_array[$n+1][] = $total; //grand total
 	$data_array[$n+1][] = $shippingMethodName; //shipping option


}
   
//array_push($data_array,array('Sub Total',$subTotal));
//array_push($data_array,array('Total',$total));

//echo '<pre>'; print_r($data_array); exit;

array_to_csv_download($data_array,$csvFileName,";",$sourcePath);

uploadFileToSFTP($sourcePath,$destinationPath,$csvFileName,$orderID);
die;

}
}
}

die;

// <sitemin orig_functions>
?>