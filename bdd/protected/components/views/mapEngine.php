<!--GOOGLE MAPS VERSION 3-->


<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    
    var geocoder;
    var map;

    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-25, -59);
        var myOptions = {
            zoom: <?php if($_GET[r] == "map") echo"3"; else echo"1";?>,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        }
        map = new google.maps.Map(document.getElementById("BDD_MAP"), myOptions);
        setMarkers(map, specime);
    }

    function setMarkers(map, locations) {
      for (var i = 0; i < locations.length; i++) {
        var spc = locations[i];
        var myLatLng = new google.maps.LatLng(spc[0], spc[1]);
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            //shadow: shadow,
            //icon: image,
            //shape: shape,
            //title: "spc"+i,
            zIndex: i
        });

        var j = i + 1;
        marker.setTitle(j.toString());
        attachMessage(marker, i);
      }
    }

    function attachMessage(marker, number) {
        var infowindow = new google.maps.InfoWindow(
            { content: '<div id="infowindow" style="width: 250px; height: auto;">'+Content[number]+"</div>"});
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });
    }

</script>

<?php
 if ($_GET[r] == "map") {$widthmap="700px";$heightmap="430px";}
  if (!$_GET[r]) {$widthmap="625px";$heightmap="230px";}

echo "<div id=\"BDD_MAP\" style=\"width:$widthmap;height:$heightmap;margin-left:auto;margin-right:auto; margin-top:0px;\"></div>";