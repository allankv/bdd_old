<script type="text/javascript">
	$(function() {
		$("#tabs").tabs({
                        event: 'mouseover',
			ajaxOptions: {
				error: function(xhr, status, index, anchor) {
					$(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible. If this wouldn't be a demo.");
				}
			}
		});
	});
</script>
<div id="result" class="item">

    <div style="margin-bottom:20px;margin-top:30px;width:80%;margin-left:auto;margin-right:auto;height:1px;background-color:#cccccc;"></div>
        <?php //if($count_recordlevelelementsList) {?>
    <div class="foundbar">
                <?php echo Yii::t('yii','Records found').": <font style=\"font-size:14px;font-weight:bold;\">".$count_recordlevelelementsList."</font>"; ?>
    </div>
    <table id="tablelist" class="list">
        <thead>
            <tr>
                <th></th>
                <th><?php echo CHtml::encode(Yii::t('yii','Taxonomic elements')); ?></th>
                <th style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Catalog number')); ?></th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
                    <?php foreach($recordlevelelementsList as $n=>$model):?>
            <tr id="trrecordlevelelement_<?php echo $model->idrecordlevelelements;?>">
                <td style="width:20px;text-indent:0;"><?php if($model->isrestricted) echo CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;","title"=>Yii::t('yii','Private')));?></td>
                <td><?php echo WebbeeController::lastTaxa($model); ?></td>
                <td style="width:120px;text-align:center;"><?php echo CHtml::encode($model->occurrenceelement->catalognumber); ?></td>
                <td style="width:160px;text-align:center;text-indent:0px;">
                                <?php //echo CHtml::link(CHtml::image("images/main/ico_buscar.gif", "",array("style"=>"border:0px;")),array('show','id'=>$model->idrecordlevelelements, 'idinstitutioncode'=>$recordlevelelements->idinstitutioncode, 'idcollectioncode'=>$recordlevelelements->idcollectioncode, 'catalognumber'=>$occurrenceelements->catalognumber, 'idscientificname'=>$taxonomicelements->idscientificname))." | "; ?>
                                <?php echo CHtml::link(CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Update'))),array('update','id'=>$model->idrecordlevelelements, 'idinstitutioncode'=>$recordlevelelements->idinstitutioncode, 'idcollectioncode'=>$recordlevelelements->idcollectioncode, 'catalognumber'=>$occurrenceelements->catalognumber, 'idscientificname'=>$taxonomicelements->idscientificname))." | "; ?>
                                <?php echo CHtml::link(CHtml::image("images/main/doc.png", "",array("style"=>"border:0px;","title"=>Yii::t('yii','References'))),array('referenceelements','id'=>$model->idrecordlevelelements, 'idinstitutioncode'=>$recordlevelelements->idinstitutioncode, 'idcollectioncode'=>$recordlevelelements->idcollectioncode, 'catalognumber'=>$occurrenceelements->catalognumber, 'idscientificname'=>$taxonomicelements->idscientificname))." |"; ?>
                                <?php echo CHtml::link(CHtml::image("images/main/images.gif", "",array("style"=>"border:0px;","title"=>Yii::t('yii','Images'))),array('media','id'=>$model->idrecordlevelelements, 'idinstitutioncode'=>$recordlevelelements->idinstitutioncode, 'idcollectioncode'=>$recordlevelelements->idcollectioncode, 'catalognumber'=>$occurrenceelements->catalognumber, 'idscientificname'=>$taxonomicelements->idscientificname))." |"; ?>
                                <?php echo CHtml::link(CHtml::image("images/main/ic_alvo.gif", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Interaction'))),array('/interactionelements/specimenInteraction','idrecordlevelelement'=>$model->idrecordlevelelements, 'idinstitutioncode'=>$recordlevelelements->idinstitutioncode, 'idcollectioncode'=>$recordlevelelements->idcollectioncode, 'catalognumber'=>$occurrenceelements->catalognumber, 'idscientificname'=>$taxonomicelements->idscientificname))." |"; ?>
                                <?php $msg = Yii::t('yii','Are you sure to delete the');
                                $catalog = (string)$model->occurrenceelement->catalognumber;
                                echo CHtml::link(CHtml::image("images/main/canc.gif", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Delete'))), "", array('onclick'=>"deleteRecordlevelElement('$msg',$model->idrecordlevelelements,'$catalog');")); ?>
                </td>
            </tr>
        <tbody>
                    <?php endforeach; ?>
    </table>
    <div class="navbar"><?php $this->widget('CLinkPager',array('pages'=>$pages)); ?></div>
    <div class="legendbar">
                <?php //echo CHtml::image("images/main/ico_buscar.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Show')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Update')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/doc.png", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','References')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/images.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Images')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/ic_alvo.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Interaction')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/canc.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Delete')."&nbsp; | &nbsp;&nbsp;"; ?>
                <?php echo CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii','Is Private'); ?>
    </div>
            <?php// }else { ?>

    <br>
    <br>
    <center>
            	No specimens has been found.
    </center>
    <br>

            <?php //}?>
    <br/>
</div>