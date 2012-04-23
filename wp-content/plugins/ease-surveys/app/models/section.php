<?php

class Section extends MvcModel {

	var $display_field = 'name';
	
	var $belongs_to = array('Survey');
}

?>