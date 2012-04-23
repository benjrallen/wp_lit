<h2><?php echo MvcInflector::titleize($this->action); ?> <?php echo MvcInflector::titleize($model->name); ?></h2>

<?php


  echo $this->form->create($model->name);
  echo $this->form->input('name');
  //echo $this->form->has_many_dropdown('QuestionOption'. $question_options);
  echo $this->form->input('menu_order');
  echo $this->form->belongs_to_dropdown('Question', $questions, array('style' => 'width: 200px;', 'empty' => true));  
  echo $this->form->end('Add');


  //print_r($object);

  /*

  $sql = '
      CREATE TABLE '.$wpdb->prefix.'question_options (
        id int(11) NOT NULL auto_increment,
        question_id int(11) NOT NULL,
        name varchar(255) NOT NULL,
        menu_order int(11) NOT NULL default 0,
        PRIMARY KEY  (id),
        KEY question_id (question_id)
      )';
  dbDelta($sql);
  */

?>
