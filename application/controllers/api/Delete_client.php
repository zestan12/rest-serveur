<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';

    class Delete_client extends REST_Controller{
        public function __construct() {
          parent::__construct();
          $this->load->database();
        }

        function deteleClient_get($id) {
            if ($id != null) {
                $this->db->where('id_p', $id);
                $this->db->delete('client');
                $this->set_response(['statut' => 200,'message' => 'succès'],200);
            }else {
                $this->set_response(['statut' => 405,'message' => 'Méthode de requête non autorisée.'],405);
            }
        }


    }

?>    