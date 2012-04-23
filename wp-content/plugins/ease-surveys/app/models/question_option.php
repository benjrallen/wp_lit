<?php

class QuestionOption extends MvcModel {

	var $display_field = 'name';
  
  var $belongs_to = array('Question');
	
}

?>