<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . '/libraries/CreatorJwt.php';

    class List_client extends REST_Controller{
        public function __construct() {
          parent::__construct();
          $this->objOfJwt = new CreatorJwt();
          $this->load->database();
        }
        function data_get($id){
            $this->db->distinct();
            $this->db->select('id_p,nomCommercial,nomEntreprise,nomPersonne,coordonneesPersonne,montant,localisation,dateRDV,autresServices');
            $this->db->from('client');
            $this->db->join('commercial','commercial.id = client.id_commercial');
            $this->db->join('superviseur', $id .'= commercial.id_sup');
            $insert = $this->db->get()->result_array();
            $this->set_response(['statut' => 200,'data' =>$insert ,'message' => 'succès'],200);
        }
/*         function data_get() {
            $insert = $this->db->get('client')->result_array();
            $this->set_response(['statut' => 200,'data' =>$insert ,'message' => 'succès'],200);
        }  */   
    }


?>        