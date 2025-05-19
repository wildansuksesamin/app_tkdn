<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Menu_model extends MY_Model{

        protected $table = 'menu';

        public function load_data($receive_data = array()){
            $this->db->select("id_menu, nama_menu, icon_menu, url_menu, parent_menu, urutan_menu, (select count(-1) from menu a where nama_menu not like '%[OFF]%' and a.parent_menu=menu.id_menu) jml_child", false);

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

        public function my_first_page(){
            $id_jns_admin = $this->session->userdata('id_jns_admin');
            $str = "SELECT url_menu FROM menu
                    WHERE id_menu = (
                    SELECT id_menu FROM hak_akses_menu
                    WHERE id_jns_admin=".$id_jns_admin." and 
                    id_menu in (select id_menu from menu where url_menu != '#')
                    ORDER BY id_menu ASC
                    LIMIT 1)";
            $exe = $this->db->query($str);
            return $exe->result_array();
        }

    }

?>
