var opened = false;
var dialog = false;
var focus = false;
var listNN = new Array();

function showMessage(msg, success, permanent)
{
    var message = "<br>";
    for (var i in msg) {
        message += "<li style='margin-left:40px;'>" + msg[i] + "</li>";
    }
    message += "<br>";
    if (success) {
        $('#Notification').jnotifyAddMessage({
            text: message,
            permanent: permanent,
            disappearTime: 5000
        });
    }
    else {
        $('#Notification').jnotifyAddMessage({
            text: message,
            permanent: permanent,
            disappearTime: 5000,
            type: 'error'
        });
    }
}

function configNotify()
{
    $('#Notification').jnotifyInizialize({
        oneAtTime: false,
        appendType: 'append'
    })
    .css({
        'position': 'fixed',
        'marginTop': '-130px',
        'right': '10px',
        'width': '400px',
        'z-index': '9999'
    });
}

//Show suggest dialog without suggestion term
function suggest(_id, _field, _controller)
{
   // if($.trim($(_field).val())==''){
        //Kill previous dialogs
        $('#dialog').dialog('destroy');
        $('#dialog').dialog().remove();
        $('#dialog').remove();
        //Call showDialogs with blank == true
        showDialogs(_id, _field, _controller, true);
   // }
}
function suggestNN(_field, _controllerItem, _controllerElement)
{
    //if($.trim($(_field).val())==''){
        //Kill previous dialogs
        $('#dialog').dialog('destroy');
        $('#dialog').dialog().remove();
        $('#dialog').remove();
        //Call showDialogs with blank == true
        showDialogsNN(_field, $.trim($(_field).val()), _controllerItem, _controllerElement);
    //}
}



function configIcons() {
    $(function(){
        $('ul.iconJQueryHover li').hover(
            function() {
                $(this).addClass('ui-state-hover');
            },
            function() {
                $(this).removeClass('ui-state-hover');
            }
            );
    });
}
function fillFields(_id,_field,controller){
    if($.trim($(_field).val())!='' && $(_id).val()==''){
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: 'index.php?r='+controller+'/getJSON',
            data: {
                "field": $(_field).val()
            },
            success: function(json){
                if(json.success){
                    $(_id).val(json.id);
                    $(_field).val(json.field);
                }else{
                    $('#dialog').dialog('destroy');
                    $('#dialog').dialog().remove();
                    $('#dialog').remove();
                    $('#insertMsg').dialog('destroy');
                    $('#insertMsg').dialog().remove();
                    $('#insertMsg').remove();
                    if($('#dialog').html()==null&&$('#insertMsg').html()==null){
                        var t=setTimeout("showDialogs('"+_id+"','"+_field+"','"+controller+"')",400);
                    }
                }
            }
        });
    }
}
function configAutocomplete(_id,_field,controller){
    $(_field).blur(
        function(){
            if(!opened){
                if($(_id).val()=='')
                    fillFields(_id,_field,controller);
            }
            focus = false;
        });
    $(_field).focus(function(){
        focus = true;
        $(_id).val('');
    });
    $(_field).autocomplete({
        source: 'index.php?r='+controller+'/search',
        minLength: 2,
        select: function( event, ui ) {
            $(_id).val(ui.item.id);
            $(_field).val(ui.item.value);
        },
        close: function( event, ui ) {
            opened = false;
            if(!focus)
                fillFields(_id,_field,controller);
        },
        open: function( event, ui ) {
            opened = true;
        }
    });
}
// Mesmo que configAutocomplete, muda somente *select* e *fillFieldsForNN*
function configAutocompleteForNN(id,field,controller,jList,_list,target){
    $(field).blur(
        function(){
            if(!opened){
                if($(id).val()=='')
                    fillFieldsForNN(id,field,controller,jList,_list,target);
            }
            focus =false;
        });
    $(field).focus(function(){
        focus = true;
        $(id).val('');
    });
    $(field).autocomplete({
        source: 'index.php?r='+controller+'/search',
        minLength: 2,
        select: function( event, ui ) {
            $(id).val(ui.item.id);
            $(field).val(ui.item.value);            
            addToListNN(id,field,controller,jList,_list,target);                        
        },
        close: function( event, ui ) {
            opened = false;
            if(!focus){   
                if($(id).val()!='')
                    fillFieldsForNN(id,field,controller,jList,_list,target);
            }
        },
        open: function( event, ui ) {
            opened = true;
        }
    });
}
function fillFieldsForNN(_id,_field,_controller,jList,_list,target){
    if($.trim($(_field).val())!='' && $(_id).val()==''){
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: 'index.php?r='+_controller+'/getJSON',
            data: {
                "field": $(_field).val()
            },
            success: function(json){
                if(json.success){
                    $(_id).val(json.id);
                    $(_field).val(json.field);
                    addToListNN(_id,_field,_controller,jList,_list,target);
                }else{
                    $('#dialog').dialog('destroy');
                    $('#dialog').dialog().remove();
                    $('#dialog').remove();
                    $('#insertMsg').dialog('destroy');
                    $('#insertMsg').dialog().remove();
                    $('#insertMsg').remove();
                    if($('#dialog').html()==null&&$('#insertMsg').html()==null){
                        var t=setTimeout("showDialogs('"+_id+"','"+_field+"','"+_controller+"')",400);
                    }
                }
            }
        });
    }
}

