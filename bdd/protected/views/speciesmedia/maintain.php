<?php
$cs=Yii::app()->clientScript;
//$cs->registerScriptFile("js/tips/jquery.poshytip.min.js",CClientScript::POS_END);
?>

<LINK REL=StyleSheet HREF="js/tips/tip-darkgray/tip-darkgray.css" TYPE="text/css">
<script src ="js/List.js"></script>

<style>
    .galleriaThumb
    {
        height: 60px;
        background: #fff;
        border: 1px solid #000;;
        cursor: pointer;
    }
    a.tip-darkgray:link {text-decoration:none}
    a.tip-darkgray:visited {text-decoration:none; color:blue}
    a.tip-darkgray:hover {text-decoration:none; color:orange}
    a.tip-darkgray:active {text-decoration:none; color:orange}
</style>

<?php if ($speciesMedia->idspecies != null) {
        $idspecies = $speciesMedia->idspecies;
    } else {
        $idspecies = 0;
    } ?>

<script type="text/javascript">
    $(document).ready(bootSpeciesMedia);

    var idspc = <?php echo $idspecies; ?>;
    var mediaFilterList = new Array();
    var mediaActionList = new Array();

    //Thumbnail row count
    var thumbRow = 0;

    function bootSpeciesMedia()
    {        
        if (idspc != 0) {loadImageArray();}

        //Load some data into mediaFilterList so it's not undefined'
        mediaFilterList[0] = 0;

        //Create the Relate Media buttons
        //$("#createMedia").button();
        $("#relateMedia").button();
        $("#relateMedia").click(function() {
            //Destroy both dialogs
            $('#listRelatedRef').dialog('destroy');
            $('#listRelatedRef').dialog().remove();
            $('#listRelatedRef').remove();

            $('#listRelatedMedia').dialog('destroy');
            $('#listRelatedMedia').dialog().remove();
            $('#listRelatedMedia').remove();

            $('#listRelatedPub').dialog('destroy');
            $('#listRelatedPub').dialog().remove();
            $('#listRelatedPub').remove();

            $('#listRelatedPaper').dialog('destroy');
            $('#listRelatedPaper').dialog().remove();
            $('#listRelatedPaper').remove();

            $('#listRelatedKey').dialog('destroy');
            $('#listRelatedKey').dialog().remove();
            $('#listRelatedKey').remove();

            $( '<div id="listRelatedMedia"></div>').load('index.php?r=media/goToListRelated', {}).dialog({
                                modal:true,
                            title: 'Relate Media Records to Species Record',
                            show:'fade',
                            hide:'fade',
                            width: 800,
                            height:600,
                            buttons: {
                                'Close': function(){
                                    $(this).dialog('close');
                                   loadImages();
                                }}
                            });
        });
    }
    function loadImageArray()
    {
        //Get the images for the species id from the SpeciesMedia table
        $.ajax({ type:'POST',
            url:'index.php?r=species/getRelatedMedia',
            data: ({'idspecies' : idspc}),
            dataType: "json",
            success:function(json) {

                var rs = new Array();
                rs = json.result;

                for (var i in rs)
                {
                    //Put them in the filter list
                    mediaFilterList.push(rs[i].idmedia)
                }

                loadImages();
            }
        });
    }
    function loadImages()
    {
        thumbRow = 0;
        
        $.ajax({ type:'POST',
            url:'index.php?r=media/showMedia',
            data: {'mediaShowList' : mediaFilterList},
            dataType: "json",
            success:function(json) {
                var rs = new Object();

                //Empty the galleria div
                $('#galleria').empty();

                rs = json.result;

                //Start row for gallery
                $('#galleria').append('<tr>');

                for(var i in rs)
                {
                    insertThumb(rs[i]);
                }
                
                //End row for gallery
                $('#galleria').append('</tr>');

            }
        });
    }
    function insertThumb(rs)
    {
        if (thumbRow % 5 == 0)
            {
                $('#galleria').append('</tr><tr>');
            }

        var title = rs.title;
        var category = rs.categorymedia;
        var subcategory = '';
        if (rs.subcategory == null)
        {subcategory = 'None';}
        else
        {subcategory = rs.subcategorymedia;}
        var editFile = "<div style='float:right; margin-left:5px;'><a href='index.php?r=media/goToMaintain&id="+rs.idmedia+"' target='_blank' onmouseover='javascript:configIcons()'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Media Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var removeFile = "<div style='float:right; margin-left:5px;'><a href='javascript:removeMediaRelationship("+rs.idmedia+")' onmouseover='javascript:configIcons()'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Remove Media Relationship'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div>";

        var caption = editFile+removeFile+"</div><div><b>"+title+"</b><br/>Category: "+category+"<br/>Subcategory: "+subcategory+"</div>";

        //If there is a file, create download icon and get extension
        var extension = '';
        var downloadFile = '';
        var image = '';

        if (rs.path != null && rs.name != null)
            {
                //If there is a file
                //Get the file's extension, take out whitespace from split()
                var extensionArray = rs.name.split(".");
                extension = extensionArray[extensionArray.length - 1];
                extension = extension.split(" ")[0];

                //Create download icon
                downloadFile = "<div style='float:right; margin-left:5px;'><a href='"+rs.path+"/"+rs.name+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Download Media'><span class='ui-icon ui-icon-disk'></span></li></ul></a></div>";

                //Create download link on the poshy tip
                caption = downloadFile+caption;
            }

        //If it's an image, place image in page with the above caption
        if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif")
        {
            image = rs.path+'/'+rs.name;
        }

        //EVENTUALLY WILL USE THE TYPE FIELD

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

        var tdStart = '<td width=110 border=0><center>';
        var tdEnd = '</center></td>';
        var img = '<img src=\"'+image+'\" alt=\"\" class=\"galleriaThumb\" id="idmedia_'+rs.idmedia+'" title="'+caption+'"/>';
        var removeCode = '<br/><a href="javascript:removeMediaRelationship('+rs.idmedia+')">Remove Relationship</a>';

        $('#galleria').append(tdStart+img+tdEnd);
        

        $('#idmedia_'+rs.idmedia).poshytip({
                hideTimeout: 500,
                showTimeout: 500,
                alignTo: 'target',
                alignX: 'center',
                offsetX: 0,
                offsetY: 5,
                className: 'tip-twitter'
        });

        thumbRow++;
    }

    function removeMediaRelationship (idmedia)
    {
        if (confirm('Are you sure you would like to delete this relationship?'))
            {
                var idRemove = mediaFilterList.indexOf(idmedia);
                if(idRemove != -1)
                {
                    //Take the media record out of the filter list
                    mediaFilterList.splice(idRemove, 1);
                    
                    //Place the action of deleting the media record
                    var jsonItem = {
                        "id":idmedia,
                        "action":"delete"
                    };
                    mediaActionList.push(jsonItem);
                }

                else
                    alert("Error removing the media record.");

                loadImages();
            }
    }
</script>

<!-- Add images -->
<center>
<input id = "relateMedia" type="button" value="Relate to Media Records" onclick="" />

<table border=0 width=550 style='table-layout:fixed; background:transparent; cellpadding:0; cellspacing:0;'>
    <tbody id="galleria">

    </tbody>
</table>

</center>