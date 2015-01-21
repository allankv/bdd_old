var jFilterList = new Array();

$.widget( "custom.catcomplete", $.ui.autocomplete, {
    _renderMenu: function( ul, items ) {
        var self = this,
        currentCategory = "";
        $.each( items, function( index, item ) {
            if ( item.category != currentCategory ) {
                ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                currentCategory = item.category;
            }
            self._renderItem( ul, item );
        });
    }
});
function removeItemList(controller,id){
   
	
	for(var i = 0; i < jFilterList.length; i++){
        if(controller==jFilterList[i].controller && id==jFilterList[i].id){
            jFilterList.splice(i,1);
        }
    }
    while(id.toString().match(' '))
        id = id.toString().replace(" ","_","g");

    if ($('#'+controller+'_'+id+'OR').html() != null) {
        $('#'+controller+'_'+id+'OR').remove();
    }
    else {
        $('#'+controller+'Div' + ' div.filterOR:first').remove();
    }
    $('#'+controller+'_'+id).remove();
    $('#'+controller+'_'+id).remove();
    if ($('#'+controller+'Div').html() == '') {
        if ($('#'+controller+'DivAND').html() != null) {
            $('#'+controller+'DivAND').remove();
        }
        else {
            $('#filterList' + ' div.filterAND:first').remove();
        }
        $('#'+controller+'Div').remove();
    }
}
function configCatComplete(id,field,controller,_filterList){
	
	console.log(controller+ ' '+ id);
    $(field).catcomplete({
        source: 'index.php?r='+controller+'/search',
        minLength: 2,
        select: function( event, ui ) {
            addToList(ui.item.id,ui.item.label,ui.item.controller,ui.item.category,_filterList);
            $(field).val('');
            $(id).val('');
        }
    });
}
function addToList(id,field,controller,category,_list){
    var exist = false;
    for(var i=0; jFilterList!= null && i < jFilterList.length; i++){
        if(jFilterList[i].id==id&&jFilterList[i].controller==controller){
            exist = true;
            break;
        }else{
            exist = false;
        }
    }
    if(!exist){
        var jsonItem = {
            "id":id,
            "name":field,
            "controller":controller,
            "category":category
        };
        jFilterList.push(jsonItem);
        // Constroi linha para ser inserida
        //var actionOnClick = 'onclick="removeItemList(\''+controller+'\',\''+id+'\');filter();"';
        //var image = '<a href="#" style="margin-left: 16px" '+actionOnClick+'><img src="images/main/canc.gif"/></a>';
        var image = '<a href="javascript:removeItemList(\''+controller+'\',\''+id+'\');filter();" style="margin-left: 16px">' + "<ul class='iconJQuery ui-widget ui-helper-clearfix' style='margin: 0; padding: 0;height:16px; width:24px;'><li class='ui-state-default ui-corner-all' title='Cancel' style='padding: 4px 0; cursor: pointer; float:left; list-style: none;'><span class='ui-icon ui-icon-trash' style='float: left; margin: 0 4px;'></span></li></ul>" + '</a>';
        var content = jFilterList[jFilterList.length-1].category+': '+jFilterList[jFilterList.length-1].name;
        //Remove spaces
            
        while(id.toString().match(' '))
        id = id.toString().replace(" ","_","g");

        var filterAND = '<div id="'+controller+'DivAND" class="filterAND">AND</div>';
        var filterOR = '<div class="filterOR" id="' + controller + '_' + id + 'OR">OR</div>';
        var line = '<div id="' + controller + '_' + id + '"><div class="filterContent">' + content + '</div><div class="filterImage">' + image + '</div><div style="clear:both;"></div></div>';
        if ($('#filterList').html() != '') {
            var floatDiv = filterAND + '<div id="'+controller+'Div" class="filterFloat"></div>'
        }
        else {
            var floatDiv = '<div id="'+controller+'Div" class="filterFloat"></div>';
        }
        if ($('#'+controller+'Div').length) {
            $('#'+controller+'Div').append(filterOR + line);
        }
        else {
            $(_list).append(floatDiv);
            $('#'+controller+'Div').append(line);
        }

        configIcons();
        filter();
    }
}
function deleteRecord (id, controller) {
    $.ajax({
        type:'POST',
        url:'index.php?r='+controller+'/delete',
        data: {
            "id":id
        },
        success:function(data){
            
        }
    });
}
function configIcons() {
	$(function(){
		$('ul.iconJQueryHover li').hover(
			function() { $(this).addClass('ui-state-hover'); }, 
			function() { $(this).removeClass('ui-state-hover'); }
		);
	});
}