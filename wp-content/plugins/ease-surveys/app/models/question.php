<?php

class Question extends MvcModel {

	var $display_field = 'name';
  var $includes = array('QuestionOption');
  
  //var includes( )
  
  var $belongs_to = array('Survey', 'Section', 'Result', 'QuestionsTypes');
  //var $belongs_to = array('Result', 'QuestionsTypes');
    
  var $has_many = array(
    'QuestionOption' => array(
      'dependent' => true
    )
  );
  
  // public function after_save($object){
  //   $this->save_options($object);
  // }
  // 
  // public function save_options($object){
  //   //error_log( print_r( $object ) );
  //   //error_log( print_r( $_REQUEST, true ) );
  // }
  
}

?>