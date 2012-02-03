(function($){

var hours = [
  { year: "2004", branding: 100, marketing: 200, webDesign: 300 },
  { year: "2005", branding: 200, marketing: 300, webDesign: 400 },
  { year: "2006", branding: 300, marketing: 400, webDesign: 500 },
  { year: "2007", branding: 26, marketing: 70, webDesign: 107 },
  { year: "2008", branding: 200, marketing: 550, webDesign: 380 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2009", branding: 15, marketing: 400, webDesign: 280 },
  { year: "2010", branding: 80, marketing: 300, webDesign: 180 },
  { year: "2011", branding: 5, marketing: 10, webDesign: 8 }
];

	
	$(document).ready(function(){
	
		var gg = new GuruGraph( hours, {
				scale: 600,
				numLines: 5,
            	dataPoints: [
            		{ key: "branding", name: "Whatevever", color: '#bada55' },
            		{ key: "marketing", name: "Marketing and stuff", color: '#bad' },
            		{ key: "webDesign", name: "Web Desig and how do you don", color: '#ffaa33' }
            	]
            	//dataKey: 'branding'
            	//width:300,
            	//height: 300,
            	//innerRadius: 40,
            	//outerRadius: 200
			});
		
		//console.log(gg);
		
	});




	//make outerRadius & height/width bigger than your biggest data point
	function GuruGraph(data, config){
		
        var me = this;
        
        if (!data)
        	return false;
        else
        	me.data = data;
        
        var defaults = {
            	width: 1000,
            	height: 1000,
            	innerRadius: 90,
            	outerRadius: 400,
            	scale: 600,
            	numLines: 6,
            	divColor: '#000',
            	circleColor: '#eee',
            	labelColor: 'ccc',
            	fill: '#e5e5e5',
            	dataKey: 'year',
            	dataPoints: [
            		{ key: "branding", name: "Branding", color: '#0068E4' },
            		{ key: "marketing", name: "Marketing", color: '#FF971B' },
            		{ key: "webDesign", name: "Web Design", color: '#333333' }
            	]
            };
    
        for (var key in config) {
            defaults[key] = config[key] || defaults[key];
        }
    
        for (var key in defaults) {
            me[key] = defaults[key];
        }
        



       
        me.init = function(){				
			me.radius = function(mic){
				var radius = ((me.outerRadius - me.innerRadius) * mic/me.scale + me.innerRadius);
				return radius;
			};

			me.dataPointKeys = pv.keys( me.data[0] ).filter(function(el){ return ( el != me.dataKey ) });
			/*
			 * The pie is split into equal sections for each year, with a blank
			 * section at the top for the grid labels. Each wedge is further
			 * subdivided to make room for the three data pieces, equispaced.
			 */
			me.bigAngle = 2.0 * Math.PI / (me.data.length + 1);
			me.smallAngle = me.bigAngle / (me.dataPointKeys.length * 2 + 1);

			me.makePanel();
			
			me.makeBackWedges();

			me.renderDataWedges();
			
			me.addCircularGridLines();			
			
			me.addRadialGridLines();
			
			me.addKeyLabels();
			
			me.makeLegend();
			
			    
      		//draw it.
      		me.vis.render();
      		
        };
        
        me.makePanel = function(){
			/* The root panel. */
			me.vis = new pv.Panel()
			    .width(me.width)
			    .height(me.height)
			    //.bottom(100);
			    .bottom(0);
        };
        
		me.makeBackWedges = function(){
			/* Background wedges to place bars on. */
			me.bg = me.vis.add(pv.Wedge)
			    .data(me.data) // assumes Burtin's order
			    .left(me.width / 2)
			    .top(me.height / 2)
			    .innerRadius(me.innerRadius)
			    .outerRadius(me.outerRadius )
			    .angle(me.bigAngle)
			    .startAngle(function(d){ return this.index * me.bigAngle + me.bigAngle / 2 - Math.PI / 2; })
			    .fillStyle( me.fill ); //fills the back of the graph.  forget it.
			    
			//console.log(me.bg);
		};

		me.renderDataWedges = function(){
			/* data */			
			for ( var j=0; j<me.dataPoints.length; j++ ) {
				var key = me.dataPoints[j].key;
				var color = me.dataPoints[j].color;				
				me.addWedge( key, color, j );
			}
		};

		me.addWedge = function( key, color, j ){
				me.bg.add(pv.Wedge)
					.angle(me.smallAngle)
					.startAngle( function(d){
						return this.proto.startAngle() + me.smallAngle * (j*2+1); 
					})
					.outerRadius( function(d){
						return me.radius( d[key] );
					})
					.fillStyle( color )
				  .anchor("outer").add(pv.Label)
				  	//.textBaseline('middle')
				  	//.textAlign( (this.isReversed() ? 'left' : 'right') )
				  	.textAlign(function(d){
				  		//console.log(this, this.parent, this.target);
				  		return 'left';
				  	})
				  	//.left(300)
				  	.textStyle(me.labelColor)
				  	.text(function(d){
				  		return d[key];
				  	});
		};
		
		me.addCircularGridLines = function(){
			/* Circular grid lines. */
			me.bg.add(pv.Dot)
			    .data( pv.range(0, me.numLines + 1) )
			    .fillStyle(null)
			    .strokeStyle(me.circleColor)
			    .lineWidth(1)
			    .size(function(i){
					return Math.pow( ((me.outerRadius - me.innerRadius) / (me.numLines / i) + me.innerRadius), 2 );
			    })
			  .anchor("top").add(pv.Label)
			    //.visible(function(i){ return i < 3; })
			    .textBaseline("bottom")
			    .text(function(i){ 
			    	return Math.floor( (me.scale) / (me.numLines / i) ); 
			    });			
		};

		me.addRadialGridLines = function(){	
			/* Radial grid lines. */
			me.bg.add(pv.Wedge)
			    .data(pv.range(me.data.length + 1))
			    .innerRadius(me.innerRadius - 10)
			    .outerRadius(me.outerRadius + 10)
			    .fillStyle(null)
			    .strokeStyle(me.divColor)
			    .angle(0);
		};

		me.addKeyLabels = function(){	
			/* Labels. */
			me.bg.anchor("outer").add(pv.Label)
			    .textAlign("center")
			    .text(function(d){ return d[ me.dataKey ] });
		};

		me.makeLegend = function(){
			/* Legend. */
			me.vis.add(pv.Bar)
			    .data( me.dataPointKeys )	//drop out the key (year) from the legend.  it's not colored
			    .right( me.width / 2 + 3)
			    .top(function(){ return me.height / 2 - 28 + this.index * 18; })
			    .fillStyle(function(d){
			    	var fill;
			    	for (var k=0; k<me.dataPoints.length; k++){
			    		if (me.dataPoints[k].key == d){
			    			fill = me.dataPoints[k].color;
			    			break;
			    		}
			    	}
			    	return fill;
			    })
			    .width(36)
			    .height(12)
			  .anchor("right").add(pv.Label)
			    .textMargin(6)
			    .textAlign("left")
			    .text(function(d){
			    	console.log(d);
			    	var name = '';
			    	for (var i=0; i<me.dataPoints.length; i++) {
			    		if ( me.dataPoints[i].key === d ) {
			    			name = me.dataPoints[i].name;
			    			break;
			    		}
			    	}
			    	return name;
			    });
		};
		
		
        me.init();
        
        return me;
	}

	
})(jQuery);

