<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Hak_akses_menu_model extends MY_Model{

        protected $table = 'hak_akses_menu';

        public function load_data($receive_data = array()){
            $this->db->select("id_menu, id_jns_admin", false);

            if (array_key_exists('where', $receive_data)) {
                $this->db->where($receive_data['where']);
            }
            if (array_key_exists('like', $receive_data)) {
                $this->db->or_like($receive_data['like']);
            }
            if (array_key_exists('order', $receive_data)) {
                $this->db->order_by($receive_data['order']);
            }
            if(array_key_exists('limit', $receive_data)){
                $limit = explode(",", $receive_data['limit']);
                $this->db->limit($limit[0], $limit[1]);
            }

            $table = $this->db->get($this->table);
            return $table;
        }

    }

?>
