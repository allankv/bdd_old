<h2>groups List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New groups',array('create')); ?>]
[<?php echo CHtml::link('Manage groups',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($groupsList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idGroup')); ?>:
<?php echo CHtml::link($model->idGroup,array('show','id'=>$model->idGroup)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('group')); ?>:
<?php echo CHtml::encode($model->group); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>