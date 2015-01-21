<h2>othercatalognumbers List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New othercatalognumbers',array('create')); ?>]
[<?php echo CHtml::link('Manage othercatalognumbers',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idothercatalognumbers')); ?>:
<?php echo CHtml::link($model->idothercatalognumbers,array('show','id'=>$model->idothercatalognumbers)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('othercatalognumbers')); ?>:
<?php echo CHtml::encode($model->othercatalognumbers); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>