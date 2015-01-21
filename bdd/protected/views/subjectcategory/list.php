<h2>subjectcategory List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New subjectcategory',array('create')); ?>]
[<?php echo CHtml::link('Manage subjectcategory',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idsubjectcategory')); ?>:
<?php echo CHtml::link($model->idsubjectcategory,array('show','id'=>$model->idsubjectcategory)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('subjectcategory')); ?>:
<?php echo CHtml::encode($model->subjectcategory); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idsubjectcategoryvocabulary')); ?>:
<?php echo CHtml::encode($model->idsubjectcategoryvocabulary); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>