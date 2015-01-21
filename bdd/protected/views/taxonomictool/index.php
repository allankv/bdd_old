<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BDD Taxonomic Tool</title>
<link rel="stylesheet" href="css/mbContainer/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/mbContainer/green.css" type="text/css" media="screen" />
<script src="js/jquery/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="css/mbContainer/mbContainer.css" title="style"  media="screen"/>
<script type="text/javascript" src="js/inc/jquery.metadata.js"></script>
<script type="text/javascript" src="js/inc/mbContainer.js"></script>
<script src="js/galleria/galleria.js"></script>
<script src="js/galleria/classic/galleria.classic.js"></script>
<script src="js/xml2json.js"></script>
<link rel="stylesheet" type="text/css" href="js/galleria/classic/galleria.classic.css" />

</head>
<body>	
<style>
	#project-label {
/*		display: block;*/
		color: #AA5511;
 		margin-bottom: 1em; 
	}
	#project-level {
		color: #AA5511;
		font-weight: bold;
	}
	#project-icon {
		float: right;		
		height: 32px;
		/* width: 32px; */
	}
	#project-description {
		margin: 0;
		padding: 0;
		font-size: small;
	}
</style>	

<script type="text/javascript">
$(document).ready(boot);
	function initDock(o,docID){
        var opt= o.get(0).options;
        var docEl=$("<span>").attr("id",o.attr("id")+"_dock").css({width:opt.dockedIconDim+5,display:"inline-block"});
        var icon= $("<img>").attr("src",opt.elementsPath+"icons/"+(o.attr("icon")?o.attr("icon"):"restore.png")).css({opacity:.4,width:opt.dockedIconDim,height:opt.dockedIconDim, cursor:"pointer"});
        icon.click(function(){o.mb_iconize()});
        docEl.append(icon);
        $("#"+docID).append(docEl);
        o.attr("dock",o.attr("id")+"_dock");
      }

      function iconize(o){
        $("#"+o.attr("dock")).find("img:first").hide();
      }
      function restore(o){
        $("#"+o.attr("dock")).find("img:first").show();
      }
      function close(o){
        $("#"+o.attr("dock")).find("img:first").hide();
        //$("#open").fadeIn();
      }
 var json;

    // Inicia configuracoes Javascript
    function boot(){
		$(".containerPlus").buildContainers({
			containment:"document",
			elementsPath:"resources/elementsMbContainer/",
			dockedIconDim:45,
			onCreate:function(o){initDock(o,"dock")},
			onClose:function(o){close(o)},
			onRestore:function(o){restore(o)},
			onIconize:function(o){iconize(o)},
			effectDuration:300
		});
/*
		$('#taxon').catcomplete({
			source: 'index.php?r=taxonomictool/search',
			minLength: 1,
			select: function( event, ui ) {

			}
		});	      
*/

		/*$( "#taxon" ).autocomplete({
			minLength: 2,
			source: 'index.php?r=taxonomictool/search',
			focus: function( event, ui ) {
				//$( "#taxon" ).val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {				
				$('.containerPlus').mb_expand();
				$( "#taxon" ).val( ui.item.label );
				$.ajax({ type:'POST',
					url:'index.php?r=taxonomictool/getEol',
					dataType: "json",
					success:function(json) {					
														
	                	$.each(json.dataObjects, function(key,pic) {	
	                		if(pic.eolThumbnailURL){
	                			$('#galleriaList').append('<a href="#" target="_blank"><img src="'+pic.eolMediaURL+'" width="366" alt="1144953 3 2x"></a>');
	                		}		                	                					
        				});
						 $('#galleriaList').galleria(
				        {
				            height:540
				        }
				        );						
					}
				});
				callCol(ui.item.id); 
				//$( "#project-id" ).val( ui.item.value );
				//$( "#project-description" ).html( ui.item.desc );
				//$( "#project-icon" ).attr( "src", "images/" + ui.item.icon );

				return false;
			}
		})

		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" ).data( "item.autocomplete", item ).append("<a><span id='project-label'>" +item.label + "</span> (<span id='project-level'>"+item.level+"</span>) <img id='project-icon' src='"+item.icon+"'/><br><span id='project-description'>" + item.desc + "</span></a>" )
				.appendTo( ul );
		};*/
		var rs = [''];		
		var d=0;
		$( "#taxon" ).autocomplete({
			minLength: 2,
			source: rs,			
			search: function( event, ui ) 
				$.ajax({ type:'POST',
				url:'index.php?r=taxonomictool/search&term='+$('#taxon').val()+'&source=local&type=fuzzy',
				dataType: "json",
				success:function(json) {
					rs = [''];
					for (var ind = 0; ind < json.length; ind++){
						rs.push(json[ind]);
					}
					$("#taxon").autocomplete("option", "source",rs);
					//$("#taxon").autocomplete("search", ''); 						
				}
				});			
			}
		)

		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" ).data( "item.autocomplete", item ).append("<a><span id='project-label'>" +item.label + "</span> (<span id='project-level'>"+item.level+"</span>) <img id='project-icon' src='"+item.icon+"'/><br><span id='project-description'>" + item.desc + "</span></a>" )
				.appendTo( ul );
		};
    }
    var tree = '';
    var i = 8;
    function callCol(id){
    	$.ajax({ type:'POST',
			url:'index.php?r=taxonomictool/getTaxonByID',
			data:{'id':id},
			dataType: "json",
			success:function(json) {				
				tab = '';
				for(var j = 0 ; j < i; j++){
					tab = tab+'&nbsp;&nbsp;';					
				}
				i--;
				tree = tab+json.taxon+'= '+json.label+'<br/>'+tree;
				if(json.id!=null||json.id!=''){
					$('#tree').html(tree);
					callCol(json.id);
				}
			}
		});    	
    }
