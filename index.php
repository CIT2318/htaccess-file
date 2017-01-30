
<?php

require_once("models/film-model.php");
$baseURL="http://localhost/CIT2318/htaccess/";
$basePath="/CIT2318/htaccess/";

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
echo "<p>$action</p>";

if ($action==="list") {
	$films=getAllFilms();
	$pageTitle="List all films";
	include("views/list-view.php");
} else if ($action==="details" && isset($urlArray[1])) {
	$film=getFilmById($urlArray[1]);
	$pageTitle="Film details";
	include("views/details-view.php");
} else {
    include("views/404-view.php");
}


?>
