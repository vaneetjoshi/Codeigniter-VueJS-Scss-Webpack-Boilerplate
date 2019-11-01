<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        ini_set('memory_limit', '-1');

//        $this->load->model('admin_model');
//        $this->App_Settings = $this->admin_model->getAppSettings();
    }

    public function index()
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(
                array(
                    'status' => true,
                    'message' => 'Api Connected Successfully'
                )
            ));

    }

    public function test_get($uid = '')
    {
        $tokenData = array();
        $tokenData['id'] = (isset($uid) && !empty($uid) ? (int)$uid : 101); //TODO: Replace with data for token
        $tokenData['timestamp'] = now();
        $output['token'] = AUTHORIZATION::generateToken($tokenData);
        $this->set_response($output, REST_Controller::HTTP_OK);
    }

    public function test_post()
    {
        $decodedToken = $this->__VerifyJWT();
        if ($decodedToken) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                    array(
                        'status' => true,
                        'message' => $decodedToken->id . ' Api Connected Successfully'
                    )
                ));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                    array(
                        'status' => false,
                        'message' => 'Invalid Token'
                    )
                ));
        }


    }


    private function __VerifyJWT()
    {
        $headers = $this->input->request_headers();

        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
            // return response if token is valid
            if ($decodedToken != false) {
                return $decodedToken;
            }
        }
        return false;
    }
}