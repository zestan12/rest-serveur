<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';

  class LogOut extends REST_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->database();
      }
    // logOut
    public function exit_post($id){
        $this->db->where('id',$id);
        $insert = $this->db->get('commercial')->result_array();
        foreach ($insert as $value) {
          $value['status'] = 0;
          $this->db->update('commercial', $value, ['id'=> $id]);
          var_dump($value);
        }
    }
  }

?>