<h2>dispersals List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New dispersals',array('create')); ?>]
[<?php echo CHtml::link('Manage dispersals',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('iddispersal')); ?>:
<?php echo CHtml::link($model->iddispersal,array('show','id'=>$model->iddispersal)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('dispersal')); ?>:
<?php echo CHtml::encode($model->dispersal); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>