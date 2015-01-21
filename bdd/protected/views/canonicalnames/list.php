<h2>canonicalnames List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New canonicalnames',array('create')); ?>]
[<?php echo CHtml::link('Manage canonicalnames',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idcanonicalnames')); ?>:
<?php echo CHtml::link($model->idcanonicalnames,array('show','id'=>$model->idcanonicalnames)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idcanonicalauthorship')); ?>:
<?php echo CHtml::encode($model->idcanonicalauthorship); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('canonicalname')); ?>:
<?php echo CHtml::encode($model->canonicalname); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>