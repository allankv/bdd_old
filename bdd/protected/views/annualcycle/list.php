<h2>annualcycle List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New annualcycle',array('create')); ?>]
[<?php echo CHtml::link('Manage annualcycle',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idannualcycle')); ?>:
<?php echo CHtml::link($model->idannualcycle,array('show','id'=>$model->idannualcycle)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('annualcycle')); ?>:
<?php echo CHtml::encode($model->annualcycle); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>