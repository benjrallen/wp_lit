<?php

class AdminSectionsController extends EaseSurveysMvcAdminController {
	
	var $default_columns = array(
		'id',
		'name',
		'menu_order'
	);
	
	public function add() {
	
  	$this->set_survey();
  	$this->create_or_save(); 

  }

  public function edit() {
	
  	$this->set_survey();
  	$this->verify_id_param();
  	$this->set_object();
  	$this->create_or_save();

  }
  
  private function set_survey(){
    
    $this->load_model('Survey');
    $surveys = $this->Survey->find(array('selects' => array('id', 'name')));
    $this->set('surveys', $surveys);
  }
  
	
}

?>