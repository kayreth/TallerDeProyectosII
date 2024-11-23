<?php
//MVC!
require_once '../config/core.php'; 
require_once '../controllers/CustomerController.php';
require_once '../services/CustomerService.php';      
require_once '../repository/CustomerRepository.php';  

$controller = new CustomerController($database);

$controller->handleRequest();

?>