<?php

# boinc-deployer/boincReport: boincReport.php: accepts data pushed by BOINC clients to add to DB
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

ini_set ("display_errors", "1");
error_reporting(E_ALL);
if(!isset($_POST['hw_serial']) || !isset($_POST['fqdn_sys']) || !isset($_POST['fqdn_boinc']) || !isset($_POST['bam_id']) || !isset($_POST['manifest'])){
    http_response_code(400);
    echo "Missing paramater";
    exit;
}

####### OPTIONS #######
$conn = new mysqli("mysql-host", "mysql-user", "mysql-pass", "mysql-db");
#######################

//timestamp from systemdate
$sql_timestamp = date('Y-m-d H:i:s');
$sql_hwserial = $_POST['hw_serial'];
$sql_fqdnsys = $_POST['fqdn_sys'];
$sql_fqdnboinc = $_POST['fqdn_boinc'];
$sql_bamid = $_POST['bam_id'];
$sql_manifest = $_POST['manifest'];

$stmt0 = $conn->prepare('SELECT `id` FROM `boinc` WHERE `hw_serial` = ? LIMIT 1');
$stmt0->bind_param("s", $sql_hwserial);

$stmt0->execute();
$stmt0->bind_result($sql_exists);
$stmt0->fetch();
$stmt0->free_result();
$stmt0->close();

if($sql_exists){
	$stmt1 = $conn->prepare('UPDATE `boinc` SET `timestamp`=?, `fqdn_sys`=?, `fqdn_boinc`=?, `bam_id`=?, `manifest`=? WHERE `hw_serial`=? LIMIT 1');
	$stmt1->bind_param("ssssss", $sql_timestamp, $sql_fqdnsys, $sql_fqdnboinc, $sql_bamid, $sql_manifest, $sql_hwserial);
} else {
	$stmt1 = $conn->prepare('INSERT INTO `boinc` (timestamp, hw_serial, fqdn_sys, fqdn_boinc, bam_id, manifest) VALUES (?, ?, ?, ?, ?, ?)');
	$stmt1->bind_param("ssssss", $sql_timestamp, $sql_hwserial, $sql_fqdnsys, $sql_fqdnboinc, $sql_bamid, $sql_manifest);
}

$stmt1->execute();
$stmt1->close();


http_response_code(200);
echo "Host logged in db";

$conn->close();
?>