function addToListNN(id,controllerItem,controllerElement,action){
    if(id!=''){
        var jsonItem = {
            "id":id,
            "action":action,
            "name":"",
            "controllerItem":controllerItem,
            "controllerElement":controllerElement
        };
        listNN.push(jsonItem);
    }
}

function persistNN(idItem, idElement, controllerItem, controllerElement, action){
    $.ajax({
        type:'POST',
        url:'index.php?r='+controllerItem+'/save'+controllerElement+"NN",
        data: {
            "idItem":idItem,
            "idElement":idElement,
            "action":action
        }
    });
}
function configAutocompleteNN(_idElement, _field, controllerItem, controllerElement){
    $(_field).fcbkcomplete({
        json_url: ("index.php?r="+controllerItem+"/search"),
        width: 192,
        addontab: true,
        height: 15,
        cache: false,
        firstselected : true,
        filter_selected:true,
        complete_text:"",
        onselect: function(item){
            
            var term = $("#"+item._id.substr(1, item._id.toString().length)).html();
            term = $.trim(term.substr(0, term.toString().length-41));
            if (item._value == ""){
                showDialogsNN(_field, term, controllerItem, controllerElement);
            }
            else{
                addToListNN(item._value,controllerItem,controllerElement,"save");
            }
        },
        onremove: function(item){
            addToListNN(item._value,controllerItem,controllerElement,"delete");            
        }
    });
    loadNN(_idElement, _field, controllerItem, controllerElement);
}

