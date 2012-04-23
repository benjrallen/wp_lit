<h2><?php echo MvcInflector::titleize($this->action); ?> <?php echo MvcInflector::titleize($model->name); ?></h2>

<?php

  echo $this->form->create($model->name);
  echo $this->form->input('is_public');
  echo $this->form->input('name');
  echo $this->form->input('description');
  echo $this->form->input('placeholder');
  echo $this->form->textarea_input('question_options', array('label'=>'Options', 'value'=>'some_value'));
  echo $this->form->input('menu_order');
  echo $this->form->belongs_to_dropdown('Survey', $surveys, array('style' => 'width: 200px;', 'empty' => true));  
  echo $this->form->belongs_to_dropdown('Section', $sections, array('style' => 'width: 200px;', 'empty' => true));  
  echo $this->form->belongs_to_dropdown('Type', $types, array('style' => 'width: 200px;', 'empty' => true));  
  echo $this->form->end('Add');



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
