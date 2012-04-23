<h2><?php echo MvcInflector::titleize($this->action); ?> <?php echo MvcInflector::titleize($model->name); ?></h2>

<div id="survey-outer">
  <div id="survey-container"></div>
  <?php $this->render_view('_controls'); ?>
  <div id="survey-json"><?php echo json_encode($object); ?></div>
</div>
