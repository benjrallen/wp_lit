<?php

class AdminSurveysController extends EaseSurveysMvcAdminController {
//class AdminSurveysController extends MvcAdminController {
	
  var $default_search_joins = array('Section', 'Question');
  var $default_searchable_fields = array('Speaker.name', 'Question.name');
	
	var $default_columns = array(
		'id',
		'name',
		'modified' => array('value_method' => 'admin_column_modified'),
		'is_public'
	);
		
  public function add() {

	  //error_log( print_r( $_REQUEST, true ) );	
  	$this->set_sections();
  	$this->set_questions();
  	$this->create_or_save(); 

  }

  public function edit() {
	
	  //error_log( print_r( $_REQUEST, true ) );
	
  	//$this->set_sections();
  	//$this->set_questions();
  	$this->verify_id_param();
  	$this->set_object();
  	$this->create_or_save();

  } 
  
  private function set_sections(){
    
    $this->load_model('Section');
    $sections = $this->Section->find(array('selects' => array('id', 'name')));
    $this->set('sections', $sections);
  }
  
  private function set_questions(){
    $this->load_model('Question');
    $questions = $this->Question->find(array('selects' => array('id', 'name')));
    $this->set('questions', $questions);
  }
    
  public function admin_column_modified($object) {
  	return empty($object->date) ? null : date('g:ia F jS, Y', strtotime($object->date));
  }


}

?>