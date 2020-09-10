<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';
  require APPPATH . '/libraries/CreatorJwt.php';

  class Login extends REST_Controller{
      public function __construct() {
        parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        $this->load->database();
      }

    //Get all data
    public function data_get() {
      $select = $this->db->get('commercial')->result_array();
      return $select;
    }
    //Get commercial by id
    function dataById_get($id) {
      $this->db->where('id');
      $this->db->get('commercial')->result_array();
    }

    // make a update by id
    public function verif_post($id){
        $this->db->where('id',$id);
        $insert = $this->db->get('commercial')->result_array();
        foreach ($insert as $value) {
          $value['status'] = 1;
          $this->db->update('commercial', $value, ['id'=> $id]);
          return $value['status'];
        }
        
    }
    // logOut
    public function exit_post(){
      $_POST = json_decode(file_get_contents('php://input'),true);
      $user = $this->input->post();
      $id=$this->input->post('id',TRUE);
      $this->db->get_where('commercial',array('id'=>$id));
      if ($this->db->affected_rows()>0) {
        $user['id'] = $id;
        $user['status'] = 0;
        $output = $this->db->update('commercial', $user, ['id'=> $id]);
        if (!empty($output)) {
          $this->set_response(['statut' => 200, 'message' => 'Déconnection réussie'],200);
        }else{
          $this->set_response(['statut' => 400, 'message' => 'Compte n\'est pas deconnecté'],400);
        }
        
      }else{
        $this->set_response(['statut' => 404, 'data' =>$id,'message' => 'Ce compte n\'est pas connecté'],404);
      }
    }
    //post commercial
    public function login_post(){
      $data = array();
      /*if (isset($this->post('mail')) && isset($this->post('nom')) && isset($this->post('password'))) {*/
        $pass = $this->post('password');
        $nom = $this->post('nom');
        $mail =$this->post('mail');
        if (!empty($pass) && !empty($nom) && !empty($mail)) {
          $this->db->where('email',$mail);
          $this->db->where('nom',$nom);
          $this->db->or_where('password',$pass);
          $insert = $this->db->get('commercial');
          $row = $insert->num_rows();
            if ($row > 0) {
              if ($insert->row('status') == 0) {
                $exist = password_verify($pass, $insert->row('password'));
                if($exist){
                  $data['id'] = $insert->row('id');
                  $data['email'] = $insert->row('email');
                  $data['nom'] = $insert->row('nom');
                  $data['status'] = $insert->row('status');
                  $this->verif_post($data['id']);
                  $data['status'] = $this->verif_post($data['id']);

                  $tokenData['id'] = $data['id'];
                  $tokenData['nom'] = $data['nom'];
                  $tokenData['email'] = $data['email'];
                  $tokenData['status'] = $data['status'];
                  $times = new DateTime();
                  $tokenData['expire'] = $times->getTimestamp() + (60*60*24*30*2);
                  

                  $jwtToken = $this->objOfJwt->GenerateToken($tokenData);

                  $this->set_response(['statut' => 200, 'data' =>$jwtToken,'message' => 'succès de la requete !'],200);
                }
                else{
                  $this->set_response(['statut' => 401,'data' =>$cpt = [$pass,$nom,$mail], 'message' => 'utilisateur non authentifié !'],401);
                } 
              }else {
                $this->set_response(['statut' => 403,'data' =>$cpt = [$pass,$nom,$mail], 'message' => 'Vous etes déja connectez !'],403);
              }
            } else {
              $this->set_response(['statut' => 401,'data' =>$cpt = [$pass,$nom,$mail], 'message' => 'utilisateur non authentifié !'],401);
            }
        }
  }
  }
?>  