<h2>synonymis List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New synonymis',array('create')); ?>]
[<?php echo CHtml::link('Manage synonymis',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idsynonyms')); ?>:
<?php echo CHtml::link($model->idsynonyms,array('show','id'=>$model->idsynonyms)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('synonyms')); ?>:
<?php echo CHtml::encode($model->synonyms); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>