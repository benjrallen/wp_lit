<?php

class EaseSurveysLoader extends MvcPluginLoader {

	var $db_version = '1.3.3';

	function init() {
	
		// Include any code here that needs to be called when this class is instantiated
	
		global $wpdb;
	
		$this->tables = array(
			'surveys' => $wpdb->prefix.'surveys',
      'sections' => $wpdb->prefix.'sections',
      'questions_types' => $wpdb->prefix.'questions_types',
      'questions' => $wpdb->prefix.'questions',
      'question_options' => $wpdb->prefix.'question_options',
      'survey_users' => $wpdb->prefix.'survey_users',
      'results' => $wpdb->prefix.'results'
      // 'venues' => $wpdb->prefix.'venues'
		);
	
	}
	
	function activate() {
	
		// This call needs to be made to activate this app within WP MVC
		
		$this->activate_app(__FILE__);
		
		// Perform any databases modifications related to plugin activation here, if necessary

		require_once ABSPATH.'wp-admin/includes/upgrade.php';
	
		add_option('ease_surveys_db_version', $this->db_version);
		
		// Use dbDelta() to create the tables for the app here
		// $sql = '';
		// dbDelta($sql);
    $sql = '
        CREATE TABLE '.$wpdb->prefix.'surveys (
          id int(11) NOT NULL auto_increment,
          name varchar(255) NOT NULL,
          description text,
          created datetime default NULL,
          modified timestamp NOT NULL default now(),
          is_public tinyint(1) NOT NULL default 0,
          PRIMARY KEY  (id)
        )';
    dbDelta($sql);
    
    $sql = '
        CREATE TABLE '.$wpdb->prefix.'sections (
          id int(11) NOT NULL auto_increment,
          survey_id int(11) NOT NULL,
          name varchar(255) NOT NULL,
          description text,
          menu_order int(11) NOT NULL default 0,
          PRIMARY KEY  (id),
          KEY survey_id (survey_id)
        )';
    dbDelta($sql);

    //questions_types allow questions to define checkbox, radio, select, etc...
    $sql = '
        CREATE TABLE '.$wpdb->prefix.'questions_types (
          id int(11) NOT NULL auto_increment,
          type varchar(255) NOT NULL,
          name varchar(255) NOT NULL,
          PRIMARY KEY  (id)
        )';
    dbDelta($sql);

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
    dbDelta($sql);

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

    $sql = '
        CREATE TABLE '.$wpdb->prefix.'survey_users (
          id int(11) NOT NULL auto_increment,
          result_id int(11) NOT NULL,
          first_name varchar(255) default NULL,
          last_name varchar(255) default NULL,
          email varchar(255) default NULL,
    		  address1 varchar(255) default NULL,
    		  address2 varchar(255) default NULL,
    		  city varchar(100) default NULL,
    		  state varchar(100) default NULL,
    		  country varchar(100) default NULL,
    		  zip varchar(20) default NULL,
          ip varchar(20) default NULL,
          salt varchar(255) NOT NULL,
          created datetime default NULL,
          modified timestamp NOT NULL default now(),
          PRIMARY KEY  (id),
          KEY result_id (result_id)
        )';
    dbDelta($sql);

    $sql = '
        CREATE TABLE '.$wpdb->prefix.'results (
          id int(11) NOT NULL auto_increment,
          user_id int(11) NOT NULL,
          survey_id int(11) NOT NULL,
          question_id int(11) NOT NULL,
    		  option_id int(11) default NULL,
          result varchar(255),
          time timestamp NOT NULL default now(),
          PRIMARY KEY  (id),
          KEY user_id (user_id),
          KEY survey_id (survey_id),
          KEY question_id (question_id),
          KEY option_id (option_id)
        )';
    dbDelta($sql);

    $this->insert_questions_types();

	}
	
	function insert_questions_types(){
		// Only insert the type data if no data already exists
	  
	  $sql = '
			SELECT
				id
			FROM
				'.$this->tables['questions_types'].'
			LIMIT
				1';
		$data_exists = $this->wpdb->get_var($sql);
		if ($data_exists) {
			return false;
		}

		$rows = array(
			array(
				'id' => 1,
        'type' => 'text',
        'name' => 'Short Text'
			),
  		array(
  			'id' => 2,
        'type' => 'email',
        'name' => 'Email Address'
  		),
    	array(
    		'id' => 3,
        'type' => 'textarea',
        'name' => 'Long Answer'
    	),
      array(
      	'id' => 4,
        'type' => 'select',
        'name' => 'Select Dropdown'
      ),
      array(
      	'id' => 5,
        'type' => 'checkbox',
        'name' => 'Checkbox'
      ),
    	array(
    		'id' => 6,
        'type' => 'radio',
        'name' => 'Radio Select'
    	)
		);
		
  	foreach($rows as $row) {
  		$this->wpdb->insert($this->tables['questions_types'], $row);
  	}
  	
	}
	

	function deactivate() {
	
		// This call needs to be made to deactivate this app within WP MVC
		
		$this->deactivate_app(__FILE__);
		
		// Perform any databases modifications related to plugin deactivation here, if necessary
	
	}

}

?>