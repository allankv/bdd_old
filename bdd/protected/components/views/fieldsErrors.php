<?php 
	echo "<div style='width:100%;' >";
	echo "<strong>".Yii::t('yii', "Please fix the following input errors").": </strong><br><br>";

echo "<UL>";	

	foreach($msg as $mensagem):
	
	echo "<LI>";	 
		echo Yii::t('yii', $mensagem)."<br>";
	
	endforeach;
	
echo "</UL>";	

	echo "</div>";

?>
