<?php

class Survey extends MvcModel {

	var $display_field = 'name';
	var $includes = array('Section', 'Question');

	var $has_many = array(
	  'Section' => array(
      'dependent' => true
	  ),
	  'Question' => array(
      'dependent' => true
	  ),
	  'Result' => array(
      'dependent' => true
	  )
	);
  
  
  public function after_save($object) {
    $this->set_timestamps($object);
  }
  
  public function set_timestamps($object){
    //error_log( print_r( $object, true ) );
    $now = date('Y-m-d H:i:s', time() );
    $update = array('modified' => $now);

    error_log( print_r( $object, true ));

    if( $object->created == null )
      $update['created'] = $now;
      
    $this->update($object->__id, $update);
  }
  
}

/*
 
    public function update_sort_name($object) {
        $sort_name = $object->name;
        $article = 'The';
        $article_ = $article.' ';
        if (strcasecmp(substr($sort_name, 0, strlen($article_)), $article_) == 0) {
            $sort_name = substr($sort_name, strlen($article_)).', '.$article;
        }
        $this->update($object->__id, array('sort_name' => $sort_name));
    }
 
}
*/


?>