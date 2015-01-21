var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
  elem: false,
  write: function(text){
    if (!this.elem) 
      this.elem = document.getElementById('log');
    this.elem.innerHTML = text;
    this.elem.style.left = '20px';
  }
};

function spaceTree(json){
    json = {id:"node01",name:"<strong>Taxon Tree</strong>" ,data:{},children:json};    
    
    //Create a new ST instance
    var st = new $jit.ST({
    	levelsToShow: 2,
        injectInto: 'infovis',
        duration: 200,
        transition: $jit.Trans.Quart.easeInOut,
        //set distance between node and its children
        levelDistance: 50,
        //enable panning
        Navigation: {
          enable:true,
          panning:true,
          zooming:20
        },
        //set node and edge styles
        //set overridable=true for styling individual
        //nodes or edges
        Node: {
            height: 70,
            width: 100,
            type: 'rectangle',
            color: '#99CC66',
            overridable: true,
            CanvasStyles: {  
		      shadowColor: '#999',  
		      shadowBlur: 10  
		    }  
        },
        
        Edge: {
            type: 'bezier',
            overridable: true
        },
        
        onBeforeCompute: function(node){
            Log.write('<img src="images/main/ajax-loader4.gif"></img>');
        },
        
        onAfterCompute: function(){
            Log.write("");
        },
        
        //This method is called on DOM label creation.
        //Use this method to add event handlers and styles to
        //your node.
        onCreateLabel: function(label, node){
            label.id = node.id;            
            label.innerHTML = node.name;
            label.onclick = function(){
           		st.onClick(node.id);
            };
            //set label styles
            var style = label.style;
            style.width = 100 + 'px';
            style.height = 'auto';            
            style.cursor = 'pointer';
            style.color = '#000';
            style.fontSize = '0.9em';
            style.textAlign= 'center';
            style.paddingTop = '3px';
            style.textShadow = '1px 1px 2px #777';
        },
        
        //This method is called right before plotting
        //a node. It's useful for changing an individual node
        //style properties before plotting it.
        //The data properties prefixed with a dollar
        //sign will override the global node style properties.
        onBeforePlotNode: function(node){
            //add some color to the nodes in the path between the
            //root node and the selected node.
            if (node.selected) {
                node.data.$color = "#F6A828";
            }
            else {
                delete node.data.$color;
                //if the node belongs to the last plotted level
                if(!node.anySubnode("exist")) {
                    //count children number
                    //var count = 0;
                    //node.eachSubnode(function(n) { count++; });
                    //assign a node color based on
                    //how many children it has
                    //node.data.$color = ['#66DD00', '#66CC00', '#66BB00', '#66AA00'][count];
                    //if (count >= 4) {
                    	//node.data.$color = '#66AA00	';
                    //}              
                }
            }
        },
        
        request: function(nodeId, level, onComplete) {
          	var id = nodeId.split('_');

			$.ajax({
			    type:'POST',
			    url:'index.php?r=analysis/getTaxon',
			    data: {'list':jFilterList, 'type':id[0], 'idkingdom':id[1], 'idphylum':id[2], 'idclass':id[3], 'idorder':id[4], 'idfamily':id[5], 'idgenus':id[6], 'idsubgenus':id[7], 'idspecificepithet':id[8], 'idinfraspecificepithet':id[9]},
			    dataType: 'json',
			    success:function(json) {
			    	var ans = {
			        	'id': nodeId,
			        	'children': json.result
			        };
			        			        
			        onComplete.onComplete(nodeId, ans);  
			    }
			});
        },
        
        //This method is called right before plotting
        //an edge. It's useful for changing an individual edge
        //style properties before plotting it.
        //Edge data proprties prefixed with a dollar sign will
        //override the Edge global style properties.
        onBeforePlotLine: function(adj){
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#eed";
                adj.data.$lineWidth = 3;
            }
            else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
        }
    });
    //load json data
    st.loadJSON(json);
    //compute node positions and layout
    st.compute();
    //optional: make a translation of the tree
    st.geom.translate(new $jit.Complex(-200, 0), "current");
    //emulate a click on the root node.
    st.onClick(st.root);
    //end
    //Add event handlers to switch spacetree orientation.
    var top = $jit.id('r-top'), 
        left = $jit.id('r-left'), 
        bottom = $jit.id('r-bottom'), 
        right = $jit.id('r-right');  
    
    function changeHandler() {
        if(this.checked) {
            top.disabled = bottom.disabled = right.disabled = left.disabled = true;
            st.switchPosition(this.value, "animate", {
                onComplete: function(){
                    top.disabled = bottom.disabled = right.disabled = left.disabled = false;
                }
            });
        }
    };
    
    top.onchange = left.onchange = bottom.onchange = right.onchange = changeHandler;
    //end
}
