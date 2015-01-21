/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    function exibeDivIco(id){
        if (document.getElementById("obj"+id).style.display == 'none'){
            document.getElementById("obj"+id).style.display = 'block';
            document.getElementById("link"+id).src = "images/main/seta_baixo.gif";
        }else{
            document.getElementById("obj"+id).style.display = 'none';
            document.getElementById("link"+id).src = "images/main/seta_cima.gif";
        }
    }

    function fechaDivIco(id){
            document.getElementById("obj"+id).style.display = 'none';
            document.getElementById("link"+id).src = "images/main/seta_cima.gif";
    }

    function abreDivIco(id){
            document.getElementById("obj"+id).style.display = 'block';
            document.getElementById("link"+id).src = "images/main/seta_baixo.gif";
    }


