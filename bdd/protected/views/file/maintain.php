<?php include_once("protected/extensions/config.php"); ?>

<html>
<head>	
	<script type="text/javascript" src="js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/upload.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery/jquery-ui.css"/>
	<script type="text/javascript" src="js/tips/jquery.poshytip.min.js"></script>
	<link rel="stylesheet" type="text/css" href="js/tips/tip-twitter/tip-twitter.css"/>
	<script type="text/javascript" src="js/jquery.jnotify.js"></script>		
	<link rel="stylesheet" type="text/css" href="css/jquery.jnotify.css"/>	
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<link rel="stylesheet" type="text/css" href="css/form.css" />
</head>
    <body style="background:#FFFFFF; " >
        <?php
        if((Yii::app()->request->isPostRequest)&&(($_FILES))) {
            ?>
        <script type="text/javascript" >
			function configIcons() {
				$(function(){
					$('ul.iconJQueryHover li').hover(
						function() {
							$(this).addClass('ui-state-hover');
						},
						function() {
							$(this).removeClass('ui-state-hover');
						}
						);
				});
			}
            $(document).ready(function() {
                parent.notificaUploadRealizado('<?php echo $file->idfile; ?>');
                //$('#teste').val($('#FileAR_idfile').val());
                parent.proximoPassoFormulario();
                var msg = new Array();
                msg[0] = "File uploaded";
                parent.printMsg(msg,'#msg',true);
                configIcons();
            });
        </script>
            <?php
        }
        ?>
        <table style="width:100%;background-color:#F9F9F9;border: 1px solid #DDDDDD;margin-top:15px; border-radius: 0.4em 0.4em 0.4em 0.4em;-moz-border-radius-topleft: 0.4em;-moz-border-radius-topright: 0.4em;-moz-border-radius-bottomleft: 0.4em;-moz-border-radius-bottomright: 0.4em;" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td style="background-color:#DDDDDD;font-weight:bold;letter-spacing:1px;padding:5px;padding-left:15px;border-radius: 0.4em 0.4em 0em 0em;-moz-border-radius-topleft: 0.4em;-moz-border-radius-topright: 0.4em;-moz-border-radius-bottomleft: 0em;-moz-border-radius-bottomright: 0em;"><?php echo Yii::t('yii', 'Associated File');?></td>
            </tr>
            <tr>
                <td style="vertical-align:middle; padding: 15px 10px 15px 20px;">
                    <?php
                    echo CHtml::activeHiddenField($file,'idfile');
                    if($file->filename<>"") {
                        echo '<div style="float: left; font-weight: bold; margin-right: 10px; margin-top: 5px;">'.$file->filename.'</div>';

                        //comando para abrir o arquivo em outra janela
                        //echo "<a style=\"border:0px;\" href=\"javascript:window.open('images/uploaded/".trim($file->fileystemname)."');\" target=\"_blank\">";
                        //echo "&nbsp;&nbsp;<a style=\"border:0px;\" href=\"images/uploaded/".trim($file->filesystemname)."\" target=\"_blank\">";
                        //echo CHtml::image("images/main/ico-download.jpg", "",array("style"=>"border:0px;"));
                        //echo "</a>&nbsp;&nbsp;";
                        
                        echo '<div style="float: left; margin-right: 7px;"><a href="images/uploaded/'.trim($file->filesystemname).'" target="_blank">';
                        showIcon("Download", "ui-icon-disk", 1);
                        echo '</a></div>';

                        //comando para apagar o arquivo do banco e retirar a associação
                        
                        echo '<div style="float: left"><a href="javascript:parent.saveRemoverArquivo();">';
                        showIcon("Delete", "ui-icon-trash", 1);
                        echo '</a></div><div style="clear:both">';

                        //echo "<a HREF=javascript:parent.saveRemoverArquivo() >";
                        //echo "<img border=0 src='images/main/canc.gif' >";
                        //echo "</a><br>";

                        //echo CHtml::imageButton("images/main/canc.gif",array('submit'=>array("deleteFile&".$extraParametros,'class'=>'confirm','id'=>$idObjectReference),'confirm'=>Yii::t('yii', 'Are you sure to delete?')));
                        ?>

                    <script type="text/javascript" >
                        $(document).ready(function() {
                            parent.notificaUploadExistente(<?php echo $file->idfile;?>);

                        });
                    </script>
                        <?php
                    }else {
                        ?>
                    <script type="text/javascript" >
                        $(document).ready(function() {
                            parent.notificaUploadNaoExistente();
                        });
                    </script>
                        <?php
                        echo "<form name='uploadForm' ID='uploadForm' method='POST' enctype='multipart/form-data' >";
                        //campo para fazer upload de arquivos
                        echo "<input TYPE='file' NAME='file' ID='upload_file'>";
                        echo "</form>";
                    }
                    ?>
                </td>

            </tr>
        </table>
    </body>
</html>
