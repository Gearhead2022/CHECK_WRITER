
<?php

$open_file = $_REQUEST['attachment'];

	echo "<script>alert('erererre');</script>";

	header("Content-Length: " . filesize ("../files/attachments/".$_REQUEST['attachment']."")); 
	header("Content-type: application/pdf"); 
	header("Content-disposition: Inline;     
	filename=".basename("../files/attachments/".$_REQUEST['attachment'].""));
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	$filepath = readfile("../files/attachments/".$_REQUEST['attachment']."");



?>