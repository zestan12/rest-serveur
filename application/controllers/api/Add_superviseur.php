<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . '/libraries/CreatorJwt.php';

    class Add_superviseur extends REST_Controller{
        public function __construct() {
          parent::__construct();
          $this->objOfJwt = new CreatorJwt();
          $this->load->database();
        }

        function add_superviseur_post(){
            $data = array();
            $id = 0;
            $id = $this->post('id_glo');
            $nom = $this->post('nom');
            $prenom = $this->post('prenom');
            $mail = $this->post('mail');
            $password = $this->post('password');
            if (!empty($id) && !empty($nom) && !empty($prenom) && !empty($mail) && !empty($password)) {
                $pass = password_hash($password,PASSWORD_BCRYPT);
                $data['nom'] = $this->post('nom');
                $data['prenom'] = $this->post('prenom');
                $data['mail'] = $this->post('mail');
                $data['password'] = $pass;
                $data['id_glo'] = $this->post('id_glo');
                $this->db->insert('superviseur', $data);
                $this->set_response(['statut' => 200,'message' => 'Sucèss'],200);
            }else {
                echo 'erreur';
            }
        }













    }
?>











