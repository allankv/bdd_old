<h2>highergeograph List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New highergeograph',array('create')); ?>]
[<?php echo CHtml::link('Manage highergeograph',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idhighergeograph')); ?>:
<?php echo CHtml::link($model->idhighergeograph,array('show','id'=>$model->idhighergeograph)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('highergeographid')); ?>:
<?php echo CHtml::encode($model->highergeographid); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('highergeograph')); ?>:
<?php echo CHtml::encode($model->highergeograph); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>