<h2>fileformats List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New fileformats',array('create')); ?>]
[<?php echo CHtml::link('Manage fileformats',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idfileformats')); ?>:
<?php echo CHtml::link($model->idfileformats,array('show','id'=>$model->idfileformats)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('fileformat')); ?>:
<?php echo CHtml::encode($model->fileformat); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>