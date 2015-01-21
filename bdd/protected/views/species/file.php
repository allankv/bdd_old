<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("css/lightbox.css");
$cs->registerScriptFile("js/Maintain.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/Geo.js",CClientScript::POS_BEGIN);
?>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

<style type="text/css">
    ul li .branch {
        margin-left: -40px;
}
</style>

<script type="text/javascript">
    $(document).ready(bootSpecies);

    function bootSpecies(){
        //Hide Information Div
        $('#speciesInfo').hide();
        $('#searchBtn').button();

        //$('#speciesInfo').toggle('slow');
    }

    function searchSpecies(){
        $('#speciesName').toggle('slow');
        setTimeout(function(){
          $('#speciesInfo').toggle('slow');
        }, 400);

    var text = $('#searchText').val();

    alert(text);
    
    }
</script>


<div class="introText">
    <h1><?php echo $spm->idspecimen != null?Yii::t('yii','Update an existing specimen record'):Yii::t('yii','Create a new specimen record'); ?></h1>
    <p><?php echo Yii::t('yii',"Use this tool to save records based on modern biological specimens' information, their spatiotemporal occurrence, and their supporting evidence housed in collections (physical or digital). This set of fields is based on international standards, such as Darwin Core, Dublin Core and their extensions."); ?></p>
</div>

<div class="tablerequired" id="speciesName" style="width:250px; margin-right: auto; margin-left: auto; padding-top: 10px; padding-bottom: 10px;">
    <div class="tablelabelcel" style="width:140px; float: left; text-align: right; margin-right: 10px;">
        Scientific Name
    </div>
    <div class="tablefieldcel" style="width:100px; float: right;">
        <input type="text" size="25" id="searchText">
        <?php //echo CHtml::activeHiddenField($spm->recordlevelelement,'idinstitutioncode');?>
        <?php //echo CHtml::activeTextField($spm->recordlevelelement->institutioncode, 'institutioncode',array('class'=>'textboxtext'));?>
    </div>
    <div style="width:80px; margin-right: auto; margin-left: auto;">
        <button type="button" id="searchBtn" onclick="searchSpecies();">Search</button>
    </div>
</div>


<div id="speciesInfo">
<div class="tablerequired" style="height: 300px; width: 90%;padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px;">

<div id="top" style="width: 100%; float: left; margin-bottom: 10px;">
<div id="picture" style="width:60%; float: left;">
    <img src="http://content4.eol.org/content/2010/11/10/09/51700_large.jpg" />
</div>

<div id="classification" style="width:40%; float: right; border-color: black;">
Classification:<br />
<ul class="branch"><li>Kingdom
    <ul class="branch"><li>Phylum
        <ul class="branch"><li>Class
            <ul class="branch"><li>Order
                <ul class="branch"><li>Family
                    <ul class="branch"><li>Genus
                        <ul class="branch"><li>Subgenus
                        </li></ul>
                    </li></ul>
                </li></ul>
            </li></ul>
        </li></ul>
    </li></ul>
</li></ul>
</div>
</div>
</div>

<div id="bottom" style="width:90%; margin-left: auto; margin-right: auto; margin-bottom: 10px; margin-top: 10px;">
<div id="leftBar" style="width: 30%; float: left; border-right: solid 2px; border-right-color: black;">

<p>
    <b>Overview:</b><br />
    Brief Summary<br />
    Comprehensive Description<br />
    Distribution<br />
</p>

<p>
    <b>Physical Description:</b><br />
    Morphology<br />
    Size<br />
    Identification Resources<br />
    Diagnostic Description<br />
</p>

<p>
    <b>Ecology:</b><br />
    Habitat<br />
    Dispersal<br />
    Trophic Strategy<br />
    Associations<br />
</p>

<p>
    <b>Life History and Behavior:</b><br />
    Behavior<br />
    Life Expectancy<br />
    Reproduction<br />
    Life Cycle<br />
</p>

<p>
    <b>Conservation:</b><br />
    Conservation Status<br />
    Threats<br />
    Management<br />
</p>

<p>
    <b>Relevance to Humans and Ecosystems:</b><br />
    Benefits<br />
</p>

<p>
    <b>Names and Taxonomy:</b><br />
    Related Names<br />
    Synonyms<br />
    Common Names<br />
</p>

<p>
    <b>Occurrence</b><br />
</p>

</div>

<div id="rightSide" style="width:70%; float: left; border-color: black;">

</div>

</div>
</div>