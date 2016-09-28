<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller {

	
	// List all your items
	public function index( )
	{
		 $this->render('dashboard/index_view');
		
	}
	
		
}

/* End of file User.php */
/* Location: ./application/controllers/admin/User.php */



