<script src="js/jreject/jquery.reject.js"></script>
<script type="text/javascript">
	$(function() {	
	  //remove js-disabled class
		$("#viewer").removeClass("js-disabled");
	
	  //create new container for images
		$("<div>").attr("id", "container").css({ position:"absolute"}).width($(".wrapper").length * 170).height(170).appendTo("div#viewer");
	  	
		//add images to container
		$(".wrapper").each(function() {
			$(this).appendTo("div#container");
		});
		
		//work out duration of anim based on number of images (1 second for each image)
		var duration = $(".wrapper").length * 1500;
		
		//store speed for later (distance / time)
		var speed = (parseInt($("div#container").width()) + parseInt($("div#viewer").width())) / duration;
						
		//set direction
		var direction = "rtl";
		
		//set initial position and class based on direction
		(direction == "rtl") ? $("div#container").css("left", $("div#viewer").width()).addClass("rtl") : $("div#container").css("left", 0 - $("div#container").width()).addClass("ltr") ;
		
		//animator function
		var animator = function(el, time, dir) {
		 
			//which direction to scroll
			if(dir == "rtl") {
			  
			  //add direction class
				el.removeClass("ltr").addClass("rtl");
			 		
				//animate the el
				el.animate({ left:"-" + el.width() + "px" }, time, "linear", function() {
										
					//reset container position
					$(this).css({ left:$("div#imageScroller").width(), right:"" });
					
					//restart animation
					animator($(this), duration, "rtl");
					
					//hide controls if visible
					($("div#controls").length > 0) ? $("div#controls").slideUp("slow").remove() : null ;			
									
				});
			} else {
			
			  //add direction class
				el.removeClass("rtl").addClass("ltr");
			
				//animate the el
				el.animate({ left:$("div#viewer").width() + "px" }, time, "linear", function() {
										
					//reset container position
					$(this).css({ left:0 - $("div#container").width() });
					
					//restart animation
					animator($(this), duration, "ltr");
					
					//hide controls if visible
					($("div#controls").length > 0) ? $("div#controls").slideUp("slow").remove() : null ;			
				});
			}
		}
		
		//start anim
		animator($("div#container"), duration, direction);
		
		//pause on mouseover
		$("a.wrapper").live("mouseover", function() {
		  
			//stop anim
			$("div#container").stop(true);
			
			//show controls
			($("div#controls").length == 0) ? $("<div>").attr("id", "controls").appendTo("div#outerContainer").css({ opacity:0.7 }).slideDown("slow") : null ;
			($("a#rtl").length == 0) ? $("<a>").attr({ id:"rtl", href:"#", title:"rtl" }).appendTo("#controls") : null ;
			($("a#ltr").length == 0) ? $("<a>").attr({ id:"ltr", href:"#", title:"ltr" }).appendTo("#controls") : null ;
			
			//variable to hold trigger element
			var title = $(this).attr("title");
			
			//add p if doesn't exist, update it if it does
			($("p#title").length == 0) ? $("<p>").attr("id", "title").text(title).appendTo("div#controls") : $("p#title").text(title) ;
		});
		
		//restart on mouseout
		$("a.wrapper").live("mouseout", function(e) {
		  
			//hide controls if not hovering on them
			(e.relatedTarget == null) ? null : (e.relatedTarget.id != "controls") ? $("div#controls").slideUp("slow").remove() : null ;
			
			//work out total travel distance
			var totalDistance = parseInt($("div#container").width()) + parseInt($("div#viewer").width());
												
			//work out distance left to travel
			var distanceLeft = ($("div#container").hasClass("ltr")) ? totalDistance - (parseInt($("div#container").css("left")) + parseInt($("div#container").width())) : totalDistance - (parseInt($("div#viewer").width()) - (parseInt($("div#container").css("left")))) ;
			
			//new duration is distance left / speed)
			var newDuration = distanceLeft / speed;
		
			//restart anim
			animator($("div#container"), newDuration, $("div#container").attr("class"));

		});
										
		//handler for ltr button
		$("#ltr").live("click", function() {
		 					
			//stop anim
			$("div#container").stop(true);
		
			//swap class names
			$("div#container").removeClass("rtl").addClass("ltr");
								
			//work out total travel distance
			var totalDistance = parseInt($("div#container").width()) + parseInt($("div#viewer").width());
			
			//work out remaining distance
			var distanceLeft = totalDistance - (parseInt($("div#container").css("left")) + parseInt($("div#container").width()));
			
			//new duration is distance left / speed)
			var newDuration = distanceLeft / speed;
			
			//restart anim
			animator($("div#container"), newDuration, "ltr");
		});
		
		//handler for rtl button
		$("#rtl").live("click", function() {
								
			//stop anim
			$("div#container").stop(true);
			
			//swap class names
			$("div#container").removeClass("ltr").addClass("rtl");
			
			//work out total travel distance
			var totalDistance = parseInt($("div#container").width()) + parseInt($("div#viewer").width());

			//work out remaining distance
			var distanceLeft = totalDistance - (parseInt($("div#viewer").width()) - (parseInt($("div#container").css("left"))));
			
			//new duration is distance left / speed)
			var newDuration = distanceLeft / speed;
		
			//restart anim
			animator($("div#container"), newDuration, "rtl");
		});
	});

    $(document).ready(function(){
        /*setTimeout(function(){
            //Reject older browsers, especially IE5,6,7,8
            $.reject({
                reject: {
                    safari2: true, safari3: true, //Safari
                    msie5: true, msie6: true, msie7: true, msie8: false, // MSIE
                    //chrome1: true, chrome2: true, chrome3: true, // Google Chrome
                    firefox1: true, firefox2: true, firefox3: true, // Mozilla Firefox
                    opera7: true, opera8: true, opera9: true, opera10:true, // Opera
                    konqueror: true, // Konqueror (Linux)
                    unknown: true // Everything else
                },
                browserInfo: { // Settings for which browsers to display
                    firefox: {
                        text: 'Firefox 4', // Text below the icon
                        url: 'http://www.mozilla.com/firefox/' // URL For icon/text link
                    },
                    safari: {
                        text: 'Safari 5',
                        url: 'http://www.apple.com/safari/download/'
                    },
                    opera: {
                        text: 'Opera 11',
                        url: 'http://www.opera.com/download/'
                    },
                    chrome: {
                        text: 'Chrome 5',
                        url: 'http://www.google.com/chrome/'
                    },
                    msie: {
                        text: 'Internet Explorer 9',
                        url: 'http://www.microsoft.com/windows/Internet-explorer/'
                    },
                    gcf: {
                        text: 'Google Chrome Frame',
                        url: 'http://code.google.com/chrome/chromeframe/',
                        allow: { all: false, msie: true } // This browser option will only be displayed for MSIE
                    }
                },
                imagePath: 'images/jreject/browser/', // Path where images are located
                fadeInTime: 'slow', // Fade in time on open ('slow','medium','fast' or integer in ms)
                fadeOutTime: 'slow' // Fade out time on close ('slow','medium','fast' or integer in ms)
            });
        },1000);*/
    });
