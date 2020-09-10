<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';
  require APPPATH . '/libraries/CreatorJwt.php';

    class Modif_superviseur extends REST_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        function modif_superviseur_post() {
            $data = array();
            $nom = $this->post('nom');
            $prenom = $this->post('prenom');
            $mail = $this->post('mail');
            $id = $this->post('id_sup');
            if (!empty($id) && !empty($nom) && !empty($mail) && !empty($prenom)) {
                $data['nom'] = $nom;
                $data['prenom'] = $prenom;
                $data['mail'] = $mail;
                $this->db->update('superviseur', $data, ['id_sup'=> $id]);
                $this->set_response(['statut' => 200,'message' => 'succès'],200);
            }else {
                echo 'Erreur';
            }
        }
    }

?>    