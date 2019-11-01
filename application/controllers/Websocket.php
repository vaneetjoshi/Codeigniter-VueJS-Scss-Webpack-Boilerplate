<?php

class Websocket extends CI_Controller
{
    public function index()
    {
        // Load package path
        $this->load->add_package_path(FCPATH.'vendor/romainrg/ratchet_client');
        $this->load->library('ratchet_client');
        $this->load->remove_package_path(FCPATH.'vendor/romainrg/ratchet_client');

        // Run server
        $this->ratchet_client->set_callback('auth', array($this, '_auth'));
        $this->ratchet_client->set_callback('event', array($this, '_event'));
        $this->ratchet_client->run();
    }

    public function _auth($datas = null)
    {
        $decodedToken = $this->__VerifyJWT($datas);
        // Here you can verify everything you want to perform user login.
        // However, method must return integer (client ID) if auth succedeed and false if not.
        return (!empty($decodedToken->id)) ? $decodedToken->id : false;
    }

    public function _event($datas = null)
    {
        // Here you can do everyting you want, each time message is received
        echo 'Hey ! I\'m an EVENT callback'.PHP_EOL;
    }

    private function __VerifyJWT($datas)
    {
        if (isset($datas->Token) && !empty($datas->Token)) {
            $decodedToken = AUTHORIZATION::validateTimestamp($datas->Token);
            // return response if token is valid
            if ($decodedToken != false) {
                return $decodedToken;
            }
        }
        return false;
    }

}