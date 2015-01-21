$(document).ready(function() {
	
		if($('#campoNovoUpload').val()=='true'){			

	        $('#files_filename').uploadify({
	                'uploader'    : 'js/filesupload/uploadify.swf',
	                'script'      : 'js/filesupload/uploadify.php',
	                'folder'      : 'images/uploaded',
	                'cancelImg'   : 'js/filesupload/cancel.png',
	                'queueID'     : 'queuefileupload',
	                'fileDataName': 'files',
	                //'multi'       : 'false',
	                //'auto'        : 'false',
	                'wmode'       : 'transparent',
	                //'fileExt'     : '*.doc;*.pdf;',
	                'onComplete'  : function (a, b, c, d) {
	                                    $("#files_filename").val(c.name);
	                                    $('#file_namefile').val(c.name);
	                                    $("#files_size").val(c.size);
	                                    $('#startupload').css("display","none");
	                                    
	                                    //esconde o input text do nome do arquivo
	                                    $('#divCampoNameFile').css("display","none");
	                                    
	                                    //mostra o nome do arquivo de upload
	                                    $('#divLabelNameFile').css("display","block");
	                                    $('#spanLabelName').text(c.name);
	                                    
	                                    //acerta o link para visualizar o arquivo
	                                    $('#linkViewFile').attr("href","images/uploaded/"+c.name);

	                                    
	                },
	                'onError'  : function (a, b, c, d) {
	                     if (d.status == 404)
	                        alert('Could not find upload script. Use a path relative to: '+'<?= getcwd() ?>');
	                     else if (d.type === "HTTP")
	                        alert('error1 '+d.type+": "+d.info);
	                     else if (d.type ==="File Size")
	                        alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
	                     else
	                        alert('error2 '+d.type+": "+d.text);
	                },
	                'onSelect' : function(a, b, c, d) {
	                    $('#startupload').css("display","block");
	                    if($('#file_namefile').val() != "")
	                        $('#file_update').val('true');
	                },
	                'onCancel'     : function(a, b, c, d) {
	                                    $('#startupload').css("display","none");
	                                    $('#file_update').val('false');
	                }
	        })
		}
});

/*
 * Funcao que remove o arquivo do formulario e habilita a opção de enviar outro arquivo
 */

function removeFormFile(){
	//mostra o input text com o nome do arquivo
    $('#divCampoNameFile').css("display","block");	
    
	//esconde o nome do arquivo de upload
    $('#divLabelNameFile').css("display","none");
    
    //apaga o nome do arquivo
    $('#spanLabelName').text("");
    
    //desfaz o link para visualizar o arquivo
    $('#linkViewFile').attr("href","");    
		
    //apaga os campos do formulario de dados do arquivo
    $('#files_filename').val("");
    $('#files_filesystemname').val("");
    $('#files_size').val("");
    $('#file_namefile').val("");
    
}