</script>
	<div id="wrapper">
		<div id="logo" class="blank">
			<h1>BDD Taxonomic Tool</h1>
			<h2>Improving the biodiversity data quality</h2>
		</div>
		<div id="when">
			<p><br/>What taxon are you searching?<!-- <br/>Subscribe by entering your e-mail below --></p>
		</div>
		<div id="form">
			<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<div>
					<input id="taxon" class="text" value="Enter a taxon name..." onfocus="if(this.value=='Enter a taxon name...') { this.value = '' }" onblur="if(this.value=='') { this.value = 'Enter a taxon name...' }" />
					<input type="hidden" value="" name="uri"/>
					<input type="hidden" name="loc" value="en_US"/>
					<input type="submit" class="submit" value="" />
				</div>
			</form>
		</div>
<div id="buttons">
	<div id="dock"></div>	
			<!--
<span id="rss"><a href="#" title="Subscribe to RSS Feed"><img src="images/rss.png" alt="RSS" /></a></span>
			<span id="twitter"><a href="#" title="Follow on Twitter"><img src="images/twitter.png" alt="Twitter" /></a></span>
-->
</div>
	
	<div id="c3" class="containerPlus draggable resizable {buttons:'m,i', icon:'tree.png', skin:'default', width:'500',iconized:'true', dock:'dock', title:'Taxonomic Tree'}" style="position:fixed;top:20px;left:20px">
    <div class="evidence">
      <h3>Taxonomic Tree</h3>
      <span id="img"></span>
      <p><br/><span id='tree'></span><br/><br/>to preiconize containers just add the param <span style="font-weight: bold;">iconized:'true'</span></p>
    </div>    
    <p>Nulla facilisi. Vestibulum vel magna in ante lobortis semper. Integer posuere justo et urna. Vestibulum sit amet sapien ut quam tempor fringilla. Fusce a neque a enim mattis dapibus. Ends with a paragraph element!</p>
  </div>
  <div id="c2" class="containerPlus draggable resizable {buttons:'m,i', icon:'comment-edit-48x48.png', skin:'default', width:'500',iconized:'true', dock:'dock', title:'Taxonomic Informations'}" style="position:fixed;top:20px;right:20px">
    <div class="evidence">
      <h3>Taxonomic Tree</h3>
      <p>to preiconize containers just add the param <span style="font-weight: bold;">iconized:'true'</span></p>
    </div>    
    <div id="galleriaList"></div>
    <div id="relateMedia" align="right"></div>
  </div>
</body>
</html>
