<?php

MvcConfiguration::set(array(
	'Debug' => false
));


MvcConfiguration::append(array(
    'AdminPages' => array(
      'sections' => false,
      'survey_users' => false,
      'questions' => false,
      'question_options' => false,
      'results' => false
    )
));


add_action('mvc_admin_init', 'surveys_on_mvc_admin_init', 10, 1);

function surveys_on_mvc_admin_init($args) {
  //error_log(print_r($args, true));
  extract($args);
  
	if (in_array($action, array('add', 'edit'))) {
  	wp_register_style('mvc_surveys_admin', mvc_css_url('ease-surveys', 'admin'));
  	//wp_enqueue_style('mvc_survey_admin');
  	wp_enqueue_style('mvc_surveys_admin');
		
 	//wp_register_script('mvc_admin', mvc_js_url('ease-surveys', 'admin'));
  	//wp_enqueue_script('mvc_admin');
		wp_enqueue_script(
		  'mvc_surveys_admin', 
		  mvc_js_url('ease-surveys', 'admin'), 
		  array(
		    'jquery', 
		    'jquery-ui-core', 
		    'jquery-ui-widget', 
		    'jquery-ui-mouse', 
		    'jquery-ui-accordion', 
		    'jquery-ui-draggable', 
		    'jquery-ui-droppable', 
		    'jquery-ui-sortable'
		  ), 
		  null, 
		  true
		);

	}
}

//redefine the create or save method to spit out JSON if the request is JSON based
class EaseSurveysMvcAdminController extends MvcAdminController {

  public function create_or_save_json() {
    if (!empty($this->params['data'][$this->model->name])) {
    
       error_log('NEW CREATE OR SAVE JSON');
             //error_log( print_r($this->params['data'], true) );
             error_log( print_r($_REQUEST, true) );
    
      $object = $this->params['data'][$this->model->name];

      error_log( 'create or save CREATE' );
      error_log( print_r( $this->params, true ));

      if (empty($object['id']) || $object['id'] == null) {
        //$this->model->create($this->params['data']);
        //create returns ID.
        $this->params['id'] = $this->model->create($this->params['data']);
        //requires id in param
        $this->set_object();
        echo( json_encode($this->object) );
        die();
      } else {
        if ($this->model->save($this->params['data'])) {
          echo( json_encode($object) );
          die();
        } else {
          echo( json_encode(array(
            'error' => $this->model->validation_error->get_errors()
          )));
          die();
        }
      }
    }
  }
  
  public function add_json() {
	  //error_log( print_r( $_REQUEST, true ) );	
  	$this->create_or_save_json(); 
  }

  public function edit_json() {	
	  //error_log( print_r( $_REQUEST, true ) );

  	$this->verify_id_param();
  	$this->set_object();
  	$this->create_or_save_json();
  }
  
  public function delete_json() {
		$this->verify_id_param();
		$this->set_object();
		if (!empty($this->object)) {
			$this->model->delete($this->params['id']);
      echo( json_encode(array(
        'success' => 'object deleted'
      )));
      die();
		} else {
      echo( json_encode(array(
        'error' => 'An Object with ID "'.$this->params['id'].'" couldn\'t be found.'
      )));
      die();
		}
  }
}


?>