function loadNN(_idElement,_field, controllerItem, controllerElement){
    if($(_idElement).val()!=null && $(_idElement).val()!=''){

        $.ajax({
            type: 'POST',
            dataType: "json",         
            url: 'index.php?r='+controllerItem+'/getNNBy'+controllerElement,
            data: {
                "idTarget": $(_idElement).val()
            },
            success: function(json){
                for(var i = 0; i < json.length; i++){
                    var jsonItem = {
                        "id":json[i].id,
                        "name":json[i].name,
                        "action":"noaction",
                        "controllerItem":controllerItem,
                        "controllerElement":controllerElement
                    };
                    listNN.push(jsonItem);
                    $(_field).trigger("addItem",[{
                        "title": json[i].name,
                        "value": json[i].id
                    }]);
                }
            }
        });
   }
}
function showDialogs(_id, _field, controller){

    if(!dialog){
        dialog = true;

        //If the term is supposed to be blank, term = "", else use the term
        var term = $(_field).val();

        //If the term is blank, use "List of Records"
        //Else, "Record not found"
        var title = "Record not found.";


        if (!blank)
            var blank = false;
        else
        {
            term = "";
            title = "List of Records";
        }
        $('#dialog').dialog('destroy');
        $('#dialog').dialog().remove();
        // DIALOG SUGGESTION
        $('<div id="dialog"/>').load('index.php?r='+controller+'/suggestion', {
            "term":term,
            "_field": _field,
            "_id": _id,
            "controller": controller
        }).dialog({
            modal:true,
            title: title,
            show:'puff',
            hide:'puff',
            width: 600,
            height:600,
            buttons: {
                'Cancel': function(){
                    //$(_id).val('');
                    $(_field).val('');
                    $(this).dialog('close');

                }
            },
            open: function(){
                $(".ui-dialog-titlebar-close").hide();
                dialog=true;
            },
            close: function(){
                opened = false;
                dialog = false;                
            //opened = false;//dialog = false;//$('.ui-effects-wrapper').remove();//$('#insertMsg').remove();//$('#errorMsg').remove();//$('#msg_d').remove();//$('#dialog').remove();
            }
        });
    }
}
function showDialogsNN(_field, term, controllerItem,controllerElement){
    if(!dialog){
        dialog = true;

        //Else, "Record not found"
        var title = "Record not found.";
        /*if (!blank)
            var blank = false;
        else{
            _term = "";
            _title = "List of Records";
        }*/
        $('#dialog').dialog('destroy');
        $('#dialog').dialog().remove();
        // DIALOG SUGGESTION
        $('<div id="dialog"/>').load('index.php?r='+controllerItem+'/suggestionNN', {
            "term":term,
            "_field": _field,
            "controllerItem": controllerItem,
            "controllerElement": controllerElement
        }).dialog({
            modal:true,
            title: title,
            show:'puff',
            hide:'puff',
            width: 600,
            height:600,
            buttons: {
                'Cancel': function(){
                    $(this).dialog('close');
                }
            },
            open: function(){
                $(".ui-dialog-titlebar-close").hide();
                dialog=true;
            },
            close: function(){
                opened = false;
                dialog = false;
                $(_field).trigger("removeItem",[{
                    "value": ""
                }]);
            }
        });
    }
}
function selectSuggestion(_id, _field, id, field) {
    $(_id).val(id);
    $(_field).val(field);
    $('#dialog').dialog('close');        
}
function selectSuggestionNN(_field, id, field, controllerItem, controllerElement) {
    $('#dialog').dialog('close');
    addToListNN(id, controllerItem, controllerElement, "save");
    $(_field).trigger("addItem",[{
        "title": field,
        "value": id
    }]);
}
function createSuggestion(_id, _field, value, controller) {
	if (clickedParseBibliographic) {
		clickedCreate = true;
		clickedNo = false;	
	}
    $('#insertMsg').dialog('destroy');
    $('#insertMsg').dialog().remove();
    $('#insertMsg').remove();
    $('#dialog').dialog('close');
    if($('#insertMsg').html()==null){
        var msg = '<p>Are you sure that you want to insert a <b>NEW</b> record?</p>';
        // DIALOG INSERT NEW RECORD
        $('<div id="insertMsg" title="Insert a new record: '+value+'">'+msg+'</div>').dialog({
            show: "slide",
            hide: "slide",
            buttons: {
                Yes: function() {
                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        url: 'index.php?r='+controller+'/save',
                        data: {
                            "field": value
                        },
                        success: function(json){
                            if(json.success){
                                $(_id).val(json.id);
                                $(_field).val(json.field);
                                opened = false;
                                dialog = false;

                                $('#insertMsg').dialog( "close" );
                                $(_field).focus();
                            //$('#insertMsg').dialog('destroy');//$('#insertMsg').dialog().remove();//$('#insertMsg').remove();//$('.ui-effects-wrapper').remove();
                            }else{
                                $('#errorMsg').dialog('destroy');
                                $('#errorMsg').dialog().remove();
                                $('#errorMsg').remove();
                                $('#insertMsg').dialog( "close" );
                                // DIALOG ERROR
                                $('<div id="errorMsg" title="Some error was occurred">'+json.msg+'</div>').dialog({
                                    show: "slide",
                                    hide: "slide",
                                    buttons: {
                                        Ok: function() {
                                            opened = false;
                                            dialog = false;
                                            $('#errorMsg').dialog( "close" );
                                        //$('#errorMsg').dialog('destroy');
                                        //$('#errorMsg').dialog().remove();
                                        //$('#errorMsg').remove();
                                        }
                                    },
                                    close: function(){
                                        opened = false;
                                        dialog = false;
                                    }
                                });
                            }
                        }
                    });
                },
                No: function() {
                    $('#dialog').dialog('destroy');
                    $('#dialog').dialog().remove();
                    $('#dialog').remove();
                    $('#insertMsg').dialog( "close" );
                    if (creatorListParse.length > 0) {
                   		clickedNo = true;
                    	showDialogsParse(_id, _field, controller);
                    } else {
                    	showDialogs(_id, _field, controller);
                    }
                }
            },
            close: function(){
                opened = false;
                dialog = false;
                clickedCreate = false;
                verifyCreatorListParse();
            }
        });
    }
}
function createSuggestionNN(_field, value, controllerItem, controllerElement) {
	if (clickedParseBibliographic) {
		clickedCreate = true;
		clickedNo = false;	
	}
    $('#insertMsg').dialog('destroy');
    $('#insertMsg').dialog().remove();
    $('#insertMsg').remove();
    $('#dialog').dialog('close');
    if($('#insertMsg').html()==null){
        var msg = '<p>Are you sure that you want to insert a <b>NEW</b> record?</p>';
        // DIALOG INSERT NEW RECORD
        $('<div id="insertMsg" title="Insert a new record: '+value+'">'+msg+'</div>').dialog({
            show: "slide",
            hide: "slide",
            buttons: {
                Yes: function() {
                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        url: 'index.php?r='+controllerItem+'/save',
                        data: {
                            "field": value
                        },
                        success: function(json){
                            if(json.success){
                                opened = false;
                                dialog = false;
                                addToListNN(json.id, controllerItem, controllerElement, "save");
                                $(_field).trigger("addItem",[{
                                    "title": value,
                                    "value": json.id
                                }]);

                                $('#insertMsg').dialog( "close" );
                            }else{
                                $('#errorMsg').dialog('destroy');
                                $('#errorMsg').dialog().remove();
                                $('#errorMsg').remove();
                                $('#insertMsg').dialog( "close" );                                
                                // DIALOG ERROR
                                $('<div id="errorMsg" title="Some error was occurred">'+json.msg+'</div>').dialog({
                                    show: "slide",
                                    hide: "slide",
                                    buttons: {
                                        Ok: function() {
                                            opened = false;
                                            dialog = false;
                                            $('#errorMsg').dialog( "close" );
                                        }
                                    },
                                    close: function(){
                                        opened = false;
                                        dialog = false;
                                    }
                                });
                            }
                        }
                    });
                },
                No: function() {                    
                    $('#dialog').dialog('destroy');
                    $('#dialog').dialog().remove();
                    $('#dialog').remove();
                    $('#insertMsg').dialog( "close" );
                    if (clickedParseBibliographic) {
	                    clickedNo = true;
                    	showDialogsNNParse(_field, value, controllerItem, controllerElement);
                    } else {
                    	showDialogsNN(_field, value, controllerItem, controllerElement);
                    }
                }
            },
            close: function(){
                opened = false;
                dialog = false;
                clickedCreate = false;
                verifyCreatorListParse();
            }
        });
    }
}

