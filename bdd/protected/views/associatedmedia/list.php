<h2>associatedmedia List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New associatedmedia',array('create')); ?>]
[<?php echo CHtml::link('Manage associatedmedia',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idassociatedmedia')); ?>:
<?php echo CHtml::link($model->idassociatedmedia,array('show','id'=>$model->idassociatedmedia)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('associatedmedia')); ?>:
<?php echo CHtml::encode($model->associatedmedia); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idrecordlevelelements')); ?>:
<?php echo CHtml::encode($model->idrecordlevelelements); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>