(function($){
	//specifically written to use for jwplayer videos
	function EaseVideo( $el ){
		
		if( !$el || !$el.length )
			return false;
		
		var me = this;
		
		me.$self = $el;
		me.id = $el.children().attr('id');
		me.path = '/'+$el.attr('data-path');
		//me.markup = me.$self.find('textarea').val();
		//me.$embed = null;

		me.init = function(){
			//me.$self.appendTo( 'body' );
			
		    jwplayer( me.id ).setup({
		        //flashplayer: Ease.TemplateUrl+"/js/player.swf",
		        height: 480,
		        width: 864,
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
		    });
			
			//console.log(me.markup);
			//me.hide();
			
			//stop propagation on $self clicks
			//me.$self.click(function(e){
			//	e.stopPropagation();
			//});
			
		};
		
		me.init();
	}

	window['EaseVideo'] = EaseVideo;
	
})(jQuery);

$(document).ready(function(){
	new EaseVideo( $('#video') );
});

