<?php
require_once 'backend/config/database.php';
require_once 'backend/repository/CustomerRepository.php';

$database = new Database();
$customerRepo = new CustomerRepository($database);
$customers = $customerRepo->getAllCustomers();
?>

<div class="container mt-5">
        <h1 class="mb-4">Lista de Clientes</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= htmlspecialchars($customer['id']) ?></td>
                        <td><?= htmlspecialchars($customer['name']) ?></td>
                        <td><?= htmlspecialchars($customer['email']) ?></td>
                        <td><?= htmlspecialchars($customer['phone']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


<?php
include 'views/templates/footer.php';
?>

