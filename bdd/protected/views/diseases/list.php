<h2>diseases List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New diseases',array('create')); ?>]
[<?php echo CHtml::link('Manage diseases',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('iddiseases')); ?>:
<?php echo CHtml::link($model->iddiseases,array('show','id'=>$model->iddiseases)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('deseases')); ?>:
<?php echo CHtml::encode($model->deseases); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>