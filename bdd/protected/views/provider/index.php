<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/jquery/jquery.min.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("css/lightbox.css");
//$cs->registerScriptFile("js/lightbox/recordlevelelements.js",CClientScript::POS_HEAD);
//$cs->registerScriptFile("js/lightbox/localityelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/validationdata.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/Maintain.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/Geo.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/validation/jquery.numeric.pack.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/jquery.jstepper.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("js/tips/tip-twitter/tip-twitter.css");
$cs->registerScriptFile("js/tips/jquery.poshytip.min.js",CClientScript::POS_END);
include "protected/extensions/config.php";

$cs->registerScriptFile("js/loadfields.js",CClientScript::POS_END);
?>

<link href="css/jquery.jnotify.css" rel="stylesheet" type="text/css" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="js/jquery.jnotify.js" type="text/javascript"></script>
<script type="text/javascript">
    
    $(document).ready(bootProvider);
    function bootProvider(){
        $('#downloadMedia').hide();
        $('#downloadRef').hide();
        $('#loading').hide();
    }

    function provideMedia(){
        $('#loading').toggle('slow');

        $.ajax({ type:'POST',
            url:'index.php?r=provider/media',
            success:function() {
                $('#loading').toggle('slow');
                $('#downloadMedia').toggle('slow');
            }
        });
    }
    function provideReferences(){
        $('#loading').toggle('slow');

        $.ajax({ type:'POST',
            url:'index.php?r=provider/reference',
            success:function() {
                $('#loading').toggle('slow');
                $('#downloadRef').toggle('slow');
            }
        });
    }
</script>



<div style="padding:20px;">
    Hello! Please choose between the Media Provider and the References Provider.
    <p>
        <a href="javascript:provideMedia();">Media Provider</a>
    </p>

    <p>
        <a href="javascript:provideReferences();">References Provider</a>
    </p>
</div>

<div id="loading">
    Please wait. Loading...
</div>

<div id="downloadMedia">
    <a href="provider/media.xml">Media XML</a>
</div>

<div id="downloadRef">
    <a href="provider/reference.xml">Reference XML</a>
</div>