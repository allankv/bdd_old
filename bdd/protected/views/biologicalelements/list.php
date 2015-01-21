<h2>biologicalelements List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New biologicalelements',array('create')); ?>]
[<?php echo CHtml::link('Manage biologicalelements',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($biologicalelementsList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idbiologicalelements')); ?>:
<?php echo CHtml::link($model->idbiologicalelements,array('show','id'=>$model->idbiologicalelements)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idsex')); ?>:
<?php echo CHtml::encode($model->idsex); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idlifestage')); ?>:
<?php echo CHtml::encode($model->idlifestage); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('attribute')); ?>:
<?php echo CHtml::encode($model->attribute); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>