<h2>users List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New users',array('create')); ?>]
[<?php echo CHtml::link('Manage users',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($usersList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idUser')); ?>:
<?php echo CHtml::link($model->idUser,array('show','id'=>$model->idUser)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idGroup')); ?>:
<?php echo CHtml::encode($model->idGroup); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('username')); ?>:
<?php echo CHtml::encode($model->username); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('password')); ?>:
<?php echo CHtml::encode($model->password); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:
<?php echo CHtml::encode($model->email); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idUserAdd')); ?>:
<?php echo CHtml::encode($model->idUserAdd); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('dateValidated')); ?>:
<?php echo CHtml::encode($model->dateValidated); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>