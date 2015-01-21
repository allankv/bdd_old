<h2>occurrenceelements List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New occurrenceelements',array('create')); ?>]
[<?php echo CHtml::link('Manage occurrenceelements',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idoccurrenceelements')); ?>:
<?php echo CHtml::link($model->idoccurrenceelements,array('show','id'=>$model->idoccurrenceelements)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('catalognumber')); ?>:
<?php echo CHtml::encode($model->catalognumber); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('occurrencedetails')); ?>:
<?php echo CHtml::encode($model->occurrencedetails); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('occurrenceremarks')); ?>:
<?php echo CHtml::encode($model->occurrenceremarks); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('recordnumber')); ?>:
<?php echo CHtml::encode($model->recordnumber); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('individualcount')); ?>:
<?php echo CHtml::encode($model->individualcount); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('occurrencestatus')); ?>:
<?php echo CHtml::encode($model->occurrencestatus); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('iddisposition')); ?>:
<?php echo CHtml::encode($model->iddisposition); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idestablishmentmeans')); ?>:
<?php echo CHtml::encode($model->idestablishmentmeans); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idbehavior')); ?>:
<?php echo CHtml::encode($model->idbehavior); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idreproductivecondition')); ?>:
<?php echo CHtml::encode($model->idreproductivecondition); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idlifestage')); ?>:
<?php echo CHtml::encode($model->idlifestage); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idsex')); ?>:
<?php echo CHtml::encode($model->idsex); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>