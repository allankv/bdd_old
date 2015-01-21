<h2>New occurrenceelements</h2>

<div class="actionBar">
[<?php echo CHtml::link('occurrenceelements List',array('list')); ?>]
[<?php echo CHtml::link('Manage occurrenceelements',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
        'occurrenceelements'=>$occurrenceelements,
        'preparations'=>$preparations,
        'othercatalognumbers'=>$othercatalognumbers,
        'recordedby'=>$recordedby,
        'individual'=>$individual,
        'associatedsequences'=>$associatedsequences,
	'model'=>$model,
	'update'=>false,
)); ?>