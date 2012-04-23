<?php

class AdminQuestionOptionsController extends EaseSurveysMvcAdminController {
	
  var $default_search_joins = array('Question');
  var $default_searchable_fields = array('Question.name');

  var $default_columns = array(
   'id',
   'name',
   //'survey' => array('value_method' => 'survey_edit_link'),
   'menu_order'
  );

  public function add() {

    $this->set_questions();
   $this->create_or_save(); 

  }

  public function edit() {

   $this->set_questions();
   $this->verify_id_param();
   $this->set_object();
   $this->create_or_save();

  }
  
  private function set_questions(){

    $this->load_model('Question');
    $questions = $this->Question->find(array('selects' => array('id', 'name')));    
    $this->set('questions', $questions);
  }
    
	
}

?>