</script>
<style>
/* js-disabled class - set image sizes so they all fit in the viewer */
.js-disabled img { width:100px; height:100px; display:block; float:left; margin:30px 0 0; }
#imageScroller { width:692px; height:72px; position:relative; background:#FFFFFF }
#viewer { width:672px; height:72px; overflow:hidden; margin:auto; position:relative; top:10px; }
#imageScroller a:active, #imageScroller a:visited { color:#FFFFFF; }
#imageScroller a img { border:0; }
#controls { width:674px; height:0px; background:url(images/controlsBG.png) no-repeat; position:absolute; top:45px; left:4px; z-index:10; }
#controls a { width:37px; height:35px; position:absolute; top:3px; }
#controls a:active, #controls a:visited { color:#0d0d0d; }
#title { color:#000000; font-family:arial; font-size:100%; font-weight:bold; width:100%; text-align:center; margin-top:20px; }
#outerContainer { width:692px; height:90px; margin:auto; margin-bottom: 25px; position:relative; }

.line {
	height: 5px;
	background-color: #EEE;
}
.introTable {
	width: 95%;
	margin: 20px auto 20px;;
}
.introTable .top {
	height: 100px;
}
.introTable .left {
	background-color: #FFF;
	width: 355px;
	height: 255px;
	padding-top: 20px;
	text-align: left;
	font-size: 13px;
	letter-spacing: 0.6px;
	vertical-align: top;
}
.introTable h3 {
	margin: 0;
	margin-bottom: 10px;
	font-size: 15px;
}
.introTable .right {
	width: 470px;
	vertical-align: top;
}
.introTable #gallery {
	position: relative;
	top: -5px;
	left: 5px;
	padding: 0;
	margin: 0;
}
.loginTable {
	width:100%;
	margin:20px auto 20px;
}
.loginTable .left {
	vertical-align: top;
	padding-left: 20px;
}
.loginTable .right {
	width: 180px;
	padding-right: 20px;
	padding-left: 20px;
}
.loginTable .features {
	width: 100%;
	margin: 15px auto 0;
}
.loginTable .features .title {
	text-align: center;
	width:150px;
	font-size: 11px;
	vertical-align: middle;
}
.loginTable .features .title h3 {
	margin: 0;
	padding: 0;
	letter-spacing: 1px;
	font-size: 14px;
} 
.seta {
	width: 40px;
	text-align: right;
	padding-right: 10px;
	vertical-align: middle;
	height: 30px;
}
.setaconteudo {
	width: 280px;
	font-size: 13px;
	letter-spacing: 0.5px;
	vertical-align: middle;
}
</style>

