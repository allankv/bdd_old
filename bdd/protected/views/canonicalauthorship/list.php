<h2>canonicalauthorship List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New canonicalauthorship',array('create')); ?>]
[<?php echo CHtml::link('Manage canonicalauthorship',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idcanonicalauthorship')); ?>:
<?php echo CHtml::link($model->idcanonicalauthorship,array('show','id'=>$model->idcanonicalauthorship)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('canonicalauthorship')); ?>:
<?php echo CHtml::encode($model->canonicalauthorship); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>