<?php

class SaleController {
    private $saleService;

    public function __construct($database) {
        $this->saleService = new SaleService($database);
    }

    public function handleRequest() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido.');
            }

            $body = json_decode(file_get_contents('php://input'), true);
            if (!$body) {
                throw new Exception('Cuerpo de la solicitud no válido.');
            }

            $response = $this->saleService->handleRequest($body);
            http_response_code(200);
            echo json_encode($response);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
