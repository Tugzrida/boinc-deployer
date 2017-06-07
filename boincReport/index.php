<?php
ini_set ("display_errors", "1");
error_reporting(E_ALL);

####### OPTIONS #######
$conn = new mysqli("mysql-host", "mysql-user", "mysql-pass", "mysql-db");
#######################

$result_boincview = $conn->query('SELECT * from `boinc`');

$boinc_errout = mysqli_error($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>BOINC Report Results</title>
    <link rel="stylesheet" href="themes/blue/style.css">
    <script src="jquery.min.js"></script>
    <script src="jquery.tablesorter.min.js"></script>
    <script src="table2CSV.js"></script>
</head>
<body>
<h1>BOINC Report Results</h1>
<?php if($boinc_errout != NULL) { echo "Error: " . $boinc_errout; } ?>
Total rows: <?php echo $result_boincview->num_rows; ?>
<br /><br />
<style>
	tr td:last-child{
	    width:1%;
	    white-space:nowrap;
	}
</style>
<form action="getcsv.php" method="post" > 
<input type="hidden" name="csv_text" id="csv_text">
<input type="submit" value="Get CSV File" onclick="getCSVData()">
</form>
<script>
function getCSVData(){
  var csv_value=$('#boincs').table2CSV({delivery:'value'});
  $("#csv_text").val(csv_value);  
}
</script>
<table id="boincs" class="table tablesorter">
    <thead>
    <tr>
        <th>Last Report</th>
        <th>BAM! ID</th>
        <th>FQDN from BOINC</th>
        <th>FQDN from System</th>
        <th>Hardware Serial</th>
        <th>Munki Manifest</th>
    </tr>
    </thead>
    <tbody>
    <?php
	while ($row = $result_boincview->fetch_assoc()) {
    	echo "<tr><td>".$row["timestamp"]."</td><td>".$row["bam_id"]."</td><td>".$row["fqdn_boinc"]."</td><td>".$row["fqdn_sys"]."</td><td>".$row["hw_serial"]."</td><td>".$row["manifest"]."</td></tr>";
	}
    ?>
    
    </tbody>
</table>
<form action="btxml.php" method="POST">
	<input type="password" id="bampass" name="bampass"  placeholder="BAM!/GUI password" size="30">
	<input type="button" id="bamgo" value="Group hosts on BAM!">
	<input type="text" id="bammsg" size="60" disabled style="display: none;">
	<input type="submit" value="Download XML for BOINCTasks">
</form>
<script>
	$(document).ready(function() 
	{ 
		$("#boincs").tablesorter({sortList:[[5,0]], widgets: ['zebra']});
	});
	
	$('#bamgo').click(function () {
  		var bammsg = new EventSource("bamify.php?bampass=" + encodeURIComponent($('#bampass').val()));
  		$('#bammsg').css("display", "inline-block");
        $('#bammsg').val("Loading...");
        bammsg.onmessage = function(msg) {
        	if(msg.data != "" && msg.data != "endstream"){
        		$('#bammsg').val(msg.data);
        	}
        	if(msg.data == "endstream"){
        		bammsg.close()
        		bammsg = null;
        	}
        }
	});
	
</script>
</body>
</html>