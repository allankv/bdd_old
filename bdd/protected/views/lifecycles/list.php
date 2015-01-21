<h2>lifecycles List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New lifecycles',array('create')); ?>]
[<?php echo CHtml::link('Manage lifecycles',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idlifecycles')); ?>:
<?php echo CHtml::link($model->idlifecycles,array('show','id'=>$model->idlifecycles)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('lifecycle')); ?>:
<?php echo CHtml::encode($model->lifecycle); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>