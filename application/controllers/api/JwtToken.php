<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . '/libraries/CreatorJwt.php';
    
    class JwtToken extends CI_Controller{
        public function __construct() {
          parent::__construct();
          $this->objOfJwt = new CreatorJwt();
          $this->load->database();
        }
         /*************Ganerate token**************/
         public function LoginToken()
         {
            $tokenData['uniqueId'] = '11';
            $tokenData['role'] = 'alamgir';
            $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
            $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
            echo json_encode(array('Token'=>$jwtToken));
        }








    }    
?>