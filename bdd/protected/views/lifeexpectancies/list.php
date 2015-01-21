<h2>lifeexpectancies List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New lifeexpectancies',array('create')); ?>]
[<?php echo CHtml::link('Manage lifeexpectancies',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idlifeexpectancies')); ?>:
<?php echo CHtml::link($model->idlifeexpectancies,array('show','id'=>$model->idlifeexpectancies)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('lifeexpectancies')); ?>:
<?php echo CHtml::encode($model->lifeexpectancies); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>