<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendSurveyNotifications($surveyId,$patientIds)
    {
                $postdata  = array('surveyId' => $surveyId, 'listPatient' => $patientIds);
                $header = array('Content-Type: application/json',"SecurityToken: 123456");
// dump( $postdata);
// dd(json_encode($postdata));
   if (\App::environment(['Production'])) {
            $url = "https://www.compliancereward.com/App/surveyNotificationWs";
            //  $url = "https://compliancereward.ssasoft.com/CRQA/PMSGenericTextFlow?$postdata";
        
        }
        else if (\App::environment(['staging'])) {
            $url = "https://compliancereward.ssasoft.com/surveyNotificationWs";        
        }else{
            $url = "https://compliancereward.ssasoft.com/CRQA/surveyNotificationWs";            
        }

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch,CURLOPT_URL,$url);
                // curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER,  $header );
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postdata));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $contents = curl_exec($ch);
                
                if(curl_errno($ch)){
                    throw new Exception(curl_error($ch));
                }
                
                curl_close($ch);
                
                if($contents  === false){
                    //  echo 'Curl error: ' . curl_error($ch);
                }else{
                    //   echo 'Operation completed without any errors';
                }
                
                //dd($contents);
                return $contents;            
            }




            public function sendBulkReminder($patientIds)
            {
                        $postdata  = array('listOfOrders' => $patientIds);
                        $header = array('Content-Type: application/json');
        // dump( $postdata);
        // dd(json_encode($postdata));
           if (\App::environment(['Production'])) {
                    $url = "https://www.compliancereward.com/App/sendRefillReminderManuallyWs";
                    //  $url = "https://compliancereward.ssasoft.com/CRQA/PMSGenericTextFlow?$postdata";
                
                }
                else if (\App::environment(['staging'])) {
                    $url = "https://compliancereward.ssasoft.com/sendRefillReminderManuallyWs";        
                }else{
                    $url = "https://compliancereward.ssasoft.com/CRQA/sendRefillReminderManuallyWs";            
                }
        
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
                        curl_setopt($ch,CURLOPT_URL,$url);
                        // curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_HTTPHEADER,  $header );
                        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postdata));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $contents = curl_exec($ch);
                        
                        if(curl_errno($ch)){
                            throw new Exception(curl_error($ch));
                        }
                        
                        curl_close($ch);
                        
                        if($contents  === false){
                            //  echo 'Curl error: ' . curl_error($ch);
                        }else{
                            //   echo 'Operation completed without any errors';
                        }
                        
                        // dd($contents);
                        return $contents;            
                    }


    public function sendEnrollment($phoneNumber){
        
        $postdata = "PhoneNumber=$phoneNumber&Message=TMCWEB";
        if (\App::environment(['Production'])) {
            $url = "https://www.compliancereward.com/App/PMSGenericTextFlow?$postdata";
            //  $url = "https://compliancereward.ssasoft.com/CRQA/PMSGenericTextFlow?$postdata";
        
        }elseif (\App::environment(['staging'])) {
            $url = "https://compliancereward.ssasoft.com/PMSGenericTextFlow?$postdata";
        }else{
            $url = "https://compliancereward.ssasoft.com/CRQA/PMSGenericTextFlow?$postdata";
        }
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        $contents = curl_exec($ch);
       // die(print_r($contents));
        
        return $contents;
    }

    
    public function refillOrderGenerate($orderId,$token){
     
        $json_data =  array('listOrder'=>['orderId'=>$orderId]);
        $json_data=json_encode($json_data);
        $postdata = "listOrder=$json_data";

        if (\App::environment(['Production'])) {
            $url = "https://www.compliancereward.com/App/updateOrderStatusWs";
             // $url = "https://compliancereward.ssasoft.com/CRQA/updateOrderStatusWs";
        
        }else if(\App::environment(['staging'])) {
            $url = "https://compliancereward.ssasoft.com/updateOrderStatusWs";
        }else{
            $url = "https://compliancereward.ssasoft.com/CRQA/updateOrderStatusWs";
        }

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"listOrder\"\r\n\r\n{\"listOrder\":[{\"orderId\":\"$orderId\"}]}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
    "securitytoken: $token"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//   echo $response;
}
return $response=json_decode($response);
die(print_r($response));

}



    public function sendNotification($patientId,$orderId){
        if (\App::environment(['Production'])) {
            // $url = "https://compliancereward.ssasoft.com/CRQA/orderPlaceNotificationWs?PatientId=$patientId&OrderId=$orderId";
              $url = "https://www.compliancereward.com/App/orderPlaceNotificationWs?PatientId=$patientId&OrderId=$orderId";

        }else if(\App::environment(['staging'])){
            $url = "https://compliancereward.ssasoft.com/orderPlaceNotificationWs?PatientId=$patientId&OrderId=$orderId";
        }else{
             $url = "https://compliancereward.ssasoft.com/CRQA/orderPlaceNotificationWs?PatientId=$patientId&OrderId=$orderId";
        }
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        $contents = curl_exec($ch);
//        die(print_r($contents)); 
        return $contents;
    }



    public function sendNotificationOrderStatus($orderId,$orderStatusId,$token){
                
        
        $postdata  = array('id' => $orderId, 'orderStatusId' => $orderStatusId);
        // $postdata = http_build_query($postdata);
         $header = array('Content-Type: application/json',"SecurityToken: ".$token);
//    $header = array(  "cache-control: no-cache",
//    "content-type: application/json",
//    "securitytoken: 30ac6db614b35642e8892befee83d1de");
                if (\App::environment(['Production'])) {
                    $url = "https://www.compliancereward.com/App/sendNotificationByPharmacyWs";
                    // $url = "https://compliancereward.ssasoft.com/CRQA/sendNotificationByPharmacyWs";
                
                }else if(\App::environment(['staging'])){
                    $url = "https://compliancereward.ssasoft.com/sendNotificationByPharmacyWs";
                }else{
                    $url = "https://compliancereward.ssasoft.com/CRQA/sendNotificationByPharmacyWs";
                }

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                // curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER,  $header );
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postdata));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $contents = curl_exec($ch);
                curl_close($ch);
                if($contents  === false)
                {
                  //  echo 'Curl error: ' . curl_error($ch);
                }
                else
                {
                 //   echo 'Operation completed without any errors';
                }
                   
                return $contents;
            }

            public function sendNotificationAnswerAlert($qId,$patientId){
                
        
                $postdata = "PatientId=$patientId&QuestionID=$qId";
                // $postdata = http_build_query($postdata);
                //  $header = array('Content-Type: application/json',"SecurityToken: ".$token);
        //    $header = array(  "cache-control: no-cache",
        //    "content-type: application/json",
        //    "securitytoken: 30ac6db614b35642e8892befee83d1de");
                        if (\App::environment(['Production'])) {
                            $url = "https://www.compliancereward.com/App/answerAlertNotificationWs?$postdata";
                          // $url = "https://compliancereward.ssasoft.com/CRQA/answerAlertNotificationWs?$postdata";
                        
                        }else if(\App::environment(['staging'])){
                            $url = "https://compliancereward.ssasoft.com/answerAlertNotificationWs?$postdata";
                        }else{
                            $url = "https://compliancereward.ssasoft.com/CRQA/answerAlertNotificationWs?$postdata";
                        }
        
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL,$url);
                        // curl_setopt($ch, CURLOPT_HEADER, 1);
                        // curl_setopt($ch, CURLOPT_HTTPHEADER,  $header );
                        // curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($postdata));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $contents = curl_exec($ch);
                        curl_close($ch);
                        if($contents  === false)
                        {
                          //  echo 'Curl error: ' . curl_error($ch);
                        }
                        else
                        {
                         //   echo 'Operation completed without any errors';
                        }
                    //    die(print_r($contents));
                        return $contents;
                    }


                 /*   public function refillOrderGenerate1($orderId,$token){
        
                        $json_data =  array('listOrder'=>['orderId'=>$orderId]);
                        $json_data=json_encode($json_data);
                        $postdata = "listOrder=$json_data";
                        $header = array('Content-type: application/json',"SecurtyToken:".$token);
        
                        if (\App::environment(['Production'])) {
                            $url = "https://compliancereward.ssasoft.com/CRQA/updateOrderStatusWs";
                        
                        }else{
                            $url = "https://compliancereward.ssasoft.com/CRQA/updateOrderStatusWs";
                        }
        
                        print_r($header);
                        print_r($postdata);
                        $curl = curl_init("https://compliancereward.ssasoft.com/CRQA/updateOrderStatusWs");
                        // curl_setopt($ch,CURLOPT_URL,$url);
                        // curl_setopt($ch, CURLOPT_HEADER, 1);
                       
                    
                        
                        $h = array(
                            'SecurtyToken: '.$token,
                            'Content-Type: ',
                        );
                        $headers = 
                        array(
                             "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            "postman-token: bc2bbd2a-d159-bbf6-9715-75d9879be00d",
            "securitytoken: 30ac6db614b35642e8892befee83d1de"
                            );
                            curl_setopt($curl, CURLOPT_HEADER,true);
                        curl_setopt($curl, CURLOPT_HTTPHEADER,  $headers );
                        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl,CURLOPT_POSTFIELDS,$postdata);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        // curl_setopt($curl, CURLOPT_VERBOSE, 1);
                        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                        // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                        $curlErr = curl_error($curl);
                        dump($curlErr);
                        $contents = curl_exec($curl);
                        $information = curl_getinfo($curl);
                        dump($information);
                        $curlErr = curl_error($curl);
                        dump($curlErr);
                        dump($contents);
                        curl_close($curl);
                        if($contents  === false)
                        {
                            echo 'Curl error: ' . curl_error($ch);
                        }
                        else
                        {
                            echo 'Operation completed without any errors';
                        }
                        
                       die(print_r(json_decode($contents)));
                        
                        return $contents;
                    }
        
*/


                      public function sendDownloadLink($phoneNumber){
        
        $postdata = "mobileNumber=$phoneNumber";
        if (\App::environment(['Production'])) {
            $url = "https://www.compliancereward.com/App/sendAppUrlLinkSMSWs?$postdata";
            //  $url = "https://compliancereward.ssasoft.com/CRQA/PMSGenericTextFlow?$postdata";
        
        }elseif (\App::environment(['staging'])) {
            $url = "https://compliancereward.ssasoft.com/sendAppUrlLinkSMSWs?$postdata";
        }else{
            $url = "https://compliancereward.ssasoft.com/CRQA/sendAppUrlLinkSMSWs?$postdata";
        }
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch,CURLOPT_POST,1);
        // curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        $contents = curl_exec($ch);
       // die(print_r($contents));
        
        return $contents;
    }


    public function phone_change_message($phone, $message){
        $data = array(
    'User'          => '121dezi',
    'Password'      => 'light@121!',
    'PhoneNumbers'  => array($phone),
    // 'Groups'        => array('honey lovers'),
   // 'Subject'       => 'test from php',
    'Message'       => $message,
    // 'StampToSend'   => '1305582245',
    // 'MessageTypeID' => 1
);

$curl = curl_init('https://app.tellmycell.com/sending/messages?format=json');
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// If you experience SSL issues, perhaps due to an outdated SSL cert
// on your own server, try uncommenting the line below
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($curl);
curl_close($curl);

$json = json_decode($response);
$json = $json->Response;

if ( 'Failure' == $json->Status ) {
    $errors = array();
    if ( !empty($json->Errors) ) {
        $errors = $json->Errors;
    }

    return 'Status: ' . $json->Status . "\n" .
         'Errors: ' . implode(', ' , $errors) . "\n";
} else {
    $phoneNumbers = array();
    if ( !empty($json->Entry->PhoneNumbers) ) {
        $phoneNumbers = $json->Entry->PhoneNumbers;
    }

    $localOptOuts = array();
    if ( !empty($json->Entry->LocalOptOuts) ) {
        $localOptOuts = $json->Entry->LocalOptOuts;
    }

    $globalOptOuts = array();
    if ( !empty($json->Entry->GlobalOptOuts) ) {
        $globalOptOuts = $json->Entry->GlobalOptOuts;
    }

    $groups = array();
    if ( !empty($json->Entry->Groups) ) {
        $groups = $json->Entry->Groups;
    }

    return 'Status: ' . $json->Status . "\n" .
         'Message ID : ' . $json->Entry->ID . "\n" .
         'Subject: ' . $json->Entry->Subject . "\n" .
         'Message: ' . $json->Entry->Message . "\n" .
         'Message Type ID: ' . $json->Entry->MessageTypeID . "\n" .
         'Total Recipients: ' . $json->Entry->RecipientsCount . "\n" .
         'Credits Charged: ' . $json->Entry->Credits . "\n" .
         'Time To Send: ' . $json->Entry->StampToSend . "\n" .
         'Phone Numbers: ' . implode(', ' , $phoneNumbers) . "\n" .
         'Groups: ' . implode(', ' , $groups) . "\n" .
         'Locally Opted Out Numbers: ' . implode(', ' , $localOptOuts) . "\n" .
         'Globally Opted Out Numbers: ' . implode(', ' , $globalOptOuts) . "\n";
}
    }
}
