
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rab_detail extends MY_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model("Rab_detail_model","rab_detail");
	}

}
