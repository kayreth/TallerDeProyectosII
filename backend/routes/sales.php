<?php

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once '../config/core.php'; 
require_once '../controllers/SaleController.php';
require_once '../services/SaleService.php';
require_once '../repository/SaleRepository.php';


$controller = new SaleController($database);
$controller->handleRequest();
?>
