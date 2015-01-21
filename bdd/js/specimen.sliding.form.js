$(function() {
	/*
	number of fieldsets
	*/
	var fieldsetCount = $('#formElem').children().length;
	
	/*
	current position of fieldset / navigation link
	*/
	var current 	= 1;
    
	/*
	sum and save the widths of each one of the fieldsets
	set the final sum as the total width of the steps element
	*/
	var stepsWidth	= 0;
    var widths 		= new Array();
    var heights 	= new Array();
	$('#steps .step').each(function(i){
        var $step 		= $(this);
		widths[i]  		= stepsWidth;
		heights[i]  	= $step.height();
        stepsWidth	 	+= $step.width();
    });
	$('#steps').width(stepsWidth);
	
	/*
	show the navigation bar
	*/
	$('#navigation').show();
	
	$('#steps .step').animate({height: 690}, 0, function() {});
	
	/*
	when clicking on a navigation link 
	the form slides to the corresponding fieldset
	*/
    $('#navigation a').bind('click',function(e){
		var $this	= $(this);
		var prev	= current;
		$this.closest('ul').find('li').removeClass('selected');
        $this.parent().addClass('selected');
		/*
		we store the position of the link
		in the current variable	
		*/
		current = $this.parent().index() + 1;
		/*
		animate / slide to the next or to the corresponding
		fieldset. The order of the links in the navigation
		is the order of the fieldsets.
		Also, after sliding, we trigger the focus on the first 
		input element of the new fieldset
		If we clicked on the last link (confirmation), then we validate
		all the fieldsets, otherwise we validate the previous one
		before the form slided
		*/
		
		// IMPORTANTE
		// Função que ajusta as alturas das DIVs de cada aba conforme o usuário navega:
		// DIV com fundo cinza e DIV com barra de rolagem (overflow)
		//
        $('#steps').stop().animate({
            marginLeft: '-' + widths[current-1] + 'px'
        },
        500,
        function() {
        	if (current == 1) { // Aba Record-level
        		$('#steps .step').animate({height: 690}, 0, function() {}); // DIV fundo cinza
        		$('.overflow').css('height', '' + 670 + 'px'); // DIV barra de rolagem
        	}
        	else if (current == 2) { // Aba Taxonomic
        		$('#steps .step').animate({height: 1300}, 0, function() {}); // DIV fundo cinza
        		$('.overflow').css('height', '' + 1200 + 'px'); // DIV barra de rolagem
        	}
        	else if (current == 3) { // Aba Location
        		$('#steps .step').animate({height: 2000}, 0, function() {}); // DIV fundo cinza
        		$('.overflow').css('height', '' + 1900 + 'px'); // DIV barra de rolagem
        	}
        	else if (current == 4) { // Aba Occurrence
        		$('#steps .step').animate({height: 750}, 0, function() {}); // DIV fundo cinza
        		$('.overflow').css('height', '' + 730 + 'px'); // DIV barra de rolagem
        	}
        	else if (current == 5) { // Aba Identification
        		$('#steps .step').animate({height: 560}, 0, function() {}); // DIV fundo cinza
        		$('.overflow').css('height', '' + 540 + 'px'); // DIV barra de rolagem
        	}
        	else if (current == 6) { // Aba Event
        		$('#steps .step').animate({height: 560}, 0, function() {}); // DIV fundo cinza
        		$('.overflow').css('height', '' + 540 + 'px'); // DIV barra de rolagem
        	}
        	else if (current == 7) { // Aba Media
        		$('#steps .step').animate({height: 700}, 0, function() {}); // DIV fundo cinza
        		$('.overflow').css('height', '' + 600 + 'px'); // DIV barra de rolagem
        	}
        	else if (current == 8) { // Aba Reference
        		$('#steps .step').animate({height: 700}, 0, function() {}); // DIV fundo cinza
        		$('.overflow').css('height', '' + 600 + 'px'); // DIV barra de rolagem
        	}
		});		
    });
});