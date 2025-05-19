<?php
class MY_Model extends CI_Model
{

    protected $table = null;
    protected $primary_key = null;

    function __construct()
    {
        parent::__construct();
    }
    function call_func_db($nama_function){
        $row = $this->db->query("select ".$nama_function." as data")->row();
        if ($row) {
            return $row->data;
        }
        else
            return '';
    }
    function generate_id($table, $field, $prefix, $length){
        $row = $this->db->query("select IFNULL(CAST(substr(MAX(".$field."), -".$length.") AS UNSIGNED), 0)+1 JML from ".$table." where LEFT(".$field.", (LENGTH(".$field.")-".$length."))='".$prefix."'")->row();
        if ($row) {
            //get length of count data//
            $jml_car = strlen($row->JML);
            $sisa = $length - $jml_car;

            $rangkai = "";
            for($i=0; $i<$sisa; $i++){
                $rangkai .= "0";
            }

            $generate_id = $prefix.$rangkai.$row->JML;
        }
        else
            return 0;

        return $generate_id;
    }
    function max_value($table, $field){
        $row = $this->db->query("select IFNULL(MAX(".$field."), 0)+1 JML from ".$table)->row();
        if ($row) {
            return $row->JML;
        }
        else
            return 0;

    }
    function count_viewer($data = array()){
        $row = $this->db->query("select ".$data['field_view']." jml_view from ".$data['table']." where ".$data['field_id']."='".$data['id']."'")->row();
        ($row ? $jml= $row->jml_view : $jml = 0);
        $jml++;

        //save to table..
        $table = $data['table'];
        $insert_data = array($data['field_view'] => $jml);
        $where = array($data['field_id'] => $data['id']);
        $this->update($insert_data, $where, $table);
    }
    function is_available($where, $table = null){
        if($table === null) $table = $this->table;

        $this->db->where($where);
        $this->db->from($table);
        $jml = $this->db->count_all_results();

        if($jml == 0)
            return false;
        else
            return true;
    }

    function save($data, $executor = null, $table_executor = null, $table = null){
        if($table === null) $table = $this->table;

//        $result = $this->cek_duplikat(array($this->primary_key => $data[$this->primary_key]));
        //$data = array('nama_tabel' => 'value');
        $exe = $this->db->insert($table, $data);

        if($exe){
            $data_log = array('tabel_crud' => $table,
                'tipe_crud' => 'INSERT',
                'codition_crud' => null,
                'before_crud' => null,
                'after_crud' => json_encode($data),
                'user_executor' => ($executor ? $executor : $this->session->userdata('id_admin')),
                'table_executor' => ($table_executor ? $table_executor : 'mst_admin'));
            $this->write_log_crud($data_log);

            return "1";
        }
        else
            return "0";
    }

    function save_with_autoincrement($data, $executor = null, $table_executor = null, $table = null){
        if($table === null) $table = $this->table;

//        $result = $this->cek_duplikat(array($this->primary_key => $data[$this->primary_key]));
        //$data = array('nama_tabel' => 'value');
        $exe = $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();

        if($exe){
            $data_log = array('tabel_crud' => $table,
                'tipe_crud' => 'INSERT',
                'codition_crud' => null,
                'before_crud' => null,
                'after_crud' => json_encode($data),
                'user_executor' => ($executor ? $executor : $this->session->userdata('id_admin')),
                'table_executor' => ($table_executor ? $table_executor : 'mst_admin'));
            $this->write_log_crud($data_log);

            return array(1, $insert_id);
        }
        else
            return array(0);
    }

    function empty_table($table = null){
        if($table === null) $table = $this->table;

        $exe = $this->db->empty_table($table);

        if($exe)
            return "1";
        else
            return "0";
    }

    function delete($where, $executor = null, $table_executor = null, $table = null){
        if($table === null) $table = $this->table;

        #find before delete...
        $this->db->where($where);
        $before_crud = $this->db->get($table)->result();

        $this->db->where($where);
        $exe = $this->db->delete($table);

        if($exe){
            $data_log = array('tabel_crud' => $table,
                'tipe_crud' => 'DELETE',
                'codition_crud' => json_encode($where),
                'before_crud' => json_encode($before_crud),
                'after_crud' => null,
                'user_executor' => ($executor ? $executor : $this->session->userdata('id_admin')),
                'table_executor' => ($table_executor ? $table_executor : 'mst_admin'));
            $this->write_log_crud($data_log);

            return "1";
        }
        else
            return "0";
    }

    function soft_delete($where, $executor = null, $table_executor = null, $table = null){
        if($table === null) $table = $this->table;

        #find before delete...
        $this->db->where($where);
        $before_crud = $this->db->get($table)->result();

        $data = array('active' => 0);

        $this->db->where($where);
        $this->db->set($data, FALSE);
        $exe = $this->db->update($table);

        #find after delete...
        $this->db->where($where);
        $after_crud = $this->db->get($table)->result();

        if($exe){
            $data_log = array('tabel_crud' => $table,
                'tipe_crud' => 'SOFT DELETE',
                'codition_crud' => json_encode($where),
                'before_crud' => json_encode($before_crud),
                'after_crud' => json_encode($after_crud),
                'user_executor' => ($executor ? $executor : $this->session->userdata('id_admin')),
                'table_executor' => ($table_executor ? $table_executor : 'mst_admin'));
            $this->write_log_crud($data_log);

            return "1";
        }
        else
            return "0";
    }

