<?php
echo '';
?>
<script type="text/javascript" src="js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/tips/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="js/jquery.jnotify.js"></script>
<link rel="stylesheet" type="text/css" href="js/tips/tip-twitter/tip-twitter.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery.jnotify.css"/>
<link rel="stylesheet" type="text/css" href="js/jquery/jquery-ui.css"/>
	
<script type="text/javascript">
$(document).ready(function() {

});
function insert(f){
	$.ajax({ type:'POST',
	                url:'update.php',
	                data:{'table':f},
	                dataType: "json",
	                success:function(json) {
	                	$('#status').html(json);
	                }
	});
}    
</script>
<html>
	<head>
		<title>CoL Update</title>
	</head>
	<body>
		<span id="status"></span>
		<input type="button" value="Common Names" onclick="insert('common_names');"/>
		<input type="button" value="Databases" onclick="insert('databases');"/>
		<input type="button" value="Distribution" onclick="insert('distribution');"/>		
		<input type="button" value="Families" onclick="insert('families');"/>
		<input type="button" value="Hard Coded Species Totals" onclick="insert('hard_coded_species_totals');"/>
		<input type="button" value="Hard Coded Taxon Lists" onclick="insert('hard_coded_taxon_lists');"/>
		<input type="button" value="References" onclick="insert('references');"/>
		<input type="button" value="Scientific Name References" onclick="insert('scientific_name_references');"/>
		<input type="button" value="Scientific Names" onclick="insert('scientific_names');"/>
		<input type="button" value="Simple Search" onclick="insert('simple_search');"/>
		<input type="button" value="Sp2000 Status" onclick="insert('sp2000_statuses');"/>
		<input type="button" value="Specialists" onclick="insert('specialists');"/>
		<input type="button" value="Taxa" onclick="insert('taxa');"/>
	</body>
</html>


