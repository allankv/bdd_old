<?php include_once("protected/extensions/config.php"); ?>





<script>
    $(document).ready(bootSpecimen);

     
    // Inicia configuracoes Javascript
    function bootSpecimen(){
		for (var i=1;i<9;i++){
			if (i!=2){
       		 configCatComplete('#id'+i,'#searchField'+i, 'dataquality','#filterList'+i);
			}
		}
        //Help message for the filter textbox help tool 
        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below. Different terms for different categories (e.g.: Institution Code and Collection Code) will result in an AND search. Different terms for the same category, however, will result in an OR search.</div>';

        //Set the help tooltip for the Filter textbox
       

        /*for (var i=1;i<9;i++){
			if (i!=2){
				 $('#searchField'+i).poshytip({
			            className: 'tip-twitter',
			            content: helpTip,
			            showOn: 'focus',
			            alignTo: 'target',
			            alignX: 'left',
			            alignY: 'center',
			            offsetX: 35
			        });
				 
			}
		}*/
        
    }
    
  
    
</script>

<div id="noResults<?php echo $tipo;?>" style='margin-left:50px;'>	
	 		<p> No results. </p>
	 </div>

	 
<div id="divTableList<?php echo $tipo;?>" cl="divTableList<?php echo $tipo;?>">
	
	<?php echo CHtml::beginForm(); ?>
	<div class="filter">
	    <div class="filterLabel"><?php echo 'Filter';?></div>
	    <div class="filterMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=filter',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></div>
	    <div class="filterInterval">
	    Filtered from <b><span id="start<?php echo $tipo;?>"></span></b> to <b><span id="end<?php echo $tipo;?>"></span></b> of <b><span id="max<?php echo $tipo;?>"></span></b>
	    </div>
	    <div style="clear:both"></div>
	
	    <div class="filterField">
	    <input type="text" id="searchField<?php echo $tipo;?>" style="border: 1px solid #DDDDDD;background: #FFFFFF;color: #013605;font-size: 1.3em;" />
	    <input type="hidden" id="id<?php echo $tipo;?>"/>
	    </div>
	    <div class="slider" id="slider<?php echo $tipo;?>"></div>
	  
	    <div style="clear:both"></div>
	    <div class="filterList">
	    <div id="filterList<?php echo $tipo;?>"></div>
	    </div>
	</div>
	<?php echo CHtml::endForm(); ?>
	
	<br/><br/>

	<table id="tablelist" class="list" style="margin-top:-10px;">
        <thead><tr><th style="text-align:left;" width="300px"><?php echo $title_table;?></th><th style="text-align:left;" width="150px">Collection</th><th style="text-align:left;" width="80px">Catalog Number</th><th>Options</th></tr>
        </thead>
        <tbody class="lines<?php echo $tipo;?>"></tbody>
    </table>    
    
    
	    
	
	<br/><br/>
	<div class="legendbar">
        <div class="showIconLegend"><?php showIcon("Show Specimen Record", "ui-icon-search", 0); ?></div>
        <div class="showIconLegendText">Show Record</div>
        <div class="alertIconLegend"><?php showIcon("Coordinate Alert", "ui-icon-alert", 0); ?></div>
        <div class="alertIconLegendText">No geographical information</div>
        <div class="checkIconLegend"><?php showIcon("Correction Ok", "ui-icon-check", 0); ?></div>
        <div class="checkIconLegendText">Correction Ok</div>
        <div class="flagIconLegend"><?php showIcon("Sugestions", "ui-icon-help", 0); ?></div>
        <div class="flagIconLegendText">Sugestions</div>
        <div class="undoIconLegend"><?php showIcon("Undo Corrections", "ui-icon-arrowreturnthick-1-s", 0); ?></div>
        <div class="undoIconLegendText">Undo</div>
        <div style="clear:both"></div>
	</div>  
	
	<br/><br/>
	
	<div id="graph">
	<div class="container" id="container<?php echo $tipo;?>"></div>
	</div>
</div>


	
