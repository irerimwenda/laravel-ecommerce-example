<?php

namespace App\Helpers;
use anlutro\LaravelSettings\Facade as Setting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Carbon\Carbon;

class  Mpesa{

//global $database;
//$phone = $_GET['n'];
//$phone= $_POST['phone'];
//$amount =  $_POST['amnt'];

//$database->address($_POST['id'],$_POST['city'],$_POST['street'],$_POST['hseno']);

function get_accesstoken(){
    $credentials = base64_encode('s0V0g6quhI93Yga8VnBS8ANommGCVeGm:SY1mNEPtVm26AOXG');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials, 'Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response);

    $access_token = $response->access_token;

    // The above $access_token expires after an hour, find a way to cache it to minimize requests to the server
    if(!$access_token){
        throw new Exception("Invalid access token generated");
        return FALSE;
    }
    return $access_token;
}

}

$access_token='WITxkDMaaLZdjWFqgrsP1LYSF5mv';

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header

$BusinessShortCode = 600000;
$LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
//$date = new DateTime();
$timestamp = Carbon::now()->format('YmdHis');
$password=base64_encode($BusinessShortCode.$LipaNaMpesaPasskey.$timestamp);

$curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => 5,
    'PartyA' => '254791205989',
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => '254791205989',
    'CallBackURL' => ' https://82e21e95.ngrok.io/Helpers/response.php',
    'AccountReference' => 'PaymentTest',
    'TransactionDesc' => 'TestEnv',
    'InvoiceNumber' => '123456'
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
//echo $curl_response;


?>
<script src="js/jquery.js"></script>
<script>
setTimeout(
    function(){
        document.write("Waiting MPESA confirmation...");
        //location.href="success.php"
        },15000);
</script>

}
