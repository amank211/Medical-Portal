<?php
if($_SERVER["REQUEST_METHOD"] == "GET"){
	$dt = $_GET['dt'];
	$tm = $_GET['tm'];
	$doc = $_GET['doc'];


	echo "<option> " . $dt . "</option>";
	echo "<option> " . $tm . "</option>";
	echo "<option> " . $doc . "</option>";
}
?>