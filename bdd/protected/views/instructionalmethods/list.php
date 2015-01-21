<h2>instructionalmethods List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New instructionalmethods',array('create')); ?>]
[<?php echo CHtml::link('Manage instructionalmethods',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idinstructionalmethods')); ?>:
<?php echo CHtml::link($model->idinstructionalmethods,array('show','id'=>$model->idinstructionalmethods)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('instrumentalmethod')); ?>:
<?php echo CHtml::encode($model->instrumentalmethod); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>