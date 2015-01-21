<h2>taxonomicstatus List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New taxonomicstatus',array('create')); ?>]
[<?php echo CHtml::link('Manage taxonomicstatus',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idtaxonomicstatus')); ?>:
<?php echo CHtml::link($model->idtaxonomicstatus,array('show','id'=>$model->idtaxonomicstatus)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('taxonomicstatus')); ?>:
<?php echo CHtml::encode($model->taxonomicstatus); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>