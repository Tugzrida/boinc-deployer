<?php

# boinc-deployer/boincReport: getcsv.php: generates CSV of BOINC clients for analysis
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

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"boincReport-".date('Y-m-d H:i:s').".csv\"");
$data=stripcslashes($_POST['csv_text']);
echo $data; 
?>