<div id="ajaxMsg">Saving...</div>

<div id="survey-controls" class="clearfix">
  
  <div id="controls-save-survey" class="clearfix">
    
    <button class="btn btn-add btn-save-survey">Save Survey</button>
  </div>
  
  
  <div id="add-question">
    
    <button class="btn btn-add btn-add-question">Add Question</button>
  </div>
  
  <div id="add-section">
    
    <button class="btn btn-add btn-add-section">Add Section</button>
  </div>
  
</div>

<?php

  $this->load_model('QuestionsTypes');
  $types = $this->QuestionsTypes->find(array('selects' => array('id', 'name', 'type' )));
  
  echo '<div id="question-types">'.json_encode($types).'</div>';


?>