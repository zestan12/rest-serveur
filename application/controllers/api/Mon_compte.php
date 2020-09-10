<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';
  require APPPATH . '/libraries/CreatorJwt.php';

    class Mon_compte extends REST_Controller{
      public function __construct() {
        parent::__construct();
        $this->load->database();
      }
      function infoCompte_get($id){
        $this->db->select('nom,prenom,mail');
        $this->db->where('id_sup',$id);
        $insert = $this->db->get('superviseur')->result_array();
        $this->set_response(['statut' => 200,'data' =>$insert ,'message' => 'succès'],200);
      }


    }

?>      