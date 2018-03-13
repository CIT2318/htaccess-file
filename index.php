<?php
$basePath="/CIT2318/using-htaccess/";
echo "<p>Base Path: ".$basePath."</p>";

//get full path of current URL
$url=$_SERVER["REQUEST_URI"]; 
echo "<p>URL: ".$url."</p>";

//get the end components of the path
$shortPath = substr($url, strlen($basePath)); 
echo "<p>Short path: $shortPath</p>";

//split this string using '/' as a delimiter
$urlArray=explode("/", $shortPath); 
print_r($urlArray);

//the first element in the array is the action to use
$action=$urlArray[0];
echo "<p>Action = ".$action."</p>";



if($action == "red"){
	require_once("pages/red.php");
}else if($action == "green"){
	require_once("pages/green.php");
}else if($action == "blue"){
	$num1 = $urlArray[1];
	$num2 = $urlArray[2];
	require_once("pages/blue.php");
}

?>