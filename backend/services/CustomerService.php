<?php

class CustomerService {
    private $customerRepo;

    public function __construct($database) {
        $this->customerRepo = new CustomerRepository($database);
    }

    public function handleRequest($body) {
        if (!isset($body['action']))
            throw new Exception('La acción es requerida.');


        switch ($body['action']) {
            case 'delete':
                return $this->deleteCustomer($body);
            case 'view': 
                return $this->viewCustomer($body);
            case 'save': 
                return $this->saveCustomer($body);
            case 'list':
                return $this->getAllCustomers();
            default:
                throw new Exception('Acción no válida: ' . $body['action']);
        }
    }

    private function getAllCustomers() {
        $clients = $this->customerRepo->getAllCustomers();
        return [
            'success' => true,
            'data' => $clients,
        ];
    }

    private function deleteCustomer($body) {
        if (!isset($body['id']) || empty($body['id']))
            throw new Exception('El ID del cliente es obligatorio para borrar.');


        $id = intval($body['id']);
        $result = $this->customerRepo->deleteCustomerById($id);

        if ($result) {
            return ['success' => 'Cliente eliminado correctamente.'];
        } else {
            throw new Exception('No se pudo borrar el cliente. Verifica si el ID es válido.');
        }
    }

    private function viewCustomer($body) {
        if (!isset($body['id']) || empty($body['id'])) {
            throw new Exception('El ID del cliente es obligatorio.');
        }

        $id = intval($body['id']);
        $customer = $this->customerRepo->getCustomerById($id);

        if ($customer) {
            return $customer;
        } else {
            throw new Exception('No se encontró el cliente con el ID especificado.');
        }
    }

    private function saveCustomer($body) {
        if (!isset($body['nombre'], $body['email'], $body['telefono'], $body['direccion'])) {
            throw new Exception('Todos los campos son obligatorios para guardar.');
        }

        $customerData = [
            'id' => $body['id'] ?? null,
            'nombre' => $body['nombre'],
            'email' => $body['email'],
            'telefono' => $body['telefono'],
            'direccion' => $body['direccion'],
        ];

        if (empty($customerData['id'])) {
            $result = $this->customerRepo->createCustomer($customerData);
            if ($result) {
                return ['success' => 'Cliente creado correctamente.'];
            } else {
                throw new Exception('Error al crear el cliente.');
            }
        } else {
            $result = $this->customerRepo->updateCustomer($customerData);
            if ($result) {
                return ['success' => 'Cliente actualizado correctamente.'];
            } else {
                throw new Exception('Error al actualizar el cliente.');
            }
        }
    }
}
