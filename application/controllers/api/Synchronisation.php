<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';

  class Synchronisation extends REST_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
    //Ajout un client
    public function ajout_post() 
    {
 	 	if ($this->post()){
      $_POST = $this->post();
      $cmp = count($_POST);
     
      $insert = '';
        foreach($_POST as $key=>$value){
          $value['autresServices'] = json_encode($value['autresServices']);
          
          $check = $this->getverify($value);
          $checkId= $this->getverifyID($value);
          if($check === true){
            if($checkId === false){
              //var_dump($value);
              $insert = $this->db->insert('client', $value);

            }else{
            $insert = $this->update($value);

            }
          }

        $cmp--;
        }
        $this->set_response(['statut' => ($insert) ? 200 : 400,'inserer'=>(count($_POST) - $cmp).' sur '.count($_POST) , 'message' => 'succès de la requete !'],200);
      }else {
        $this->set_response(['statut'=> 404 , 'data'=>$this->post(), 'message'=>'erreur, veuillez verifier tous vos champs svp !'],200);
      }
    }


        public function update($arg) 
    {
 	 	if ($arg){
      $_POST = $arg;
      $insert = '';
          $_POST['autresServices'] = json_encode($_POST['autresServices']);
          $check = $this->getverifyID($_POST);
          if($check === true){
            $insert = $this->db->update('client', $_POST, ['id'=>$_POST['id']]);
          }
          return $insert;

        //$this->set_response(['statut' => ($insert) ? 200 : 400, 'message' => 'succès de la requete !'],200);
      }else {
        return false;
        //$this->set_response(['statut'=> 404 , 'data'=>$this->post(), 'message'=>'erreur, veuillez verifier tous vos champs svp !'],200);
      }
    }

    private function getverify($param){
      $select = $this->db->get_where('client', $param)->result_array();
      if($select){
          return false;
      }else{
        return true;
      }
    }

    private function getverifyID($param){
      $select = $this->db->get_where('client', ['id'=>$param['id']])->result_array();
      if($select){
          return true;
      }else{
        return false;
      }
    }
	public function index_get(){
	}
	}
?>
