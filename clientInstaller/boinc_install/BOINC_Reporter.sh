#!/bin/sh

# boinc-deployer/clientInstaller: BOINC_Reporter.sh: Runs occasionally on BOINC Clients to
#                                                    report back to boincReport
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

hw_serial=$(system_profiler SPHardwareDataType | awk '/Serial/ {print $4}')
fqdn_boinc=$(sudo /Library/Application\ Support/BOINC\ Data/boinccmd --get_host_info | grep "domain name" | awk '{print $3}')
fqdn_sys=$(hostname -f)
bam_id=$(sudo cat /Library/Application\ Support/BOINC\ Data/acct_mgr_reply.xml | grep "BAM! Host:" | grep -E -o "[0-9]" | tr -d '\n')
manifest=$(defaults read /Library/Preferences/ManagedInstalls.plist ClientIdentifier)

curl 'http://BOINCREPORT_SERVER/boincReport.php' --data "hw_serial=$hw_serial&fqdn_boinc=$fqdn_boinc&fqdn_sys=$fqdn_sys&bam_id=$bam_id&manifest=$manifest"
