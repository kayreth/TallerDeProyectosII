<?php

class SaleService {
    private $saleRepo;

    public function __construct($database) {
        $this->saleRepo = new SaleRepository($database);
    }

    public function handleRequest($body) {
        if (!isset($body['action'])) {
            throw new Exception('La acción es requerida.');
        }

        switch ($body['action']) {
            case 'list':
                return $this->listSales();
            case 'view':
                return $this->viewSale($body);
            case 'save':
                return $this->saveSale($body);
            default:
                throw new Exception('Acción no válida.');
        }
    }

    private function listSales() {
        $sales = $this->saleRepo->listSales();
        return [
            'success' => true,
            'data' => $sales,
        ];
    }

    private function viewSale($body) {
        if (!isset($body['ventaId']) || empty($body['ventaId'])) {
            throw new Exception('El ID de la venta es obligatorio.');
        }

        $venta = $this->saleRepo->getSaleDetails($body['ventaId']);
        return [
            'success' => true,
            'data' => $venta,
        ];
    }

    private function saveSale($body) {
        if (!isset($body['clienteId'], $body['articulos']) || empty($body['articulos'])) {
            throw new Exception('Los datos de la venta son obligatorios.');
        }

        $ventaId = $this->saleRepo->createSale($body['clienteId'], $body['articulos']);
        return [
            'success' => true,
            'ventaId' => $ventaId,
        ];
    }
}
