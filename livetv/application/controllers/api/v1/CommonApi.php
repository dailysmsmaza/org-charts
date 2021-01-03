<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class CommonApi extends REST_Controller {

	public function commonResponseJson($statusCode, $statusMessage, $response)
	{
		$this->response([
            'StatusCode' => $statusCode,
            'StatusMessage' => $statusMessage,
            'ResponseData' => $response
			], REST_Controller::HTTP_OK);
	}

}
