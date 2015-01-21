<?php
	$cs=Yii::app()->clientScript;
	//Light box
	$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
	$cs->registerCssFile("css/lightbox.css");
        $cs->registerScriptFile("js/lightbox/referenceselements.js",CClientScript::POS_HEAD);
        //Sorter
        $cs->registerScriptFile("js/tablesorter/jquery.tablesorter.min.js",CClientScript::POS_HEAD);
        $cs->registerScriptFile("js/tablesorter/tablesorter.js",CClientScript::POS_HEAD);
        //Load autocompletefields
        $cs->registerScriptFile("js/autocomplete.js",CClientScript::POS_END);
        $cs->registerScriptFile("js/loadfields.js",CClientScript::POS_END);
?>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main_portlet.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bdd.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/tablesorter/themes/blue/style.css" />

<?php echo CHtml::image("images/main/lupa.png","",array("style"=>"border:0px; padding-right:30px; z-index: 2; float: left; width: 35px;")); ?>


<div class="actionBar">
[<?php echo CHtml::link(Yii::t('yii', "Create new Reference Record"), array('create')); ?>]
[<?php echo CHtml::link('Manage References Elements',array('admin')); ?>]
</div>


<div class="yiiForm" style="width: 490px;">
    <div class="item">
    <?php echo CHtml::beginForm(); ?>

    <div class="simple">
        <?php echo CHtml::label(Yii::t('yii','Creator'), "referenceselements", array("class"=>"listrecord", "style"=>"text-align:right;padding-left:60px; padding-top: 3px; width: 140px")); ?>
        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=creator',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;'));?>
        <?php echo CHtml::activeTextField($creators, 'creator', array('class'=>'textboxtext'));?>
    </div>

    <div class="simple">
        <?php echo CHtml::label(Yii::t('yii','Title'), "referenceselements", array("class"=>"listrecord", "style"=>"text-align:right;padding-left:60px; padding-top: 3px; width: 140px")); ?>
        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=title',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;'));?>
        <?php echo CHtml::activeTextField($model,'title', array('class'=>'textboxtext')); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::label(Yii::t('yii','Subject'), "referenceselements", array("class"=>"listrecord", "style"=>"text-align:right;padding-left:60px; padding-top: 3px; width: 140px")); ?>
        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subject',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;'));?>
        <?php echo CHtml::activeTextField($model,'subject', array('class'=>'textboxtext')); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::label(Yii::t('yii','Languages'), "referenceselements", array("class"=>"listrecord", "style"=>"text-align:right;padding-left:60px; padding-top: 3px; width: 140px")); ?>
        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=languages',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;'));?>
        <?php echo CHtml::activeDropDownList($model,'idlanguages', CHtml::listData(languages::model()->findAll(), 'idlanguages', 'language'), array('empty'=>'-')); ?>
    </div>




    <br/>

    <div class="simple" style="float: right;padding-right:42px">
        <?php echo CHtml::submitButton(Yii::t('yii','Search')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
    </div>

    <!-- Process and show results -->
    <?php if($modelList !== null) { ?>
    <div class="item" style="width:168%;">
        <br>
        <br>
        <?php echo CHtml::image("images/main/linha.png","",array("style"=>"border:0px; padding-left:0px; z-index: 2; float: left; width: 820px;")); ?>
        <br>
        <br>

        <table id="tablelist" class="tablesorter" style="display: table; width: 100%;">
            <thead>
                <tr style="display:table-row;background-image:url('images/main/table_header.jpg');height:25px;font-family:verdana;font-size:10px;text-align:left;">
                    <th style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:6px;"><?php echo CHtml::encode(Yii::t('yii','Creator')); ?></th>
                    <th style="display: table-cell; width: 160px; border:0px solid gray;vertical-align:middle;padding-left:3px;"><?php echo CHtml::encode(Yii::t('yii','Title')); ?></th>
                    <th style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:3px;"><?php echo CHtml::encode(Yii::t('yii','Subject')); ?></th>
                    <th style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:3px;"><?php echo CHtml::encode(Yii::t('yii','Language')); ?></th>
                    <th style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:3px;"><?php echo CHtml::encode(Yii::t('yii','Date last modified')); ?></th>
                    <th style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:0px;text-align: center;"> - </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($modelList as $n=>$model):?>
                    <tr style="display:table-row;background-image:url('images/main/table_content.jpg');height:25px;">
                        <td style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:6px;">
                            <?php echo CHtml::encode($creators->creator->creator)?>
                        </td>
                        <td style="display: table-cell; width: 160px; border:0px solid gray;vertical-align:middle;padding-left:3px;">
                            <?php echo CHtml::encode($model->title->title); ?>
                        </td>
                        <td style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:3px;">
                            <?php echo CHtml::encode($model->subject->subject); ?>
                        </td>
                        <td style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:3px;">
                            <?php echo CHtml::encode($model->idlanguages->language); ?>
                        </td>
                        <td style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:3px;">
                            <?php echo CHtml::encode($model->modified); ?>
                        </td>
                        <td style="display: table-cell; width: 200px; border:0px solid gray;vertical-align:middle;padding-left:10px;text-align: center;">
                            <?php echo CHtml::link(Yii::t('yii', 'View'),array('show','id'=>$model->idreferenceselements))." | "; ?>
                            <?php echo CHtml::link(Yii::t('yii', 'Update'),array('update','id'=>$model->idreferenceselements)); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
             </tbody>
         </table>
    </div>
    <?php } ?>
    <br/>












</div>



<?php /*

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idreferenceselements')); ?>:
<?php echo CHtml::link($model->idreferenceselements,array('show','id'=>$model->idreferenceselements)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idaccuralmethods')); ?>:
<?php echo CHtml::encode($model->idaccuralmethods); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idaccuralperiodicities')); ?>:
<?php echo CHtml::encode($model->idaccuralperiodicities); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idaccuralpolicies')); ?>:
<?php echo CHtml::encode($model->idaccuralpolicies); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idaudiences')); ?>:
<?php echo CHtml::encode($model->idaudiences); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idcontributors')); ?>:
<?php echo CHtml::encode($model->idcontributors); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idcreators')); ?>:
<?php echo CHtml::encode($model->idcreators); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idinstructionalmethods')); ?>:
<?php echo CHtml::encode($model->idinstructionalmethods); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idlanguages')); ?>:
<?php echo CHtml::encode($model->idlanguages); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idpublishers')); ?>:
<?php echo CHtml::encode($model->idpublishers); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idtypereferences')); ?>:
<?php echo CHtml::encode($model->idtypereferences); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('title')); ?>:
<?php echo CHtml::encode($model->title); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('subject')); ?>:
<?php echo CHtml::encode($model->subject); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('description')); ?>:
<?php echo CHtml::encode($model->description); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('source')); ?>:
<?php echo CHtml::encode($model->source); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('relation')); ?>:
<?php echo CHtml::encode($model->relation); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('coverage')); ?>:
<?php echo CHtml::encode($model->coverage); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('rights')); ?>:
<?php echo CHtml::encode($model->rights); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('date')); ?>:
<?php echo CHtml::encode($model->date); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('format')); ?>:
<?php echo CHtml::encode($model->format); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('identifier')); ?>:
<?php echo CHtml::encode($model->identifier); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('provenance')); ?>:
<?php echo CHtml::encode($model->provenance); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('rightsholder')); ?>:
<?php echo CHtml::encode($model->rightsholder); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('accessrights')); ?>:
<?php echo CHtml::encode($model->accessrights); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('bibliographiccitation')); ?>:
<?php echo CHtml::encode($model->bibliographiccitation); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

 */ ?>