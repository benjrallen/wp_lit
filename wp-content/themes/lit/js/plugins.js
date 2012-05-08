// place any jQuery/helper plugins in here, instead of separate, slower script files.


/*
 * Try/Catch the console
 */
try{
    console.log('Hello Console.');
} catch(e) {
    window.console = {};
    var cMethods = "assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(",");
    for (var i=0; i<cMethods.length; i++) {
        console[ cMethods[i] ] = function(){};
    }
}


(function($){

	function Popup(id, positionType){
		var me = this;
		me.positionType = positionType || 'fixed';
		
		me.el = $('<div />', { id: id }).css({
			position: this.positionType
		}).appendTo('body');
		
		me.IS_VISIBLE = false;
				
		me.setContent = function( content ){
			if( typeof content !== 'undefined' )
				me.el.html( content );
			
			return me;
		};
		
		me.show = function( content ){
			if( typeof content !== 'undefined' )
				me.setContent( content );

			me.IS_VISIBLE = true;

			me.position();
			me.el.show();
			
			return me;
		};
		
		me.hide = function(){
			if ( me.IS_VISIBLE ){
				me.el.hide();
				me.IS_VISIBLE = false;
			}
			return me;
		};
		
		me.position = function( x, y ){
			return ( me.positionType === 'fixed' ? me.positionFixed() : me.positionAbsolute( x, y ) );
		};
		
		me.onClick = function(e){
			e.stopPropagation();
		};
		
		me.positionFixed = function(){
			if ( me.IS_VISIBLE ){
				var left = Math.floor( ($(window).width() - me.el.outerWidth()) / 2 ),
					top = Math.floor( ($(window).height() - me.el.outerHeight()) / 2 );

				left = ( left < 0 ? 0 : left );
				top = ( top < 0 ? 0 : top );

				me.el.css({
					left: left,
					top: top
				});
			}
			return me;
		};
		
		me.positionAbsolute = function( x, y ){			
			me.el.css({
				left: x,
				top: y
			});
			return me;
		};

		if( me.positionType === 'fixed' )
			$(window).resize(me.positionFixed);

		me.el.click(me.onClick);
		
		return me;
	};

	window['Popup'] = Popup;
	
})(jQuery);


