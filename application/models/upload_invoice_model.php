<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Upload_invoice_model extends CI_Model
{
    protected $table = 'upload_invoice';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_all()
    {
        $this->db->order_by($this->primaryKey, 'DESC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function get_by_id($id)
    {
        $this->db->where($this->primaryKey, $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function update($id, $data)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->delete($this->table);
    }
}
