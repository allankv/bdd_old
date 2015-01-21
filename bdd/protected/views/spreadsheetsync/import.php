<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/Maintain.js"></script>

<link href="js/valums/client/fileuploader.css" rel="stylesheet" type="text/css">
<script src="js/valums/client/fileuploader.js" type="text/javascript"></script>
    <script>        
        function createUploader(){      
        	configNotify();
        	$(':button').button();      
        	$('#importLoading').hide();
            var uploader = new qq.FileUploader({
                element: document.getElementById('file'),
                action: 'js/valums/server/php.php',
                debug: false,
                onComplete: function(id, fileName, responseJSON){
					$('#file').hide();
                	$('#importLoading').fadeIn(2000);                	
                	$.ajax({url:'index.php?r=spreadsheetsync/startImport',
	    		        type: 'POST',
	    	        	data: {'fileName':responseJSON.fileName},
		    	        dataType: "json",
			            success: function(json){   
					   					
 
	//var link = '<div style="float:left; position:relative; left:50%; margin-right:15px;"><a id="link" target="_blank" href="'+json.url+'"><img width="35px" src="images/main/excel.png"/><br>Download</a></div>';
							//$('#divlink').show();
		                	//$('#result').fadeIn(2000);
			                var log = [];
			                log[0] = '<b># '+(json.response.totalSpecimenCreated)+' Specimens records handled.</b>';
			                log[1] = '<b># '+(json.response.totalInteractionCreated)+' Interactions records handled.</b>';
			               // log[2] = '<b># '+json.response.totalSpecimenUpdated+' Specimens records.</b>';
			               // log[3] = '<b># '+json.response.totalInteractionUpdated+' Interactions records updated.</b>';
		        	        showMessage(log, true, true);
		        	        $('#importLoading').fadeOut(2000);
		            	    //$('#divlink').html(link);
					    	//$('#sinceCountdown').countdown('pause');			    		    	
	            			//$('#sinceCountdown').countdown('destroy');              
	        		    }
			        });
                },
            });           
        } 
        window.onload = createUploader;     
</script>   
<div id="Notification"></div>

<div class="introText">
    <div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
    <h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'Import from spreadsheet'); ?></h1>
    <div style="clear:both;"></div>
    <p><?php echo Yii::t('yii', 'Use this to import data from a spreadsheet file into the BDD database. To create a spreadsheet file, please use the template we’ve provided and follow the recommendations, both found below.'); ?></p>

    <table align="center" width="100%">
            <tbody>
                <tr align="center">
                <tr align="center">
                    <td>
                        <a style="text-decoration:none; " href="../../tmp/spreadsheetsync_model.xls" target="_blank">
                            <img width="35px" src="images/main/excel.png">
                            <br>
                            Spreadsheet File Model
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

</div>

<div class="importContainer">
	<div id="importStart">
			<div class="privateRecord" id="file">		
		<noscript>			
			<p>Please enable JavaScript to use file uploader.</p>
		</noscript>         
	</div>
	</div>	
	<div id="importLoading">
		<div><img width="25px" src="images/main/ajax-loader2.gif"/></div>
	    <div class="loading"><?php echo Yii::t('yii', 'Please wait while your file is uploaded to the BDD. This may take a few minutes depending on the size of your spreadsheet file and your internet connection speed.'); ?></div>
	    <button onclick="window.open('<?php echo getCurrentURL(); ?>');">Continue to work on BDD</button>
	</div>
 </div>
