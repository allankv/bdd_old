<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/lightbox/media.js"></script>
<script type="text/javascript" src="js/galleria/galleria.js"></script>
<script type="text/javascript" src="js/galleria/classic/galleria.classic.js"></script>
<link rel="stylesheet" type="text/css" href="js/galleria/classic/galleria.classic.css" />
<script type="text/javascript" src="js/List.js"></script>

<style type="text/css">
    #galleriaList{
        height:540px;
    }
    #slider {
    	margin: 10px;
    }
    .ui-autocomplete-category {
        color: orange;
        font-weight: bold;
        padding: .2em .4em;
        margin: .8em 0 .2em;
        line-height: 1.5;
    }
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
</style>

<script>
    $(document).ready(bootMedia);

    $('#searchField').keypress(function(event){

        if (event.keyCode == 10 || event.keyCode == 13) 
            event.preventDefault();

      });
    
    var related = <?php echo $related; ?>;
    var startMedia;
    var endMedia;
    var maxMedia;
    var intervalMedia;
    var handleSize;
    var tip = [];

    if (!related)
    {
        var mediaFilterList = new Array();        
    }

    // Inicia configuracoes Javascript
    function bootMedia() {
        Galleria.loadTheme('js/galleria/classic/galleria.classic.js');
        
        $("#printButton").button();

        //Load slider values
        startMedia = 0;
        endMedia = 10;
        intervalMedia = 5;
        handleSize = 50;

        //test
        $('#closeButton').button().click(function() {
                $('#listRelatedMedia').dialog('close');
            });

        configCatComplete('#id','#searchField', 'media','#filterList');
        filter();

        //Help message for the filter textbox help tooltip
        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below. Different terms for different categories (e.g.: Institution Code and Collection Code) will result in an AND search. Different terms for the same category, however, will result in an OR search.</div>';

        //Set the help tooltip for the Filter textbox
        $('#searchField').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'left',
            alignY: 'center',
            offsetX: 35
        });

        configIcons();

    }
    function filter(senderValue){

        //If it's BOOT or a filter, reset the offset to 0. Otherwise, leave it as is.
        if (senderValue == null)
            {startMedia = 0;}

        $.ajax({ type:'POST',
            url:'index.php?r=media/filter',
            data: {'limit':intervalMedia,'offset':startMedia,'list':jFilterList, 'mediaFilterList':mediaFilterList},
            dataType: "json",
            success:function(json) {
                var rs = new Object();

                //Get values for the slider
                maxMedia = parseInt(json.count);

                if (startMedia > maxMedia)
                    {startMedia = 0;}

                $('#startMedia').html(startMedia);

                endMedia = startMedia + intervalMedia;
                
                if (endMedia>maxMedia)
                        {endMedia = maxMedia;}

                $('#endMedia').html(endMedia);
                $('#maxMedia').html(maxMedia);

                slider();

                //Empty the galleria div
                $('#galleriaList').empty();

                rs = json.result;
                for(var i in rs) {
                    insertImage(rs[i]);
                }

                loadGalleria();
            }
        });
    }

    function loadGalleria()
    {
        $('#galleriaList').galleria(
        {
            height:540
        }
        );
    }
    function showInfoMedia(id) {
        var content = tip[id];
        $('#btnInfoMedia' + id).poshytip({
            className: 'tip-twitter',
            content: content,
            showOn: 'hover',
            alignTo: 'target',
            alignX: 'center',
            alignY: 'bottom'
        });
    }
    function insertImage (rs)
    {
        //tip = '';
        //Prints out the title, category, subcategory
        //Shows icons of delete,
        var startTable = "<div class='captionMedia'>";
        var endTable = "<div style='clear:both;'></div>";

        var title = "<div class=\'key\'>Title</div><div class=\'value\'>"+rs.title+"</div><div style=\'clear:both;\'></div>";
        var category = "<div class=\'key\'>Category</div><div class=\'value\'>"+rs.categorymedia+"</div><div style=\'clear:both;\'></div>";
        var subcategory = "<div class=\'key\'>Subcategory</div><div class=\'value\'>"+rs.subcategorymedia+"</div><div style=\'clear:both;\'></div>";
        var type = "<div class=\'key\'>Type</div><div class=\'value\'>"+rs.typemedia+"</div><div style=\'clear:both;\'></div>";
        var subtype = "<div class=\'key\'>Subtype</div><div class=\'value\'>"+rs.subtype+"</div><div style=\'clear:both;\'></div>";
        //var size = "<div class=\'key\'>Size</div><div class=\'value\'>"+rs.size/1000+" KB</div><div style=\'clear:both;\'></div>";
        var tipdiv = "<div class='infoMedia'>" + title+category+subcategory+type+subtype + "</div>";
        //var funcao = 'showInfoMedia(\'stes\');';
        tip[rs.id] = tipdiv;

        var editIcon = "<div class='btnUpdateMedia'><a href='index.php?r=media/goToMaintain&id="+rs.id+"' onmouseover='javascript:configIcons()'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Media Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var deleteIcon = "<div class='btnDeleteMedia'><a href='javascript:removeMedia("+rs.id+")' onmouseover='javascript:configIcons()'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete Media Record'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div>";
        var relateIcon = "<div class='btnRelateMedia'><a onclick='relateMediaRecord("+rs.id+")'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Relate Media Record'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
        var infoIcon = "<div id='btnInfoMedia"+rs.id+"' class='btnInfoMedia'><a href='#' onmouseover='javascript:showInfoMedia("+rs.id+")'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Media Informations'><span class='ui-icon ui-icon-comment'></span></li></ul></a></div>";
        var showIcon = "<div class='btnEditMedia'><a href='index.php?r=media/goToShow&id="+rs.id+"' onmouseover='javascript:configIcons()'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Media Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
        
        //var editIcon = '<a href=\'index.php?r=media/goToMaintain&id='+rs.id+'\'><img src=\'images/galleria/edit.jpeg\' width=40px/></a>';
        //var deleteIcon = '<a href=\'javascript:removeMedia('+rs.id+')\'><img src=\'images/galleria/delete.jpeg\' width=40px/></a>';
        //var relateIcon = '<a href=\'#\' onclick=\'javascript:relateMediaRecord('+rs.id+')\'><img src=\'images/galleria/check.jpeg\' width=40px/></a>';
        //var relateIcon = '<input type=\'button\' id=\'relateMediaCheck\' onclick=\'javascript:relateMediaRecord('+rs.id+')\' value=\'Click to Relate Media\'/>';

        //If there is a file, create download icon and get extension
        var extension = '';
        var downloadIcon = '';
        var image = '';
        
        if (rs.path != null && rs.name != null)
            {
                //Get the file's extension, take out whitespace from split()
                var extensionArray = rs.name.split(".");
                extension = extensionArray[extensionArray.length - 1];
                extension = extension.split(" ")[0];
                extension = extension.toLowerCase(); 
                downloadIcon = "<div class='btnDownloadMedia'><a href='"+rs.path+"/"+rs.name+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Download Media'><span class='ui-icon ui-icon-disk'></span></li></ul></a></div>";
                //downloadIcon = '<a href=\''+rs.path+'/'+rs.name+'\' target=\'_blank\'><img src=\'images/galleria/download.jpg\' width=40px/></a>';
            }

        //If it's a related media listing, show only the relate icon
        //else, show the edit, download (if applicable) and delete icons'
        if (related)
            {
                //for (var i in mediaFilterList)
                //    if (rs.id == mediaFilterList[i])
                //        $('#relateMediaButton').replaceWith('<input type=\'checkbox\' id=\'relateMediaButton\'><label for=\'relateMedia\'>Click to Unrelate Media</label>');
                //var caption = startTable+relateIcon+title+category+subcategory+type+subtype+size+endTable;
                var caption = startTable+relateIcon+endTable;
            }
        else
            {
                //var caption = startTable+editIcon+downloadIcon+deleteIcon+title+category+subcategory+type+subtype+size+endTable;
                var caption = startTable+showIcon+editIcon+downloadIcon+deleteIcon+infoIcon+endTable;
            }
            
        //If it's an image, place image in page with the above caption
        if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif")
        {
            image = rs.path+'/'+rs.name;
        }

        //If it's PDF, use the standard PDF icon'
        else if (extension == "pdf")
        {
            image = 'images/galleria/pdf.jpeg';
        }

        else if (extension == 'doc' || extension == 'docx')
        {
            image = 'images/galleria/word.png';
        }

        else if (extension == 'xls' || extension == 'xlsx')
        {
            image = 'images/galleria/excel.png';
        }

        else if (extension == 'avi' || extension == 'mpg' || extension == 'mp4' || extension == 'mpeg')
        {
            image = 'images/galleria/movie.jpg';
        }

        else if (extension == 'mp3' || extension == 'wav')
        {
            image = 'images/galleria/sound.jpg';
        }

        //All others, use the "Unknown format" icon
        else
        {
            image = 'images/galleria/unknown.jpg';
        }

        $('#galleriaList').append('<img src=\"'+image+'" alt=\"'+caption+'\"/>');
        //$('#galleriaList').append('<img src=\"'+image+'"/>');
        
    }
    function removeMedia (idmedia)
    {
        if (confirm('Are you sure you would like to permanently delete this media record?'))
            {
                //Delete record
                deleteRecord(idmedia,'media');

                //Reload Galleria - empty the div and reload it
                $('#galleriaList').empty();
                filter('remove');
        }
    }
    function relateMediaRecord(idmedia)
    {
        //Push onto the filter list
        mediaFilterList.push(idmedia);
        
        //Push onto the action list
        var jsonItem =
            {
                "id":idmedia,
                "action":"save"
            };
        mediaActionList.push(jsonItem);

        filter('relate');
        configIcons();
    }
    function slider(){
        
        $("#slider").slider({
            range: false,
            min:0,
            max:maxMedia - intervalMedia,
            value:startMedia,
            stop: function(event, ui) {
                startMedia = ui.value;
                endMedia = startMedia + intervalMedia;
                filter('slider');
            },



            slide:function(event, ui) {
                $('#startMedia').html(ui.value);
                $('#endMedia').html((ui.value + intervalMedia));
            }
        }).find( ".ui-slider-handle" ).css({
				width: handleSize
			});

    }
    function print() {
	    var windowReference = window.open('index.php?r=loadingfile/goToShow');	    
	    $.ajax({
        	type:'POST',
            url:'index.php?r=media/printList',
            data: {
            	'list':jFilterList,
            	'mediaFilterList':mediaFilterList
            },
            dataType: "json",
            success:function(json) {
	            windowReference.location = json;
            }
        });
    }

</script>

<div class="introText">
<div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
<h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'List media records'); ?></h1>
<div style="clear:both;"></div>
<p><?php echo Yii::t('yii', 'Use this tool to search through all media records in the BDD database and view, edit or delete any of them. You may also specify filters to narrow the list of media shown.'); ?></p>
</div>

<?php echo CHtml::beginForm(); ?>
<div class="filter">
    <div class="filterLabel"><?php echo 'Filter';?></div>
    <div class="filterMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=filter',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></div>
    <div class="filterInterval">
    Filtered from <b><span id="startMedia"></span></b> to <b><span id="endMedia"></span></b> of <b><span id="maxMedia"></span></b>
    </div>
    <div style="clear:both"></div>

    <div class="filterField">
    <input type="text" id="searchField" style="border: 1px solid #DDDDDD;background: #FFFFFF;color: #013605;font-size: 1.3em;" />
    <input type="hidden" id="id"/>
    </div>
    <div class="slider" id="slider"></div>
    <div style="clear:both"></div>
    <input id="printButton" type="button" style="float: right;" value="Print" onclick="print()">
    <div style="clear:both"></div>
    <div class="filterList">
    <div id="filterList"></div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>

<div id="galleriaList"></div>
<div id="relateMedia" align="right"></div>