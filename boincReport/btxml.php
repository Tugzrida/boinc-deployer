<?php
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: Binary'); 
header('Content-disposition: attachment; filename="computers.xml"'); 

####### OPTIONS #######
$conn = new mysqli("mysql-host", "mysql-user", "mysql-pass", "mysql-db");
#######################

$result_boincview = $conn->query('SELECT `fqdn_sys` from `boinc`');
?>
<computers>

<?php
$num = 0;
while ($row = $result_boincview->fetch_assoc()) {
    echo "<computer>\n";
    
    echo "    <id_name>".++$num."-".explode(".",$row["fqdn_sys"])[0]."</id_name>\n";
	echo "    <id_group></id_group>\n";
	echo "    <ip>".$row["fqdn_sys"]."</ip>\n";
	echo "    <mac></mac>\n";
	echo "    <checked>1</checked>\n";
	echo "    <port>-1</port>\n";
	echo "    <password>".$_POST['guipass']."</password>\n";
	echo "    <encryption>no</encryption>\n";
    
    echo "</computer>\n";
    
}
?>

</computers>