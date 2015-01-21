<h2>publishers List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New publishers',array('create')); ?>]
[<?php echo CHtml::link('Manage publishers',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idpublishers')); ?>:
<?php echo CHtml::link($model->idpublishers,array('show','id'=>$model->idpublishers)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('publisher')); ?>:
<?php echo CHtml::encode($model->publisher); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>