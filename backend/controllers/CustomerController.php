<?php

class CustomerController {
    private $customerService;

    public function __construct($database) {
        $this->customerService = new CustomerService($database);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            throwResourceError('Método no permitido.');


        $body = json_decode(file_get_contents('php://input'), true);
        
        if(!$body) 
           throwResourceError('Cuerpo de la solicitud no válido.');

        try {
            $response = $this->customerService->handleRequest($body);
            http_response_code(200);
            echo json_encode($response);
        } catch (Exception $e) {
            http_response_code(400); 
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