function saveNN (idItem){
    if(listNN.length > 0){
        for (var i=0; i < listNN.length; i++) {
            if(listNN[i].action != "noaction"){
                var action = true;
                for (var j=i; j < listNN.length; j++) {
                    if(listNN[i].id == listNN[j].id && i != j && listNN[i].controllerItem == listNN[j].controllerItem){
                        action = false;
                        break;
                    }
                }
                if(action)
                    persistNN(listNN[i].id, idItem, listNN[i].controllerItem, listNN[i].controllerElement, listNN[i].action);
            }
        }
    }
}
function saveSpecimenNN (idRecordLevel, idLocality, idOccurrence, idIdentification){
    if(listNN.length > 0){
        for (var i=0; i < listNN.length; i++) {
            if(listNN[i].action!="noaction"){
                var action = true;
                    for (var j=i; j < listNN.length; j++) {
                        if(listNN[i].id == listNN[j].id && i != j){
                            action = false;
                            break;
                        }
                    }
                    if(action){
                        switch(listNN[i].controllerElement){
                            case "RecordLevelElement":
                                persistNN(listNN[i].id, idRecordLevel, listNN[i].controllerItem, listNN[i].controllerElement,listNN[i].action);
                                break;
                            case "OccurrenceElement":
                                persistNN(listNN[i].id, idOccurrence, listNN[i].controllerItem, listNN[i].controllerElement,listNN[i].action);
                                break;
                            case "LocalityElement":
                                persistNN(listNN[i].id, idLocality, listNN[i].controllerItem, listNN[i].controllerElement,listNN[i].action);
                                break;                 
                            case "IdentificationElement":
                                persistNN(listNN[i].id, idIdentification, listNN[i].controllerItem, listNN[i].controllerElement,listNN[i].action);
                                break;
                        }
                    }
            }
        }
    }
}
function saveRelatedNN (id, controllerElement, controllerItem, listNN){
    if(listNN.length > 0){
        for (var i=0; i < listNN.length; i++) {
            if(listNN[i].action!="noaction"){
                var action = true;
                    for (var j=i; j < listNN.length; j++) {
                        if(listNN[i].id == listNN[j].id && i != j){
                            action = false;
                            break;
                        }
                    }
                    if(action){
                        persistNN(listNN[i].id, id, controllerItem, controllerElement, listNN[i].action);

                    }
            }
        }
    }
}
String.prototype.wordWrap = function( tam, div, c){
	var i, j, l, s, r;
	if(tam < 1)
		return this;
	for(i = -1, l = (r = this.split("\n")).length; ++i < l; r[i] += s)
		for(s = r[i], r[i] = ""; s.length > tam; r[i] += s.slice(0, j) + ((s = s.slice(j)).length ? div : ""))
			j = c == 2 || (j = s.slice(0, tam + 1).match(/\S*(\s)?$/))[1] ? tam : j.input.length - j[0].length
			|| c == 1 && tam || j.input.length + (j = s.slice(tam).match(/^\S*/)).input.length;
	return r.join("\n");
};

