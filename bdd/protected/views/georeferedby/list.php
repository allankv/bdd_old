<h2>georeferedby List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New georeferedby',array('create')); ?>]
[<?php echo CHtml::link('Manage georeferedby',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idgeoreferdby')); ?>:
<?php echo CHtml::link($model->idgeoreferdby,array('show','id'=>$model->idgeoreferdby)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('georeferdedby')); ?>:
<?php echo CHtml::encode($model->georeferdedby); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>