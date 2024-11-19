<?php
include 'views/templates/head.php';
include 'views/templates/navbar.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Registrar Nueva Venta</h1>
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Seleccionar Cliente</label>
            <input type="number" class="form-control" id="cliente_id" name="cliente_id" placeholder="ID del Cliente" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo de Comprobante</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tipo_comprobante" id="ticket" value="Ticket" required>
                <label class="form-check-label" for="ticket">Ticket</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tipo_comprobante" id="factura" value="Factura">
                <label class="form-check-label" for="factura">Factura</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="articulo_id" class="form-label">Selección de Artículos</label>
            <input type="number" class="form-control" id="articulo_id" name="articulo_id" placeholder="ID del Artículo" required>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad del Artículo" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Venta</button>
    </form>
</div>

<?php
include 'views/templates/footer.php';
?>
