


function habilitaCampos(strCampo){
	$('#div'+strCampo+'Label').css("display","none");
	$('#div'+strCampo+'Valor').css("display","none");
	$('#div'+strCampo).css("display","block");
	$('#div'+strCampo+'Valor').text("");
}

function dasabilitaCampos(strCampo){
	$('#div'+strCampo).css("display","none");
	$('#div'+strCampo+'Label').css("display","block");
	$('#div'+strCampo+'Valor').css("display","block");
	$('#div'+strCampo+'Valor').text("");
	$('#div'+strCampo+'Valor').text($(strCampo).val());
}

function lightbox() {
  var links = $('a[rel^=lightbox]');
  var overlay = $(jQuery('<div id="overlay" style="display: none"></div>'));
  var container = $(jQuery('<div id="lightbox" style="display: none"></div>'));
  var close = $(jQuery('<a href="#close" class="close"><image style border=\'0px\' src="images/help/icone_x.png"></a>'));
  var target = $(jQuery('<div class="target" style="padding-left:14px;"></div>'));

  $('body').append(overlay).append(container);
  container.append(close).append(target);
  container.show().css({'top': Math.round((($(window).height() > window.innerHeight ? window.innerHeight : $(window).height()) - container.outerHeight()) / 2) + 'px', 'left': Math.round(($(window).width() - container.outerWidth()) / 2) + 'px', 'margin-top': 0, 'margin-left': 0}).hide();
  close.click(function(c) {
    c.preventDefault();

    overlay.add(container).fadeOut('normal');
  });


  links.each(function(index) {
    var link = $(this);

    link.click(function(c) {

      c.preventDefault();
      open(link.attr('href'));      
      links.filter('.selected').removeClass('selected');
      link.addClass('selected');
    });
    link.attr({'lb-position': index});
  });

  var open = function(url) {

    if(container.is(':visible')) {
      target.children().fadeOut('normal', function() {
        target.children().remove();
      });
    } else {
      target.children().remove();
      overlay.add(container).fadeIn('normal',function(){});
    }

    target.html("<br><br>");
    container.addClass('loading');


    target.append($.ajax({
      url: url,
	  async: false,
	  success: function() {container.removeClass('loading')}
	 }).responseText);
  }


}

function carregarPagina(urlDestino){
	$('#lightbox').addClass('loading');

	$.ajax({
		   url: urlDestino,
		   success: function(msg){
				$('div[class^=target]').html(msg);
				$('#lightbox').removeClass('loading');
			}
		 });
}

$(document).ready(function() {
	  lightbox();
	});