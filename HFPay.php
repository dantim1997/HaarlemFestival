<?php
require_once( "Autoloader.php");
/*
 * Make sure to disable the display of errors in production code!
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once ("mollie/vendor/autoload.php");
require_once ("mollie/examples/functions.php");
/*
 * Initialize the Mollie API library with your API key.
 *
 * See: https://www.mollie.com/dashboard/developers/api-keys
 */

$Config = Config::getInstance();

$MakeOrder = new MakeOrder;
$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey($Config->GetMollieKey());

$payment = $mollie->payments->create([
    "amount" => [
        "currency" => "EUR",
        "value" => $MakeOrder->GetPrice()
    ],
    "description" => "Kaartjes Haarlem Fest",
    "redirectUrl" => $Config->GetWebURL()."/HFPay.php",
    "webhookUrl"  => $Config->GetWebURL()."/HFWebHook.php",
]);

header("Location: " . $payment->getCheckoutUrl(), true, 303);
?>