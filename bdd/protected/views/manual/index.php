<?php
$cs=Yii::app()->clientScript;
//$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_HEAD);
//$cs->registerCssFile("css/lightbox.css");
?>


<?php echo CHtml::beginForm(); ?>

<div class="yiiForm">

    <div style="height: 100%; position:relative;margin-left: auto;margin-right: auto;width:80%;margin-top:50px;text-align:justify;">
        <h1><?php echo Yii::t('yii','The Biodiversity Data Digitizer User Manual'); ?></h1>
        <table align="center" width="100%">
            <tr align="center">
                <th>
                    <br/><h3><?php echo Yii::t('yii','Everything you need to know to use the BDD'); ?></h3>
                    <p align="justify"><?php echo Yii::t('yii','The BDD manual serves both as a quick reference guide and as an extensive and detailed guide to using the Biodiversity Data Digitizer. It includes information on every type of field used as well as step-by-step instructions on how to create, list, link, update, and delete any and all Specimen, Interaction, Reference, and Media records.'); ?>
                    <p align="left">Note that your computer needs PDF-reading capabilities to view the manual. If it does not, please download the <a href="http://get.adobe.com/reader" target="_blank" style="text-decoration:underline;">Adobe Reader</a> application.</p>
                </th>
            </tr>
            <tr align="center">
                <th>
                    <HR WIDTH=100% ALIGN=CENTER NOSHADE>
                </th>
            </tr>
            <tr align="center">
                <th>
                    <h3><?php echo Yii::t('yii','Download the BDD User Manual'); ?></h3>
                    <p align="justify"><?php echo Yii::t('yii',''); ?></p>
                    <table align="center" width="100%">
                        <tr align="center">
                            <th><a href="images/uploaded/grantee_model.xls"><img width="25%" src="images/main/excel.png"/></a></th>
                        </tr>
                        <tr align="center">
                            <td><a href="images/uploaded/grantee_model.xls"><?php echo Yii::t('yii','Click the link above to download the manual in PDF form.'); ?></a></td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr align="center">
                <th>
                    <HR WIDTH=100% ALIGN=CENTER NOSHADE>
                </th>
            </tr>
            <tr align="left">
                <th>
                    <h3><?php echo Yii::t('yii','Quick Reference Guide'); ?></h3>
                    <?php echo Yii::t('yii','While the manual covers everything that can be done on the Biodiversity Data Digitizer, it also includes a Quick Reference Guide. Located at the beginning of the manual, it has information on how to:'); ?>
                    <ul>
                        <li style="margin-bottom:10px;">Easily create specimen records</li>
                        <li style="margin-bottom:10px;">Quickly edit specimen records</li>
                        <li style="margin-bottom:10px;">Create a reference/media/interaction record related to a specimen record</li>
                        <li style="margin-bottom:10px;">Edit existing records’ relationships</li>
                        <li style="margin-bottom:10px;">Auto-Complete functionality</li>
                        <li style="margin-bottom:10px;">Auto-Suggest utility</li>
                        <li style="margin-bottom:10px;">File Upload tool</li>
                    </ul>
                </th>
            </tr>
        </table>
    </div>

</div>
<br/><br/><br/>
<?php
echo CHtml::endForm();
?>
<br>
<br>