<table class="introTable" cellspacing="0" cellpadding="0">
	<tr>
		<td class="top" colspan="2">
		<div id="outerContainer">
			<div id="imageScroller">
				<div id="viewer" class="js-disabled">
					<a style="margin:20px" class="wrapper" href="#" title="IABIN"><img class="logo" height="50px" id="jqueryui" src="images/logos/logo_iabin.gif" alt="IABIN"></a>
					<a style="margin:20px" class="wrapper" href="#" title="MMA"><img class="logo" height="50px" id="firefox" src="images/logos/logo_mma.png" alt="MMA"></a>
					<a style="margin:20px" class="wrapper" href="#" title="FAO"><img class="logo" height="50px" id="jquery" src="images/logos/logo_fao.jpg" alt="FAO"></a>
					<a style="margin:20px" class="wrapper" href="#" title="UNEP"><img class="logo" height="50px" id="twitter" src="images/logos/logo_unep.gif" alt="UNEP"></a>
					<a style="margin:20px" class="wrapper" href="#" title="GEF"><img class="logo" height="50px" id="jqueryui" src="images/logos/logo_gef.jpg" alt="GEF"></a>
					<a style="margin:20px" class="wrapper" href="#" title="FUNBIO"><img class="logo" height="50px" id="jqueryui" src="images/logos/logo_funbio.jpg" alt="FUNBIO"></a>
					<a style="margin:20px" class="wrapper" href="#" title="USP"><img class="logo" height="40px" id="jqueryui" src="images/logos/logo_usp.jpg" alt="USP"></a>
					<a style="margin:20px" class="wrapper" href="#" title="POLI"><img class="logo" height="50px" id="jqueryui" src="images/logos/logo_poli.jpg" alt="POLI"></a>
					<a style="margin:20px" class="wrapper" href="#" title="OEA"><img class="logo" height="50px" id="jqueryui" src="images/logos/logo_oea.jpg" alt="OEA"></a>
					<a style="margin:20px" class="wrapper" href="#" title="WB"><img class="logo" height="50px" id="jqueryui" src="images/logos/logo_wb.gif" alt="WB"></a>
					<a style="margin:20px" class="wrapper" href="#" title="FAPESP"><img class="logo"  height="40px" id="apple" src="images/logos/logo_fapesp.jpg" alt="FAPESP"></a>
					<a style="margin:20px" class="wrapper" href="#" title="NAPPC"><img class="logo"  height="50px" id="apple" src="images/logos/logo_nap.jpg" alt="NAPPC"></a>
					<a style="margin:20px" class="wrapper" href="#" title="P2"><img class="logo"  height="40px" id="apple" src="images/logos/logo_pollinator.jpg" alt="P2"></a>
				</div>			
			</div>
		</div>
	    </td>
    </tr>
    <tr>
        <td class="left">            
            <h3><?php echo CHtml::encode(Yii::t('yii', 'WELCOME TO BDD'));?></h3>
            <?php echo CHtml::encode(Yii::t('yii', 'This tool was designed for easy digitization, manipulation, and publication of biodiversity data. It stands out by allowing the user to manipulate its data simply and objectively, especially the data from field observations and small collections.'));?>
            <br/><br/><div style="text-align:center;width:100%"><!--<img src="images/cepann_thumb.jpg" /></br><b>CEPANN</b>--></div>
        </td>
        <td class="right">
            <div id="gallery">
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/1.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Biodiversity Data Digitizer');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'This tool was designed for easy digitization, manipulation, and publication of biodiversity data.');?> " height="253" width="460" style="padding: 5px">
                </a>
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/2.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Auto-suggestion');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'A mechanism for data quality that suggests values based on authoritative databases, such as ITIS and Geonames.');?> " height="253" width="460" style="padding: 5px;">
                </a>
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/3.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Media & References');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'BDD offers tools to manage and relate media and reference files with occurrence and interaction records.');?>" height="253" width="460" style="padding: 5px;">
                </a>
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/4.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'TAPIR Provider');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'A TAPIR provider is built into BDD. It publishes records from the database in the standard schemas (Darwin Core, Dublin Core, etc).');?>" height="253" width="460" style="padding: 5px;">
                </a>
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/5.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Interaction Records');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'Interaction tool allows one to register the relationship between two occurrence records.');?> " height="253" width="460" style="padding: 5px;">
                </a>
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/6.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Standards');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'BDD is based on international metadata standards for biodiversity information, such as Darwin Core (TDWG), Dublin Core and MRTG.');?> " height="253" width="460" style="padding: 5px;">
                </a>
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/7.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Development');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'The BDD was an outgrowth of the PDD, which was developed within the scope of the Pollinator Thematic Network (IABIN-PTN).');?>" height="253" width="460" style="padding: 5px;">
                </a>
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/8.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Map views');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'BDD has a map tool that plots occurrence records from the database. Filters help you refine your analysis.');?>" height="253" width="460" style="padding: 5px;">
                </a>
                <a style="opacity: 0;" href="">
                    <img src="images/main/slideshow/9.jpg" title="" alt="" rel="&lt;h3&gt;<?php echo Yii::t('yii', 'Access tool');?>&lt;/h3&gt;<?php echo Yii::t('yii', 'The BDD is a browser-based system that can be accessed remotely, through an external server, or locally, when installed on a personal computer.');?>" height="253" width="460" style="padding: 5px;">
                </a>
                <div style="opacity: 0.9; width: 460px; height: 60px; display: block;" class="caption">
                    <div style="opacity: 0.9;" class="content"><h3><?php echo Yii::t('yii', 'Biodiversity Data Digitizer');?></h3></div>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="line"></div>

