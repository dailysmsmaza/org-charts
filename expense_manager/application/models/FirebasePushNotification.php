<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FirebasePushNotification extends MY_Model {

    public function __construct() {
        $this->return_as = 'object';
        
        parent::__construct();
    }

    function sendNotifications($post_data){
#API access key from Google API's Console

    define( 'API_ACCESS_KEY', 'AIzaSyCWFvrLe9kfOfLOv3UfRr48kCqN3whFmtA' );

    $json = json_decode(file_get_contents('php://input'), false);

    // $mobile_number = $post_data[COL_MOBILE_NUMBER];
    $title = $post_data['title'];
    $body = $post_data['body'];

    // echo $mobile_number;
    // $this->db->like(COL_MOBILE_NUMBER, trim($mobile_number));
    // $result = $this->db->get(TBL_USERS);
    // $users = $result->result_array();
    // $registrationIds = $users[0][COL_NOTIFICATION_TOKEN]; 
    $registrationIds = "frhV_Ie7_3Q:APA91bH2iEoqBXFpSoffT52zXjGgf3N8yRveyrFT309xULRYl-JuLQujICulynVopLYt2lv5v2reU2EsfrYPxhEIdnKbOSbZCE7oRn2zfnkaDO-21EeaeyzAaOs9bR6NqrjgNe6e61HU"; 

    // $registrationIds = "e1-mBRJwenQ:APA91bFsGaiPq7ZzqmvBtWC8uYEW5LYOULDuCzDk43b-rp_nPAgW3Fmx36G9oLDgkgX1bkZt8zSVPv9BVmgvcp1DjWXsMKbbVmEqtAhcrpbDaCJzM_01_18yRuWAMquz6cJbLd7ICLkd";//$_GET['id'];

#prep the bundle
    $msg = array
    (
        'body'  => $body,
        'title' => $title,
        'icon'  => 'myicon',/*Default Icon*/
        'sound' => 'mySound'/*Default sound*/
    );

    // This is Use For Notification
    $fields = array
    (
        'to'        => $registrationIds,
        'notification'  => $msg
    );
    
    // This is Use for Data

    // $fields = array
    // (
    //     'to'        => $notification_token,
    //     'data'  => $msg
    // );

    $headers = array
    (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

#Send Reponse To FireBase Server    
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );

#Echo Result Of FireBase Server
    // echo $result;
}
}


/* End of file Application_model.php */

