<?php

$callbackJSONData=file_get_contents('php://input');
$callbackData=json_decode($callbackJSONData);
$resultCode=$callbackData->Body->stkCallback->ResultCode;
$resultDesc=$callbackData->Body->stkCallback->ResultDesc;
$merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
$checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;
$amount=$callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$mpesaReceiptNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$balance=$callbackData->Body->stkCallback->CallbackMetadata->Item[2]->Value;
$transactionDate=$callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
$phoneNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;

if($resultCode == 0)
{

 //$session->sendMpesa($resultCode,$resultDesc,$merchantRequestID,$checkoutRequestID,$amount,$mpesaReceiptNumber,$balance,$transactionDate,$phoneNumber);
 $session->payWithMpesa($resultCode,$resultDesc,$merchantRequestID,$checkoutRequestID,$amount,$mpesaReceiptNumber,$balance,$transactionDate,$phoneNumber);
  // $_SESSION['mpesa']=$mpesaReceiptNumber;
   	 //header("Location: http://127.0.0.1/web/success.php");
//$database->updateOrders($session->Id,"paid");
//  $database->payWthMpesa($resultCode,$amount,$phoneNumber);
echo $callbackData;
        //Return a success response to m-pesa
        $response = array(
            'ResultCode' => 0,
            'ResultDesc' => 'Success'
        );
        echo json_encode($response);
}
else{
    //Return a error response to m-pesa
    $response = array(
        'ResultCode' => 1,
        'ResultDesc' => 'Transaction Failed'
    );
    echo json_encode($response);
}

?>
