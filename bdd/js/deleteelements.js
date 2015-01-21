function deleteRecordlevelElement(msg,id,number) {

    var conf = confirm(msg+' Catalog Number [ '+number+' ] !?');

    if(conf) {
        $.ajax({
               type: "POST",
               url: 'index.php?r=recordlevelelements/delete&id='+id,
               success: function(msg){
                        if($('#trrecordlevelelement_'+id).remove()){
                            alert(msg);
                        }
               }
             });
    }
}
function deleteMedia(msg,id,number) {

    var conf = confirm(msg+' Title [ '+number+' ] !?');
    
    if(conf) {
        $.ajax({
               type: "POST",
               url: 'index.php?r=media/delete&id='+id,
               success: function(msg){
                        if($('#trmedia_'+id).remove()){
                            alert(msg);
                        }
               }               

             });
    }
}
function deleteReference(msg,idreference,number) {

    var conf = confirm(msg+' Title [ '+number+' ] !?');

    if(conf) {
        $.ajax({
               type: "POST",
               url: 'index.php?r=referenceselements/delete&id='+idreference,
               success: function(msg){
                        if($('#trreference_'+idreference).remove()){
                            alert(msg);
                        }
               }

             });
    }
}
function deleteReferenceRecordlevel(msg,idreference,idrecordlevel,number) {

    var conf = confirm(msg+' Title [ '+number+' ] !?');

    if(conf) {
        $.ajax({
               type: "POST",
               url: 'index.php?r=referenceselements/delete&idreference='+idreference+'&idrecordlevel='+idrecordlevel,
               success: function(msg){
                        if($('#trreference_'+idreference).remove()){
                            alert(msg);
                        }
               }

             });
    }
}
function deleteMediaRecordlevel(msg,idmedia,idrecordlevel,number) {

    var conf = confirm(msg+' Title [ '+number+' ] !?');

    if(conf) {
        $.ajax({
               type: "POST",
               url: 'index.php?r=media/delete&idmedia='+idmedia+'&idrecordlevel='+idrecordlevel,
               success: function(msg){
                        if($('#trmedia_'+idmedia).remove()){
                            alert(msg);
                        }
               }

             });
    }
}