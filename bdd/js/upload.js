function configUpload(fk_id){
	if($(fk_id).val()!=''){
		$('#fileStatus').show();
		$('#file').hide();
		
		$.ajax({url:'index.php?r=file/getFile',
	        type: 'POST',
	    	data: {'id':$(fk_id).val()},
	        dataType: "json",
	        success: function(json){   
				
				var saveBtn = '<div style="float: left; margin-right: 20px; margin-left: 300px;"><a href="'+json.ar.path+json.ar.filename+'" target="_blank">';
	            saveBtn += "<ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Download'><span class='ui-icon ui-icon-disk'></span></li></ul>";//"<?=showIcon("Download", "", 1);?>";
	            saveBtn += '</a></div>';
	            var deleteBtn = '<div style="float: left"><a onClick="$(\''+fk_id+'\').val(\'\');$(\'#file\').show();$(\'#fileStatus\').hide();configButtonUpload(\''+fk_id+'\');">';
	            deleteBtn += "<ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete'><span class='ui-icon ui-icon-trash'></span></li></ul>";//"<?=showIcon("Delete", "ui-icon-trash", 1);?>";
	            deleteBtn += '</a></div><div style="clear:both">';
	                        
				$('#fileStatus').html(saveBtn+deleteBtn);
		    }
	    });
			
	}else{
		$('#fileStatus').hide();
		$('#file').show();		 
	}			
	configButtonUpload(fk_id)	
}
function configUploadShow(fk_id){
	if($(fk_id).val()!=''){
		$('#fileStatus').show();
		$('#file').hide();
		
		$.ajax({url:'index.php?r=file/getFile',
	        type: 'POST',
	    	data: {'id':$(fk_id).val()},
	        dataType: "json",
	        success: function(json){   
				
				var saveBtn = '<div style="float: left; margin-right: 20px; margin-left: 320px;"><a href="'+json.ar.path+json.ar.filename+'" target="_blank">';
	            saveBtn += "<ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Download'><span class='ui-icon ui-icon-disk'></span></li></ul>";//"<?=showIcon("Download", "", 1);?>";
	            saveBtn += '</a></div><div style="clear:both">';
	                        
				$('#fileStatus').html(saveBtn);
		    }
	    });
			
	}else{
		$('#fileStatus').hide();
		$('#file').show();
		$('#noFile').show();		 
	}			
}
function saveFile(fileName,fk_id){
	$.ajax({url:'index.php?r=file/save',
        type: 'POST',
    	data: {'filename':fileName},
        dataType: "json",
        success: function(json){   
			$(fk_id).val(json.id);
			$('#file').hide();
			$('#fileStatus').show();
			
			var saveBtn = '<div style="float: left; margin-right: 20px; margin-left: 300px;"><a href="'+json.fileURL+'" target="_blank">';
            saveBtn += "<ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Download'><span class='ui-icon ui-icon-disk'></span></li></ul>";//"<?=showIcon("Download", "", 1);?>";
            saveBtn += '</a></div>';
            var deleteBtn = '<div style="float: left"><a onClick="$(\''+fk_id+'\').val(\'\');$(\'#file\').show();$(\'#fileStatus\').hide();configButtonUpload(\''+fk_id+'\');">';
            deleteBtn += "<ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete'><span class='ui-icon ui-icon-trash'></span></li></ul>";//"<?=showIcon("Delete", "ui-icon-trash", 1);?>";
            deleteBtn += '</a></div><div style="clear:both">';
                        
			$('#fileStatus').html(saveBtn+deleteBtn);
	    }
    });
}
function configButtonUpload(fk_id){
	$('#file').html('');
	var uploader = new qq.FileUploader({
        element: document.getElementById('file'),
        action: 'js/valums/server/php.php',
        debug: false,
        onComplete: function(id, fileName, responseJSON){
        	saveFile(responseJSON.fileName,fk_id);            	    	
        },
    });
}