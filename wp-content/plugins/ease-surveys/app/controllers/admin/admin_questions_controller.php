<?php

class AdminQuestionsController extends EaseSurveysMvcAdminController {

    var $default_search_joins = array('Section', 'Survey');
    var $default_searchable_fields = array('Survey.name', 'Section.name');
  
  var $default_columns = array(
   'id',
   'name',
   //'survey' => array('value_method' => 'survey_edit_link'),
   'menu_order'
  );
  
    public function add() {
  
     $this->set_surveys();
     $this->set_sections();
     $this->set_question_types();
     //$this->set_question_options();
     $this->create_or_save(); 
  
    }
  
    public function edit() {
  
     $this->set_surveys();
     $this->set_sections();
     $this->set_question_types();
     //$this->set_question_options();
     $this->verify_id_param();
     $this->set_object();
     $this->create_or_save();
  
    }
    
    private function set_question_types(){
      
      $this->load_model('QuestionsTypes');
      $types = $this->QuestionsTypes->find(array('selects' => array('id', 'name')));
      $this->set('types', $types);
    }
    
    private function set_sections(){
      $this->load_model('Section');
      $sections = $this->Section->find(array('selects' => array('id', 'name')));
      $this->set('sections', $sections);
    }
    
    private function set_surveys(){
      $this->load_model('Survey');
      $surveys = $this->Survey->find(array('selects' => array('id', 'name')));
      $this->set('surveys', $surveys);
    }
    
    // public function set_question_options(){
    //   $this->load_model('QuestionOption');
    //   $surveys = $this->Survey->find(array('selects' => array('id', 'name')));
    //   $this->set('surveys', $surveys);
    // }
    
  // public function survey_edit_link($object) {
  //   //error_log( print_r( $object, true ) );
  //   return empty($object->survey) ? null : HtmlHelper::admin_object_link($object->survey, array('action' => 'edit'));
  // }


}

/*
$sql = '
    CREATE TABLE '.$wpdb->prefix.'questions (
      id int(11) NOT NULL auto_increment,
      survey_id int(11) NOT NULL,
      section_id int(11) NOT NULL default 0,
      type_id int(11) NOT NULL default 1,
      name varchar(255) NOT NULL,
      description text,
      placeholder varchar(255),
      menu_order int(11) NOT NULL default 0,
      is_public tinyint(1) NOT NULL default 0,
      PRIMARY KEY  (id),
      KEY survey_id (survey_id),
      KEY section_id (section_id),
      KEY type_id (type_id)
    )';
*/

?>