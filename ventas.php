<?php
require_once 'backend/config/database.php';
require_once 'backend/repository/SaleRepository.php';

include 'views/templates/head.php';
include 'views/templates/navbar.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Gestión de Facturas</h1>

    <div class="row">
        <div class="col-12">
            <form method="POST">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="cliente_id" class="form-label">Seleccionar Cliente</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cliente_id" name="cliente_id" placeholder="Cliente" readonly required>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#clientModal">Buscar Cliente</button>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tipo de Factura</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="tipo_factura" id="factura_a" value="Factura A" required>
                                <label class="form-check-label" for="factura_a">Factura A</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_factura" id="factura_b" value="Factura B">
                                <label class="form-check-label" for="factura_b">Factura B</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Artículos</label>
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#articleModal">Agregar Artículo</button>
                    </div>

                    <div class="col-md-3 text-end">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-success me-2">Registrar Factura</button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#salesModal">Ver Ventas</button>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th class='td-nombre'>Nombre</th>
                                <th class='td-cantidad'>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="articleTable">
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5" class="text-end"><strong>Total:</strong></td>
                            <td id="totalGeneral">0.00</td>
                            <td></td>
                          </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Seleccionar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="articleModalLabel">Seleccionar Artículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="salesModal" tabindex="-1" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel">Ventas Registradas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td><?= htmlspecialchars($sale['VentaID']) ?></td>
                                <td><?= htmlspecialchars($sale['ClienteID']) ?></td>
                                <td><?= htmlspecialchars($sale['FechaVenta']) ?></td>
                                <td><?= htmlspecialchars($sale['Total']) ?></td>
                                <td>
                                    <button 
                                        class="btn btn-info viewSaleDetailBtn" 
                                        data-id="<?= $sale['VentaID'] ?>" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#saleDetailModal">Ver Detalle</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="js/ventas.js"></script>
<?php
include 'views/templates/footer.php';
?>
