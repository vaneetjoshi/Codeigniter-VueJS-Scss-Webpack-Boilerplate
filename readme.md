### Codeigniter VueJS Webpack Boilerplate
    Boilerplate Template for Codeigniter 
    Pre Configured with Rest API + JWT + Web Sockets + VueJS + SCSS + Webpack
    
### Features
    => Codeigniter 3
    => Rest API
    => JWT
    => Web Sockets
    => VueJS
    => SCSS
    => WebPack
    

### Changes Required

    change database settings in application/config/database.php
    change folder path in .htaccess
    

### Create New Rest API Controller
    # First Include This File
    
    require APPPATH . '/libraries/REST_Controller.php';

    # Extent Controller 
    
    class AdminAPI extends REST_Controller{
    
    }
    
### Generate Auth Token
    
    $tokenData = array();
    $tokenData['id'] = 1; // Replace with data for token
    $tokenData['timestamp'] = now();
    $output['token'] = AUTHORIZATION::generateToken($tokenData);
    $this->set_response($output, REST_Controller::HTTP_OK);    
    
### Verify Token
    
    $decodedToken = $this->__VerifyJWT();
    
    if($decodedToken){
        // VALID TOKEN
    }else{
        // INVALID TOKEN
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
    
### VueJS Folder
    All VueJS Files must be placed under "/VueJS/js/" folder
    
### SCSS Folder
    All SCSS Files must be placed under "/SCSS/" folder
    
### Export VueJS + SCSS Code for Production
    npm run production
    
### Start Web Socket Server
    php index.php websocket index
    