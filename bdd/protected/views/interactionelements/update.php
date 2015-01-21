
<?php
	if(!(isset($idrecordlevelelement))){
		echo "<div class='actionbar'>";
		echo CHtml::link(CHtml::image("images/main/ico_seta2.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii', "Go back to Interaction list"),array(
						'list&idinstitutioncode='.$_GET['idinstitutioncode'].
		                '&idcollectioncode='.$_GET['idcollectioncode'].
		                '&idbasisofrecord='.$_GET['idbasisofrecord'].
		                '&idscientificname='.$_GET['idscientificname'].
						'&idinteractiontype='.$_GET['idinteractiontype']
		                ));	
		echo "</div>";		

	}else{
	
		echo "<div class='actionbar'>";
		echo CHtml::link(CHtml::image("images/main/ico_seta2.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii', "Create new interaction"),array('interactionelements/specimenInteraction','idrecordlevelelement'=>$_GET['idrecordlevelelement'],'idinstitutioncode'=>$_GET['idinstitutioncode'], 'idcollectioncode'=>$_GET['idcollectioncode'], 'catalognumber'=>$_GET['catalognumber'], 'idscientificname'=>$_GET['idscientificname'], 'scientificnamevalue'=>$_GET['scientificnamevalue']));
		echo "</div>";	
	
	}
	
?>


<?php echo $this->renderPartial('_form', array(
	'interactionelements'=>$interactionelements,
	'recordlevelelementSpecimen1'=>$recordlevelelementSpecimen1,
	'recordlevelelementSpecimen2'=>$recordlevelelementSpecimen2,
	'idrecordlevelelement'=>$idrecordlevelelement,
	'interactionelementsList'=>$interactionelementsList,
	'interactiontypes'=>$interactiontypes,
	'recordlevelelements'=>$recordlevelelements,
	'pages'=>$pages,
	'update'=>true,
	'msgType'=>$msgType,
	'totalRegistros'=>$totalRegistros,
)); ?>