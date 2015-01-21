<h2>reproductions List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New reproductions',array('create')); ?>]
[<?php echo CHtml::link('Manage reproductions',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idreproduction')); ?>:
<?php echo CHtml::link($model->idreproduction,array('show','id'=>$model->idreproduction)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('reproductions')); ?>:
<?php echo CHtml::encode($model->reproductions); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>