<?php

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0); 
require APPPATH . 'libraries/REST_Controller.php';
//require_once("application/libraries/REST/REST_Controller.php");

class CommonAPI extends REST_Controller
{

    //NOTE: If pagination required then need to pass totalRecords to check whether require to return 404 or 204
    //NOTE: If need to handle status code other than 404 and 204 (208, 409, 406) pass status code from master.php and also pass status message to display.

    public function commonApiController($commonRes, $totalRecords = null, $statusCode = null, $statusMessage = null) {
        if($statusCode == null) {
            if ($totalRecords == null) {
                if ($commonRes) {
                    $this->commonResponseJson($commonRes,REST_Controller::HTTP_OK, '');
                } else {
                    $this->commonResponseJson($commonRes,REST_Controller::HTTP_NOT_FOUND, 'No data found.');
                }
            } else {
                if($totalRecords == 0) {
                    $this->commonResponseJson($commonRes,REST_Controller::HTTP_NOT_FOUND, '');
                } else {
                    if ($commonRes) {
                        $this->commonResponseJson($commonRes,REST_Controller::HTTP_OK, '');
                    } else {
                        $this->commonResponseJson($commonRes,REST_Controller::HTTP_NO_CONTENT, 'No more data found.');
                    }
                }
            }
        } else {
            $this->commonResponseJson($commonRes, $statusCode, $statusMessage);
        }

    }

    public function commonResponseJson($commonRes, $internalStatusCode, $statusMessage) {

        $this->response([
            'StatusCode' => $internalStatusCode,
            'StatusMessage' => $statusMessage,
            'ResponseData' => $commonRes
        ], REST_Controller::HTTP_OK);

    }

    public function getPostParams(){
        $requestData = array();
        $requestData = json_decode(file_get_contents('php://input'), true);
        return $requestData;
    }

    public function getGetParams($key){
        return $this->input->get($key);
    }

    public function getJsonDict($data) {
        return $value = json_decode(json_encode($data), true);
    }

}