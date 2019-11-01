<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Garbageremoval {

    function clear() {
        $CI = & get_instance();
        $CI->load->database();
        $new_time = date("Y-m-d H:i:s", strtotime('-30 minute'));
        $CI->db->delete('query', 'timestamp < "' . strtotime($new_time).'"');
        
        $CI = & get_instance();
        $CI->load->database();
        $new_time = date("Y-m-d H:i:s", strtotime('-30 minute'));
        $CI->db->delete('sessions', 'timestamp < "' . strtotime($new_time).'"');
    }

}
