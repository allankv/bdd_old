<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/lightbox/referenceselements.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/loadfields.js"></script>
<script type="text/javascript" src="js/deleteelements.js"></script>
<script type="text/javascript" src="js/List.js"></script>

<div class="introText">
    <div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
    <h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'Exporting Bibliographic References Metadata in XML Format'); ?></h1>
    <div style="clear:both;"></div>
    <p><?php echo Yii::t('yii', 'This resource allows export metadata from bibliographic references records of BDD database. The metadata are formatted according Simple Dublin Core Metadata Schema.'); ?></p>

    <table align="center" width="100%">
            <tbody>
                <tr align="center">
                <tr align="center">
                    <td>
                        <a style="text-decoration:none; " href="<?php echo $address;?>" target="_blank">
                            <img width="35px" src="images/main/Filetype-XML-icon.png">
                            <br>
                            Download<br/>Bibliographic References (Dublin Core)
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

</div>