(function($){
	
	var EaseRotator = function(config){
		var me = this,
			defaults = {
				contID: 'rotator',
				sliderClass: 'slides',
				slideClass: 'slide',
				controlsClass: 'controls',
				nextText: '>>',
				prevText: '<<',
				z: 1, //z-index set to 1 in css for the slides
				transitionTime: 1000,
				hoverControls: false,
				gidAtt: 'gid', //attribute to look for on the controls
				timeoutTime: 7500,
				showControls: false, //false, true, or 'binary'.  'binary' will print out the controls as prev/next only
				linkTo: false,
				useSlideTextInControls: false,
				linkClickCallback: function(){},
				autoRotate: false, //set to true to start the rotation automatically.  key if you just instantiate the rotator and not the controller
				appendControlsTo: false //css selector.  if set, the controls get appended to a specific element
			};
			
		for (var key in config) {
			defaults[key] = config[key] || defaults[key];
		}
	
		for (var key in defaults) {
			me[key] = defaults[key];
		}
		
		//unconfigurable variables		
		me.container = null;
		me.slider = null;
		me.slides = null;
		me.controls = null;
		me.sliderTimeout = null;
		
		me.currentSlide = [];
		me.nextSlide = null;
		
		me.binaryControls = null;
		
		me.RUNNING = false;
		
		me.other = false;
		
		me.init = function(){
			if( $('#'+me.contID).length ){
				//initialize variables
				me.container = $('#'+me.contID);
				me.slider = me.container.find('.'+me.sliderClass);
				//me.slides = me.slider.children(); 
				me.slides = me.slider.find('.'+me.slideClass); 
																
				//print controls
				me.controls = me.makeControls();
				
				//the last slide is the one that shows onload
				//me.controls.children().last().addClass('active');
				me.controls.children().first().addClass('active');
				me.slides.last().addClass('active');
				
				me.currentSlide = me.slides.last().fadeTo( me.transitionTime, 1);
				
				//so set all the others to 0 opacity
				me.slides.not('.active').fadeOut(0);

				//only rotate if the slider is visible
				$(window).resize(me.onResize);
				
				//'trigger it'
				me.onResize();
				
				me.RUNNING = true;
			}
			
			return me;
		};
		
		me.isRunning = function(){
			return me.RUNNING;
		};
		
		me.onResize = function(e){
			
			if ( me.container.is(':visible') ) {
				//start the change timer
				if( !me.sliderTimeout && me.autoRotate )
					me.sliderTimeout = setTimeout( me.sliderTimeoutFunc, me.timeoutTime );
			} else {
				if ( me.sliderTimeout && me.autoRotate ) {
					clearTimeout( me.sliderTimeout );
					me.sliderTimeout = null;
					//console.log( 'timeout cleared', me.sliderTimeout );
				}
			}
		}
		
		me.makeControls = function(){
			var ctrls = $('<div />').addClass( me.controlsClass+' norm' );
						
			//make a selector for each slide
			me.slides.each(function(i){
				
				var gid = $(this).attr(me.gidAtt);
				//console.log( 'making ctrols', gid, this );
				
				//var ctrl = $('<div />', { text: i+1 }).attr( me.gidAtt, gid ).click(me.ctrlClickHandle).appendTo( ctrls );
				var ctrl = $('<div />', {}).attr( me.gidAtt, gid ).click(me.ctrlClickHandle).prependTo( ctrls );
				
				if ( me.hoverControls ){
					ctrl.mouseover( me.ctrlClickHandle );
				}
				
				if( me.useSlideTextInControls )
					ctrl.append( '<span class="line"></span><span>'+$(this).html()+'</span>' );
				
				if( $(this).attr('thumb') ){
					var thumb = JSON.parse( $(this).attr('thumb') );
					$('<span />').css({ 'background-image': 'url("'+thumb[0]+'")' }).appendTo(ctrl);
				}
				
				
			});
			
			//do we want to only show binary controls?
			//if ( !me.showControls || me.showControls === 'binary' )
			if ( !me.showControls ){
				ctrls.hide();
			}
			
			if ( me.showControls === 'binary' )
				me.binaryControls = me.makeBinaryControls();
			
			//ctrls.appendTo(me.container);
			//this functionality was added for UPAL to have controls in a flag.
			if ( me.appendControlsTo && $(me.appendControlsTo).length ) {
				ctrls.appendTo( me.appendControlsTo );
			} else {
				ctrls.appendTo(me.container);
			}
			
			return ctrls;

		};
		
		me.makeBinaryControls = function(){
			var ctrls = $('<div />').addClass( me.controlsClass+' bin' );
			
			//make prev/next selctors to switch through the slides
			$('<span />', { text: me.prevText }).addClass('prev').click(me.binaryCtrlClickHandle).appendTo( ctrls );		
			$('<span />', { text: me.nextText }).addClass('next').click(me.binaryCtrlClickHandle).appendTo( ctrls );		
			
			//this functionality was added for UPAL to have controls in a flag.
			//if ( me.appendControlsTo && $(me.appendControlsTo).length ) {
				ctrls.appendTo( me.appendControlsTo );
			//} else {
				ctrls.appendTo(me.container);
			//}
			
			return ctrls;
		};
		
		me.ctrlClickHandle = function(e){
			var gid = $(this).attr(me.gidAtt)
			
			me.slideChange( gid );
			
			return me.linkClickCallback( gid, me.linkTo );
		}
		
		//the numbered controls are still there, so click on a back or forward looks at those controls to decide which one is next
		me.binaryCtrlClickHandle = function(e){
			//find the next slide gid in the list (of the actual numbered controls)
			var gid = ( $(this).hasClass('prev') ?
						//go back
						me.getPreviousSlide().attr(me.gidAtt) :
						//go forward
						me.getNextSlide().attr(me.gidAtt)
					);
			
			me.slideChange( gid );
			
			return me.linkClickCallback( gid, me.linkTo );
		};

		me.getNextSlide = function(){			
			return ( me.currentSlide.next().length ? 
							me.currentSlide.next() : 
							me.currentSlide.parent().children().first() );
		};
		me.getPreviousSlide = function(){
			return ( me.currentSlide.prev().length ? 
							me.currentSlide.prev() : 
							me.currentSlide.parent().children().last() );
		};
				
		me.slideChange = function( gid ){
			//var gid = ctrl.attr( me.gidAtt );
			
			var ctrl = me.getControlByID( gid );
			
			if ( !ctrl.hasClass('active') ) {
				//clear the timeout transition.  this will allow us to essentially reset the change timer
				if( me.sliderTimeout )
					clearTimeout( me.sliderTimeout);
				
				//increment the target z-index up by one
				me.z++;
				
				//get the target slide
				me.nextSlide = me.getSlideByID( gid );

				//switch to the new slide
				me.fadeChange();
				
												
				//turn off the old one
				me.controls.find('.active').removeClass('active');
				//turn on the corresponding control circle
				ctrl.addClass('active');

//				//known bug in Sizzle engine with .siblings() when using a selector.  returns empty array.
//				//turn on the corresponding control circle
//				ctrl.addClass('active')
//					//and turn off the old one
//					.siblings('.active').removeClass('active');
					
				//start the change timer
				return ( me.autoRotate ? me.sliderTimeout = setTimeout( me.sliderTimeoutFunc, me.timeoutTime ) : true );
			}
		};
				
		me.fadeChange = function(){
			if ( !me.nextSlide ) return false;
						
			//stop the animation if one is fading in
			me.slider.find( me.currentSlide ).stop(false, false);
			
			//finish the animation for those that are fading out (all not active slides are told to fade out everytime)
			me.slides.not( me.nextSlide ).stop(true,false);
			
			//set this one as active to signify that it is fading in.
			me.nextSlide.addClass('active')
				//move it to the top
				.css({ zIndex: me.z })
				//clear its animation queue cause we are using setTimeout and might have a stacked queue
				.stop(true,true)
				//fade it in
				.fadeTo( me.transitionTime, 1)
			
			//get all the other slides
			me.slides.not( me.nextSlide )
				//clear its animation queue cause we are using setTimeout and might have a stacked queue
				.stop(true,true)					
				//tell them to get to zero opacity
				.fadeOut(me.transitionTime)
				//and tell them that none of them are fading in
				.removeClass('active');
					
			//set the new active		
			me.currentSlide = me.nextSlide;
			me.nextSlide = null;	
		};
		
		//used in the controller
		me.getControlByID = function( gid ){
			if ( !gid ) return false;
			return me.controls.find('['+me.gidAtt+'="'+gid+'"]');	
		};

		me.getSlideByID = function( gid ){
			if ( !gid ) return false;			
			return me.slider.find('['+me.gidAtt+'="'+gid+'"]');	
		};

		
		//set up the timeout change function
		me.sliderTimeoutFunc = function(){
			return me.slideChange( me.getNextSlide().attr(me.gidAtt) );
		};
				
		return me.init();		
	}
	
	//expose to window
	window['EaseRotator'] = EaseRotator;
	
	
	//class to control the timeouts on multiple EaseRotators to keep them in sync
	function EaseRotatorController(config){
		
		var me = this,
			defaults = {
				rotatorsConfig: [],
				timeoutTime: 7500
			};
			
		for (var key in config) {
			defaults[key] = config[key] || defaults[key];
		}
	
		for (var key in defaults) {
			me[key] = defaults[key];
		}
		
		me.rotators = {};
		me.sliderTimeout = null;
		
		me.init = function(){
			//rotators should be init objects.  lets start them.
			if( typeof me.rotatorsConfig === 'object' && me.rotatorsConfig.length ){
								
				$.each( me.rotatorsConfig, me.startRotator );
							
				me.sliderTimeout = setTimeout( me.sliderTimeoutFunc, me.timeoutTime );
			}
				
			return me;	
		};
		
		me.startRotator = function(i){			
			//we want to connect the linked clicks
			if( this.linkTo )
				this.linkClickCallback = me.linkClickCallback;
						
			me.rotators[this.contID] = new EaseRotator( this );
		};
		
		me.sliderTimeoutFunc = function(){
			//clear the timeout
			clearTimeout( me.sliderTimeout );
			//rotate each instance
			$.each( me.rotators, me.rotateInstance );
			//reset the timeout
			return me.sliderTimeout = setTimeout( me.sliderTimeoutFunc, me.timeoutTime );
		};
		
		me.rotateInstance = function(i){
			//this is the instance.  fading and changing takes processing power, 
			//	and on mobile layouts, I often hide these rotators.  so do a check
			if( !this.autoRotate && this.RUNNING && this.container.is(':visible') )
				this.slideChange( this.getNextSlide().attr(this.gidAtt) );
			
			return true;
		};
		
		//this is what links the rotators together.  ctrl is element that was clicked, id is the contID that instance is linked to (rotator.linkTo)
		me.linkClickCallback = function( gid, linkTo ){
									
			//only do this if the instance is linked to another
			if ( !gid || !linkTo )
				return false;
			
			//clear the timeout
			clearTimeout( me.sliderTimeout );
			
			//the instance where the call is coming from
			var rotator = this;

			//find the linked instance in the rotators array
			var other = me.rotators[ linkTo ];
			
			//make sure it is running
			if( typeof other === 'object' && other.isRunning() ){
				//get the linked ctrl
				other.slideChange( gid );
			}
			
			return me.sliderTimeout = setTimeout( me.sliderTimeoutFunc, me.timeoutTime );
		};
		
		return me.init();
	}
	
	window['EaseRotatorController'] = EaseRotatorController;
	
})(jQuery);



