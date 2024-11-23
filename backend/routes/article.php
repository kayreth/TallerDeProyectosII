<?php
//MVC!
require_once '../config/core.php'; 
require_once '../controllers/ArticleController.php';
require_once '../services/ArticleService.php';      
require_once '../repository/ArticleRepository.php';  

$controller = new ArticleController($database);

$controller->handleRequest();

?>