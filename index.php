<?php
$basePath="/CIT2318/using-htaccess/";

//get full path of current URL
$url=$_SERVER["REQUEST_URI"]; 
echo "<p>URL: $url</p>";

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
	require_once("red.php");
}elseif($action == "green"){
	require_once("green.php");
}else {
    include("404-view.php");
}
?>