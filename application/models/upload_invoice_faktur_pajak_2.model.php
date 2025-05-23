<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_invoice_faktur_pajak_2_model extends CI_Model
{
    // Simpan data hasil upload invoice & faktur pajak
    public function save($data)
    {
        return $this->db->insert('upload_invoice_faktur_pajak_2', $data);
    }

    // Ambil semua data yang sudah diupload
    public function get_all()
    {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('upload_invoice_faktur_pajak_2')->result();
    }

    // (Opsional) Ambil satu data berdasarkan ID
    public function get_by_id($id)
    {
        return $this->db->get_where('upload_invoice_faktur_pajak_2', ['id' => $id])->row();
    }

    // (Opsional) Hapus data berdasarkan ID
    public function delete($id)
    {
        return $this->db->delete('upload_invoice_faktur_pajak_2', ['id' => $id]);
    }

    
}
