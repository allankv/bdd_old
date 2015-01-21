<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/upload.js",CClientScript::POS_HEAD);
?>
<script type="text/javascript" >
    var auxImport = false;
    function notificaConclusaoUpload(idfile){
        if(auxImport)startImport(idfile);
    }
</script>
<iframe style="background-color: white;" marginheight="0px"   name='uploadFrame'  src="index.php?r=file/goToMaintain&id=<?php echo $idFile;?>" width="676px" height="115px" frameborder="0" ID="uploadFrame" align="top" >
</iframe>
