<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');
	require_once SYSDIR.'/libraries/Email.php';

class Email_lib extends CI_Email{

    function __construct(){
        parent::__construct();
    }

}
?>