(function($){
	
	function EasePhotoGallery( config ){
		var me = this,
			defaults = {
				galleryContSelector: 'ease-photo-gallery',
				linkCls: 'ease-img-link',
				showTitles: false,
				showDescriptions: false,
				useFrame: false,
				dataAttr: 'ease_full',
				dataEl: false,  //use a data element with pagination to override the default image link with a scripty pagination
				paginate: false,  //put in a number to tell how many items to paginate
				paginateContCls: 'gallery-page-controls', //default class for the controls wrapper
				popupId: 'easePopup',
				isStatic: false
			};
			
		for (var key in config) {
			defaults[key] = config[key] || defaults[key];
		}
	
		for (var key in defaults) {
			me[key] = defaults[key];
		}
		
		//unconfigurable variables
		//me.CONSTANT = 'constant';
		
		me.currentI = 0;
		me.allData = [];
		me.fullData = [];
		me.currentPage = 1;
		me.maxPages = 0;
		me.pageContainer = false;
		me.pageControls = false;
		me.isIE = ( Ease.ie || $('html.ie').length ? true : false );
		me.galleryExists = false;
		me.popup = false;
		me.frameCont = null;
		me.frame = null;
		me.images = {};
		
		me.init = function(){
						
			if ( $(me.galleryContSelector).length ){
				me.galleryExists = true;
				
				me.gallery = $(me.galleryContSelector);

				//check if this is using the a paginated setup
				if ( me.paginate && me.dataEl )
					return me.initPaginated();
				
				
				me.links = me.gallery.find('.'+me.linkCls);
				
				
				me.links.each(function(i){
					var data = $(this).attr( me.dataAttr );
						//json = $.parseJSON( data );
						
					//me.allData[i] = json;
					me.allData[i] = $.parseJSON( data );
				});
				
				me.links.click( me.linkClick );
				
				$('body').click( me.closePop );
			}
						
		};

		me.initPaginated = function(){
			//gallery is already set up
			var data = JSON.parse( $(me.dataEl).text() );
			
			/*
			for (var i=0; i<data.length; i++){
				me.fullData.push( data[i] );
				me.allData.push( data[i].full );
			}
			*/
			//changed for lit project
			$.each( data, function(i){
				me.fullData.push( this );
				me.allData.push( this.full );
			});
						
			me.maxPages = Math.ceil( data.length / me.paginate );
			
			if( me.useFrame )
				me.makeFrame();
			
			if( me.maxPages > 1 ){
				me.makePageContainer();
				me.makePaginateControls();
			}
		
			//this is a selection disabler plugin/function i found.  defined above this class
			if( $.fn.disableSelection )
				$('.pageNext, .pagePrev').disableSelection();
			
			if( me.isStatic ){
				me.currentI = 0;
				me.makePopup();
			} else {
				me.buildPage();
				$('body').click( me.closePop );
			}			
			
		};
		
		me.makeFrame = function(){
			//console.log( 'me.makeFrame', me.fullData[0] );
			
			//get full photo for first photo in bin
			var data = me.fullData[0];
			
			me.frameCont = $('<div />', { id: 'gallery-frame' });
			me.frame = $('<img />', { 
				src: data.full.src,
				thisI: 0,
				alt: data.full.title
			}).attr( me.dataAttr, JSON.stringify( data.full ) )
			.click( me.loadPhoto )
			.appendTo( me.frameCont );

			me.frameTip = $('<div />', { html: 'Click to expand' }).addClass('frame-tip').appendTo( me.frameCont );
			//me.frame = $('<div />', id: { 'gallery-frame' }).insertBefore( me.gallery );
			//me.frame = $('<div />', id: { 'gallery-frame' }).insertBefore( me.gallery );
		
			return me.frameCont.insertBefore( me.gallery );
		};
		
		me.frameClick = function(e){};
		
		me.makePageContainer = function(){
			me.pageContainer = $('<div />', { id: 'gallery-page-container' });
			
			return me.pageContainer.prependTo( me.gallery );
		};
		
		me.buildPage = function(){
			//get the indexes to loop through from the allDat array.
			var minI = me.currentPage * me.paginate - me.paginate,
				maxI = me.currentPage * me.paginate - 1;
			//console.log('buildPage', minI, maxI);
			
			//clear out the page container
			me.pageContainer.html('');
			
			//loop through pictures and build out the links
			for ( var i=minI; i <= maxI; i++ )
				if( i < me.fullData.length )
					me.makeThumbLink( i ).appendTo( me.pageContainer );
			
			//and set the counter
			me.pageControls.find('.pageCounter').text(''+me.currentPage+' of '+me.maxPages);
		};
		
		//all this data is set up in the gallery page template, and follows along with the original html the php was echo-ing...
		me.makeThumbLink = function( i ){
			var data = me.fullData[i];
			//console.log('me.makeThumbLink', data);

			//add in an 'index' attribut to work with pagination

			var a = $('<a>', {
					href: data.full.src,
					thisI: i, //the 'index' in the data array
					title: data.full.title,
					html:  $('<img />', {
						src: data.thumb[0],
						width: data.thumb[1],
						height: data.thumb[2]
					})
				}).attr( me.dataAttr, JSON.stringify( data.full ) )
				.addClass( me.linkCls)
				.click( me.linkClick );
						
			return a;
		};

		me.makePaginateControls = function(){
			
			var controls = {
				nextBttn : $('<div />', { html: 'Next Page' }).addClass('pageNext').click(me.nextPage),
				prevBttn : $('<div />', { html: 'Prev Page' }).addClass('pagePrev').click(me.prevPage),
				counter: $('<div />').addClass('pageCounter'),
				clear: $('<div />').addClass('clearfix')
			};
			
			me.pageControls = $('<div />', {}).addClass( me.paginateContCls )
			
			for ( var ctrl in controls ) {
				me.pageControls.append( controls[ctrl] );
			}			
			
			//return me.pageControls.insertBefore( me.pageContainer );
			return me.pageControls.insertAfter( me.pageContainer );
		};
		
		me.nextPage = function(){
			me.currentPage < me.maxPages ?
				me.currentPage++ :
				me.currentPage = 1;
				
			me.buildPage();
		};
		me.prevPage = function(){
			me.currentPage > 1 ?
				me.currentPage-- :
				me.currentPage = me.maxPages;
				
			me.buildPage();
		};
		
		
		
		me.linkClick = function(e){
			e.stopPropagation();
			e.preventDefault();			
			
			return ( me.useFrame ?
				me.loadPhotoInFrame.call( this, e ) :
				me.loadPhoto.call( this, e )
			);
		};
		
		me.loadPhotoInFrame = function( e ){
			e.stopPropagation();
			e.preventDefault();			
			
			var i = $(this).attr('thisI');
			
			me.frame.attr({ 
				thisI: $(this).attr('thisI'),
				src: me.fullData[i].full.src
			}).attr( me.dataAttr, JSON.stringify( me.fullData[i].full ) );
			
			//console.log( 'me.loadPhotoInFrame', this, e, me.frame );
			
		};
		
		me.loadPhoto = function(e){
			e.stopPropagation();
			e.preventDefault();			
			//check for the index value as an attribute of the link.  use it if it is there ( added for paginating )
			if ( $(this).attr('thisI') ) {
				me.currentI = $(this).attr('thisI');
			} else {
				me.currentI = $(this).index();
			}
			me.makePopup();
		};
		
		me.closePop = function(){
			//$('#underlay, #popup').remove();
			if( me.popup )
				me.popup.hide();
		};
		
		me.nextPop = function(){
			me.currentI++;
			if (me.currentI >= me.allData.length) {
				me.currentI = 0;
			}
			me.switchPop();
		};
		
		me.prevPop = function(){
			me.currentI == 0 ? me.currentI = me.allData.length - 1 : me.currentI--;
				
			me.switchPop();
		};
		
		me.positionPop = function(){
			//var popup = $('#popup'),
			var	pW = me.popup.width(),
				pH = me.popup.height()
				//dH = $.getDocHeight(),
				//dW = $.getDocWidth(),
				dW = $(window).width(),
				sT = $(document).scrollTop(),
				left = Math.floor( (dW - pW) / 2 );
			
			//console.log('left', left);	
			if ( left < 0 ) left = 0;
			
			me.popup.css({
				top: 40 + sT,
				left: left
			}).show();
		};
		
		me.resizeHeight = function( h, w, max ){			
			//this is simple cross multiplication, and the new height is defined by the max(window) height
			//  w/h = x/max
			var newW = Math.round( max * w / h );
			
			return { height : max, width : newW };
		}
		
		me.resizeWidth = function( h, w, max ){
			//this is simple cross multiplication, and the new width is defined by the max(window) width
			//  w/h = max/y
			var newH = Math.round( max * h / w );
			
			return { height : newH, width : max };
		}
		
		me.switchPop = function(){
			//var popup = $('#popup'),
			var	oldImg = me.popup.children('.line, img, #pInfo, #pDesc, #pTitle').remove(),
				i = me.currentI,
				data = me.allData[i],
				imgHeight = data.height,
				imgWidth = data.width,
				imgClass = 'high';
			
			if( me.isStatic && imgWidth > imgHeight )
				imgClass = 'wide';
						
			//console.log('width', imgWidth, maxWidth );
			if ( !me.isStatic && imgWidth > maxWidth ) {
				var maxWidth = $(window).width() - 40,
					newImg = me.resizeWidth( imgHeight, imgWidth, maxWidth );
				imgHeight = newImg.height;
				imgWidth = newImg.width;
				//console.log('new width', newImg, imgWidth, maxWidth );
			}

			//console.log('height', imgHeight, maxHeight );
			if ( !me.isStatic && imgHeight > maxHeight ) {
				var maxHeight = $(window).height() - 80,
					newImg = me.resizeHeight( imgHeight, imgWidth, maxHeight );
				
				imgHeight = newImg.height;
				imgWidth = newImg.width;
			}
			
			
								
			var	imgData = {
					line: $('<div />').addClass('line'),
					img : $('<img />', {
							src: data.src,
							height: imgHeight,
							width: imgWidth
						}).addClass(imgClass)
						.click(me.nextPop)
					//desc : $('<div />', { id: 'pDesc', html : data.desc})
					//title: $('<div />', { id: 'pTitle', html : data.title})
				};
			
			
			//changed for lit to keep them in the same container
			if( me.showTitles || me.showDescriptions )
				imgData.info = $('<div />', { id: 'pInfo' });
			
			//add the title in if defined in the instance config
			if( me.showTitles )
				$('<div />', { id: 'pTitle', html : data.title}).appendTo(imgData.info);
				//imgData.title = $('<div />', { id: 'pTitle', html : data.title});
			
			//same with description
			if( me.showDescriptions )
				$('<div />', { id: 'pDesc', html : data.desc}).appendTo(imgData.info);;
				//imgData.desc = $('<div />', { id: 'pDesc', html : data.desc});
						
			for (var k in imgData) {
				me.popup.append( imgData[k] );
			}	
			
			me.isStatic ? me.popup.show() : me.positionPop();
			
			me.preloadAdjacentImages();
		};
		
		me.preloadAdjacentImages = function(){
			me.currentI+1 >= me.fullData.length ? me.preloadImage( 0 ) : me.preloadImage( me.currentI+1 );	
			me.currentI-1 < 0 ? me.preloadImage( me.fullData.length-1 ) : me.preloadImage( me.currentI-1 );	
			
		};
		
		me.preloadImage = function(i){
			if( !me.images[i] ){
				me.images[i] = new Image;
				me.images[i].src = me.allData[i].src;				
			}
		};
		
		me.makePopup = function(){			
			if (!me.popup){
				
				var controls = {
					nextBttn : $('<div />', { id: 'pNext', html: 'next' }).click(me.nextPop),
					prevBttn : $('<div />', { id: 'pPrev', html: 'prev' }).click(me.prevPop)
				};
				
				if( !me.isStatic )
					controls.closeBttn = $('<div />', { id: 'pClose', html: '&times;' }).click(me.closePop);
				
				me.popup = $('<div />', { id: me.popupId }).click(function(e){ e.stopPropagation(); });
				
				for ( var ctrl in controls ) {
					me.popup.append( controls[ctrl] );
				}
				
				//popup.insertAfter(underlay);
				me.isStatic ? 
					me.popup.prependTo( me.gallery ) :
					me.popup.prependTo('body');
			}
			
			me.switchPop();
		};
		


		me.init();
		
		$(window).resize(function(){
			if( me.popup && !me.popup.is(':hidden') )
				me.switchPop();
		});
		
		return ( me.galleryExists ? me : false );
	}
	
	window['EasePhotoGallery'] = EasePhotoGallery;
	
})(jQuery);


(function($){
		
	function EasePopup( $el ){
		
		if( !$el || !$el.length )
			return false;
		
		var me = this;
		
		me.$self = $el;

		me.init = function(){
			me.$self.appendTo( 'body' );
			
			//stop propagation on $self clicks
			me.$self.click(function(e){
				e.stopPropagation();
				
			});
			
		};
		
		me.show = function(){
			me.position();
			me.$self.show(0);
			
		};
		
		me.hide = function(){
			me.$self.hide(0);
		};
		
		me.position = function(){
			
			var oW = me.$self.outerWidth(),
				oH = me.$self.outerHeight()

			var left = Math.floor( ($(window).width() - oW) / 2 );

			if( left < 0 )
				left = 0;

			var top = Math.floor( ($(window).height() - oH) / 2 + $(window).scrollTop());
			if( top < 0 )
				top = 0;

			me.$self.css({
				top: top,
				left: left
			});

		};
		
		me.init();
	}

	window['EasePopup'] = EasePopup;
	
})(jQuery);