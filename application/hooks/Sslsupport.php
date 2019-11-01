<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sslsupport {

    function check_ssl() {
        $CI = & get_instance();

        if ($CI->config->config['EnableSSL'] == true) {
            $class = $CI->router->fetch_class();
            if ((in_array($class, array('cron'))) || $class=='cron') {
                // $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
                // if ($_SERVER['SERVER_PORT'] != 80) {
                //     redirect($CI->uri->uri_string());
                // }
            } else {
                $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
                if ($_SERVER['SERVER_PORT'] != 443) {
                    redirect($CI->uri->uri_string());
                }
            }
        } else {
            $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
            if ($_SERVER['SERVER_PORT'] != 80) {
                redirect($CI->uri->uri_string());
            }
        }

        /* if ($CI->config->config['EnableSSL'] == true) {

          $class = $CI->router->fetch_class();
          $method = $CI->router->fetch_method();
          $ssl = array('masteradmin/login', 'site');
          $partial = array('site', 'members', 'shop','customcontrols');
          if ((in_array("$class/$method", $ssl)) || (in_array($class, $partial))) {
          $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
          if ($_SERVER['SERVER_PORT'] != 443) {
          redirect($CI->uri->uri_string());
          }
          } else {
          $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
          if ($_SERVER['SERVER_PORT'] != 80) {
          redirect($CI->uri->uri_string());
          }
          }

          } */
    }

}
