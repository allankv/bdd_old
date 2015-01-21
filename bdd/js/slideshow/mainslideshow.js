$(document).ready(function() {

        slideShow();

    });

    function slideShow() {

        $('#gallery a').css({opacity: 0.0});

        $('#gallery a:first').css({opacity: 1.0});

        $('#gallery .caption').css({opacity: 0.7});

        $('#gallery .caption').css({width: $('#gallery a').find('img').css('width')});

        $('#gallery .content').html($('#gallery a:first').find('img').attr('rel'))
        .animate({opacity: 0.7}, 460);

        setInterval('gallery()',6000);

    }

    function gallery() {

        //if no IMGs have the show class, grab the first image
        var current = ($('#gallery a.show')?  $('#gallery a.show') : $('#gallery a:first'));

        //Get next image, if it reached the end of the slideshow, rotate it back to the first image
        var next = ((current.next().length) ? ((current.next().hasClass('caption'))? $('#gallery a:first') :current.next()) : $('#gallery a:first'));

        //Get next image caption
        var caption = next.find('img').attr('rel');

        //Set the fade in effect for the next image, show class has higher z-index
        next.css({opacity: 0.0})
        .addClass('show')
        .animate({opacity: 1.0}, 1000);

        //Hide the current image
        current.animate({opacity: 0.0}, 1000)
        .removeClass('show');

        //Set the opacity to 0 and height to 1px
        $('#gallery .caption').animate({opacity: 0.0}, { queue:false, duration:0 }).animate({height: '1px'}, { queue:true, duration:300 });

        //Animate the caption, opacity to 0.7 and heigth to 100px, a slide up effect
        $('#gallery .caption').animate({opacity: 0.7},100 ).animate({height: '60px'},500 );

        //Display the content
        $('#gallery .content').html(caption);

    }