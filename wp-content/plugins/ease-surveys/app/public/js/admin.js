var Ease = Ease || {};

(function($){
	
	//some info on these merging algorithms: http://en.literateprograms.org/Merge_sort_%28JavaScript%29
	Ease.merge_sort = function( array, comparison ){

		if(array.length < 2)
			return array;

		var middle = Math.ceil(array.length/2);

		return Ease.merge(
			Ease.merge_sort( array.slice(0,middle), comparison ),
			Ease.merge_sort( array.slice(middle), comparison ),
			comparison
		);
		
	};
	
	Ease.merge = function( left, right, comparison ){
		var result = [];
		
		while( (left.length > 0) && (right.length > 0) ){
			if( comparison( left[0], right[0] ) <= 0 )
				result.push( left.shift() );
			else
				result.push( right.shift() );
		}
		
		while( left.length > 0 )
			result.push( left.shift() );
		
		while( right.length > 0 )
			result.push( right.shift() );
		
		return result;		
	}
	
	Ease.Surveys = {
		
		instances : [],
		
		//called in the scope of whatever object needs it.
		makeDataCont : function(){
			var block = $('<div />', {

			}).addClass('dataCont');
			
			if( this.data.id && !(this instanceof Ease.Surveys.QuestionOption) )
				block.hide();
			
			return block;
		},
		makeQuestionsHeader : function(){
			return $('<h2 />', { text: 'Questions' }).addClass('cont-header questions-header');
		},
		makeQuestionsCont : function(){
			var section = ( this.parent ? this : null ),
				that = this;
			
			this.$questionsCont = $('<div />',{})
				.addClass('questions').sortable({
				connectWith: '.questions',
				//update function finds where all the questions are and assigns them the proper survey_id and section_id
				start: function(e, ui){
					$('.questions').addClass('sorting');
				},
				stop: function(){
					$('.questions').removeClass('sorting');
				},
				receive: function( e, ui ){
					//update the section id of the item that has been moved
					ui.item.find('[name="section_id"]').val(
						( section ? section.data.id : 0 )
					).trigger('change');
				},
				update: Ease.Surveys.onSortableUpdate
			});
						
			return this.$questionsCont;
		},
		//used for questions, sections, and options
		onSortableUpdate: function( e, ui ){
			$.each( $(this).children(), Ease.Surveys.updateMenuOrder );
		},
		makeAccordianHeader: function(){
			//console.log( 'make accordian header', this );
			var that = this,
				head = $('<span />', {
					html: '<span class="text">'+(this.data.name ? this.data.name : 'New '+this.model)+'</span>'
				}).addClass('head');
			
			//make the toggler
			$('<span />',{
				
			}).addClass('icon')
			.click(function(e){
				Ease.Surveys.accordianClick.apply(that);
			})
			.prependTo(head);

			if( !this.data.id )
				head.addClass('active');
			
							
			return head;
		},
		accordianClick: function(){
			this.$head.toggleClass('active');
			this.$dataCont.toggle();
		},
		//scope is a jQuery object of the container
		orderChildren: function(){
			var children = [];
			//turn jquery obj cont to array cont
			$.each( this.children(), function(){
				children.push( $(this) );
			});
			//sort them
			children = Ease.merge_sort( children, function(a,b){
				var idA = a.find('[name="menu_order"]').val(),
					idB = b.find('[name="menu_order"]').val();

				if( idA == idB )
					return 0;
				else if ( idA < idB )
					return -1;
				else
					return 1;
			});

			var that = this;
			$.each( children, function(){
				that.append( this );
			});			
		},
		
		updateQuestionOrder: function(){
			$.each( this.$questionsCont.children(), Ease.Surveys.updateMenuOrder );
		},
		//use in each loop to compare index value vs menu_order input value
		updateMenuOrder: function(i){
			var input = $(this).find('[name="menu_order"]').first();
			if( input.val() != i )
				input.val( i ).trigger('change');
		},
		makeTextInput: function( label, name, value, placeholder ){
			var placeholder = placeholder || '';			
			var block = $('<div />').addClass('input-block ' + name);
			
			$('<label />', {
				text: label,
				for: name
			}).appendTo( block );
			
			$('<input />', {
				type: 'text',
				name: name,
				value: value,
				placeholder: placeholder
			}).appendTo( block );
			
			return block;
		},
		makeTextArea : function( label, name, value, placeholder ){
			var placeholder = placeholder || '';
			var block = $('<div />').addClass('input-block ' + name);
			
			$('<label />', {
				text: label,
				for: name
			}).appendTo( block );
			
			$('<textarea />', {
				name: name,
				text: value,
				placeholder: placeholder
			}).appendTo( block );
			
			return block;
		},
		makeCheckbox : function( label, name, value ){
			var block = $('<div />').addClass('input-block ' + name);
			
			$('<label />', {
				text: label,
				for: name
			}).appendTo( block );
			
			$('<input />', {
				name: name,
				checked: !!parseInt(value, 10),
				type: 'checkbox'
			}).appendTo( block );
			
			return block;
		},
		makeSelect : function( label, name, value, options ){
			/* options = { id: {value: 'id', name: 'something pretty'} } */
			var block = $('<div />').addClass('input-block ' + name);
			
			$('<label />', {
				text: label,
				for: name
			}).appendTo( block );
			
			var select = $('<select />', {
				name: name,
				type: 'checkbox'
			}).appendTo( block );
			
			$.each( options, function(){
				$('<option />', {
					text: this.name,
					value: this.id,
					selected: ( this.id == value ? true : false )
				}).appendTo( select );
			});
			
			return block;
		},
		//removes the private __xxx keys in the MVC data model
		removePrivateKeys : function( object ){
			for( var key in object ){
				//if( key.indexOf('__') > -1 || key === 'created' || key === 'modified' )
				if( key.indexOf('__') > -1 )
					delete object[key];
				else if ( object[key] === 'null' )
					object[key] = null;
			}
			
			return object;
		},
		updateInput : function( $el, value ){
			if( $el.length ){
				if( $el.length > 1 ){
					//probably never happens, but just in case
					var that = this;
					$.each( $el, function(){
						that.updateInput( $(this), value );
					});
					return;
				} else {
					if( $el.attr('type') === 'checkbox' ){
						$el.attr('checked', !!parseInt(value, 10) );
					} else {
						//console.log( 'updating input', value, typeof value, value === 'null' );
						if( value !== 'null' && value != $el.val() )
							$el.val( value ).trigger('change');
					}
				}
			}
			return;
		},
		makeDeleteButton : function( text ){
			var that = this;
			return $('<button />', {
				html: '<span class="icon">x</span><span class="text">' + ( text ? text : 'delete') + '</span>',
				title: 'Delete this '+this.model
			}).addClass('btn btn-delete')
			.click(function(e){
				e.preventDefault();
				var confirmed = confirm('Are you sure you want to delete this '+that.model+'?');
				if( confirmed ){
					Ease.Surveys.deleteModel.call( that );
				}
			}).prependTo( this.$dataCont );
		},
		deleteModel : function(){
			//console.log( 'delete', this);
			if( !this.data.id )
				return Ease.Surveys.removeObject.call( this );

			var postVars = {
				action: this.controller+'_delete_json',
				id: this.data.id,
				data: {}
			};

			//set the model info
			postVars.data[this.model] = this.data;

			//console.log( 'delete postVars', postVars );						
			var that = this;
			
			$.post( ajaxurl, postVars, function(data, status, obj){
				Ease.Surveys.deleteCallback.apply( that, arguments );
			});

		}, 
		deleteCallback : function(data, status, obj){
			var data = JSON.parse( data );
			
			if( data.success ){
				if( this instanceof Ease.Surveys.Survey ){
					//whoa now.  you deleted the whole thing?
					//Ease.Surveys.findAndDeleteObject( Ease.Surveys.instances, this.data.id );
				}
				return Ease.Surveys.removeObject.call( this );
			}
			//console.log( 'delete callback', this, this.data.id, data, status, obj);
		},
		findAndDeleteObject : function( array, id ){
			$.each( array, function(i){
				if( this.data.id == id ){
					array[i].$object.remove();
					array.splice(i, 1);
					return false;
				}
			});
		},
		removeObject : function(){
			//console.log( 'remove object', this );
			//this.$object.remove();
			var constructors = {
				'options' : Ease.Surveys.QuestionOption,
				'questions' : Ease.Surveys.Question,
				'section' : Ease.Surveys.Section
			}
			for ( var key in constructors ){
				if( this instanceof constructors[key] ){
					//console.log('option deleted before?', this.parent[key], this.parent[key].length)
					Ease.Surveys.findAndDeleteObject( this.parent[key], this.data.id );
					//console.log('option deleted after?', this.parent[key], this.parent[key].length)
					break;
				}
			}
		},
		setChangeHandlers : function(){
			//set the tracker on whether the data has changed.
			var that = this;

			this.$dataCont.find('input, textarea')
				.change( function(){
					var val = $(this).val();

					if( $(this).attr('type') === 'checkbox' ){
						val = ( $(this).attr('checked') ? 1 : 0 );
					}
					that.data[this.name] = val;
					that.needs_sync = true;
					
					//update the head
					if( this.name == 'name' && that.$head ){
						that.$head.find('.text').text( (val ? val : 'New '+that.model) );
					}
					
					//console.log( 'value changed this data', that.data, this.name, $(this).val(), $(this).attr('checked') );
				});
		},		

		save : function(){
			
			if( !this.syncing ){
				//console.log('NOT SYNCING', this, this.timeout);
				if( this.parent && !this.parent.data.id && !this.parent.needs_sync ){
					
					this.parent.needs_sync = true;	
					//console.log('this.parent && !this.parent.data.id && !this.parent.needs_sync', this);
					return $.each( Ease.Surveys.instances, function(){
						this.autoSave();
					});
				} else if ( this.parent && this.parent.syncing ){
					//TODO:  TRACK THE HELL OUT OF THESE TIMEOUTS
					//console.log('SETTING TIMEOUT', this.timeout);
					var that = this;
					return this.timeout = setTimeout( function(){ that.save(); }, 50 );
				}
				
				this.syncing = true;

				//do the save.
				//console.log('SAVE!', this);
				var postVars = {
					action: this.controller+'_edit_json',
					data: {}
				};

				//set the model info
				postVars.data[this.model] = this.data;
				
				//console.log( 'postVars', postVars );
				if( this.data.id ){
					//set up paths
					postVars.id = this.data.id;
				} else {
					//set up paths
					delete this.data.id;
					postVars.action = this.controller+'_add_json';
				}
				
				var that = this;
				
				$.post( ajaxurl, postVars, function(data, status, obj){
					that.saveCallback.apply( that, arguments );
				});
			} else {
				//console.log( 'already syncing', this );
			}

		},
		saveCallback: function( data, status, obj ){
			//console.log( 'save callback', status, obj, this );
			
			if( data ){
				//console.log( 'data before parse', data );
				var data = JSON.parse( data );
				data = Ease.Surveys.removePrivateKeys( data );

				var setParentID = false;
				//check if the data id was null, used in instance stuff below
				if ( !this.data.id )
					setParentID = true;

				this.data = data;
				
				for ( var key in this.data )
					Ease.Surveys.updateInput( this.$dataCont.find('[name="'+key+'"]'), this.data[key] );
					//this.$dataCont.find('[name="'+key+'"]').val( this.data[key] );
				
				this.syncing = false;
				this.needs_sync = false;
				
				if( this instanceof Ease.Surveys.Survey ){
					var surveyId = this.data.id;
					$.each( [this.sections, this.questions], function(){
						$.each( this, function(){
							this.data.survey_id = surveyId;
						});
					});
				} else if ( this instanceof Ease.Surveys.Section ) {
					var sectionId = this.data.id;
					$.each( this.$questionsCont.children(), function(){
						Ease.Surveys.updateInput( $(this).find('[name="section_id"]'), sectionId );
					});
				} else if ( this instanceof Ease.Surveys.Question ) {
					var questionId = this.data.id;
					$.each( this.$optionsCont.children(), function(){
						Ease.Surveys.updateInput( $(this).find('[name="question_id"]'), questionId );
					});
				}
				//console.log( 'there is data', data, this.data, this instanceof Ease.Surveys.Survey );
				
				return $.each( Ease.Surveys.instances, function(){
					this.autoSave();
				});
				
			}
		},
		setupModel : function( controllerName, modelName, emptyModel, data ){
			
			this.data = data || emptyModel;
			this.data = Ease.Surveys.removePrivateKeys( this.data );
			
			this.model = modelName;
			this.controller = controllerName;
			
			this.$dataCont = null;
			this.needs_sync = false;
			this.syncing = false;
			this.timeout = null;
			
			return this.init();
		}
	};
	
	Ease.Surveys.Survey = function(json, types){
		//start here
		this.$cont = $('#survey-container');
		if ( !this.$cont.length )
			return false;

		//types get parsed in init
		this.types = types;
		//console.log( 'types', types );
		
		var data = false;
		if( json )
			data = JSON.parse( json );
			
		//this.$object becomes the jQuery container object;
		this.$object = null;
		this.$sectionsCont = null;
		this.$questionsCont = null;
		this.sections = [];
		this.questions = [];
		
		var model = {
			name: null,
			description: null,
			id: null,
			questions: null,
			sections: null
		};

		Ease.Surveys.setupModel.apply( this, [ 'admin_surveys', 'Survey', model, data ]);
				
		//console.log( 'DATA', this.data );		
		return;		
	};
	
	Ease.Surveys.Survey.prototype.init = function(){
		var that = this;
		
		//if the id exists, then it doesn't need to be saved right away
		if( !this.data.id )
			this.needs_sync = true;
		
		//parse the question types
		var types = JSON.parse( this.types );
		this.types = {};
		$.each( types, function(){
			that.types[this.id] = this;
		});
		this.types = Ease.Surveys.removePrivateKeys( this.types );
		//console.log( 'types', this.types, types );
		types = null;
		
		this.createSurvey();

		this.makeQuestions();
		
		this.makeSections();
		
		//sort the questions into the right sections
		this.sortQuestions();
		
		//attach control handlers
		this.handleControls();

		//set the saving message
		$('#ajaxMsg').ajaxStart(function(){
			$(this).slideDown( 100 );
		}).ajaxStop(function(){
			$(this).slideUp( 100 );
		});
		
		Ease.Surveys.instances.push( this );
		
	};	
	
	
	Ease.Surveys.Survey.prototype.createSurvey = function(){
		
		this.$object = $('<form />', { id: 'survey-cont' }).addClass('object').submit( this.submitForm ).appendTo( this.$cont );
		
		//construct it on it's own
		this.$dataCont = $('<div />', {
			id: 'survey'
		}).appendTo( this.$object );
		//make the inputs
		//this.$dataCont = Ease.Surveys.makeDataCont.call(this).attr({ id: 'survey' }).appendTo( this.$object );

		Ease.Surveys.makeTextInput( 'ID', 'id', this.data.id ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Name', 'name', this.data.name, 'Enter Name.' ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextArea( 'Description', 'description', this.data.description, 'Enter a description.' ).appendTo( this.$dataCont );
		Ease.Surveys.makeCheckbox( 'Public?', 'is_public', this.data.is_public ).appendTo( this.$dataCont );
		
		Ease.Surveys.makeDeleteButton.call( this );
		
		//make the save survey button
		$('<div />', {
			id: 'save-survey',
			type: 'submit',
			html: '<button type="submit" class="btn btn-add btn-save-survey">Save Survey</button>'
		}).prependTo( this.$dataCont );
		
		/*
		<div id="save-survey">

	    <button class="btn btn-add btn-save-survey">Save Survey</button>
	  </div>
	  */
		
		this.setChangeHandlers();		
	};

	Ease.Surveys.Survey.prototype.setChangeHandlers = Ease.Surveys.setChangeHandlers;

	Ease.Surveys.Survey.prototype.makeSections = function(){
		var that = this;

		$('<h2 />', { text: 'Sections' }).addClass('cont-header').appendTo( this.$object );

		this.$sectionsCont = $('<div />',{
			id: 'sections'
		}).sortable({
			start: function(e, ui){
				$(this).addClass('sorting');
			},
			stop: function(e, ui){
				$(this).removeClass('sorting');
			},
			update: Ease.Surveys.onSortableUpdate
		}).appendTo(this.$object);

						
		if( this.data.sections ) {
			$.each( this.data.sections, function(i){ that.createSection(this); });
		}
		
		Ease.Surveys.orderChildren.call( this.$sectionsCont );
		//delete this from object, cause it is necessary
		delete this.data.sections;		
	};
	
	Ease.Surveys.Survey.prototype.createSection = function(data){
		var section = new Ease.Surveys.Section( this, data ).appendTo( this.$sectionsCont );
		
		//make sure the menu order starts out correctly
		if( !data )
			$.each( this.$sectionsCont.children(), Ease.Surveys.updateMenuOrder );

	};	
	
	Ease.Surveys.Survey.prototype.makeQuestions = function(){
		
		Ease.Surveys.makeQuestionsHeader.call( this ).appendTo( this.$object );
		Ease.Surveys.makeQuestionsCont.call( this ).appendTo( this.$object );
		
		var that = this;
		
		//do other stuff
		if( this.data.questions ) {
			$.each( this.data.questions, function(i){ that.createQuestion(this); });
		}
		
		delete this.data.questions;
	};
	
	Ease.Surveys.Survey.prototype.createQuestion = function(data, type){
		var question = new Ease.Surveys.Question( this, data, type ).appendTo( this.$questionsCont );

		//make sure the menu order starts out correctly
		if( !data )
			$.each( this.$questionsCont.children(), Ease.Surveys.updateMenuOrder );

	};
	
	//sorts the questions into the correct order and the correct sections after they are inited andput in DOM
	Ease.Surveys.Survey.prototype.sortQuestions = function(){
		//console.log('sort questions', this, this.questions);
		var that = this;
		
		var sortQuestion = function(i){
			//console.log( 'sort', this, that, this.data.section_id );			
			var question = this;
			
			$.each( that.sections, function(){
				if( this.data.id == question.data.section_id )
					question.$object.appendTo( this.$questionsCont );
			});
		};
		
		$.each( this.questions, sortQuestion);
		
		//now order the questions
		var questionConts = [this.$questionsCont];
		$.each( this.sections, function(){
			questionConts.push( this.$questionsCont );
		});
		//order the questions
		$.each( questionConts, Ease.Surveys.orderChildren );
		questionConts = null;
	};
	
	Ease.Surveys.Survey.prototype.handleControls = function(){
		//var addQuestion = $('#add-question').find('button').click();
		var that = this;
		var addSection = $('#add-section').find('button').click(function(e){
			e.preventDefault();
			
			that.autoSave();
			that.createSection();
		});
		
		var btnSaveSurvey = $('.btn-save-survey').each(function(){
			$(this).click(function(e){
				e.preventDefault();
				that.autoSave();
			});
		});
		
		var addQuestion = $('#add-question');
		//Ease.Surveys.makeSelect('Type', 'question_type', null, this.types ).prependTo( addQuestion );
		addQuestion.click(function(e){
			e.preventDefault();
			//console.log('create question!', this, that, $(this).parent().find('select').val() );
			//that.createQuestion( false, $(this).parent().find('select').val() );
			that.createQuestion( false, null );
			//save the survey so the parent id gets set on next go round
			that.autoSave();
		});
	};
	
	Ease.Surveys.Survey.prototype.submitForm = function(e){
		e.preventDefault();		
	};

	Ease.Surveys.Survey.prototype.save = Ease.Surveys.save;

	Ease.Surveys.Survey.prototype.saveCallback = Ease.Surveys.saveCallback;

	Ease.Surveys.Survey.prototype.autoSave = function(){
		//console.log('autosave', this);

		//one function to rule them all
		var check_sync = function(){
			//console.log( 'check sync', this );

			//check the options in the questions
			if( this.options )
				$.each( this.options, check_sync );
			
			if( this.needs_sync )
				this.save();
						
			return;
		};
		//check the survey, sections, and questions
		check_sync.call(this);
		$.each( this.sections, check_sync );
		$.each( this.questions, check_sync );		
	};

	Ease.Surveys.Section = function( parent, data ){
		
		this.parent = parent;
								
		//this.$object becomes the jQuery container object;
		this.$object = null;
		this.$head = null;
		this.$questionsCont = null;
		
		var model = {
			id: null,
			name: null,
			description: null,
			menu_order: '0'
		};
		//this.init();
		Ease.Surveys.setupModel.apply( this, [ 'admin_sections', 'Section', model, data ]);
		
		return this.$object;

	};
	
	Ease.Surveys.Section.prototype.init = function(){
		//console.log( 'initing new Section', this );

		this.data.survey_id = this.parent.data.id;

		this.$object = $('<div />',{
			section_id: this.data.id,
		}).addClass('section object');
				
		this.$head = Ease.Surveys.makeAccordianHeader.call( this ).appendTo( this.$object );
		this.$dataCont = Ease.Surveys.makeDataCont.call(this).appendTo( this.$object );
		
		Ease.Surveys.makeTextInput( 'Section ID', 'id', this.data.id ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Name', 'name', this.data.name, 'Enter Name.' ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextArea( 'Description', 'description', this.data.description, 'Enter a description.' ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Menu Order', 'menu_order', this.data.menu_order ).appendTo( this.$dataCont );

		//make the questions container
		Ease.Surveys.makeQuestionsHeader.call( this ).appendTo( this.$object );
		Ease.Surveys.makeQuestionsCont.call( this ).appendTo( this.$object );
		
		Ease.Surveys.makeDeleteButton.call( this );
				
		this.setChangeHandlers();		

		this.parent.sections.push(this);
	};
	
	Ease.Surveys.Section.prototype.setChangeHandlers = Ease.Surveys.setChangeHandlers;
	
	Ease.Surveys.Section.prototype.save = Ease.Surveys.save;
	Ease.Surveys.Section.prototype.saveCallback = Ease.Surveys.saveCallback;
	
	
	Ease.Surveys.Question = function(parent, data, type){
		//console.log( 'instantiating question');
		this.parent = parent; //the parent is always going to be the survey
								
		//this.$object becomes the jQuery container object;
		this.$object = null;
		this.$head = null;
		this.$optionsCont = null;
		this.options = [];
		
		var model = {
			id: null,
			is_public: '1',
			name: null,
			description: null,
			placeholder: null,
			section_id: '0',
			menu_order: '0',
			type_id: type
		};
		//this.init();
		Ease.Surveys.setupModel.apply( this, [ 'admin_questions', 'Question', model, data ]);
		
		return this.$object;
	};
	
	Ease.Surveys.Question.prototype.init = function(){
		
		this.$object = $('<div />', {
			//text: 'QUESTION!!!',
			question_id: this.data.id
		}).addClass('question object');

		this.data.survey_id = this.parent.data.id;
		
		this.$head = Ease.Surveys.makeAccordianHeader.call( this ).appendTo( this.$object );
		this.$dataCont = Ease.Surveys.makeDataCont.call(this).appendTo( this.$object );
		
		//make the inputs
		Ease.Surveys.makeTextInput( 'Question ID', 'id', this.data.id ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Question Type ID', 'type_id', this.data.type_id ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Section ID', 'section_id', this.data.section_id ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Menu Order', 'menu_order', this.data.menu_order ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Name', 'name', this.data.name, 'Enter Name.' ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextArea( 'Description', 'description', this.data.description, 'Enter a description.' ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Placeholder', 'placeholder', this.data.placeholder ).appendTo( this.$dataCont );
		Ease.Surveys.makeCheckbox( 'Public?', 'is_public', this.data.is_public ).appendTo( this.$dataCont );
		//make the type select
		this.makeTypeSelect( this.data.type_id ).appendTo( this.$dataCont );

		Ease.Surveys.makeDeleteButton.call( this );
		//make the addOption button
		this.makeAddOption().appendTo( this.$dataCont );


		this.makeOptions();

		this.setChangeHandlers();		

		this.parent.questions.push(this);
		
	};
	
	Ease.Surveys.Question.prototype.makeAddOption = function( id ){
		var that = this;
		return $('<button />', {
			text: 'Add Option'
		}).addClass('addOption').click(function(e){
			that.createOption();
		});
	};
	
	Ease.Surveys.Question.prototype.makeTypeSelect = function( id ){
		var typeSelect = Ease.Surveys.makeSelect('Type', 'question_type', id, this.parent.types ).change( this.typeChange );
		this.setTypeChangeHandler( typeSelect );
		return typeSelect;
	};	
	
	Ease.Surveys.Question.prototype.setTypeChangeHandler = function( $el ){		
		var that = this;
		
		$el.find('select').change(function(e){
			that.$dataCont.find('[name="type_id"]').val( $(this).val() ).trigger('change');
		});
	};
	
	Ease.Surveys.Question.prototype.makeOptions = function(){		
		var that = this;

		this.$optionsCont = $('<div />',{
			//id: 'sections'
		}).addClass('options')
		.sortable({
			start: function(e, ui){
				$(this).addClass('sorting');
			},
			stop: function(e, ui){
				$(this).removeClass('sorting');
			},
			update: Ease.Surveys.onSortableUpdate
		}).appendTo(this.$object);
				
		//do other stuff
		if( this.data.question_options ) {
			$.each( this.data.question_options, function(i){ that.createOption(this); });
		}
		
		Ease.Surveys.orderChildren.call( this.$optionsCont );
		
		delete this.data.question_options;
	};
	
	Ease.Surveys.Question.prototype.createOption = function(data){
		var option = new Ease.Surveys.QuestionOption( this, data ).appendTo( this.$optionsCont );

		//make sure the menu order starts out correctly
		if( !data )
			$.each( this.$optionsCont.children(), Ease.Surveys.updateMenuOrder );

		//console.log( 'create option', data, (!data) );
	};

	
	Ease.Surveys.Question.prototype.setChangeHandlers = Ease.Surveys.setChangeHandlers;
	Ease.Surveys.Question.prototype.save = Ease.Surveys.save;
	Ease.Surveys.Question.prototype.saveCallback = Ease.Surveys.saveCallback;
	
	Ease.Surveys.QuestionOption = function(parent, data){
		this.parent = parent;
					
		//this.$object becomes the jQuery container object;
		this.$object = null;
		this.$head = null;
		
		var model = {
			id: null,
			name: null,
			question_id: '0',
			menu_order: '0'
		};

		Ease.Surveys.setupModel.apply( this, [ 'admin_question_options', 'QuestionOption', model, data ]);
		
		return this.$object;
	};
	
	Ease.Surveys.QuestionOption.prototype.init = function(){
		this.$object = $('<div />', {}).addClass('option object');

		this.data.question_id = this.parent.data.id;
						
		this.$dataCont = Ease.Surveys.makeDataCont.call(this).appendTo( this.$object );
		
		//make the inputs
		Ease.Surveys.makeTextInput( 'Option ID', 'id', this.data.id ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Question ID', 'question_id', this.data.question_id ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Option Name', 'name', this.data.name, 'Enter Option.' ).appendTo( this.$dataCont );
		Ease.Surveys.makeTextInput( 'Menu Order', 'menu_order', this.data.menu_order ).appendTo( this.$dataCont );

		Ease.Surveys.makeDeleteButton.call( this );

		this.setChangeHandlers();		

		this.parent.options.push(this);
		
	};
	
	Ease.Surveys.QuestionOption.prototype.setChangeHandlers = Ease.Surveys.setChangeHandlers;
	Ease.Surveys.QuestionOption.prototype.save = Ease.Surveys.save;
	Ease.Surveys.QuestionOption.prototype.saveCallback = Ease.Surveys.saveCallback;
	
	
	$(document).ready(function(){
		//make the survey		
		var survey = new Ease.Surveys.Survey( $('#survey-json').text(), $('#question-types').text() );
	});
	
	
})(jQuery);


