<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

####### OPTIONS #######
$conn = new mysqli("mysql-host", "mysql-user", "mysql-pass", "mysql-db");
$proxy = "http://proxyaddr:proxyport"; # Leave blank if not needed
$bamuser = "BAM_USERNAME";
#######################

shell_exec("curl -s -c /tmp/.bamlogin -x '".$proxy."' 'https://boincstats.com/en' --data 'user_name=".$bamuser."&password=".$_GET['bampass']."&login=Login'");
echo "data: " . "Logged in to BAM!" . "\n\n";
ob_flush();
flush();

$conn = new mysqli("mysql-host", "mysql-user", "mysql-pass", "mysql-db");
$result_boincview = $conn->query('SELECT `bam_id`, `manifest` from `boinc`');

$total_hosts = $result_boincview->num_rows;
$count = 0;
$other = 0;

while ($row = $result_boincview->fetch_assoc()) {
	if (stripos($row["manifest"], "desktop-staff") !== false) {
		shell_exec("curl -s -b /tmp/.bamlogin -x '".$proxy."' 'https://boincstats.com/en/xml/bamHost/' --data 'action=sg&ID=".$row["bam_id"]."&ProjectID=-3&data=Staff_Desktops&uid=1489134812454'");
	} elseif ((stripos($row["manifest"], "desktop-student") !== false) || (stripos($row["manifest"], "desktop-music") !== false)) {
		shell_exec("curl -s -b /tmp/.bamlogin -x '".$proxy."' 'https://boincstats.com/en/xml/bamHost/' --data 'action=sg&ID=".$row["bam_id"]."&ProjectID=-3&data=Student_Desktops&uid=1489134812454'");
	} elseif (stripos($row["manifest"], "laptop-school") !== false) {
		shell_exec("curl -s -b /tmp/.bamlogin -x '".$proxy."' 'https://boincstats.com/en/xml/bamHost/' --data 'action=sg&ID=".$row["bam_id"]."&ProjectID=-3&data=School_Laptops&uid=1489134812454'");
	} else {
		shell_exec("curl -s -b /tmp/.bamlogin -x '".$proxy."' 'https://boincstats.com/en/xml/bamHost/' --data 'action=sg&ID=".$row["bam_id"]."&ProjectID=-3&data=Other&uid=1489134812454'");
		$other++;
	}
	
	$count++;
	echo "data: " . "Done ".$count."/".$total_hosts . "\n\n";
	ob_flush();
	flush();
}

shell_exec("curl -s -b /tmp/.bamlogin -x '".$proxy."' 'https://boincstats.com/en/bam/hosts/' --data 'logout=Logout'");
shell_exec("rm /tmp/.bamlogin");
echo "data: " . "Logged out of BAM!" . "\n\n";
ob_flush();
flush();

echo "data: " . "Done! " . $other . " machine(s) were put in 'Other' group" . "\n\n";
ob_flush();
flush();
echo "data: " . "endstream" . "\n\n";
ob_flush();
flush();
exit;
?>