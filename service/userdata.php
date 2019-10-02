<?php

//include db connection 
include("connect.php");
//create database object 
$db = new dbObj();
$connection =  $db->getConnstring();
//$_SERVER method to access action information
$request_method=$_SERVER["REQUEST_METHOD"];


switch($request_method)
{
	//GET request to retrieve all user data
	case 'GET':
		//if id was entered  
		if(!empty($_GET["id"]))
		{
			$id=intval($_GET["id"]);
			//method called retrieve data from the row of the id entered 
			get_userdata($id);
		}
		//else if no id was entered
		else
		{
			//method called to retrieve all data
			get_userdata();
		}
		break;
	//POST request if user wants to create a new row
	case 'POST':
	//method called to create row
	insert_userdata();
	break;
	//PUT request if user wants to edit a row
	case 'PUT':
		$id=intval($_GET["id"]);
		//method called to edit data of row containing the id entered by user
		update_userdata($id);
		break;
	//DELETE request if user wants to delete a row
	case 'DELETE':
		// Delete Product
		$id=intval($_GET["id"]);
		//method called to delete row containing the id entered by user 
		delete_userdata($id);
		break;

	default:
		// Invalid Request Method
		header("HTTP/1.0 405 Method Not Allowed");
		break;
}

//method to retrieve data from db 
function get_userdata($id=0)
{
	global $connection;
	//storing the json string(data) sent in the request 
	$d = $_GET['json'];
	//decodes the json string into array of data
	$data = json_decode($d, true);
	$id=$data['id'];
	//sql selecting all from db 
	$query="SELECT * FROM userdata";
	//if there are more than 0 rows
	if($id != 0)
	{
		//sql to find row specified by user
		$query.=" WHERE id=".$id." LIMIT 1";
	}
	//creating variable which will be used to send data back 
	$response=array();
	$result=mysqli_query($connection, $query);
	//while scanning through row of data requested
	while($row=mysqli_fetch_array($result))
	{
		//add data retrieved into $response variable 
		$response[]=$row;
	}
	header('Content-Type: application/json');
	//json_encode() method converts arrays of data into json string which is echoed back to index.php
	echo json_encode($response);
}

//method to create new row in db 
function insert_userdata()
{
	global $connection;

	//storing the json string(data) sent in the request 
	$d = $_GET['json'];
	//decodes the json string into array of data
	$data = json_decode($d, true);
	//storing the data sent in the POST request 
	$date = date('Y-m-d');
	$name=$data["name"];
	$url=$data["url"];
	$description=$data["description"];
	//sql to create new row 
	echo $query="INSERT INTO userdata SET date='".$date."', name='".$name."', url='".$url."', description='".$description."'";
	//if sql create was successful
	if(mysqli_query($connection, $query))
	{
		$response=array(
			'status' => 1,
			'status_message' =>'Data Added Successfully.'
		);
	}
	//if sql create was not successful
	else
	{
		$response=array(
			'status' => 0,
			'status_message' =>'Data Addition Failed.'
		);
	}
	header('Content-Type: application/json');
	//json_encode() method converts arrays of data into json string which is echoed back to index.php
	echo json_encode($response);
}


function update_userdata($id)
{
	global $connection;
	//storing the json string(data) sent in the request
	$d = $_GET['json'];
	//decodes the json string into array of data
	$data = json_decode($d, true);
	//storing the data sent in the PUT request 
	$date = date('Y-m-d');
	$name=$data["name"];
	$url=$data["url"];
	$id=$data["id"];
	$description=$data["description"];
	//sql to update a row 
	$query="UPDATE userdata SET date='".$date."', name='".$name."', url='".$url."', description='".$description."' WHERE id=".$id;
	//if sql update was successful
	if(mysqli_query($connection, $query))
	{
		$response=array(
			'status' => 1,
			'status_message' =>'Data Updated Successfully.'
		);
	}
	//if sql update was not successful
	else
	{
		$response=array(
			'status' => 0,
			'status_message' =>'Data Updation Failed.'
		);
	}
	header('Content-Type: application/json');
	//json_encode() method converts arrays of data into json string which is echoed back to index.php
	echo json_encode($response);
}

function delete_userdata($id)
{
	
	global $connection;
	//storing the json string(data) sent in the request
	$d = $_GET['json'];
	//decodes the json string into array of data
	$data = json_decode($d, true);
	$id=$data["id"];
	//sql to delete a row 
	$query="DELETE FROM userdata WHERE id=".$id;
	//if sql delete was successful
	if(mysqli_query($connection, $query))
	{
		$response=array(
			'status' => 1,
			'status_message' =>'Data Deleted Successfully.'
		);
	}
	//if sql delete was successful
	else
	{
		$response=array(
			'status' => 0,
			'status_message' =>'Data Deletion Failed.'
		);
	}
	header('Content-Type: application/json');
	//json_encode() method converts arrays of data into json string which is echoed back to index.php
	echo json_encode($response);
}


?>