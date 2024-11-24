<?php

//back
require_once 'backend/config/core.php';
require_once 'backend/repository/CustomerRepository.php';

$customerRepo = new CustomerRepository($database);
$customers = $customerRepo->getAllCustomers();

//front
include 'views/templates/head.php';
include 'views/templates/navbar.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Lista de Clientes</h1>
    <button class="btn btn-primary mb-3" id="addCustomerBtn" data-bs-toggle="modal" data-bs-target="#customerModal">Agregar Cliente</button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= htmlspecialchars($customer['ClienteID']) ?></td>
                    <td><?= htmlspecialchars($customer['Nombre']) ?></td>
                    <td><?= htmlspecialchars($customer['Email']) ?></td>
                    <td><?= htmlspecialchars($customer['Telefono']) ?></td>
                    <td><?= htmlspecialchars($customer['Direccion']) ?></td>
                    <td>
                        <button 
                            class="btn btn-success btn-sm editCustomerBtn" 
                            data-id="<?= $customer['ClienteID'] ?>" 
                            data-bs-toggle="modal" 
                            data-bs-target="#customerModal">Editar</button>
                        <button 
                            class="btn btn-danger btn-sm deleteCustomerBtn" 
                            data-id="<?= $customer['ClienteID'] ?>">Borrar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal único para agregar y editar cliente -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="customerForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="clienteID" name="id">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="js/clientes.js"></script>

<?php
include 'views/templates/footer.php';
?>
