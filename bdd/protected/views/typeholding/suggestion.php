<!-- Set names -->
<?php $field = 'Types of holding'; ?>
<?php $field_plural = 'Types of holding'; ?>

<script>
    $(document).ready(bootTypeHolding)

    function bootTypeHolding() {

        <?php foreach($listName as $n=>$ar): ?>
            insertLine("<?php echo $ar->idtypeholding;?>", "<?php echo $ar->typeholding; ?>");
        <?php endforeach; ?>

        //Set create button to jQuery
        $("input:button").button();

        //Set hover effect
        configIcons();
    }

    function insertLine(id, field)
    {
        var line = "<tr id='id__ID_'><td>_FIELD_</td><td><div class='btnSelect'><a href='_URL_'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Select this entry'><span class='ui-icon ui-icon-check'></span></li></ul></a></div></td></tr>";
        line = line.replace('_ID_',id);
        line = line.replace('_FIELD_', field);
        line = line.replace('_URL_', 'javascript:selectSuggestion("<?php echo $_id;?>","<?php echo $_field;?>", "'+id+'", "'+field+'");');

        if(field.length > 0){
        	$('#lines').append(line);
        }
    }

</script>

<div style="width: 500px; margin-top: 20px; margin-bottom: 20px; padding-left: 30px; padding-top: 0px ; float: left; color: #535353; font-size: 16px; font-family: Verdana;">
    <?php if ($term != "") echo $field.' "'.$term.'" does not exist.';?>
</div>

<div class="yiiForm" style="width: 350px; float: left; margin-left: 50px; padding-left: 10px; padding-right: 10px;">
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired">
        <tr>
            <td class="tablelabelcel" width="300px" style="text-align: left; padding-left: 10px;">
                <?php echo 'New '.$field.': '; ?>
            </td>
        </tr>
        <tr>
            <td class="tablefieldcel" width="200px" style="padding-left: 10px;">
                <input id="valueTextField" type="text" style="width: 200px" value="<?php echo $term;?>">
            </td>
            <td class="tablefieldcel" width="100px" style="padding-right: 10px;">
                <input name="create" type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick='createSuggestion("<?php echo $_id;?>","<?php echo $_field;?>",$("#valueTextField").val(),"<?php echo $controller;?>")'/>
            </td>
        </tr>

    </table>
</div>

<div style="width: 500px; margin-top: 20px; margin-bottom: 10px; padding-left: 30px; padding-top: 0px ; float: left; color: #535353; font-size: 16px; font-family: Verdana;">
    <?php if ($term != "") echo Yii::t('yii', "Suggestions: ");?>
    <?php if ($term == "") echo "List of ".$field_plural." found in the database:"; ?>
</div>


<div id="rs" class="item">
    <table id="tablelist" class="list" style="width:550px; margin-left: 0px; margin-right: 0px; float: left;">
        <thead>
            <tr>
                <th style="text-align:left;">Name</th><th style="width:50px;">Select</th>
            </tr>
        </thead>
        <tbody id="lines">
        </tbody>
    </table>
</div>
