<h2><?php echo MvcInflector::titleize($this->action); ?> <?php echo MvcInflector::titleize($model->name); ?></h2>

<?php

  echo $this->form->create($model->name);
  echo $this->form->input('name');
  echo $this->form->input('description');
  echo $this->form->input('menu_order');
  echo $this->form->belongs_to_dropdown('Survey', $surveys, array('style' => 'width: 200px;', 'empty' => true));  
  echo $this->form->end('Add');


  /*
  CREATE TABLE '.$wpdb->prefix.'sections (
    id int(11) NOT NULL auto_increment,
    survey_id int(11) NOT NULL,
    name varchar(255) NOT NULL,
    description text,
    menu_order int(11) NOT NULL default 0,
    PRIMARY KEY  (id),
    KEY survey_id (survey_id)
  )';
  */


?>
