<?php

//back
require_once 'backend/config/core.php';
require_once 'backend/repository/ArticleRepository.php';

$articleRepo = new ArticleRepository($database);
$articles = $articleRepo->getAllArticles();

//front
include 'views/templates/head.php';
include 'views/templates/navbar.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Lista de Artículos</h1>
    <button class="btn btn-primary mb-3" id="addArticleBtn" data-bs-toggle="modal" data-bs-target="#articleModal">
        Agregar Artículo
    </button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['ArticuloID']) ?></td>
                    <td><?= htmlspecialchars($article['Codigo']) ?></td>
                    <td><?= htmlspecialchars($article['Nombre']) ?></td>
                    <td><?= htmlspecialchars($article['Categoria']) ?></td>
                    <td><?= htmlspecialchars($article['Precio']) ?></td>
                    <td><?= htmlspecialchars($article['Stock']) ?></td>
                    <td>
                        <button 
                            class="btn btn-success btn-sm editArticleBtn" 
                            data-id="<?= $article['ArticuloID'] ?>" 
                            data-bs-toggle="modal" 
                            data-bs-target="#articleModal">Editar</button>
                        <button 
                            class="btn btn-danger btn-sm deleteArticleBtn" 
                            data-id="<?= $article['ArticuloID'] ?>">Borrar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="articleForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="articleModalLabel">Agregar Artículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="articleID" name="id">
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
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

<script src="js/articulos.js"></script>
<?php
include 'views/templates/footer.php';
?>
