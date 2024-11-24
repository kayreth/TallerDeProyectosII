<?php
//back
require_once 'backend/config/core.php';
require_once 'backend/repository/InventoryRepository.php';

//$inventoryRepo = new InventoryRepository($database);
//$inventories = $inventoryRepo->getAllInventoryMovements();

//front
include 'views/templates/head.php';
include 'views/templates/navbar.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Movimientos de Inventario</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Movimiento</th>
                <th>Artículo</th>
                <th>Tipo de Movimiento</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventories as $inventory): ?>
                <tr>
                    <td><?= htmlspecialchars($inventory['id']) ?></td>
                    <td><?= htmlspecialchars($inventory['articulo']) ?></td>
                    <td><?= htmlspecialchars($inventory['tipo_movimiento']) ?></td>
                    <td><?= htmlspecialchars($inventory['cantidad']) ?></td>
                    <td><?= htmlspecialchars($inventory['fecha_movimiento']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include 'views/templates/footer.php';
?>
