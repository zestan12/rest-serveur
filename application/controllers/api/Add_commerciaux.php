<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';
  require APPPATH . '/libraries/CreatorJwt.php';

  class Add_commerciaux extends REST_Controller{
    public function __construct() {
      parent::__construct();
      $this->objOfJwt = new CreatorJwt();
      $this->load->database();
    }

    //Add commerciaux
    function add_commerciaux_post() {
        $data = array();
        $id = 0;
        $id = $this->post('id_sup');
        $nom = $this->post('nom');
        $prenom = $this->post('prenom');
        $mail = $this->post('mail');
        $password = $this->post('password');

        if(!empty($id) && !empty($nom) && !empty($prenom) && !empty($mail) && !empty($password)) {
            $pass = password_hash($password,PASSWORD_BCRYPT);
            $data['nom'] = $this->post('nom');
            $data['prenom'] = $this->post('prenom');
            $data['email'] = $this->post('mail');
            $data['password'] = $pass;
            $data['id_sup'] = $this->post('id_sup');
            $this->db->insert('commercial', $data);
            $this->set_response(['statut' => 200,'message' => 'Sucèss'],200);
        } else {
            echo 'erreur';
        }
    }


  }

?>    