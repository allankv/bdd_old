<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
 Copyright 2010 Google Inc.
 Licensed under the Apache License, Version 2.0:
 http://www.apache.org/licenses/LICENSE-2.0
-->
<?php
$cs=Yii::app()->clientScript;
?>

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php
        $cs=Yii::app()->clientScript;
        ?>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Geospatial Data Tool for Biodiversity</title>
        <script type="text/javascript" src="http://maps.google.com/maps?file=api&v=2.x&key=ABQIAAAA_eiBN3iJmJIl8dz9uc6achSA8gLup45ck7EGeuFmBbFhll9N5hS4EUOoR49FbXkEHN5xovCXk0Zpxg"></script>
        <script type="text/javascript">
            var MAPFILES_URL = "http://www.google.com/mapfiles/";
            var map = null;
            var markers = null;
            var polylines = null;
            var bounds = null;
            var info = null;
            var details = null;
            var selected = null;
            var reverseIcon = null;
            var clickMarker = null;
            var hashFragment = "";

            var GGeoStatusCode = {
                "200": "G_GEO_SUCCESS",
                "400": "G_GEO_BAD_REQUEST",
                "500": "G_GEO_SERVER_ERROR",
                "601": "G_GEO_MISSING_QUERY",
                "602": "G_GEO_UNKNOWN_ADDRESS",
                "603": "G_GEO_UNAVAILABLE_ADDRESS",
                "604": "G_GEO_UNKNOWN_DIRECTIONS",
                "610": "G_GEO_BAD_KEY",
                "620": "G_GEO_TOO_MANY_QUERIES"
            };

            var GGeoStatusDescription = {
                "200": "No errors occurred. The address was successfully parsed and its geocode has been returned.",
                "400": "A directions request could not be successfully parsed.",
                "500": "A geocoding or directions request could not be successfully processed,<br/>yet the exact reason for the failure is not known.",
                "601": "The HTTP q parameter was either missing or had no value.<br/>For geocoding requests, this means that an empty address was specified as input.</br>For directions requests, this means that no query was specified in the input.",
                "602": "No corresponding geographic location could be found for the specified address.<br/>This may be due to the fact that the address is relatively new, or it may be incorrect.",
                "603": "The geocode for the given address or the route for the given<br/>directions query cannot be returned due to legal or contractual reasons.",
                "604": "The GDirections object could not compute directions between the points mentioned in the query.<br/>This is usually because there is no route available between the two points, or because we do not have data for routing in that region.",
                "610": "The given key is either invalid or does not match the domain for which it was given.",
                "620": "The given key has gone over the requests limit in the 24 hour period."
            };

            var GGeoAddressAccuracy = {
                "0": "Unknown location.",
                "1": "Country",
                "2": "Region<br/>(state, province, prefecture, etc.) ",
                "3": "Sub-region<br/>(county, municipality, etc.)",
                "4": "Town (city, village)",
                "5": "Post code (zip code)",
                "6": "Street level accuracy.",
                "7": "Intersection level accuracy.",
                "8": "Address level accuracy.",
                "9": "Premise<br/>(building name, property name, shopping center, etc.)"
            }

            function init() {
                var params = parseUrlParams();
                clearOptions();
                setOptions(params);

                if (GBrowserIsCompatible()) {
                    map = new GMap2(document.getElementById("map"));
                    map.setCenter(new GLatLng(0.0, 0.0), 1);
                    //map.setCenter(params.center ? params.center : new GLatLng(0.0, 0.0));
                    map.setZoom(params.zoom ? params.zoom : 1);
                    map.setUIToDefault();

                    reverseIcon = new GIcon(G_DEFAULT_ICON);
                    reverseIcon.image = MAPFILES_URL + "dd-start.png";

                    GEvent.addListener(map, "click", function(overlay, latlng) {
                        if (! overlay) {
                            document.getElementById("query").value = latlng.toUrlValue(6);
                            document.getElementById("resposta").innerHTML = latlng.toUrlValue(6);
                            reverseGeocode(latlng);
                        }
                    });

                    if (document.getElementById("query").value) {
                        geocode();
                    }

                    document.getElementById("query").onkeyup = function() {
                        if (!e) var e = window.event;
                        if (e.keyCode != 13) return;
                        document.getElementById("query").blur();
                        geocode(document.getElementById("query").value);
                    }
                }

                setInterval(checkHashFragment, 200);
            }

            function checkHashFragment() {
                if (unescape(window.location.hash) != unescape(hashFragment)) {
                    var params = parseUrlParams();
                    clearOptions();
                    setOptions(params);

                    if (params.zoom && params.center) {
                        map.setZoom(params.zoom);
                        map.setCenter(params.center);
                    }

                    if (document.getElementById("query").value) {
                        geocode();
                    }
                }
            }

            function parseUrlParams() {
                var params = {};

                if (window.location.search) {
                    params.query = unescape(window.location.search.substring(1));
                }

                if (window.location.hash) {
                    hashFragment = unescape(window.location.hash);
                    var args = hashFragment.substring(1).split('&');
                    for (var i in args) {
                        var param = args[i].split('=');
                        switch (param[0]) {
                            case 'q':
                                params.query = unescape(param[1]);
                                break;
                            case 'vpcenter':
                                var center = parseLatLng(param[1]);
                                if (center != null) {
                                    params.center = center;
                                }
                                break;
                            case 'vpzoom':
                                var zoom = parseInt(param[1]);
                                if (! isNaN(zoom)) {
                                    params.zoom = zoom;
                                }
                                break;
                            case 'country':
                                params.country = unescape(param[1]);
                                break;
                        }
                    }
                }

                return params;
            }

            function clearOptions() {
                document.getElementById("query").value = "";

                //document.getElementById("country").value = "";
            }

            function setOptions(params) {
                if (params.query) {
                    document.getElementById("query").value = params.query;
                }

                //if (params.country) {
                //    document.getElementById("country").value = params.country;
                //}
            }

            function geocode() {
                var query = document.getElementById("query").value;
                if (/\s*^\-?\d+(\.\d+)?\s*\,\s*\-?\d+(\.\d+)?\s*$/.test(query)) {
                    var latlng = parseLatLng(query);
                    if (latlng == null) {
                        document.getElementById("query").value = "";
                    } else {
                        reverseGeocode(latlng);
                    }
                } else {
                    forwardGeocode(query);
                }
            }

            function initGeocoder(query) {
                selected = null;
                map.clearOverlays();

                var hash = 'q=' + query;

                //var country = document.getElementById("country").value;
                var geocoder = new GClientGeocoder();



                /*if (country) {
                    hash += '&country=' + country;
                    geocoder.setBaseCountryCode(country);
                }*/

                hashFragment = '#' + escape(hash);
                window.location.hash = escape(hash);
                return geocoder;
            }

            function forwardGeocode(address) {
                var geocoder = initGeocoder(address);
                geocoder.getLocations(address, function(response) {
                    showResponse(response, false);
                });
            }

            function reverseGeocode(latlng) {
                var geocoder = initGeocoder(latlng.toUrlValue(6));
                geocoder.getLocations(latlng, function(response) {
                    showResponse(response, true);
                });
                map.panTo(latlng);
                map.addOverlay(new GMarker(latlng, { 'icon': reverseIcon }));
            }

            function parseLatLng(value) {
                value.replace('/\s//g');
                var coords = value.split(',');
                var lat = parseFloat(coords[0]);
                var lng = parseFloat(coords[1]);
                if (isNaN(lat) || isNaN(lng)) {
                    return null;
                } else {
                    return new GLatLng(lat, lng);
                }
            }

            function showResponse(response, reverse) {
                if (! response) {
                    alert("Geocoder request failed");
                } else {
                    /*
                    //document.getElementById("requestQuery").innerHTML = response.name;
                    //document.getElementById("statusValue").innerHTML = response.Status.code;
                    //document.getElementById("statusConstant").innerHTML = GGeoStatusCode[response.Status.code];
                    //document.getElementById("statusDescription").innerHTML = GGeoStatusDescription[response.Status.code];

                    document.getElementById("responseInfo").style.display = "block";
                    document.getElementById("responseStatus").style.display = "block";
                    document.getElementById("country").innerHTML = "";
                    document.getElementById("region").innerHTML = "";
                    document.getElementById("city").innerHTML = "";
                    document.getElementById("address").innerHTML = "";
                    document.getElementById("region").innerHTML = response.Placemark[0].AddressDetails.Country
                    .AdministrativeArea.AdministrativeAreaName;
                    document.getElementById("country").innerHTML = response.Placemark[0].AddressDetails.Country.CountryName;
                    document.getElementById("city").innerHTML = response.Placemark[0].AddressDetails.Country.AdministrativeArea.Locality.LocalityName;
                    document.getElementById("address").innerHTML = response.Placemark[0].address;
                    //alert();
                    if (response.Status.code == 200) {
                        //document.getElementById("matchCount").innerHTML = response.Placemark.length;
                        document.getElementById("responseCount").style.display = "block";
                        plotMatchesOnMap(response, reverse);
                    } else {
                        document.getElementById("responseCount").style.display = "none";
                        document.getElementById("matches").style.display = "none";
                        document.getElementById("query").value = "";
                        if (! reverse) {
                            map.setCenter(new GLatLng(0.0, 0.0), 1);
                        }
                    }*/
                    alert (response.Placemark[0].AddressDetails.Country.CountryName);
                }
            }

            function plotMatchesOnMap(response, reverse) {
                var resultCount = response.Placemark.length;

                info      = new Array(resultCount);
                details   = new Array(resultCount);
                markers   = new Array(resultCount);
                polylines = new Array(resultCount);
                bounds    = new Array(resultCount);

                var icons   = new Array(resultCount);
                var latlngs = new Array(resultCount);

                var infoListHtml = "";
                // IMPORTANTE resultCount
                for (var i = 0; i < 1; i++) {
                    icons[i] = new GIcon(G_DEFAULT_ICON);
                    icons[i].image = MAPFILES_URL + "marker" + String.fromCharCode(65 + i) + ".png";
                    latlngs[i] = new GLatLng(response.Placemark[i].Point.coordinates[1],
                    response.Placemark[i].Point.coordinates[0]);
                    markers[i] = new GMarker(latlngs[i], { icon: icons[i] } );
                    polylines[i] = getPolyline(response.Placemark[i]);
                    bounds[i] = getBounds(response.Placemark[i]);
                    info[i] = getInfoHtml(response.Placemark[i]);
                    details[i] = getAddressDetailHtml(response.Placemark[i]);

                    infoListHtml += getInfoListItem(i, icons[i].image, info[i]);
                }

                document.getElementById("matches").innerHTML = infoListHtml;
                document.getElementById("p0").style.border = "none";
                document.getElementById("matches").style.display = "none";
                document.getElementById("sumir").style.display = "none";

                if (! reverse) {
                    zoomToBounds(bounds, map);
                }

                for (var i = 0; i < resultCount; i++) {
                    map.addOverlay(markers[i]);
                    addInfoWindowListener(i, markers[i], details[i]);
                }

                GEvent.trigger(markers[0], "click");
            }

            function getInfoListItem(i, iconUrl, info) {
                var html  = '<a onclick="selectMarker(' + i + ')">';
                html += '<div class="info" id="p' + i + '">';
                html += '<table><tr valign="top">';
                html += '<td style="padding: 2px"><img src="' + iconUrl + '"/></td>';
                html += '<td style="padding: 2px">' + info + '</td>';
                html += '</tr></table>';
                html += '</div></a>';
                return html;
            }

            function selectMarker(n) {
                GEvent.trigger(markers[n], "click");
            }

            function zoomToBounds(bounds, map) {
                var b = new GLatLngBounds();

                for (var i = 0; i < markers.length; i++) {
                    b.extend(bounds[i].getSouthWest());
                    b.extend(bounds[i].getNorthEast());
                }

                var center = b.getCenter();
                var zoom   = map.getBoundsZoomLevel(b);
                map.setCenter(center, zoom);
            }

            function addInfoWindowListener(i, marker, details) {
                GEvent.addListener(marker, "click", function() {
                    if (selected != null) {
                        document.getElementById('p' + selected).style.backgroundColor = "white";
                        map.removeOverlay(polylines[selected]);
                    }
                    var zoomDelta = map.getBoundsZoomLevel(bounds[i]) - map.getZoom();
                    if (zoomDelta < 0 || zoomDelta > 5) {
                        map.setZoom(map.getBoundsZoomLevel(bounds[i]));
                    }
                    marker.openInfoWindowHtml(details);
                    if (! map.getBounds().containsBounds(bounds[i])) {
                        map.zoomOut();
                        map.panTo(bounds[i].getCenter());
                    }
                    map.addOverlay(polylines[i]);
                    document.getElementById('p' + i).style.backgroundColor = "#eeeeff";
                    document.getElementById('matches').scrollTop = document.getElementById('p' + i).offsetTop - document.getElementById('matches').offsetTop;
                    selected = i;
                });
            }

            function getPolyline(placemark) {
                var ne = new GLatLng(placemark.ExtendedData.LatLonBox.north, placemark.ExtendedData.LatLonBox.east);
                var se = new GLatLng(placemark.ExtendedData.LatLonBox.south, placemark.ExtendedData.LatLonBox.east);
                var sw = new GLatLng(placemark.ExtendedData.LatLonBox.south, placemark.ExtendedData.LatLonBox.west);
                var nw = new GLatLng(placemark.ExtendedData.LatLonBox.north, placemark.ExtendedData.LatLonBox.west);
                var polyline = new GPolyline([ne, se, sw, nw, ne], '#ff0000', 2, 1.0);
                return polyline;
            }

            function getBounds(placemark) {
                var ne = new GLatLng(placemark.ExtendedData.LatLonBox.north, placemark.ExtendedData.LatLonBox.east);
                var sw = new GLatLng(placemark.ExtendedData.LatLonBox.south, placemark.ExtendedData.LatLonBox.west);
                var bounds = new GLatLngBounds(sw, ne);
                return bounds;
            }
            // IMPORTANTE
            function getInfoHtml(placemark) {
                var html  = '<table class="tabContent">';
                html += tr('Localidade', placemark.address);
                html += tr('Coordenada', latlngtxt(placemark.Point.coordinates));
                //html += tr('Bounds', boundstxt(placemark.ExtendedData.LatLonBox));
                //html += tr('Acuracidade (ref. a localidade)', accuracytxt(placemark.AddressDetails.Accuracy));
                html += '</table>';
                return html;
            }

            function getAddressDetailHtml(placemark) {
                return html = '<table class="tabContent">' + getAddressDetailDt(placemark.AddressDetails) + '</table>';
            }

            function getAddressDetailDt(feature) {
                var html = '';
                for (var key in feature) {
                    if (feature[key] instanceof Array) {
                        html += tr(key, feature[key][0]);
                    } else if (feature[key] instanceof Object) {
                        html += getAddressDetailDt(feature[key]);
                    } else {
                        html += tr(key, feature[key]);
                    }
                }
                return html;
            }

            function tr(key, value) {
                return '<tr><td style="text-align: right; font-weight: bold; vertical-align: top; white-space: nowrap;">' + key + ':</td><td>' + value + '</td></tr>';
            }

            function latlngtxt(coordinates) {
                return '(' + coordinates[1] + ', ' + coordinates[0] + ')';
            }

            function boundstxt(latlonbox) {
                return latlngtxt([latlonbox.west, latlonbox.south]) + ' - ' + latlngtxt([latlonbox.east, latlonbox.north]);
            }

            function accuracytxt(accuracy) {
                return accuracy + ' - ' + GGeoAddressAccuracy[accuracy];
            }
        </script>

        <style>
            #map {
                width: 640px;
                height: 480px;
                border: 1px solid black;
                margin: 10px;
                float: left;
            }

            #responseStatus {
                display: none;
            }

            #responseCount {
                display: none;
            }

            #responseInfo {
                background-color: #faFfE9;
                margin-top: 0px;
                margin-left: 0px;                
                border: 1px solid #999999;
                padding: 10px;
                width: 290px;
                display: none;
            }

            #statusDescription {
                margin-left: 10px;
            }

            .info {
                border-top: 1px solid #666666;
                padding: 4px;
                padding-left: 8px;
                font: 10pt sans-serif;
                margin-left: 4px;
                margin-right: 4px;
                cursor: pointer;
                background-color: white;
            }

            .tabContent {
                font: 10pt sans-serif;
                border-collapse: collapse;
                table-layout: auto;
            }

            #matches {
                margin-top: 0px;
                width: 290px;
                height: 250px;
                float: left;                
                border: 1px solid #666666;
                display: none;
                overflow: auto;
            }

            h1 {
                border-bottom: 1px solid #999999;
                font-family: sans-serif;
                padding-bottom: 12px;
                width: 650px;
                margin-bottom: 0px;
            }

            #inputForm {
                width: 150px;
                margin: 10px;
            }

            #footer {
                padding-top: 4px;
                font-family: sans-serif;
                font-size: 8pt;
                clear: both;
                width: 650px;
                border-top: 1px solid #999999;
            }

            #instructions {
                padding-bottom: 8px;
            }

            #options {
                margin-top: 5px;
            }



            #newFeatures {
                position: absolute;
                top: 1px;
                right: -2px;
                background-color: #ffffd0;
                border: 1px solid black;
                font-family: sans-serif;
                font-size: 8pt;
                padding: 2px;
            }
        </style>
    </head>

    <body onload="init()" onunload="GUnload()" style="width: 100%; height: 100%; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; top: 0px; overflow-x: hidden; overflow-y: hidden; ">

        <div style="z-index: 2; position: absolute; width: 290px; right: 5px; top: 35px; height: 130px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: dotted; border-right-style: dotted; border-bottom-style: dotted; border-left-style: dotted; border-top-color: rgb(119, 119, 153); border-right-color: rgb(119, 119, 153); border-bottom-color: rgb(119, 119, 153); border-left-color: rgb(119, 119, 153); background-color: white; padding-top: 1px; padding-right: 1px; padding-bottom: 1px; padding-left: 1px; font-size: 14px; ">
            <!--<div id="inputForm" style=" width: 100%;height: 150px;" >-->
            <table cellspacing="0" cellpadding="5" align="center" style="
                   position: relative;
                   width:100%;
                   height: 130px;
                   margin-left: auto;
                   margin-right: auto;
                   background-color:#f4efd9;
                   padding-left: 0px;
                   padding-right:0px;
                   -moz-border-radius-topleft: 0.4em;
                   -moz-border-radius-topright: 0.4em;
                   -moz-border-radius-bottomleft: 0.4em;
                   -moz-border-radius-bottomright: 0.4em;">

                <tr style="-moz-border-radius-topleft: 0.4em;
                    -moz-border-radius-topright: 0.4em;
                    -moz-border-radius-bottomleft: 0.4em;
                    -moz-border-radius-bottomright: 0.4em;
                    text-align:center;
                    letter-spacing:1px;
                    margin-left:5px;
                    margin-right:5px;
                    background-color:#faFfE9;
                    border:1px solid #ffaaaa;
                    padding-left:5px;
                    margin-top:5px;
                    margin-bottom:5px;">
                    <td  align="center" style="font-size: 14px; padding-top: 5px; padding-bottom: 5px;padding-left: 5px;padding-right: 5px;">
                        Digite a coordenada geográfica ou nome de um país, estado, cidade ou localidade para consultar dados geoespaciais:
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <input type="text" size="50" id="query"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center" style="padding-top:0px;text-align:center;">
                        <div style="text-align: center;
                             width:220px;
                             vertical-align: middle;
                             background-color: transparent;">
                            <input type="button" value="Consultar" onclick="geocode()" style="width: 220px;"/>
                        </div>
                    </td>
                </tr>
            </table>
            <!--</div>-->
        </div>


        <div id="responseInfo" style="z-index: 2; position: absolute; width: 290px; right: 5px; top: 180px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: dotted; border-right-style: dotted; border-bottom-style: dotted; border-left-style: dotted; border-top-color: rgb(119, 119, 153); border-right-color: rgb(119, 119, 153); border-bottom-color: rgb(119, 119, 153); border-left-color: rgb(119, 119, 153); background-color:#faFfE9; padding-top: 1px; padding-right: 1px; padding-bottom: 1px; padding-left: 1px; font-size: 14px; ">
            <div id="responseStatus" style="-moz-border-radius-topleft: 0.4em;
                 -moz-border-radius-topright: 0.4em;
                 -moz-border-radius-bottomleft: 0.4em;
                 -moz-border-radius-bottomright: 0.4em;
                 text-align:center;
                 letter-spacing:1px;
                 margin-left:5px;
                 margin-right:5px;
                 background-color:#f4efd9;
                 border:1px solid #ffaaaa;
                 padding-left:5px;
                 margin-top:5px;
                 margin-bottom:5px;
                 position: relative;">
                <span style="font-weight: bold">País: </span>
                <div id="country"></div>
                <span style="font-weight: bold">Estado/Região: </span>
                <div id="region"></div>
                <span style="font-weight: bold">Município: </span>
                <div id="city"></div>
                <span style="font-weight: bold">Localidade: </span>
                <div id="address"></div>
                <span style="font-weight: bold">Coordenada Geográfica: </span>
                <div id="resposta"></div>
                <div style="padding-top: 10px; color: #EEEEEE" id="responseCount">
                    <span id="matchCount"></span>
                    <span id="requestQuery"></span>
                    <span id="statusValue"></span> <span id="statusConstant"></span>
                    <div id="statusDescription"></div>
                </div>
            </div>
            <div style="text-align: center;">
                <?php
                echo CHtml::beginForm();
                echo CHtml::hiddenField('voltar', true);
                echo CHtml::hiddenField('tudo', true);
                echo CHtml::submitButton(Yii::t('yii','Select'));
                echo CHtml::endForm(); ?>
            </div>

        </div>
        <div id="sumir" style="display: none; z-index: 2; position: absolute; width: 290px; right: 5px; top: 240px; height: 250px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: dotted; border-right-style: dotted; border-bottom-style: dotted; border-left-style: dotted; border-top-color: rgb(119, 119, 153); border-right-color: rgb(119, 119, 153); border-bottom-color: rgb(119, 119, 153); border-left-color: rgb(119, 119, 153); background-color: white; padding-top: 1px; padding-right: 1px; padding-bottom: 1px; padding-left: 1px; font-size: 14px; ">
            <div id="matches"></div>
        </div>

        <div id="map" style="width: 100%; height: 100%; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; top: 0px; overflow-x: hidden; overflow-y: hidden; z-index: 1; position: absolute; background-color: rgb(229, 227, 223); "></div>
    </body>
</html>