// usado para dar o parse do bibliographic citation
var creatorListParse = new Array(); // lista de autores do campo bibliographic citation
var clickedCreate = false; // flag para saber se foi clicado no botao Create, na tela de suggestions
var clickedNo = false; // flag para saber se foi clicado no botao No, na tela de confirmação do Create
var clickedParseBibliographic = false; // flag para saber se se trata do caso em que foi clicado o botao de Parse Bibliographic Citation, dado que o funcionamento da ferramenta muda um pouco
function showDialogsParse(_id, _field, controller){

    if(!dialog){
        dialog = true;

        //If the term is supposed to be blank, term = "", else use the term
        var term = $(_field).val();

        //If the term is blank, use "List of Records"
        //Else, "Record not found"
        var title = "Record not found.";


        if (!blank)
            var blank = false;
        else
        {
            term = "";
            title = "List of Records";
        }
        $('#dialog').dialog('destroy');
        $('#dialog').dialog().remove();
        // DIALOG SUGGESTION
        $('<div id="dialog"/>').load('index.php?r='+controller+'/suggestion', {
            "term":term,
            "_field": _field,
            "_id": _id,
            "controller": controller
        }).dialog({
            modal:true,
            title: title,
            show:'puff',
            hide:'puff',
            width: 600,
            height:600,
            buttons: {
                'Cancel': function(){
                    //$(_id).val('');
                    $(_field).val('');
                    $(this).dialog('close');

                }
            },
            open: function(){
                $(".ui-dialog-titlebar-close").hide();
                dialog=true;
            },
            close: function(){
                opened = false;
                dialog = false;
                //alert('fechei: ' + _field);
                verifyCreatorListParse();
            //opened = false;//dialog = false;//$('.ui-effects-wrapper').remove();//$('#insertMsg').remove();//$('#errorMsg').remove();//$('#msg_d').remove();//$('#dialog').remove();
            }
        });
    }
    // se encontrar o campo já existente, esconder opções de criar novo registro
    $.ajax({ type:'GET',
	    url:'index.php?r='+controller+'/searchEqual',
	    data: {
	    	"term": $(_field).val()
	    },
	    dataType: "json",
	    success:function(json) {
	    	if (json.length != 0) {
		    	$('#msgDoesNotExist').hide();
		    	$('#newRecordBox').hide();
		    	$('#msgConfirm').show();
	    	}   
	    }
	});
}
function showDialogsNNParse(_field, term, controllerItem,controllerElement){
    if(!dialog){
        dialog = true;

        //Else, "Record not found"
        var title = "Record not found.";
        /*if (!blank)
            var blank = false;
        else{
            _term = "";
            _title = "List of Records";
        }*/
        $('#dialog').dialog('destroy');
        $('#dialog').dialog().remove();
        // DIALOG SUGGESTION
        $('<div id="dialog"/>').load('index.php?r='+controllerItem+'/suggestionNN', {
            "term":term,
            "_field": _field,
            "controllerItem": controllerItem,
            "controllerElement": controllerElement
        }).dialog({
            modal:true,
            title: title,
            show:'puff',
            hide:'puff',
            width: 600,
            height:600,
            buttons: {
                'Cancel': function(){
                    $(this).dialog('close');
                }
            },
            open: function(){
                $(".ui-dialog-titlebar-close").hide();
                dialog=true;
            },
            close: function(){
                opened = false;
                dialog = false;
                $(_field).trigger("removeItem",[{
                    "value": ""
                }]);
                verifyCreatorListParse();
            }
        });
    }
    // se encontrar o campo já existente, esconder opções de criar novo registro
    $.ajax({ type:'GET',
	    url:'index.php?r='+controllerItem+'/searchEqual',
	    data: {
	    	"term": term
	    },
	    dataType: "json",
	    success:function(json) {
	    	if (json.length != 0) {
		    	$('#msgDoesNotExist').hide();
		    	$('#newRecordBox').hide();
		    	$('#msgConfirm').show();
	    	}   
	    }
	});
}
function verifyCreatorListParse() {
	if (creatorListParse.length > 0 && clickedCreate == false && clickedNo == false) {
		showDialogsNNParse("#CreatorAR_creator", creatorListParse.pop(), "creator", "reference");
	}
}