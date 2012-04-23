<?php

class QuestionsTypes extends MvcModel {

	var $display_field = 'name';
  
	var $has_many = array('Question');
	
  
}

?>