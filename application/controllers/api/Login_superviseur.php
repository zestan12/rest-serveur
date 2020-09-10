<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';
  require APPPATH . '/libraries/CreatorJwt.php';


  class login_superviseur extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        $this->load->database();
    }
    // make a update by id in table global superviseur
    public function verifGlobal_post($id){
        $this->db->where('id_glo',$id);
        $insert = $this->db->get('superviseur-global')->result_array();
        foreach ($insert as $value) {
          $value['status'] = 1;
          $this->db->update('superviseur-global', $value, ['id_glo'=> $id]);
          return $value['status'];
        } 
    }
    // make a update by id in table superviseur
    public function verifSuperviseur_post($id){
        $this->db->where('id_sup',$id);
        $insert = $this->db->get('superviseur')->result_array();
        foreach ($insert as $value) {
          $value['status'] = 1;
          $this->db->update('superviseur', $value, ['id_sup'=> $id]);
          return $value['status'];
        } 
    }
    // connexion 
    function login_post() {
        $nom ='';
        $mail ='';
        $password ='';
        $data = array();
        $nom = $this->post('nom');
        $mail = $this->post('mail');
        $password = $this->post('password');

        if(!empty($nom) && !empty($mail) && !empty($password)) {
          $this->db->where('mail',$mail);
          $this->db->where('nom',$nom);
          $this->db->or_where('password',$password);
          $insert = $this->db->get('superviseur-global');
          $row = $insert->num_rows();
            if ($row > 0) {
                
                    if ($insert->row('status') == 0 && $insert->row('role') == 1) {
                        $hasf_pass = sha1($password);
                        if($hasf_pass === $insert->row('password')){
                            $data['id'] = $insert->row('id_glo');
                            $data['mail'] = $insert->row('mail');
                            $data['nom'] = $insert->row('nom');
                            $data['status'] = $insert->row('status');
                            $data['role'] = $insert->row('role');
                            $this->verifGlobal_post($data['id']);
                            $data['status'] = $this->verifGlobal_post($data['id']);
            
                            $tokenData['id'] = $data['id'];
                            $tokenData['nom'] = $data['nom'];
                            $tokenData['mail'] = $data['mail'];
                            $tokenData['status'] = $data['status'];
                            $tokenData['role'] = $data['role'];
                            $times = new DateTime();
                            $tokenData['expire'] = $times->getTimestamp() + (60*60*24*30*2);
                            
            
                            $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
            
                            $this->set_response(['statut' => 200, 'data' =>$jwtToken,'message' => 'succès de la requete !'],200);
                        }else{
                            $this->set_response(['statut' => 401,'data' =>$cpt = [$password,$nom,$mail], 'message' => 'utilisateur non authentifié !'],401);
                        } 
                    }else {
                        $this->set_response(['statut' => 403,'data' =>$cpt = [$password,$nom,$mail], 'message' => 'Vous etes déja connectez !'],403);
                    }
            }else {
                $this->db->where('mail',$mail);
                $this->db->where('nom',$nom);
                $this->db->or_where('password',$password);
                $insert = $this->db->get('superviseur');
                $row_sup = $insert->num_rows();
                if ($row_sup > 0) {
                    if ($insert->row('status') == 0) {
                        //$hasf_pass = password_hash($password,PASSWORD_BCRYPT);

                        //var_dump($hasf_pass);
                        $exist = password_verify($password, $insert->row('password'));
                        if($exist){
                            $data['id'] = $insert->row('id_sup');
                            $data['mail'] = $insert->row('mail');
                            $data['nom'] = $insert->row('nom');
                            $data['status'] = $insert->row('status');
                            $this->verifSuperviseur_post($data['id']);
                            $data['status'] = $this->verifSuperviseur_post($data['id']);
                            //var_dump($data);
                            $tokenData['id'] = $data['id'];
                            $tokenData['nom'] = $data['nom'];
                            $tokenData['mail'] = $data['mail'];
                            $tokenData['status'] = $data['status'];
                            $times = new DateTime();
                            $tokenData['expire'] = $times->getTimestamp() + (60*60*24*30*2);
                            
            
                            $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
            
                            $this->set_response(['statut' => 200, 'data' =>$jwtToken,'message' => 'succès de la requete !'],200);
                        }else{
                            $this->set_response(['statut' => 401,'data' =>$cpt = [$password,$nom,$mail], 'message' => 'utilisateur non authentifiéfffff !'],401);
                        } 
                    }else {
                        $this->set_response(['statut' => 403,'data' =>$cpt = [$password,$nom,$mail], 'message' => 'Vous etes déja connectez !'],403);
                    }
                }else {
                    $this->set_response(['statut' => 401,'data' =>$cpt = [$password,$nom,$mail], 'message' => 'utilisateur non authentifié !'],401);
                }
            }

        }
    }
    //logOut
    function exit_post() {
        
    } 
  }









































?>