<!-- Set names -->
<?php $field = 'Biome'; ?>
<?php $field_plural = 'Biomes'; ?>

<script>
    $(document).ready(bootBiomes)

    function bootBiomes() {
        <?php foreach($listName as $n=>$ar): ?>
            insertLine("<?php echo $ar->idbiome;?>", "<?php echo $ar->biome; ?>", "<?php echo $controllerItem; ?>", "<?php echo $controllerElement; ?>");
        <?php endforeach; ?>
        //Set create button to jQuery
        $("input:button").button();
        //Set hover effect
        configIcons();
    }

    function insertLine(id, field, controllerItem, controllerElement){
        var line = "<tr id='id__ID_'><td>_FIELD_</td><td><div class='btnSelect'><a href='_URL_'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Select this entry'><span class='ui-icon ui-icon-check'></span></li></ul></a></div></td></tr>";
        line = line.replace('_ID_',id);
        line = line.replace('_FIELD_', field);
        line = line.replace('_URL_', 'javascript:selectSuggestionNN("<?php echo $_field;?>", "'+id+'", "'+field+'", "'+controllerItem+'", "'+controllerElement+'");');

        if(field.length > 0){
        	$('#lines').append(line);
        }
    }

</script>

<div style="width: 500px; margin-top: 20px; margin-bottom: 10px; padding-left: 30px; padding-top: 0px ; float: left; color: #535353; font-size: 16px; font-family: Verdana;">
    <?php echo "List of ".$field_plural." found in the database:"; ?>
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

