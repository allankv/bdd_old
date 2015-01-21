<div class="yiiForm" style="height:200px;overflow:auto;width:415px;">
    <?php
    if (count($recordlevelelementsList)<1) {
        //;
        echo "<center>".Yii::t('yii', "No records found")."</center></div>";
        exit();
    }
    ?>
    <table width="100%" >
        <tr class="headerTabela">
            <td colspan="2">
                <?php echo Yii::t('yii', "Catalog");?>
            </td>
            <td>
                <?php echo Yii::t('yii', "Taxonomy");?>
            </td>
        </tr>
        <?php
        foreach($recordlevelelementsList as $n=>$model) {
            echo "<tr onmouseout=\"this.className='linhaSemMouse'\" onmouseover=\"this.className='linhaComMouse'\" class=\"linhaSemMouse\" >
					<td class='celulaDestacada' >";
            ?>
        <input TYPE='radio' ID='interactionelements_<?php echo $objSpecimen; ?>' NAME='interactionelements[<?php echo $objSpecimen; ?>]' VALUE=<?php echo $model->idrecordlevelelements; ?> >
            <?php
            echo "	</td>
					<td class='celulaDestacada' style='width:90px;'>";
            echo $model->occurrenceelement->catalognumber;
            echo "	</td>
                        <td>";
            echo WebbeeController::lastTaxa($model);
            //echo $model->taxonomicelement->scientificname->scientificname;
            echo "	</td>";	
        }
        ?>
    </table>
</div>