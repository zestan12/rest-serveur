<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . '/libraries/CreatorJwt.php';

    class List_commerciaux extends REST_Controller{
        public function __construct() {
          parent::__construct();
          $this->objOfJwt = new CreatorJwt();
          $this->load->database();
        }

        function data_get($id) {
            $this->db->select('id,nom,prenom,email');
            $this->db->where('id_sup',$id);
            $insert = $this->db->get('commercial')->result_array();
            $this->set_response(['statut' => 200,'data' =>$insert ,'message' => 'succès'],200);
        }


    }    

?>        