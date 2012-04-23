<h2><?php echo MvcInflector::titleize($this->action); ?> <?php echo MvcInflector::titleize($model->name); ?></h2>

<?php

  echo $this->form->create($model->name);
  echo $this->form->input('name');
  echo $this->form->input('description');
  echo $this->form->input('menu_order');
  echo $this->form->belongs_to_dropdown('Survey', $surveys, array('style' => 'width: 200px;', 'empty' => true));  
  echo $this->form->end('Update');

?>
