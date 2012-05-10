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
	//specifically written to use for jwplayer videos
	function EaseVideo( $el ){
		
		if( !$el || !$el.length )
			return false;
		
		var me = this;
		
		me.$self = $el;
		me.id = $el.children().attr('id');
		me.path = '/'+$el.attr('data-path');

		me.init = function(){
			
		    jwplayer( me.id ).setup({
		        //flashplayer: Ease.TemplateUrl+"/js/player.swf",
		        height: 480,
		        width: 864,
			    skin: Ease.TemplateUrl + '/js/glow/glow.zip',
		        image: Ease.TemplateUrl + me.path + ".jpg",
				 modes: [
		            { type: "html5" },
		            { type: "flash", src: Ease.TemplateUrl+"/js/player.swf" },
		            { type: "download" }
		        ],
		        levels: [
		            { file: Ease.TemplateUrl + me.path + ".mp4" },    // H.264 version
		            { file: Ease.TemplateUrl + me.path + ".webm" },    // WebM version
		            { file: Ease.TemplateUrl + me.path + ".ogg" }     // Ogg Theora version
		        ]
		    }).onComplete(function(event){
				_gaq.push(['_trackEvent', 'Video', Ease.pageTitle, 'Complete', event.duration ]);
			}).onPlay(function(event){
				//console.log('play', event, this.getPosition() );
				_gaq.push(['_trackEvent', 'Video', Ease.pageTitle, 'Play', this.getPosition() ]);
			});
			
						
		};
		
		me.init();
	}


	$(document).ready(function(){
		new EaseVideo( $('#video') );
	});

	
})(jQuery);

