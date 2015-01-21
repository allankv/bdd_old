<link rel="stylesheet" type="text/css" href="resources/menu/css/menu_green.css" />
<script src="resources/menu/inc/jquery.metadata.js"></script>
<script src="resources/menu/inc/jquery.hoverIntent.js"></script>
<script src="resources/menu/inc/mbMenu.js"></script>
<link rel="stylesheet" href="css/tipsy.css" type="text/css" />
<script type="text/javascript" src="js/tips/tipsy/jquery.tipsy.js"></script>
<script type="text/javascript">
	function logout() {
		$.ajax({
			type:'POST',
	        url:'index.php?r=logout',
	        dataType: "json",
	        success:function(json) {
				//location.reload(true);
				document.location.href = 'index.php';
	        }
        });
	}
	
	$(document).ready(function() {

    	$("#userMenu").buildMenu({
	      menuWidth:140,
	      openOnRight:false,
	      hasImages:false,
	      fadeInTime:100,
	      fadeOutTime:300,
	      adjustLeft:0,
	      minZindex:"auto",
	      adjustTop:0,
	      opacity:.95,
	      shadow:true,
	      shadowColor:"#ccc",
	      hoverIntent:0,
	      openOnClick:false,
	      closeOnMouseOut:false,
	      closeAfter:1000,
	      submenuHoverIntent:200
	    });
        });

        $(document).ready(aboutTips);

        function aboutTips(){
            $('#aboutSpecimen').tipsy({
                className: 'tip-twitter',
                fallback: "View and maintain records of specimens' occurrence information.",
                live: true
            });
            $('#aboutSpecies').tipsy({
                className: 'tip-twitter',
                fallback: "View and maintain records of biological species' information.",
                live: true
            });
            $('#aboutInteraction').tipsy({
                className: 'tip-twitter',
                fallback: 'View and maintain data related to interactions between specimens.',
                live: true
            });
            $('#aboutDeficit').tipsy({
                className: 'tip-twitter',
                fallback: 'View and maintain records of pollination deficit assessment and detection studies.',
                live: true
            });
            $('#aboutMonitoring').tipsy({
                className: 'tip-twitter',
                fallback: "View and maintain monitoring of biological specimens, its space-time occurrences, and other information.",
                live: true
            });
            $('#aboutMedia').tipsy({
                className: 'tip-twitter',
                fallback: 'View and maintain media records of modern biological specimens and information such as format, copyright and date digitized.',
                live: true
            });
            $('#aboutBibliographic').tipsy({
                className: 'tip-twitter',
                fallback: 'View and maintain records of references to biological specimens and information such as authorship, copyright and content data.',
                live: true
            });
            $('#aboutAnalysis').tipsy({
                className: 'tip-twitter',
                fallback: 'Set of visualizations and statistical analysis of the current specimen occurrence records database.',
                live: true
            });
            $('#aboutSpreadsheet').tipsy({
                className: 'tip-twitter',
                fallback: 'Import and export Specimen Records and their Interactions in a spreadsheet application, such as Microsoft Excel.',
                live: true
            });
         };
</script>
<style>
	div.menuTitle {
		color:black;
		font-weight:bold;
		font-family:Arial;
		letter-spacing:2px;
		padding-bottom:4px;
   		padding-top:3px;
    	text-align:center;
    	width:100px;
    	margin-left:auto;
    	margin-right:auto;
	}
	div.menuImage {
		height:65px;
    	text-align: center;
	}
	.boxMenu a {
		margin: 0px;
	}
</style>

<div id="userMenu" style="margin-left:20px;">
  <table class="rootVoices" cellspacing='0' cellpadding='0' border='0'><tr>
  
	<?php if (!Yii::app()->user->isAdmin) { ?>
	  	<td class="rootVoice {menu: 'empty'}" onclick="javascript:document.location.href = 'index.php'">Home</td>
	<?php } ?>
  	<?php if (Yii::app()->user->isAdmin) { ?>
  			<td class="rootVoice {menu: 'admin'}" onclick="javascript:document.location.href = 'index.php?r=admin'">Admin</td>
  	<?php } ?>
  	
  	<?php if (!Yii::app()->user->isAdmin) { ?>
	  	<?php if (!Yii::app()->user->isGuest) { ?>
	  	<td class="rootVoice {menu: 'tools_menu'}">Tools</td>
	  	<?php } ?>
	  	
	   	
	  	<td class="rootVoice {menu: 'empty'}" onclick="javascript:document.location.href = 'index.php?r=manual'">Manual</td>
	    <td class="rootVoice {menu: 'empty'}" onclick="javascript:document.location.href = 'index.php?r=about'">About</td>
	   
	<?php } ?>
	
	<?php if (!Yii::app()->user->isGuest) { ?>
	   <td class="rootVoice {menu: 'empty'}" onclick="javascript:logout();">Logout (<?php echo Yii::app()->user->getFirst_Name();?>)</td>
	<?php } ?>
  </tr></table>
</div>

