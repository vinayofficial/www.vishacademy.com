<?php 
	// Frontend DB connector
	
	//Defining constants
	define("HOSTNAME","localhost");
	define("USERNAME","root");
	define("PASSWORD","");
	define("DBNAME","visharzq_vishac");
	define("SITE_PATH","http://localhost/www.vishacademy.com/");
	
	//connecting to database
	$dbcon = mysqli_connect("HOSTNAME","USERNAME","PASSWORD","DBNAME") or die("can not connect to database");
?>