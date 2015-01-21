
	<style>
	.ui-tabs-vertical { width: 55em; }
	.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
	.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
	.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
	.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
	.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
	
	.list{
	width: 500px !important;
	}	
</style>

 
<div id="tabs_taxos">
  <ul>
    <li><a id = "tab-1" href="#tabs-1">Kingdom</a></li>
    <li><a href="#tabs-2">Phylum</a></li>
    <li><a href="#tabs-3">Class</a></li>
    <li><a href="#tabs-4">Order</a></li>
    <li><a href="#tabs-5">Family</a></li>
    <li><a href="#tabs-6">Genus</a></li>
    <li><a href="#tabs-7">Species</a></li>
  </ul>
  <?php for ($i=1; $i<8;$i++){?>
	  <div id="tabs-<?php echo $i;?>">
	    
			  <div id="divTableList">
			  <div class='divLoad'> Aguarde a leitura dos dados...</div>
			  <div class='divNoTaxon'> No Taxons.</div>
				<table id="tablelistsp" class="list listTaxons" style="margin-top:-10px;" width="400px";>
			        <thead><tr><th style="text-align:left;" width="300px"><?php echo $title_table;?></th><th width="180px">Options</th></tr>
			        </thead>
			        <tbody class="lines_taxons<?php echo $i;?>"></tbody>
			    </table>    
				<br/><br/>
			</div>
	    
	  </div>
  <?php }?>
  
</div>

<br/><br/>

<div class="legendbar" style="text-align:center">
        <div id="content_Legend">
        	<div class="flagIconLegend"><?php showIcon("Sugestions", "ui-icon-flag", 0); ?></div>
	        <div class="flagIconLegendText">Sugestions</div>
	        <div class="undoIconLegend"><?php showIcon("Undo Corrections", "ui-icon-arrowreturnthick-1-s", 0); ?></div>
	        <div class="undoIconLegendText">Undo</div>
	        <div class="listIconLegend"><?php showIcon("List Specimens", "ui-icon-note", 0); ?></div>
	        <div class="listIconLegendText">List Specimens</div>
	        <div style="clear:both"></div>
        </div>
</div>
<br/><br/>
	
	<div id="graph">
	<div class="container" id="container<?php echo $tipo;?>"></div>
	</div>
	
 <script>
	$(function() {
		
		
		$( "#tabs_taxos" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs_taxos li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

				
		$("#tabs_taxos").tabs().bind("tabsselect",function(event,ui){
			var index = ui.index + 1;
			    $('.list').show();
				listIncorrectTaxons(index,2);
			
		  
		  });

		
	});
</script>   