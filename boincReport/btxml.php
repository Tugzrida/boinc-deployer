<?php

# boinc-deployer/boincReport: btxml.php: generates list of BOINC clients for BoincTasks 
#                                        as an XML file
# Copyright (C) 2017 Tugzrida (github.com/Tugzrida)
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published
# by the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# 
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

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