<div id="tools_menu" class="mbmenu boxMenu">
	<table style="border:0;">
	  <tr>
	    <td>
	      <div class="menuTitle">specimen occurrence</div>   
          <div class="menuImage"><img src="images/menu/bee.png" alt="Specimen Occurrence" height="60px"></div>                    
          <a href="index.php?r=specimen/goToMaintain">Create</a>
          <a href="index.php?r=specimen/goToList">List/Update</a>
          <a href="index.php?r=spreadsheetsync/import"><img src="images/excel.png" alt="Deficit" height="15px">Import</a>
          <a href="index.php?r=spreadsheetsync/export"><img src="images/excel.png" alt="Deficit" height="15px">Export</a>
          <a href="tapirlink/www/tapir.php/specimen_provider">Provider</a>
        </td>
        <td>
          <div class="menuTitle">specimen interaction</div>
          <div class="menuImage"><img src="images/menu/interaction.png" alt="Specimen Interaction" height="60px" style="padding-top:0px"></div>
          <a href="index.php?r=interaction/goToMaintain">Create</a>          
          <a href="index.php?r=interaction/goToList">List/Update</a>
		  <a href="index.php?r=spreadsheetsync/import"><img src="images/excel.png" alt="Deficit" height="15px">Import</a>
          <a href="index.php?r=spreadsheetsync/export"><img src="images/excel.png" alt="Deficit" height="15px">Export</a>
          <a href="tapirlink/www/tapir.php/interaction_provider">Provider</a>
        </td>
        <td>
	      <div class="menuTitle" style="height:29px;">species</div>   
          <div class="menuImage"><img src="images/menu/flowers.png" alt="Species" height="60px" style="padding-top:0px;"></div>
          <a href="index.php?r=species/goToMaintain">Create</a>
          <a href="index.php?r=species/goToList">List/Update</a>
        </td>        
        <td>
		  <div class="menuTitle" style="height:29px;">pollination deficit</div>
          <div class="menuImage"><img src="images/menu/deficit.png" alt="Deficit" height="60px"></div>
          <a href="index.php?r=deficit/goToMaintain">Create</a>
          <a href="index.php?r=deficit/goToList">List/Update</a>
        </td>
        <td>
		  <div class="menuTitle" style="height:29px;">monitoring</div>
          <div class="menuImage"><img src="images/menu/monitoring.png" alt="Deficit" height="60px"></div>
          <a href="index.php?r=monitoring/goToMaintain">Create</a>
          <a href="index.php?r=monitoring/goToList">List/Update</a>
          <a href="index.php?r=spreadsheetsync/import_monitoring"><img src="images/excel.png" alt="Deficit" height="15px">Import</a>
          <a href="index.php?r=spreadsheetsync/export_monitoring"><img src="images/excel.png" alt="Deficit" height="15px">Export</a>
        </td>
        <td>
		  <div class="menuTitle">media resource</div>
          <div class="menuImage"><img src="images/menu/camera.png" alt="Media Resouces" height="60px"></div>
          <a href="index.php?r=media/goToMaintain">Create</a>
          <a href="index.php?r=media/goToList">List/Update</a>
        </td>
        <td>
          <div class="menuTitle">bibliographic resource</div>
          <div class="menuImage"><img src="images/menu/articles.png" alt="Reference Resources" height="60px"></div>
          <a href="index.php?r=reference/goToMaintain">Create</a>
          <a href="index.php?r=reference/goToList">List/Update</a>
          <a href="index.php?r=reference/getXml">XML Exporting</a>
        </td>
        <td>
          <div class="menuTitle">analysis tools</div>
          <div class="menuImage"><img src="images/menu/settings.png" alt="Analysis Tools" height="60px" style="padding-top:0px"></div>
          <!--http://www.eobjects.dk/datacleaner/IconDataQuality.png<a href="index.php?r=taxonomictool">BDD Taxon Tool</a>
          <a href="index.php?r=georeferencingtool/goToMaintain">BDD Georeferencing Tool</a>-->
          <a href="index.php?r=analysis">Statistics Tool - Specimen</a>
          <a href="index.php?r=analysismonitoring">Statistics Tool - Monitoring</a>
          <a href="index.php?r=morphospecies">Morphospecies Identification</a>
          <a href="index.php?r=dataquality">Data Quality Improvement</a>
          <!--<a href="index.php">Batching Edition</a>		  -->
        </td>
        <!--<td>
          <div class="menuTitle">spreadsheet sync</div>
          <div class="menuImage"><img src="images/menu/excel2.png" alt="Spreadsheet Sync Tool" height="60px" style="padding-top:0px"></div>
          <a href="index.php?r=spreadsheetsync/import">Import</a>
          <a href="index.php?r=spreadsheetsync/export">Export</a>
          <a id="aboutSpreadsheet" href="index.php?r=spreadsheetsync">About</a>
        </td>-->
	  </tr>
	</table>
    
</div>


<div id="admin" class="mbmenu boxMenu">
	<table style="border:0;">
	  <tr>
	    <td>
	      <div class="menuTitle">Groups</div>   
          <div class="menuImage"><img src="images/menu/groups.png" alt="Groups" height="60px"></div>                    
          <a href="index.php?r=admin/goToMaintainGroup">Create</a>
          <a href="index.php?r=admin/goToListGroups">List/Update</a>
         
        </td>
        <td>
          <div class="menuTitle">Users</div>
          <div class="menuImage"><img src="images/menu/users.png" alt="Users" height="60px" style="padding-top:0px"></div>
          <a href="index.php?r=admin/goToMaintainUser">Create</a>          
          <a href="index.php?r=admin/goToListUsers">List/Update</a>
		 
        </td>
       
	  </tr>
	</table>
    
</div>
