<?php

$vars = ["use", "host_name", "alias", "address", "display_name", "check_period", "service_description", "check_command"];


if(!isset($_POST['submit'])){
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Dodawanie do Nagiosa</title>
	</head>
	<body>
		<form action="index.php" method="post">
			<table border=0>
				<tr>
					<td><strong>Use (host)</strong></td>
					<td><input type="radio" name="use" value="windows-server" />windows-server</td>
					<td><input type="radio" name="use" value="linux-server" />linux-server</td>
					<td><input type="radio" name="use" value="own-option" /><input type="text" name="uset" value="Type own option" /></td>
				</tr>
				<tr>
					<td><strong>Use (service)</strong></td>
					<td><input type="radio" name="use2" value="generic-serveice" />generic-serveice</td>
					<td><input type="radio" name="use2" value="service2" />service2</td>
					<td><input type="radio" name="use2" value="own-option" /><input type="text" name="use2t" value="Type own option" /></td>
				</tr>
				<tr>
					<td><strong>Host name</strong></td>
					<td><input type="radio" name="host_name" value="winserver" />winserver</td>
					<td><input type="radio" name="host_name" value="linserver" />linserver</td>
					<td><input type="radio" name="host_name" value="own-option" /><input type="text" name="host_name_t" value="Type own option" /></td>
				</tr>
				<tr>
					<td><strong>Alias</strong></td>
					<td><input type="text" name="alias" value="Widoczna nazwa" /></td>
				</tr>
				<tr>
					<td><strong>Address IP</strong></td>
					<td><input type="text" name="address" value="192.168.1.XX" /></td>
				</tr>
				<tr>
					<td><strong>Service description</strong></td>
					<td><select name="service_desc">
							<option value="NSClient++ Version">NSClient++ Version</option>
							<option value="Uptime">Uptime</option>
							<option value="CPU Load">CPU Load</option>
							<option value="Memory Usage">Memory Usage</option>
							<option value="C:\ Drive Space">C:\ Drive Space</option>
							<option value="W3SVC">W3SVC</option>
							<option value="Explorer">Explorer</option>
					</select></td>
					<td><input type="radio" name="service_desc" value="own-option"/><input type="text" name="service_desc_t" value="Type own option" /></td>
				</tr>
				<tr>
					<td><strong>Check command</strong></td>
					<td><select name="check_command">
							<option value="check_nt!CLIENTVERSION">check_nt!CLIENTVERSION</option>
							<option value="check_nt!UPTIME">check_nt!UPTIME</option>
							<option value="check_nt!CPULOAD!-l 5,80,90">check_nt!CPULOAD!-l 5,80,90</option>
							<option value="check_nt!MEMUSE!-w 80 -c 90">check_nt!MEMUSE!-w 80 -c 90</option>
							<option value="check_nt!USEDDISKSPACE!-l c -w 80 -c 90">check_nt!USEDDISKSPACE!-l c -w 80 -c 90</option>
							<option value="check_nt!SERVICESTATE!-d SHOWALL -l W3SVC">check_nt!SERVICESTATE!-d SHOWALL -l W3SVC</option>
							<option value="check_nt!PROCSTATE!-d SHOWALL -l Explorer.exe">check_nt!PROCSTATE!-d SHOWALL -l Explorer.exe</option>
					</select></td>
					<td><input type="radio" name="check_command" value="own-option"/><input type="text" name="check_command_t" value="Type own option" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="save_host" value="save_host" />Save host</td>
					<td><input type="checkbox" name="save_service" value="save_service" />Save service</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" value="Wyślij" /></td>
				</tr>
			</table>
		</form>
	</body>
</html>


<?
}
else
{
$usep = $_POST['use'];
	if($usep == "own-option"){
		$use = $_POST['uset'];
	}
	else{
		$use = $usep;
	}

	if($_POST['use2'] == "own-option"){
		$use2 = $_POST['use2t'];
	}
	else{
		$use2 = $_POST['use2'];
	}

	if($_POST['host_name'] == "own-option"){
		$host_name = $_POST['host_name_t'];
	}
	else{
		$host_name = $_POST['host_name'];
	}

	if($_POST['service_desc'] == "own-option"){
		$service_desc = $_POST['service_desc_t'];
	}
	else{
		$service_desc = $_POST['service_desc'];
	}

	if($_POST['check_command'] == "own-option"){
		$check_command = $_POST['check_command_t'];
	}
	else{
		$check_command = $_POST['check_command'];
	}

$alias = $_POST['alias'];
$address = $_POST['address'];

$dane[0] = "\n##### $alias - $address\n";
$dane[1] = "define host{\n";
$dane[2] = "\t$vars[0]\t\t\t\t$use\n";
$dane[3] = "\t$vars[1]\t\t$host_name\n";
$dane[4] = "\t$vars[2]\t\t\t$alias\n";
$dane[5] = "\t$vars[3]\t\t\t$address\n";
$dane[6] = "\t}\n";

$dane2[0] = "\n##### $alias - $address\n";
$dane2[1] = "define service{\n";
$dane2[2] = "\t$vars[0]\t\t\t\t\t\t$use2\n";
$dane2[3] = "\t$vars[1]\t\t\t\t$host_name\n";
$dane2[4] = "\t$vars[6]\t\t$service_desc\n";
$dane2[5] = "\t$vars[7]\t\t\t$check_command\n";
$dane2[6] = "\t}\n";

$today = date(dMYHi);

// przypisanie zmniennej $file nazwy pliku
$files = ["windows-hosts.cfg", "windows-services.cfg", "linux-hosts.cfg", "linux-services.cfg", "rest-hosts.cfg", "rest-services.cfg"];

if (isset($_POST['save_host'])){
	if ($usep == "windows-server"){
		$file_host = $files[0];
	}
	elseif ($usep == "linux-server") {
		$file_host = $files[2];
	}
	elseif ($usep == "own-option") {
		$file_host = $files[4];
	}
	$md5fh = md5_file($file_host);
	$pathh = "backup\\$file_host-$today.log";
	copy($file_host, $pathh);
	if ($md5fh == md5_file($pathh)){
		$back_h = "<font color='green'>OK</font>";
	}
	else
	{
		$back_h = "<font color='red'>ERROR</font>";
}
}
if (!isset($_POST['save_host'])){
	$file_host = 'No checked option';
	$back_h = 'No checked option';
	$upload_h = 'No checked option';
}


if (isset($_POST['save_service'])){
	if ($usep == "windows-server"){
		$file_service = $files[1];
	}
	elseif ($usep == "linux-server") {
		$file_service = $files[3];
	}
	elseif ($usep == "own-option") {
		$file_service = $files[5];
	}
	$md5fs = md5_file($file_service);
	$paths = "backup\\$file_service-$today.log";
	copy($file_service, $paths);
	if ($md5fs == md5_file($paths)){
		$back_s = "<font color='green'>OK</font>";
	}
	else
	{
		$back_s = "<font color='red'>ERROR</font>";
}
}
if (!isset($_POST['save_service'])){
	$file_service = 'No checked option';
	$back_s = 'No checked option';
	$upload_s = 'No checked option';
}



if (isset($_POST['save_host'])){
	$fp = fopen($file_host, "a");
	flock($fp, 2);
	for ($i=0; $i<count($dane); $i++){
		fwrite($fp, $dane[$i]);
	}
	flock($fp, 3);
	fclose($fp);
	if ($md5fh != md5_file($file_host)){
		$upload_h = "<font color='green'>OK</font>";
	}else{
		$upload_h = "<font color='red'>ERROR</font>";
}
}


if (isset($_POST['save_service'])){
$fp = fopen($file_service, "a");
flock($fp, 2);
for ($i=0; $i<count($dane2); $i++){
	fwrite($fp, $dane2[$i]);
}
flock($fp, 3);
fclose($fp);
if ($md5fs != md5_file($file_service)){
	$upload_s = "<font color='green'>OK</font>";
}else{
$upload_s = "<font color='green'>OK</font>";
}
}
?>

<table border=1>
	<tr>
		<td><strong>FILENAME</strong></td>
		<td><strong>BACKUP</strong></td>
		<td><strong>UPLOAD</strong></td>
	</tr>
	<tr>
		<td><?echo "$file_host";?></td>
		<td><?echo "$back_h";?></td>
		<td><?echo "$upload_h";?></td>
	</tr>
	<tr>
		<td><?echo "$file_service";?></td>
		<td><?echo "$back_s";?></td>
		<td><?echo "$upload_s";?></td>
	</tr>
</table>
<?
}
?>
