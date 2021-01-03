<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FirebasePushNotification extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function sendFCM() {

    $url = 'https://android.googleapis.com/gcm/send';
    $fields = array(
        'registration_ids' => $_GET['id'],
        'data' => $message,
    );

    define('GOOGLE_API_KEY', 'AIzaSyCjctNK2valabAWL7rWUTcoRA-UAXI_3ro');

    $headers = array(
        'Authorization:key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );
    echo json_encode($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);
    if($result === false)
        die('Curl failed ' . curl_error());

    curl_close($ch);
    return $result;

    // $API_ACCESS_KEY = "AIzaSyAD_u-akURd0hOtogIEy5JcBNJMVFQtjg0";
    // $title = $_GET['title'];
    // $body = $_GET['body'];
    // $id = $_GET['id'];
    // $url = 'https://fcm.googleapis.com/fcm/send';

    // $fields = array (
    //         'registration_ids' => array (
    //                 $id
    //         ),               
    //         'priority' => 'high',
    //         'notification' => array(
    //                     'title' => $title,
    //                     'body' => $body,                            
    //         ),
    // );
    // $fields = json_encode ( $fields );

    // $headers = array (
    //         'Authorization: key=' . $API_ACCESS_KEY,
    //         'Content-Type: application/json'
    // );
    // $ch = curl_init ();
    // curl_setopt ( $ch, CURLOPT_URL, $url );
    // curl_setopt ( $ch, CURLOPT_POST, true );
    // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    // curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    // curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
    // $result = curl_exec ( $ch );
    // curl_close ( $ch );
}
}


/* End of file Application_model.php */

