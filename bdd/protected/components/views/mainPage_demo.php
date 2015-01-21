<table style="width:95%;margin-top:20px;" align="center" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="2" style="background-color:#f9f9f9;width:355px;padding:15px;text-align:left;font-size:13px;letter-spacing:0.5px;vertical-align:top">
            
            <h3 style="margin:0px;margin-bottom: 10px;font-size:15px;">DEMO THE BDD</h3>
            This demo allows you to try out the BDD tool. You may add and delete any specimen, interaction, media, and reference records in the database.
            <p>Note that all data on this demo is fictitious and thus will not be used in the IABIN Portal.</p>
            <p>To login, use the username <b>guest</b> and password <b>guest</b>.</p>

            <!-- jquery scripts -->
            <link href="js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>
            <script src="js/jquery/jquery.min.js"></script>
            <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
            <script src="js/jquery/jquery-ui.min.js"></script>


            <script>
                        $(function() {
                            $( "button, input:submit", ".demo" ).button();                            
                        });
            </script>


            <table style="width:100%;margin-top:0px;background-color:#f9f9f9;" align="center">
                <tr>
                    <td>
                        <div class="demo" align="right">
                            <button onclick='location.href="/index.html"; return false;'>BACK</button>
                        </div>
                    </td>

                    <td>
                        Click to go back to the introductory page.
                    </td>

                </tr>
            </table>
            
            <br/><br/>

        </td>
        <td rowspan="4" style="width:470px;vertical-align: top;">
            <div id="gallery" style="position:relative;top:-5px;left:5px;padding:0px;margin:0px;">
                <a style="opacity: 0;" href="#" class="">
                    <img src="images/main/slideshow/1.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Biodiversity Data Digitizer');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'This tool was designed for easy digitization, manipulation, and publication of biodiversity data.');?> " height="253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <a class="show" style="opacity: 1;" href="#">
                    <img src="images/main/slideshow/2.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Auto-suggestion');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'A mechanism for data quality that suggests values based on authoritative databases, such as ITIS and Geonames.');?> " height=253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <a class="" style="opacity: 0;" href="#">
                    <img src="images/main/slideshow/3.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Media & References');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'BDD offers tools to manage and relate media and reference files with occurrence and interaction records.');?>" height="253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <a class="" style="opacity: 0;" href="#">
                    <img src="images/main/slideshow/4.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'TAPIR Provider');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'A TAPIR provider is built into BDD. It publishes records from the database in the standard schemas (Darwin Core, Dublin Core, etc).');?>" height="253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <a style="opacity: 0;" href="#" class="">
                    <img src="images/main/slideshow/5.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Interaction Records');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'Interaction tool allows one to register the relationship between two occurrence records.');?> " height="253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <a class="" style="opacity: 0;" href="#">
                    <img src="images/main/slideshow/6.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Standards');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'BDD is based on international metadata standards for biodiversity information, such as Darwin Core (TDWG), Dublin Core and MRTG.');?> " height="253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <a class="" style="opacity: 0;" href="#">
                    <img src="images/main/slideshow/7.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Development');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'The BDD was an outgrowth of the PDD, which was developed within the scope of the Pollinator Thematic Network (IABIN-PTN).');?>" height="253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <a class="" style="opacity: 0;" href="#">
                    <img src="images/main/slideshow/8.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Map views');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'BDD has a map tool that plots occurrence records from the database. Filters help you refine your analysis.');?>" height="253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <a class="" style="opacity: 0;" href="#">
                    <img src="images/main/slideshow/9.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Access tool');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'The BDD is a browser-based system that can be accessed remotely, through an external server, or locally, when installed on a personal computer.');?>" height="253" width="460" style="padding: 5px 5px 5px 5px;">
                </a>
                <div style="opacity: 0.7; width: 460px; height: 60px; display: block;" class="caption">
                    <div style="opacity: 0.7;" class="content"><h3><?php echo Yii::t('yii', 'Biodiversity Data Digitizer');?></h3></div>
                </div>
            </div>
        </td>
    </tr>
    <?php /*<tr>
        <td style="width:40px;padding:0px;padding-top:30px;padding-bottom: 10px;margin:0px;vertical-align:middle;">
            &nbsp;<?php echo Yii::t('yii',' '); ?><!--<?php echo CHtml::image('images/main/seta.png', '', array('style'=>'float: right;')); ?>-->
        </td>
        <td style="width:315px;padding:0px;padding-top:30px;padding-bottom: 10px;margin:0px;vertical-align: middle;">
            &nbsp;<?php echo Yii::t('yii',' '); ?><!--<font color="green"><h3 style="margin:0px;padding:0px;padding-left:8px;font-size:15px;"><?php echo Yii::t('yii','FIND SPECIES'); ?></h3></font>-->
        </td>
    </tr>
    <tr>
        <td style="padding-left:33px;height:30px;vertical-align:top;" colspan="2">
           <!-- <input name="find" size="30" type="text">
            <input value="search" type="submit">-->&nbsp;<?php echo Yii::t('yii',' '); ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left:33px;font-size:12px;padding-bottom: 6px;font-style: italic;" colspan="2">
          <!--  ex: tetragonisca angustula-->&nbsp;<?php echo Yii::t('yii',' '); ?>
        </td>
    </tr>
</table>

     */?>

<style type="text/css">
    <!--
    .seta {width:40px;text-align:right;padding-right:10px;vertical-align: middle;height:30px;}
    .setaconteudo {width:280px;font-size:13px;letter-spacing:0.5px;vertical-align: middle;}
    -->
</style>

<table style="width:100%;margin-top:30px;margin-bottom:20px;" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2" style="height:8px;background-color:#f2f2f2;">
        </td>
    </tr>
    <tr>
        <td style="vertical-align:top;padding-left:20px;">
            <table style="width:100%;margin-top:15px;" align="center">
                <tr>
                    <td style="text-align:center;width:150px;font-size: 11px;vertical-align:middle;"><font color="green"><h3 style="margin:0px;padding:0px;letter-spacing:1px;font-size:14px;"><?php echo Yii::t('yii', 'Main features');?></h3></font></td>
                    <td ><?php echo CHtml::image('images/main/linha_verde.jpg')?></td>
                    <td style="text-align:center;width:150px;font-size: 11px;vertical-align:middle;"><font color="green"><h3 style="margin:0px;padding:0px;letter-spacing:1px;font-size:14px;"><?php echo Yii::t('yii', 'Data Management');?></h3></font></td>
                    <td ><?php echo CHtml::image('images/main/linha_verde.jpg')?></td>
                </tr>
            </table>
            <table style="width:100%;margin-top:0px;" align="center">
                <tr>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Manage Collections of Specimen Data'); ?></td>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Create Specimen Occurrence Records'); ?></td>
                </tr>
                <tr>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Ensure Accuracy with Data Quality Tools'); ?></td>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Link References, Media, and Interactions'); ?></td>
                </tr>
                <tr>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','View Specimen Locations on a World Map'); ?></td>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Attach Reference and Media Files'); ?></td>
                </tr>
                <tr>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Import and Export Data using Spreadsheets'); ?></td>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Access Data Through the TAPIR Protocol'); ?></td>
                </tr>
            </table>
        </td>
        <td rowspan="2" style="width:180px;padding-right:20px;padding-left:20px;">
            <?php $this->widget('UserLogin',array('visible'=>Yii::app()->user->isGuest)); ?>
        </td>
    </tr>
</table>