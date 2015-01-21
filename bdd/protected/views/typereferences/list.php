<h2>typereferences List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New typereferences',array('create')); ?>]
[<?php echo CHtml::link('Manage typereferences',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idtypereferences')); ?>:
<?php echo CHtml::link($model->idtypereferences,array('show','id'=>$model->idtypereferences)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('typereferences')); ?>:
<?php echo CHtml::encode($model->typereferences); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>