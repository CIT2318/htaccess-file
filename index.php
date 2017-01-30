<?php
require_once("models/film-model.php");
if(isset($_GET["action"])){
    $action=$_GET['action'];
}else{
    $action="list";
}
if ($action==="list") {
	$films=getAllFilms();
	$pageTitle="List all films";
	include("views/list-view.php");
} else if ($action==="details" && isset($_GET['id'])) {
	$film=getFilmById($_GET['id']);
	$pageTitle="Film details";
	include("views/details-view.php");
} else {
    include("views/404-view.php");
}
?>