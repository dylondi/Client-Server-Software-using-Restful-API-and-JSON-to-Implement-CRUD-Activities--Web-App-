<?php

class dbObj{
var $databaseHost = 'localhost';
var $databaseName = 'data';
var $databaseUsername = 'root';
var $databasePassword = '';
function getConnstring() {
	$con = mysqli_connect($this->databaseHost, $this->databaseUsername, $this->databasePassword, $this->databaseName);


if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
		} else {
		$this->conn = $con;
		}
		return $this->conn;
	}
}
?>