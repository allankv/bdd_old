<!--<h2>New recordlevelelements</h2>-->

<!--
<div class="actionBar">
[<?php //echo CHtml::link('recordlevelelements List',array('list')); ?>]
[<?php //echo CHtml::link('Manage recordlevelelements',array('admin')); ?>]
</div>
-->

<?php echo $this->renderPartial('_form', array(
'recordlevelelements'=>$recordlevelelements,
'autocompletehiddenfield'=>$autocompletehiddenfield,
'curatorialelements'=>$curatorialelements,
'eventelements'=>$eventelements,
'salvo'=>$salvo,
'collectioncodes'=>$collectioncodes,
'institutioncodes'=>$institutioncodes,
'basisofrecords'=>$basisofrecords,
'catalognumbersalvo'=>$catalognumbersalvo,
'taxonomicelements'=>$taxonomicelements,
'identificationelements'=>$identificationelements,
'localityelements'=>$localityelements,
'occurrenceelements'=>$occurrenceelements,
'othercatalognumbers'=>$othercatalognumbers,
'recordedby'=>$recordedby,
'individual'=>$individual,
'associatedsequences'=>$associatedsequences,
'associatedsequencescur'=>$associatedsequencescur,
'geospatialelements'=>$geospatialelements,
'preparations'=>$preparations,
'disposition'=>$disposition,
'dispositioncur'=>$dispositioncur,
'preparationscur'=>$preparationscur,
'georeferencedby'=>$georeferencedby,
'identifiedbycur'=>$identifiedbycur,
'typestatusident'=>$typestatusident,
'georeferenceverificationstatus'=>$georeferenceverificationstatus,
'georeferencesources'=>$georeferencesources,
'georeferencesourcesgeo'=>$georeferencesourcesgeo,
'georeferenceverificationstatus'=>$georeferenceverificationstatus,
'identifiedby'=>$identifiedby,
'typestatus'=>$typestatus,
'model'=>$model,
'update'=>false,
)); ?>