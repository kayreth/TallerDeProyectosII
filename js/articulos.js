document.addEventListener('DOMContentLoaded', function () {
    const articleModal = new bootstrap.Modal(document.getElementById('articleModal'));

    document.getElementById('addArticleBtn').addEventListener('click', function () {
        document.getElementById('articleModalLabel').textContent = 'Agregar Artículo';
        document.getElementById('articleForm').reset();
        document.getElementById('articleID').value = '';
    });

    // EDIT MODE
    document.querySelectorAll('.editArticleBtn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            fetch('backend/routes/article.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'view',
                    id: id
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); 
            })
            .then(data => {
                if (data.success && data.data) {
                    const article = data.data;
                    document.getElementById('articleModalLabel').textContent = 'Editar Artículo';
                    document.getElementById('articleID').value = article.ArticuloID;
                    document.getElementById('codigo').value = article.Codigo;
                    document.getElementById('nombre').value = article.Nombre;
                    document.getElementById('categoria').value = article.Categoria;
                    document.getElementById('precio').value = article.Precio;
                    document.getElementById('stock').value = article.Stock;

                    const articleModal = new bootstrap.Modal(document.getElementById('articleModal'));
                    articleModal.show();
                } else {
                    alert(data.error || 'No se encontró el artículo.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al obtener los detalles del artículo.');
            });
        });
    });


    document.getElementById('articleForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const payload = {
            action: 'save',
            id: formData.get('id') || null,
            codigo: formData.get('codigo'),
            nombre: formData.get('nombre'),
            categoria: formData.get('categoria'),
            precio: formData.get('precio'),
            stock: formData.get('stock')
        };

        fetch('backend/routes/article.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload();
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al guardar el artículo.');
        });
    });

    document.querySelectorAll('.deleteArticleBtn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            if (confirm('¿Estás seguro de que deseas borrar este artículo?')) {
                fetch('backend/routes/article.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'delete', id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        location.reload();
                    } else {
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al borrar el artículo.');
                });
            }
        });
    });

    document.getElementById('ArticleModal').addEventListener('hidden.bs.modal', function () {
    document.body.classList.remove('modal-open');
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }

    });

});