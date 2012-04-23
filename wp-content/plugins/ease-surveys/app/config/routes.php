<?php
 
MvcRouter::public_connect('{:controller}', array('action' => 'index'));
MvcRouter::public_connect('{:controller}/{:id:[\d]+}', array('action' => 'show'));
MvcRouter::public_connect('{:controller}/{:action}/{:id:[\d]+}');

// $ajaxControllers = array(
//   'admin_surveys',
//   'admin_sections',
//   'admin_questions',
//   'admin_question_options'
// );
// foreach( $ajaxControllers as $c ){
//   MvcRouter::admin_ajax_connect(array('controller' => $c, 'action' => 'add_json'));
//   MvcRouter::admin_ajax_connect(array('controller' => $c, 'action' => 'add_json'));
// }


MvcRouter::admin_ajax_connect(array('controller' => 'admin_surveys', 'action' => 'add_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_surveys', 'action' => 'edit_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_surveys', 'action' => 'delete_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_sections', 'action' => 'add_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_sections', 'action' => 'edit_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_sections', 'action' => 'delete_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_questions', 'action' => 'add_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_questions', 'action' => 'edit_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_questions', 'action' => 'delete_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_question_options', 'action' => 'add_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_question_options', 'action' => 'edit_json'));
MvcRouter::admin_ajax_connect(array('controller' => 'admin_question_options', 'action' => 'delete_json'));


?>