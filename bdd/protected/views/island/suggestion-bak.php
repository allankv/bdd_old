
<script>
    $(document).ready(bootIsland);
    function bootIsland(){
        $("#select").buttonset();
    }
</script>
<div class="table" style="width: 554px; background-color: #F4F4F4; margin-top:10px; margin-bottom:10px; -moz-border-radius-topleft: 1.0em; -moz-border-radius-topright: 1.0em; -moz-border-radius-bottomleft: 1.0em; -moz-border-radius-bottomright: 1.0em; border: 1px solid #ccc;">
    <div id="select">
        <div style="width: 554px; height: 80px;">
            <div>
                <?php echo CHtml::image("images/help/iconelist.png","",array("style"=>"padding-left: 30px; padding-top: 20px ; float: left;")); ?>
                <div style="padding-left: 30px; padding-top: 20px; float: left; color: #a35353; font-size: 18px; font-family: Verdana;">
                    <?php if ($term != '') echo Yii::t('yii', "Island \"").$term."\" does not exist.";?>
                    <?php if ($term == "") echo "List of Islands found in the database:"; ?>
                </div>
            </div>
        </div>
        <div class="yiiForm" style="width: 500px">
            <table cellspacing="0" cellpadding="0" align="center" class="tablerequired">
                <tr>
                    <td class="tablelabelcel" width="200px">
                        <?php echo 'New island: '; ?>
                    </td>
                    <td class="tablefieldcel" width="200px">
                        <input id="valueTextField" type="text" style="width: 200px" value="<?php echo $term;?>">
                    </td>
                    <td class="tablefieldcel" width="100px">
                        <input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick='createSuggestion("<?php echo $_id;?>","<?php echo $_field;?>",$("#valueTextField").val(),"<?php echo $controller;?>")'/>
                    </td>
                </tr>

            </table>
        </div>
        <div style="padding-left: 30px; padding-top: 0px ; float: left; color: #535353; font-size: 16px; font-family: Verdana;">
            <?php if ($term != '') echo Yii::t('yii', "Did you mean: ");?>
        </div>
        <table style="width: 90%; padding-bottom: 10px; border-top: 5px solid #CCCCCC; border-bottom: 5px solid #CCCCCC;" align="center" cellpadding="0" cellspacing="0">
            <?php foreach($islandList as $n=>$ar): ?>
            <tr style="width:500px; height: 30px;">
                <td style="border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
                    <span style="padding-left: 10px;"><?php echo CHtml::encode($ar->island); ?></span>
                </td>
                <td style="text-align: center; border-bottom: 1px solid #CCCCCC; width: 100px;" >
                    &nbsp;&nbsp;<input type="button" value="<?php echo Yii::t('yii', "Select");?>" onclick='selectSuggestion("<?php echo $_id;?>","<?php echo $_field;?>","<?php echo $ar->idisland;?>", "<?php echo CHtml::encode($ar->island);?>" );' id="<?php echo CHtml::encode($ar->idisland); ?>" name="select" />
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>