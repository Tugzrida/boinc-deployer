#!/bin/sh
hw_serial=$(system_profiler SPHardwareDataType | awk '/Serial/ {print $4}')
fqdn_boinc=$(sudo /Library/Application\ Support/BOINC\ Data/boinccmd --get_host_info | grep "domain name" | awk '{print $3}')
fqdn_sys=$(hostname -f)
bam_id=$(sudo cat /Library/Application\ Support/BOINC\ Data/acct_mgr_reply.xml | grep "BAM! Host:" | grep -E -o "[0-9]" | tr -d '\n')
manifest=$(defaults read /Library/Preferences/ManagedInstalls.plist ClientIdentifier)

curl 'http://BOINCREPORT_SERVER/boincReport.php' --data "hw_serial=$hw_serial&fqdn_boinc=$fqdn_boinc&fqdn_sys=$fqdn_sys&bam_id=$bam_id&manifest=$manifest"