    function update($data, $where, $executor = null, $table_executor = null, $table = null){
        if($table === null) $table = $this->table;

        #find before delete...
        $this->db->where($where);
        $before_crud = $this->db->get($table)->result();

        $this->db->where($where);
        $this->db->set($data, FALSE);
        $exe = $this->db->update($table);

        #find after delete...
        $this->db->where($where);
        $after_crud = $this->db->get($table)->result();

        if($exe){

            $data_log = array('tabel_crud' => $table,
                'tipe_crud' => 'UPDATE',
                'codition_crud' => json_encode($where),
                'before_crud' => json_encode($before_crud),
                'after_crud' => json_encode($after_crud),
                'user_executor' => ($executor ? $executor : $this->session->userdata('id_admin')),
                'table_executor' => ($table_executor ? $table_executor : 'mst_admin'));
            $this->write_log_crud($data_log);

            return "1";
        }
        else
            return "0";
    }

    function select_count($where = null, $table = null){
        if($where != null)
            $this->db->where($where);
        if($table === null) $table = $this->table;
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    function write_log_crud($data){
        $this->db->insert('log_crud', $data);
    }

    function load_data($receive_data = array()){
        if (array_key_exists('select', $receive_data)) {
            $select = $receive_data['select'];
        }
        else
            $select = "*";
        $this->db->select($select, false);

        if (array_key_exists('where', $receive_data)) {
            $this->db->where($receive_data['where']);
        }
        if (array_key_exists('like', $receive_data)) {
            $this->db->or_like($receive_data['like']);
        }
        if (array_key_exists('order', $receive_data)) {
            $this->db->order_by($receive_data['order']);
        }
        if (array_key_exists('group', $receive_data)) {
            $this->db->group_by($receive_data['group']);
        }
        if(array_key_exists('limit', $receive_data)){
            $limit = explode(",", $receive_data['limit']);
            $this->db->limit($limit[0], $limit[1]);
        }
        if(array_key_exists('join', $receive_data)){
            for($i = 0; $i < count($receive_data['join']); $i++){
                $tabel = $receive_data['join'][$i]['tabel'];
                $relation = $receive_data['join'][$i]['relation'];
                $direction = $receive_data['join'][$i]['direction']; #left / right
                $this->db->join($tabel, $relation, $direction);
            }
        }

        $table = $this->db->get($this->table);
        return $table;
    }

    /**
     * Generates the WHERE portion of the query.
     * @param   mixed
     * @param   string
     * @param   boolean
     * @return  CI_DB_query_builder
     */
    public function where()
    {
        /**
         * Get all method parameters
         * @var [type]
         */
        $params = func_get_args();

        /**
         * Exit if no parameters found
         */
        if (func_num_args() < 1) {
            return;
        }

        if (count($params) == 1) {
            $this->db->where($params);
        }
        else if (count($params) > 1) {
            $esc_params = NULL;

            if (isset($params[2]) && is_bool($params[2])) {
                $esc_params = $params[2];
            }

            $this->db->where($params[0], $params[1], $esc_params);
        }

        return $this;
    }

    public function where_not_in()
    {
        /**
         * Get all method parameters
         * @var [type]
         */
        $params = func_get_args();

        /**
         * Exit if no parameters found
         */
        if (func_num_args() < 1) {
            return;
        }

        if (count($params) == 1) {
            $this->db->where_not_in($params);
        }
        else if (count($params) > 1) {
            $esc_params = NULL;

            if (isset($params[2]) && is_bool($params[2])) {
                $esc_params = $params[2];
            }

            $this->db->where_not_in($params[0], $params[1], $esc_params);
        }

        return $this;
    }

    /**
     * Generates a %LIKE% portion of the query.
     * @param   mixed
     * @param   string
     * @param   string
     * @return CI_DB_query_builder
     */
    public function like()
    {
        /**
         * Get all method parameters
         * @var [type]
         */
        $params = func_get_args();

        /**
         * Exit if no parameters found
         */
        if (func_num_args() < 1) {
            return;
        }

        if (count($params) == 1 && is_array($params[0])) {
            $this->db->like($params);
        }
        else if (count($params) > 1) {
            $option = 'both';

            if (isset($params[2])) {
                $option = $params[2];
            }

            $this->db->where($params[0], $params[1], $option);
        }

        return $this;
    }

    public function group_by($param)
    {
        return $this->db->group_by($param);
    }

    public function order_by($fields, $order = NULL)
    {
        if ($order === NULL) {
            $this->db->order_by($fields);
        }
        else {
            $this->db->order_by($fields, $order);
        }

        return $this;
    }

    public function select($params, $esc_params = TRUE)
    {
        return $this->db->select($params, $esc_params);
    }

    public function get($table = NULL)
    {
        if ($table === NULL) $table = $this->table;

        return $this->db->get($table);
    }

    public function query($query)
    {
        return $this->db->query($query);
    }

    /**
     * Find rows by its primary key
     * @param  string   $value requested id
     * @return DB model        return instances of DB class
     */
    public function find($value)
    {
        return $this->db->get_where($this->table, array($this->primary_key => $value));
    }

    public function from($table)
    {
        return $this->db->from($table);
    }

    public function join($relation, $type = NULL)
    {
        return $type === NULL ? $this->db->join($this->table, $relation) : $this->db->join($this->table, $relation, $type);
    }
}
