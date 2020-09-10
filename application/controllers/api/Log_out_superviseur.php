<?php 
  defined('BASEPATH') OR exit('No direct script access allowed');
  require APPPATH . 'libraries/REST_Controller.php';

    class Log_out_superviseur extends REST_Controller{
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }
        //logOut superviseur
        function exit_superviseur_post() {
            $id = $this->post('id');
            $role = $this->post('role');
            if (!empty($id) && !empty($role)) {
                if ($role === 1) {
                    $this->db->where('id_glo', $id);
                    $this->db->where('role', $role);
                    $insert = $this->db->get('superviseur-global')->result_array();
                    foreach ($insert as $value) {
                        $value['status'] = 0;
                        $this->db->update('superviseur-global', $value, ['id_glo'=> $id]);
                        $this->set_response(['statut' => 200, 'message' => 'Déconnection réussie'],200);
                    }
                }
            } else if (!empty($id)) {
                $this->db->where('id_sup', $id);
                $insert = $this->db->get('superviseur')->result_array();
                foreach ($insert as $value) {
                    $value['status'] = 0;
                    $this->db->update('superviseur', $value, ['id_sup'=> $id]);
                    $this->set_response(['statut' => 200, 'message' => 'Déconnection réussie'],200);
                }
            }
        }























    }













?>