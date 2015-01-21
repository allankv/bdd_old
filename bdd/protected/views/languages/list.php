<h2>languages List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New languages',array('create')); ?>]
[<?php echo CHtml::link('Manage languages',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idlanguages')); ?>:
<?php echo CHtml::link($model->idlanguages,array('show','id'=>$model->idlanguages)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('language')); ?>:
<?php echo CHtml::encode($model->language); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>