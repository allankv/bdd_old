<?php include_once("protected/extensions/config.php"); ?>
<LINK REL=StyleSheet HREF="js/tips/tip-darkgray/tip-darkgray.css" TYPE="text/css">
<script src ="js/List.js"></script>
<script type="text/javascript" src="js/lightbox/media.js"></script>
<script type="text/javascript" src="js/galleria/galleria-1.2.7.min.js"></script>
<script type="text/javascript" src="js/galleria/classic127/galleria.classic.min.js"></script>

<style>
    #galleriaList{
        height:540px;
    }
    .galleriaThumb
    {
        height: 60px;
        background: #fff;
        border: 1px solid #000;
        cursor: pointer;
    }
    a.tip-darkgray:link {text-decoration:none}
    a.tip-darkgray:visited {text-decoration:none; color:blue}
    a.tip-darkgray:hover {text-decoration:none; color:orange}
    a.tip-darkgray:active {text-decoration:none; color:orange}
    .galleria-info {
        width: 10%;
    }
</style>

<?php if ($specimenMedia->idspecimen != null) {
        $idspecimen = $specimenMedia->idspecimen;
    } else {
        $idspecimen = 0;
    } ?>

<script type="text/javascript">
    $(document).ready(bootSpecimenMedia);

    var idspm = <?php echo $idspecimen; ?>;
    var mediaFilterList = new Array();
    var mediaActionList = new Array();
    
    var tip = [];

    function bootSpecimenMedia() {        
        Galleria.loadTheme('js/galleria/classic127/galleria.classic.min.js');
        Galleria.configure({
            wait: true
        });
        
        if (idspm != 0) {
            loadImageArray();
        }

        //Load some data into mediaFilterList so it's not undefined'
        mediaFilterList[0] = 0;
    }
    
    function loadImageArray() {
        //Get the images for the specimen id from the SpecimenMedia table
        $.ajax({ type:'POST',
            url:'index.php?r=specimen/getRelatedMedia',
            data: ({'idspecimen' : idspm}),
            dataType: "json",
            success:function(json) {
                var rs = new Array();
                rs = json.result;
                
                if (rs.length == 0) {
                 	$("#galleriaDiv").hide();
	                $("#notFoundRelatedMedia").show();
                } else {
                	$("#galleriaDiv").show();
	                $("#notFoundRelatedMedia").hide();
	                for (var i in rs) {
	                    //Put them in the filter list
	                    mediaFilterList.push(rs[i].idmedia)
	                }
	                loadImages();
                }
            }
        });
    }
    
    function loadImages() {
        $.ajax({ type:'POST',
            url:'index.php?r=media/showMedia',
            data: {'mediaShowList' : mediaFilterList},
            dataType: "json",
            success:function(json) {
                var rs = new Object();

                //Empty the galleria div
                $('#galleriaList').empty();

                rs = json.result;
                for(var i in rs) {
                    insertThumb(rs[i]);
                }
                
                Galleria.run("#galleriaList");
                //loadGalleria();
            }
        });
    }
    
    function loadGalleria() {
        $('#galleriaList').galleria(
        {
            height:500, width:630
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
    
    function insertThumb(rs) {
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
        tip[rs.idmedia] = tipdiv;

        var editIcon = "<div class='btnUpdateMedia'><a href='index.php?r=media/goToMaintain&id="+rs.idmedia+"' onmouseover='javascript:configIcons()'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Media Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var relateIcon = "<div class='btnRelateMedia'><a onclick='relateMediaRecord("+rs.idmedia+")'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Relate Media Record'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
        var infoIcon = "<div id='btnInfoMedia"+rs.idmedia+"' class='btnInfoMedia'><a href='#' onmouseover='javascript:showInfoMedia("+rs.idmedia+")'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Media Informations'><span class='ui-icon ui-icon-comment'></span></li></ul></a></div>";
        
        //If there is a file, create download icon and get extension
        var extension = '';
        var downloadIcon = '';
        var image = '';
        
        if (rs.path != null && rs.name != null) {
                //Get the file's extension, take out whitespace from split()
                var extensionArray = rs.name.split(".");
                extension = extensionArray[extensionArray.length - 1];
                extension = extension.split(" ")[0];
                downloadIcon = "<div class='btnDownloadMedia'><a href='"+rs.path+"/"+rs.name+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Download Media'><span class='ui-icon ui-icon-disk'></span></li></ul></a></div>";
                //downloadIcon = '<a href=\''+rs.path+'/'+rs.name+'\' target=\'_blank\'><img src=\'images/galleria/download.jpg\' width=40px/></a>';
        }
            
        var caption = startTable+downloadIcon+infoIcon+endTable;
        //If it's an image, place image in page with the above caption
        if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {
            image = rs.path+'/'+rs.name;
        }
        //If it's PDF, use the standard PDF icon'
        else if (extension == "pdf") {
            image = 'images/galleria/pdf.jpeg';
        }
        else if (extension == 'doc' || extension == 'docx') {
            image = 'images/galleria/word.png';
        }
        else if (extension == 'xls' || extension == 'xlsx') {
            image = 'images/galleria/excel.png';
        }
        else if (extension == 'avi' || extension == 'mpg' || extension == 'mp4' || extension == 'mpeg') {
            image = 'images/galleria/movie.jpg';
        }
        else if (extension == 'mp3' || extension == 'wav') {
            image = 'images/galleria/sound.jpg';
        }
        //All others, use the "Unknown format" icon
        else {
            image = 'images/galleria/unknown.jpg';
        }

        $('#galleriaList').append('<img src=\"'+image+'" alt=\"'+caption+'\"/>');
    }
</script>

<div id ="galleriaDiv" class="overflow" style="overflow: visible; width: 630px; height: auto">
    <div id="galleriaList" style="width: 100%;"></div>
</div>

<div id="notFoundRelatedMedia">There are no related media in this record.</div>
