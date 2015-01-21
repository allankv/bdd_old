<h2>licenses List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New licenses',array('create')); ?>]
[<?php echo CHtml::link('Manage licenses',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idlicenses')); ?>:
<?php echo CHtml::link($model->idlicenses,array('show','id'=>$model->idlicenses)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('licenses')); ?>:
<?php echo CHtml::encode($model->licenses); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>