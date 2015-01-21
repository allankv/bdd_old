<h2>contributors List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New contributors',array('create')); ?>]
[<?php echo CHtml::link('Manage contributors',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idcontributors')); ?>:
<?php echo CHtml::link($model->idcontributors,array('show','id'=>$model->idcontributors)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('contributor')); ?>:
<?php echo CHtml::encode($model->contributor); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>