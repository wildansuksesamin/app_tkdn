<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends MY_Controller {

	function __construct(){
        parent::__construct();
	}

	public function index(){

    }

    public function backup_db(){
        //execute this backup database once every day on 24:00 via cronjob...
        $bhaga_server = 'http://www.bhaga.id';
        $email = $this->http_request_builder(array(), $bhaga_server.'/api/get_email_backup');
        if($email){
            $subject = 'Backup DB '.$this->aplikasi.' '.date('d-m-Y H:i');
            $nama_file = 'Backup DB '.$this->aplikasi.' '.date('YmdHis').'.sql';
            $domain = $_SERVER['SERVER_NAME'];
            $domain = str_replace('http://', '', $domain);
            $domain = str_replace('https://', '', $domain);
            $domain = str_replace('www.', '', $domain);
            $email_destination = $email;

            // Load the DB utility class
            $this->load->dbutil();
            $prefs = array(
                'tables'     => array(),
                // Array table yang akan dibackup
                'ignore'     => array(),
                // Daftar table yang tidak akan dibackup
                'format'     => 'txt',
                // gzip, zip, txt format filenya
                'filename'   => $nama_file,
                // Nama file
                'add_drop'   => TRUE,
                // Untuk menambahkan drop table di backup
                'add_insert' => TRUE,
                // Untuk menambahkan data insert di file backup
                'newline'    => "\n"
                // Baris baru yang digunakan dalam file backup
            );
            // Backup database dan dijadikan variable
            $backup = $this->dbutil->backup($prefs);

            // Load file helper dan menulis ke server untuk keperluan restore
            $this->load->helper('file');
            write_file($nama_file, $backup);

            //send email..

            $this->load->library('email_lib');
            $this->email_lib->from('no-reply@'.$domain, $this->aplikasi);
            $this->email_lib->to($email_destination);

            $this->email_lib->subject($subject);
            $this->email_lib->message('Backup database dari '.$this->aplikasi.' pada '.date('d-m-Y H:i').'. Jaga email ini tetap rahasia.');
            $this->email_lib->attach($nama_file);
            $exe = $this->email_lib->send();
			
            @unlink($nama_file);
        }


    }

}