<?php
$cs=Yii::app()->clientScript;
//$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_HEAD);
//$cs->registerCssFile("css/lightbox.css");
?>


<?php echo CHtml::beginForm(); ?>

<div class="yiiForm">

    <div style="height: 100%; position:relative;margin-left: auto;margin-right: auto;width:80%;margin-top:50px;text-align:justify;">
        <h1><?php echo Yii::t('yii','Spreadsheet Synchronization Tool'); ?></h1>
        <table align="center" width="100%">
            <tr align="center">
                <th>
                    <br/><h3><?php echo Yii::t('yii','Import and Export Spreadsheet Data'); ?></h3>
                    <p align="justify" style="font-weight:normal;"><?php echo Yii::t('yii','The BDD Spreadsheet Synchronization Tool allows users to view and create Specimen Records and their Interactions in a spreadsheet application, such as Microsoft Excel.'); ?>
                    <br/><br/><?php echo Yii::t('yii', 'This allows those who are more accustomed to inputting data on spreadsheets to quickly create large numbers of records simply by following a spreadsheet template (found below) and importing it.'); ?>
                    <br/><br/><?php echo Yii::t('yii', 'The Spreadsheet Synchronization Tool also has the capability of exporting the entire BDD Specimen Record and Interaction Record Database to a spreadsheet. Geared towards users who prefer to view data in spreadsheet form, it presents all of the Specimen and Interaction data in one sheet. Note that, depending on the size of the database currently in use, this file may be exceptionally large.'); ?></p>
                    <table align="center" width="100%">
                        <tr align="center">
                            <th><h3><?php echo Yii::t('yii','Import from Spreadsheet to BDD'); ?></h3>
                                <p style="font-weight:normal;"><?php echo Yii::t('yii','Use this to import data from a spreadsheet file into the BDD database. To create a spreadsheet file, please use the template we’ve provided and follow the recommendations, both found below.'); ?></p>
                                <table align="center" width="100%">
                                    <tbody>
                                        <tr align="center">
                                        <tr align="center">
                                            <td>
                                                <a href="images/uploaded/spreadsheetsync_model.xls">Download Spreadsheet File</a>
                                            </td>
                                        </tr>
                                    </tbody>                             
                                </table>
                                <table align="center" width="100%">
                                    <tr align="center">
                                        <th><a href="index.php?r=spreadsheetsync/import"><img width="50%" src="images/main/import.jpg"/></a></th>
                                    </tr>
                                    <tr align="center">
                                        <td><?php echo Yii::t('yii','Import Spreadsheet'); ?></td>
                                    </tr>                                    
                                </table>
                            </th>
                            <th><h3><?php echo Yii::t('yii','Export to Spreadsheet from BDD'); ?></h3>
                                <p style="font-weight:normal;"><?php echo Yii::t('yii','Use this to transcribe all of the Specimen and Interaction data present in the BDD into a spreadsheet file. Once the BDD has finished the transcription process, it will allow you to download the file.'); ?></p>
                                <table align="center" width="100%">
                                    <tr align="center">
                                        <th><a href="index.php?r=spreadsheetsync/export"><img width="50%" src="images/main/export.jpg"/></a></th>
                                    </tr>
                                    <tr align="center">
                                        <td><?php echo Yii::t('yii','Export to Spreadsheet'); ?></td>
                                    </tr>
                                </table>
                            </th>
                        </tr>                       
                    </table>
                </th>
            </tr>
            <tr align="center">
                <th>
                    <HR WIDTH=100% ALIGN=CENTER NOSHADE>
                </th>
            </tr>
            <tr align="center">
                <th>                    
                    <br/><h3><?php echo Yii::t('yii','Download Spreadsheet Template'); ?></h3>
                    <p align="justify" style="font-weight:normal;"><?php echo Yii::t('yii','This template spreadsheet is offered as a means of facilitating the input of a large quantity of data for those who are more familiar with spreadsheet software (such as MS Excel). Used correctly, it allows you to upload data directly into a database, dismissing the need to input it one by one. Once you have finished inputting data, save the file and use the “Import Spreadsheet to BDD” option above.'); ?></p>
                    <table align="center" width="100%">
                        <tr align="center">
                            <th><a href="images/uploaded/spreadsheetsync_model.xls"><img width="25%" src="images/main/excel.png"/></a></th>
                        </tr>
                        <tr align="center">
                            <td><a href="images/uploaded/spreadsheetsync_model.xls"><?php echo Yii::t('yii','Download Spreadsheet File'); ?></a></td>
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
                    <br/><h3><?php echo Yii::t('yii','Recommendations for using the template'); ?></h3>                    
                    <ul style="font-weight:normal;">
                        <li style="margin-bottom:10px;">The first 8 data lines are only examples.</li>
                        <li style="margin-bottom:10px;">As you place the mouse over the fields, a help text will pop up.</li>
                        <li style="margin-bottom:10px;">Fill in only the fields for which you have data, and don't delete any columns.</li>
                        <li style="margin-bottom:10px;">When filling the fields use terms in English when applicable (ex. Sex, life stage, Country name without special signs, such as Panama x Panamá). </li>
                        <li style="margin-bottom:10px;">The "BasisOfRecord" field for specimens in collections must be set to "PreservedSpecimens". </li>
                        <li style="margin-bottom:10px;">The "BasisOfRecord" field for specimens observed in the field (but not collected) must be set to "HumanObservation".</li>
                        <li style="margin-bottom:10px;">The union of the fields "InstitutionCode"+"CollectionCode"+"CatalogNumber" identifies a unique specimen. </li>
                        <li style="margin-bottom:10px;">A unique specimen (InstitutionCode+CollectionCode+CatalogNumber) can have many interactions with other specimens (e.g. it can visit + extract nectar + nest, etc.). Each interaction will occupy one line. Look how we have repeated the same specimen twice (for specimens with catalog numbers 2,3 and 4) on the examples to input two interactions for each of them.</li>
                        <li style="margin-bottom:10px;">The field "RelatedInformation" is required in case of specimen data (preserved or observed specimens) which was obtained from bibliography (and not directly from a collection) </li>
                        <li style="margin-bottom:10px;">The "InteractionType" field must be filled in using only the expressions available at the controlled vocabulary (on cell BF1 of the spreadsheet), such as VisitedFlowerOf, HostOf. If you want to suggest other types of interaction, please contact us (address below).</li>
                        <li style="margin-bottom:10px;">Use a single sheet for all your data.</li>
                        <li style="margin-bottom:10px;">Please refer to the <i><b><a href="../guide/PDD_user_manual.pdf" target="_blank" style="text-decoration:underline;">PDD user guide</a></b></i> for more detailed information on each of the fields.</li>
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
