<?php
$cs=Yii::app()->clientScript;
?>


<?php echo CHtml::beginForm(); ?>
<div class="yiiForm">

    <div style="height: 100%; position:relative;margin-left: auto;margin-right: auto;width:80%;margin-top:50px;text-align:justify;">
        <h1><?php echo Yii::t('yii','BDD GeoTool'); ?></h1>
        <table align="center" width="100%">
                        
            <tr align="center">
                <th>
                    <br/><h3><?php echo Yii::t('yii','Biodiversity Georeferencing Tool'); ?></h3>
                    <p align="justify" style="font-weight:normal;"><?php echo Yii::t('yii','This web-based resource allows the user, by means of an interactive three-dimensional map based on the Google Earth API - Application Programming Interface - to obtain the name of the country, state and city as well as the latitude, longitude and altitude of a location by clicking on its position on the map.'); ?></p>
                    <table align="center" width="100%">
                        <tr align="center">
                            <th><a href="index.php?r=georeferencingtool&flag=true"><img  src="images/main/earth-icon.png"/></a></th>
                        </tr>
                        <tr align="center">
                            <td><a href="index.php?r=georeferencingtool&flag=true"><?php echo Yii::t('yii','Click here to access BDD GeoTool'); ?></a></td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr align="center">
                <th>
                    <HR WIDTH=100% ALIGN=CENTER NOSHADE>
                </th>
            </tr>
            <tr align="left">
                <th>
                    <br/><h1><?php echo Yii::t('yii','System Requirements'); ?></h1>
                    <br/><h3><?php echo Yii::t('yii','Google Earth Plug-in'); ?></h3>
                    <ul style="font-weight:normal;">
                        <li style="margin-bottom:10px;"><a href="http://www.google.com/earth/explore/products/plugin.html" target="_blank">Click here to install the Google Earth Plug-in.</a></li>
                    </ul>
                        <br/><h3><?php echo Yii::t('yii','Operating Systems Supported'); ?></h3>
                    <ul style="font-weight:normal;">
                        <li style="margin-bottom:10px;">Microsoft Windows 2000;</li>
                        <li style="margin-bottom:10px;">Microsoft Windows XP;</li>
                        <li style="margin-bottom:10px;">Microsoft Windows Vista;</li>
                        <li style="margin-bottom:10px;">Apple Mac OS X 10.4 and higher (Intel and PowerPC).</li>
                    </ul>
                    <br/><h3><?php echo Yii::t('yii','Browsers Supported'); ?></h3>
                    <ul style="font-weight:normal;">
                        <li style="margin-bottom:10px;">Google Chrome 1.0+;</li>
                        <li style="margin-bottom:10px;">Internet Explorer 6+;</li>
                        <li style="margin-bottom:10px;">Firefox 3.0+;</li>
                        <li style="margin-bottom:10px;">Flock 1.0+;</li>
                        <li style="margin-bottom:10px;">Safari 3.1+.</li>
                    </ul>
                </th>
            </tr>
        </table>
    </div>

</div>
<br/><br/><br/>
<?php
echo CHtml::endForm();
?>
<br>
<br>
