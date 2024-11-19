<?php
$articles = array();
include 'views/templates/head.php';
include 'views/templates/navbar.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Lista de Artículos</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['id']) ?></td>
                    <td><?= htmlspecialchars($article['name']) ?></td>
                    <td><?= htmlspecialchars($article['category']) ?></td>
                    <td><?= htmlspecialchars($article['price']) ?></td>
                    <td><?= htmlspecialchars($article['stock']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include 'views/templates/footer.php';
?>
