(function($){
	
	//transitionTime
	var guruTransTime = 350,
		maxWidth = 960;
		
	$(document).ready(function(){
		console.log('hello common ready');
		
		$('html.ie').length ? Ease.ie = true : Ease.ie = false;
		$('html.lte8').length ? Ease.lte8 = true : Ease.lte8 = false;
		typeof WebKitPoint !== 'undefined' ? Ease.webkit = true : Ease.webkit = false;
		
		homePage();
		galleryPage();
		reserveForm();
		newsSlider();
		shirtForm();
		litForum();
		newsletterSignup();
		
	});	



	function newsletterSignup(){
		if ( $('#mc-embedded-subscribe-form').length > 0 ) {

			var form 	= $('#mc-embedded-subscribe-form'),
				input	= form.find('input'),
				button	= form.find('button'),
				errorCls = 'mcError',
				sending = false,
				timeoutTime = 2500,
				fadeTime = 900;

			//console.log(container, input, button);
			form.submit(function(e){
				e.preventDefault();
				
				var email = input.val(),
					subUrl = Ease.TemplateUrl + '/mailchimp_subscribe.php';

				var mcError = function(msg, success){
					if( typeof msg === 'undefined' || !msg )
						var msg = 'Well, something went wrong.';
					
					var cls = ( !success ? errorCls+' error' : errorCls+' success' );
						
					$('<span />', { text: msg }).addClass(cls).insertAfter( button );
					
					var timeoutFunc = function(){
						var el = form.find('.'+errorCls);
						if( el.length ){
							el.fadeOut( fadeTime, function(e){
								$(this).remove();
							});
						}
					};
					
					return setTimeout( timeoutFunc, timeoutTime );
				};
			
				//remove any old errors
				form.find('.'+errorCls).remove();

				if ( email === '' ){
					mcError('We need an email address, please.');
					return false;
				}
				
				if( !sending ){
					sending = true;
					//send the address
					$.get(
						subUrl,
						'email='+email,
						function(data){
							
							sending = false;
							
							var json = JSON.parse(data);						
							
							if( json.error ){

								var msg = json.error;

								switch (true) {								
									case json.error.indexOf('already subscribed') !== -1 :
										msg = 'That email\'s already on our list!';
										break;

									case json.error.indexOf('Invalid Email Address') !== -1 :
										msg = 'We need a proper email address, please.';
										break;
								}

								return mcError( msg );
							
							}
						
							return mcError('You have been signed up!', true);
						}
					);
				}
			});
		}//the wrap condition
	}

	
	function newsSlider(){
		if( $('#carousel').length ){
			
			var cont = $('#carousel'),
				wrap = $('#outer'),
				slider = cont.find('#inner'),
				nav = cont.find('.nav'),
				thumbs = cont.find('a'),
				active = slider.find('.active'),
				totalWidth = 0,
				wrapWidth = wrap.outerWidth(),
				thumbWidth = thumbs.first().outerWidth(),
				numVisible = 5,
				targetLeft = parseInt( slider.css('left').replace('px',''), 10),
				trans = 250,
				checking = true,
				startLeft = targetLeft;
			
			//get total width of menu
			$.each(thumbs, function(i){
				totalWidth += $(this).outerWidth();
			});
			
			//click handler
			var shift = function(e){
				var dir = ( $(this).hasClass('back') ? 1 : -1 ),
					curLeft = parseInt( wrap.css('left').replace('px',''), 10);
				
				targetLeft += thumbWidth * dir;
				
				//cant go too far left
				//cant go too far right
				//if( targetLeft > startLeft + thumbWidth || targetLeft < numVisible * thumbWidth - totalWidth - thumbWidth )
				if( targetLeft > startLeft || targetLeft < numVisible * thumbWidth - totalWidth )
					return targetLeft -= thumbWidth * dir;
			
				return move();
			};
			
			nav.click(shift);

			var move = function(){
				//simple animation for now
				var time = ( checking ? 0 : trans );
				return slider.stop(false, false).animate({ left: targetLeft }, time, moveCallback);
			};

			var moveCallback = function(e){
				if( checking )
					checkActive();
			};

			var checkActive = function(){
				
				//console.log( active.position().left - numVisible * thumbWidth + targetLeft,active.position().left, numVisible * thumbWidth );
				
				//check if active is hidden
				if ( active.position().left - numVisible * thumbWidth + targetLeft >= 0 ){
					//console.log('FIX ME!');
					return nav.last().trigger('click');
				} else {
					//console.log('fixed!');
					checking = false;
					return;
				}
			};
			checkActive();

		}
	}
	

	function litForum(){
		if( $('#communityPage').length ){
			var forumLink = $('li.forum a'),
				id = 'forumPopup',
				popup = new Popup(id), //reservePopup id only for the css
				contentSet = false,
				popupContent = $('<div />', {
					'data-href': 'litmotors.com',
					'data-num-posts': 10,
					'data-width': 720
				}).addClass('fb-comments');
			
			
			//put the content into the popup
			//popup.setContent( popupContent );
			var parseFB = function(){
				if( typeof window.FB !== 'undefined' && typeof window.FB.XFBML !== 'undefined' ){
					FB.XFBML.parse( document.getElementById( id ) );
				} else {
					setTimeout( parseFB, 15 );
				}
				
			};
			
			forumLink.click(function(e){
				e.preventDefault();
				e.stopPropagation();
				
				if( !contentSet ){
					popup.show( popupContent );
					parseFB();
				} else {
					popup.show();
				}				
			});

			$('body').click(function(e){
				popup.hide();
			});
		}
	}
	
	function shirtForm(){
		if( $('#shirtForm').length ){
			
			//the t-shirt form stuff here
			var shirtLink = $('li.t-shirt a'),
				shirtForm = $('#shirtForm'),
				popup = new Popup('shirtPopup'),
				gateway = new Popup('reservePopup'), //reservePopup only for the css
				theSize = shirtForm.find('#theSize'),
				theColor = shirtForm.find('#theColor');
			
			//put the form in the popup from the hidden container
			popup.setContent( shirtForm );
			
			//Prevent the shirt page from doing anything.		
			shirtLink.click(function(e){
				e.preventDefault();
				e.stopPropagation();
				
				gateway.hide();
				popup.show();
			});
			
			//used on the form and the gateway selection block			
			var stopProp = function(e){
				e.stopPropagation();
			};

			var buildGatewaySelection = function(){
				var block = $('<div />', { id: 'step2' }).click(stopProp),
					gateways = ['google','paypal'];
				//append gateway selections
				$.each( gateways, function(){
					$('<div />', { id: this }).click( gatewaySelection ).appendTo(block);
				});	
				//prepend the notice
				$('<h2 />', {
					html: 'To complete your purchase please choose your preferred payment gateway by clicking on desired icon below:'
				}).prependTo( block );
				
				return block;
			};

			var gatewaySelection = function(e){
				var gatewayString = $(this).attr('id');
				e.stopPropagation();
				//show loading notice
				//showPopup('<h2>In a moment you will be transferred to '+gateway+' to complete your reservation.</h2>');
				gateway.show('<h2>In a moment you will be transferred to '+gatewayString+' to complete your reservation.</h2>');
				
				var form = ( gatewayString == 'paypal' ? $('#paypalForm') : $('#googleForm') );
				
				form.submit();
				
			};

			var matchValues = function(e){
				var gMatch = {
					"Black": {
						"S": 1,
						"M": 2,
						"L": 3,
						"XL": 4,
						"XXL": 5
					},
					"Grey": {
						"S": 6,
						"M": 7,
						"L": 8,
						"XL": 9,
						"XXL": 10
					},
					"Orange": {
						"S": 11,
						"M": 12,
						"L": 13,
						"XL": 14,
						"XXL": 15
					}
				}

				// var size = $("#theSize option:selected").val();
				// var color = $("#theColor option:selected").val();
				var size = theSize.val();
				var color = theColor.val();

				$("[name=\"os0\"]").val(color);
				$("[name=\"os1\"]").val(theSize.val());
				//$("[name=\"os1\"]").val($("#theSize option:selected").html());

				$("[name=\"item_selection_1\"]").val(gMatch[color][size]);				
			};

			shirtForm.find('button').click(function(e){
				e.preventDefault();
				e.stopPropagation();
				popup.hide();
				gateway.show( buildGatewaySelection() );
			});


			shirtForm.click(stopProp);

			//set click binder on body to hide popup
			$('body').click(function(e){
				//hidePopup();
				popup.hide();
				gateway.hide();
			});

			//set the change handler on the form selects
			//	this javascript came from the gross inline/inpage stuff
			//	from the author of the first iteration of the Lit site
			shirtForm.find('select').change(matchValues)
		}
	}
	
	
	
	function reserveForm(){
		if( $('#reserveForm').length ){
			var form = $('#reserveForm'),
				messages = [],
				popup = new Popup('reservePopup');
				token = 0,
				valid = true;
			
			//faq tooltips
			if ( $('#faq').length ){

				var faqLinks = $('#faq').find('a'),
					trans = 250,
					adjust = 20,
					//tooltip = $('<div />', { id: 'tooltip' }).addClass('faqClass').hide().appendTo('body');
					tooltip = new Popup( 'tooltip', 'absolute' );

				//console.log('faq', faqLinks);
				var faqClick = function(e){
					e.preventDefault();
					e.stopPropagation();

					if( typeof popup !== 'undefined' )
						popup.hide();

					//var id = $(this).attr('id');
					var content = $(this).parent().children('.tip')
					if ( content.length ){

						tooltip.setContent( content.html() );

						var off = $(this).offset(),
							y = off.top - Math.floor( tooltip.el.outerHeight() /4 ),
							x = off.left - tooltip.el.outerWidth() - adjust;

						//console.log('CLICK!', content, off, x, y);


						tooltip.position( x, y ).show();
					}
					/*
					if( faqs[id] ){
						var off = $(this).offset();
						//append the tip &							
						//position the tooltip
						tooltip.html( faqs[id] ).css({
							top: off.top - Math.floor( tooltip.outerHeight() /4 ),
							left: off.left - tooltip.outerWidth() - adjust
						}).fadeIn( trans );
					}
					*/
				};

				faqLinks.click(faqClick);
				$('body').click(function(){
					tooltip.hide();
				});
			}


			var showMessages = function(){
				var block = '';					
				$.each(messages, function(){
					block += '<div>'+this+'</div>';
				});
				popup.setContent( block ).show();
				//popup.html(block).show();
			};

			var alertInvalid = function(el){
				el.parent().addClass('error');
				return valid = false;
			};
			
			var validateForm = function(e){
				e.preventDefault();
				e.stopPropagation();
				//console.log('validateForm', $(this) );
				
				if( typeof tooltip !== 'undefined' )
					tooltip.hide();
				
				var me = null,
					selectRequired = {
						deposit: 'Please choose your deposit amount.',
						country: 'Please choose your country.'
					},
					inputRequired = {
						zip: 'Zip Code is required',
						firstname: 'First Name is required',
						lastname: 'Last Name is required',
						address: 'Address is required',
						city: 'City is required',
						state: 'State is required',
						email: 'A valid Email is required',
						phone: 'A Phone Number is Required'
					};
				
				//remove any old error notifications
				form.find('.error').removeClass('error');
				messages = [];
				valid = true;
								
				for ( var key in selectRequired ){
					me = form.find('[name='+key+']');
					if ( !me.val() || me.val() == '0' ){
						alertInvalid( me );
						messages.push( selectRequired[key] );
					}
				}
				
				for ( var key in inputRequired ){
					me = form.find('[name='+key+']');
					// if ( key == 'email' && !goog.format.EmailAddress.isValidAddress( me.val() ) ){
					// 	alertInvalid( me );
					// 	messages.push( inputRequired[key] );
					// } else 
					if ( !me.val() || me.val().length < 2 ) {
						alertInvalid( me );
						messages.push( inputRequired[key] );
					}
				}
				
				if ( valid ) {
					return sendForm();
					
				} else {
					return showMessages();
				}
			};
			
			//data has passed front-end validation
			var sendForm = function(){
				//console.log( form.serializeArray() );
				//clear the messages
				messages = [];
						
				$.ajax({
					url: Ease.TemplateUrl+'/reserve.php',
					data: form.serializeArray(),
					type: 'post',
					complete: function(){
						//console.log('complete');
					},
					success: sendFormSuccess,
					error: function(a, b, c){
						//console.log('error', a, b, c);
					}
				});
			};
			
			var sendFormSuccess = function(data, status){
				//console.log('success', data);
				
				if (typeof data.status == "undefined") {
					//we have a string
					messages.push('An error occurred please try again later.');
					return showMessages();
				}
				
				if (data.status != "ok") {
					if (typeof data.focus != "undefined") {
						//highlight the error
						//form.find('[name="'+data.focus+'"]').parent().addClass('error');
						alertInvalid(form.find('[name="'+data.focus+'"]'));
					}
					
					messages.push( data.message );
					return showMessages();									
				}
				
				if (data.proceed) {
					token = data.token;
					//move on to step 2
					return chooseGateway();
				}
				
			};
			
			var buildGatewaySelection = function(){
				var block = $('<div />', { id: 'step2' }),
					gateways = ['google','paypal'];
				//append gateway selections
				$.each( gateways, function(){
					$('<div />', { id: this }).click( gatewaySelection ).appendTo(block);
				});	
				//prepend the notice
				$('<h2 />', {
					html: 'To complete your reservation please choose your preferred payment gateway by clicking on desired icon below:'
				}).prependTo( block );
				
				return block;
			};
			
			var gatewaySelection = function(e){
				var gateway = $(this).attr('id');
				
				//show loading notice
				//showPopup('<h2>In a moment you will be transferred to '+gateway+' to complete your reservation.</h2>');
				popup.show('<h2>In a moment you will be transferred to '+gateway+' to complete your reservation.</h2>');
				
				//make an ajax request to the gateway
				$.ajax({
					//url: getApp().urls.current,
					url: Ease.TemplateUrl+'/reserve.php',
					type: 'post',
					data: {
						base_url: Ease.Url,
						template_url: Ease.TemplateUrl,
						current_url: window.location.href.toString().replace(window.location.search, ''),
						token: token,
						gateway: gateway
					},
					//complete: hidePopup,
					success: gatewayRequestSuccess,
					error: function(x) {
						//showPopup( 'Error:<br/>'+x.responseText );
						popup.show( 'Error:<br/>'+x.responseText );
					}
				});
				
				//console.log('gatewaySelection', gateway);
			};
			
			var gatewayRequestSuccess = function(data) {
				//console.log('gatewayRequestSuccess', data);
				if (typeof data.status == "undefined") {
					//we have a string
					//return showPopup('An error occurred please try again later.');
					return popup.show('An error occurred please try again later.');
				}
				
				if (data.status != "ok") {
					//return showPopup( data.message );
					return popup.show( data.message );
				}
				
				if (data.proceed && data.link && data.method) {
					if (data.link) {
						if (data.method == "get") {
							//parent.window.location = data.link;
							//console.log('data.method = get, ', data.link)
							//paypal requests
							window.location.href = data.link;
						} else {
							//var theForm = $("<form id=\"tempGoogleForm\">").attr({action: data.link, method:"post"});
							//console.log('data.method does not = get, ', data.link)
							
							//try the form action change thing
							form.attr({ action: data.link });
							form.submit();
							/*
							$("#tempGoogleForm").attr({action: data.link});
							parent.$.fancybox.close();
							parent.getApp().dom.sendToGoogle();
							*/
						}
					}
				}
			};
			
			var chooseGateway = function(){
				//console.log('choose gateway');
				
				//popup.html( buildGatewaySelection() ).show();
				//showPopup( buildGatewaySelection() );
				popup.show( buildGatewaySelection() );
			};
			
			

			var positionPopup = function(){
				popup.position();
			};

			//set click binder on body to hide popup
			$('body').click(function(e){
				//hidePopup();
				popup.hide();
			});
			//and the popup itself doesn't alert the body to it's click events
			//popup.click(function(e){
			//	e.stopPropagation();
			//});
			//resize keeps the popup centered
			$(window).resize(positionPopup);
			
			//validate the form
			form.find('[type="submit"]').click(validateForm);
			//form.submit(validateForm);
			
			
			//check for a message from the a successful return
			if( $('#actionReturn').length )
				popup.show( $('#actionReturn').html() );
				//showPopup( $('#actionReturn').html() );
		}
	}
	
	function homePage(){
		if( $('#homeRotate').length ){
			var rotate = new EaseRotator({
				contID: 'homeRotate',
				transitionTime: 1000,
				timeoutTime: 7500,
				showControls: 'binary', //false, true, or 'binary'.  'binary' will print out the controls as prev/next only
				autoRotate: true,
				appendControlsTo: '#controlWrap'
			});
			
			//console.log( rotate );	
		}
	}
	
	function galleryPage(){
		if( $('#rotatingGallery').length ){
			var gallery = new EasePhotoGallery({
				galleryContSelector: '#rotatingGallery',
				dataEl: '#galleryJson',
				paginate: 1000,
				isStatic: true,
				showTitles: true,
				showDescriptions: true
			});
			
			//console.log( gallery );
		}
	}	
	
})(jQuery);
