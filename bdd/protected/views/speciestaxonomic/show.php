<div class="subgroup" style="background-color: transparent;"><?php echo Yii::t('yii','Taxa'); ?></div>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable" style="background-color: transparent;">
    <div class="tablerow" id='divkingdom'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(KingdomAR::model(), 'kingdom');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=kingdom',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->kingdom->kingdom;?></td>
        </tr>
    </div>
    <div class="tablerow" id='divphylum'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(PhylumAR::model(), "phylum");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=phylum',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->phylum->phylum;?></td>
        </tr>
    </div>
    <div class="tablerow" id='divclass'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(ClassAR::model(), "class");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=class',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->class->class;?></td> 
        </tr>
    </div>
    <div class="tablerow" id='divorder'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(OrderAR::model(), "order");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=order',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->order->order;?></td>
        </tr>
    </div>
    <div class="tablerow" id='divfamily'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(FamilyAR::model(), "family");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=family',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->family->family;?></td>
        </tr>
    </div>
    <div class="tablerow" id='divgenus'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(GenusAR::model(), "genus");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=genus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->genus->genus;?></td>
        </tr>
    </div>
    <div class="tablerow" id='divsubgenus'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(SubgenusAR::model(), "subgenus");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subgenus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->subgenus->subgenus;?></td>
        </tr>
    </div>
    <div class="tablerow" id='divspecificepithet'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(SpecificEpithetAR::model(), "specificepithet");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=specificepithet',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->specificepithet->specificepithet;?></td>
        </tr>
    </div>
    <div class="tablerow" id='divinfraspecificepithet'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(InfraspecificEpithetAR::model(), "infraspecificepithet");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=infraspecificepithet',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $taxonomicElement->infraspecificepithet->infraspecificepithet;?></td>
        </tr>
    </div>
</table>