<table class="loginTable" cellpadding="0" cellspacing="0">
    <tr>
        <td class="left">
            <table class="features">
                <tr>
                    <td class="title"><h3><?php echo Yii::t('yii', 'Main features');?></h3></td>
                    <td><?php echo CHtml::image('images/main/linha_verde.jpg')?></td>
                    <td class="title"><h3><?php echo Yii::t('yii', 'Data Management');?></h3></td>
                    <td><?php echo CHtml::image('images/main/linha_verde.jpg')?></td>
                </tr>
            </table>
            <table class="features">
                <tr>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Manage Collections of Specimen Data'); ?></td>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Create Specimen Occurrence Records'); ?></td>
                </tr>
                <tr>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Ensure Accuracy with Data Quality Tools'); ?></td>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Link References, Media, and Interactions'); ?></td>
                </tr>
                <tr>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','View Specimen Locations on a World Map'); ?></td>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Attach Reference and Media Files'); ?></td>
                </tr>
                <tr>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Import and Export Data using Spreadsheets'); ?></td>
                    <td class="seta"><?php echo CHtml::image('images/main/seta.png'); ?></td><td class="setaconteudo"><?php echo Yii::t('yii','Access Data Through the TAPIR Protocol'); ?></td>
                </tr>
            </table>
        </td>
        <td class="right">
            <?php $this->widget('UserLogin', array('visible'=>Yii::app()->user->isGuest)); ?>
        </td>
    </tr>
</table>
