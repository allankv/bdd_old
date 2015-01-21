<?php
$cs = Yii::app()->clientScript;
if (Yii::app()->user->isGuest) {
    $cs->registerCssFile("css/slideshow.css");
    $cs->registerScriptFile("js/slideshow/AC_RunActiveContent.js",CClientScript::POS_END);
    $cs->registerScriptFile("js/slideshow/mainslideshow.js",CClientScript::POS_END);
    $cs->registerScriptFile("js/main.js",CClientScript::POS_END);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta name="language" content="en" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />
        
        <title><?php echo $this->pageTitle; ?></title>
        
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/ui-lightness/jquery-ui.css"/>-->
        <script type="text/javascript" src="js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery/jquery-ui.css"/>
        <script type="text/javascript" src="js/tips/jquery.poshytip.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/tips/tip-twitter/tip-twitter.css"/>
		<script type="text/javascript" src="js/jquery.jnotify.js"></script>		
		<link rel="stylesheet" type="text/css" href="css/jquery.jnotify.css"/>
		<script type="text/javascript" src="js/lightbox/lightbox.js"></script>		
		<link rel="stylesheet" type="text/css" href="css/lightbox.css"/>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/interaction.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/tablesorter/themes/blue/style.css" />
		
    </head>
    <body class="page">
        <table style="width:900px;height:79px;background-image:url('images/main/header1.jpg');background-repeat:no-repeat;background-position:none;" align="center" cellpadding="0" cellpadding="0">
            <tr>
                <td style="width: 70%">
				<a href="index.php"><?php echo CHtml::image("images/main/logo_bdd.png","",array("style"=>"border:0px; padding-left:27px;")); ?></a>
                </td>
                <td style="width: 30%;padding-right:10px;" align="right">
                    <?php //echo CHtml::link("portugu&ecirc;s", "index.php?r=".CController::getId()."/sitelanguage&t=pt",array('class'=>'lang')); ?><br/>
                    <?php //echo CHtml::link("english", "index.php?r=".CController::getId()."/sitelanguage&t=en_us",array('class'=>'lang')); ?><br/>
                    <?php //echo CHtml::link("espa&ntilde;ol", "index.php?r=".CController::getId()."/sitelanguage&t=es",array('class'=>'lang'));?>
                </td>
            </tr>
        </table>
        <table style="width:900px; height:34px; background-color:#EDEDED;" align="center"  cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <?php $this->widget('UserMenuPublic'); ?>
                    <!--<div style="text-align:right;height:30px;margin:0px;">
                        <?php  if(!Yii::app()->user->isGuest) {
                            //$this->widget('UserMenuLogin',array('visible'=>!Yii::app()->user->isGuest));
                        }?>
                    </div>-->
                </td>
            </tr>
        </table>
        <table style="width:900px;background-color:#ffffff;" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <?php
                    if(!isset($_GET["r"])) {
                        if((Yii::app()->user->isGuest)) $this->widget('MainPage'); else $this->widget('UserPanel');
                    } else {
                        if($content) {
                            echo "<div>";
                            echo $content;
                            echo "</div>";
                        }
                    }
                    ?>
                </td>
            </tr>
        </table>
        <table style="width:900px;" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td style="text-align:center;background-color:#DEDEDE;letter-spacing:0.5px;height:40px;color:gray;font-size:10px;font-family: Verdana;">
                    The Biodiversity Data Digitizer uses the latest web technology and requires the latest browsers.<br />
                    Browsers known to work on the BDD are Internet Explorer 8, Mozilla Firefox 3.6 or higher, Opera 11 or higher, and Google Chrome 8 or higher.<br />
                    Developed by LAA - Laborat&oacute;rio de Automa&ccedil;&atilde;o Agr&iacute;cola da Escola Polit&eacute;cnica da USP - Brazil. <?php echo Yii::powered(); ?>
                </td>
            </tr>
        </table>
    </body>
</html>
