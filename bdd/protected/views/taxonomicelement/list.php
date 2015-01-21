<h2>taxonomicelements List</h2>

<div class="actionBar">
<!-- 
[<?php //echo CHtml::link('New taxonomicelements',array('create')); ?>]
[<?php //echo CHtml::link('Manage taxonomicelements',array('admin')); ?>]
 -->
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($taxonomicelementsList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idtaxonomicelements')); ?>:
<?php echo CHtml::link($model->idtaxonomicelements,array('show','id'=>$model->idtaxonomicelements)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idscientificname')); ?>:
<?php echo CHtml::encode($model->idscientificname); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idkingdom')); ?>:
<?php echo CHtml::encode($model->idkingdom); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idphylum')); ?>:
<?php echo CHtml::encode($model->idphylum); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idclass')); ?>:
<?php echo CHtml::encode($model->idclass); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idorder')); ?>:
<?php echo CHtml::encode($model->idorder); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idfamily')); ?>:
<?php echo CHtml::encode($model->idfamily); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idgenus')); ?>:
<?php echo CHtml::encode($model->idgenus); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idspecificepithet')); ?>:
<?php echo CHtml::encode($model->idspecificepithet); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idinfraspecificepithet')); ?>:
<?php echo CHtml::encode($model->idinfraspecificepithet); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idtaxonrank')); ?>:
<?php echo CHtml::encode($model->idtaxonrank); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idscientificnameauthorship')); ?>:
<?php echo CHtml::encode($model->idscientificnameauthorship); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idnomenclaturalcode')); ?>:
<?php echo CHtml::encode($model->idnomenclaturalcode); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('highertaxon')); ?>:
<?php echo CHtml::encode($model->highertaxon); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>