<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';
  require APPPATH . '/libraries/CreatorJwt.php';

    class Modif_commerciaux extends REST_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        function modif_commerciaux_post() {
            $data = array();
            $nom = $this->post('nom');
            $prenom = $this->post('prenom');
            $email = $this->post('email');
            $id = $this->post('id');
            if (!empty($id) && !empty($nom) && !empty($email) && !empty($prenom)) {
                $data['nom'] = $nom;
                $data['prenom'] = $prenom;
                $data['email'] = $email;
                $this->db->update('commercial', $data, ['id'=> $id]);
                $this->set_response(['statut' => 200,'message' => 'succès'],200);
            }else {
                echo 'Erreur';
            }
        }
    }

?>    