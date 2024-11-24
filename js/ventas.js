
document.addEventListener('DOMContentLoaded', function () {

    //----------------- ARTICULOS -------------------

    const articleModalTableBody = document.querySelector('#articleModal tbody');
    const articleButton = document.querySelector('button[data-bs-target="#articleModal"]');
    const totalGeneralElement = document.getElementById('totalGeneral');

    articleButton.addEventListener('click', function () {
        articleModalTableBody.innerHTML = '<tr><td colspan="6">Cargando artículos...</td></tr>';

       fetch('backend/routes/article.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'list' }) 
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    articleModalTableBody.innerHTML = data.data.map(article => `
                        <tr>
                            <td>${article.ArticuloID}</td>
                            <td>${article.Codigo}</td>
                            <td>${article.Nombre}</td>
                            <td>${article.Stock}</td>
                            <td>${article.Precio}</td>
                            <td>
                                <button 
                                    class="btn btn-primary selectArticleBtn" 
                                    data-codigo="${article.Codigo}" 
                                    data-id="${article.ArticuloID}" 
                                    data-name="${article.Nombre}" 
                                    data-price="${article.Precio}">Agregar</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    articleModalTableBody.innerHTML = '<tr><td colspan="6">No se pudieron obtener los artículos.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                articleModalTableBody.innerHTML = '<tr><td colspan="6">Ocurrió un error al obtener los artículos.</td></tr>';
            });
        });

        document.querySelector('#articleModal').addEventListener('click', function (event) {
            if (event.target.classList.contains('selectArticleBtn')) {
                const button = event.target;
                const articleID = button.getAttribute('data-id');
                const articleCode = button.getAttribute('data-codigo');
                const articleName = button.getAttribute('data-name');
                const articlePrice = button.getAttribute('data-price');

                const articleTable = document.getElementById('articleTable');
                const newRow = `
                    <tr>
                        <td>${articleID}</td>
                        <td>${articleCode}</td>
                        <td class='td-nombre'>${articleName}</td>
                        <td class='td-cantidad'>
                            <input type="number" class="form-control cantidad" min="1" value="1" data-price="${articlePrice}" required>
                        </td>
                        <td>${articlePrice}</td>
                        <td class="subtotal">${articlePrice}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRowBtn">Eliminar</button>
                        </td>
                    </tr>
                `;
                articleTable.insertAdjacentHTML('beforeend', newRow);
                
                updateTotalGeneral();

                const articleModal = bootstrap.Modal.getInstance(document.getElementById('articleModal'));
                articleModal.hide();
            }
        });

   
    
    const articleTable = document.getElementById('articleTable');


    articleTable.addEventListener('input', function (event) {
    if (event.target.classList.contains('cantidad')) {
        const row = event.target.closest('tr');
        const cantidad = event.target.value;
        const price = event.target.getAttribute('data-price');
        const subtotalElement = row.querySelector('.subtotal');

        const subtotal = (cantidad * price).toFixed(2);
        subtotalElement.textContent = subtotal;
        updateTotalGeneral();
    }
    });

    function updateTotalGeneral() {
        let total = 0;
        document.querySelectorAll('#articleTable .subtotal').forEach(subtotalElement => {
            const subtotal = parseFloat(subtotalElement.textContent) || 0;
            total += subtotal;
        });

        totalGeneralElement.textContent = total.toFixed(2);
    }

    articleTable.addEventListener('click', function (event) {
        if (event.target.classList.contains('removeRowBtn')) {
            event.target.closest('tr').remove();
            updateTotalGeneral();
        }
    });


     //-------------- FIN ARTICULOS -------------------




     //-------------- CLIENTES ------------------------

     const clientModalTableBody = document.querySelector('#clientModal tbody');
    const searchClientButton = document.querySelector('button[data-bs-target="#clientModal"]'); 
    const clienteInput = document.getElementById('cliente_id'); 
    const inputGroup = document.querySelector('.input-group'); 

    searchClientButton.addEventListener('click', function () {
        clientModalTableBody.innerHTML = '<tr><td colspan="5">Cargando clientes...</td></tr>';

        fetch('backend/routes/customer.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'list' }) 
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                clientModalTableBody.innerHTML = data.data.map(client => `
                    <tr>
                        <td>${client.ClienteID}</td>
                        <td>${client.Nombre}</td>
                        <td>${client.Email}</td>
                        <td>${client.Telefono}</td>
                        <td>
                            <button 
                                class="btn btn-primary selectClientBtn" 
                                data-id="${client.ClienteID}" 
                                data-name="${client.Nombre}">Seleccionar</button>
                        </td>
                    </tr>
                `).join('');
            } else {
                clientModalTableBody.innerHTML = '<tr><td colspan="5">No se encontraron clientes.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            clientModalTableBody.innerHTML = '<tr><td colspan="5">Ocurrió un error al obtener los clientes.</td></tr>';
        });
    });

    clientModalTableBody.addEventListener('click', function (event) {
        if (event.target.classList.contains('selectClientBtn')) {
            const button = event.target;
            const clienteID = button.getAttribute('data-id');
            const clienteName = button.getAttribute('data-name');

            clienteInput.value = `${clienteID} - ${clienteName}`;
            searchClientButton.classList.add('d-none'); 

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger';
            removeButton.textContent = 'Eliminar Cliente';
            removeButton.id = 'removeClientButton';
            inputGroup.appendChild(removeButton);

            const clientModal = bootstrap.Modal.getInstance(document.getElementById('clientModal'));
            clientModal.hide();

            removeButton.addEventListener('click', function () {
                clienteInput.value = ''; 
                removeButton.remove(); 
                searchClientButton.classList.remove('d-none'); 
            });
        }
    });

    //------------FIN  CLIENTES ------------------------


    //---------------VENTAS-----------------------------
    
    const saveSaleButton = document.querySelector('.btn-success'); 

    saveSaleButton.addEventListener('click', function (event) {
        event.preventDefault();

        const clienteInput = document.getElementById('cliente_id').value.trim();
        if (!clienteInput) {
            alert('Por favor, selecciona un cliente.');
            return;
        }

        const tipoFactura = document.querySelector('input[name="tipo_factura"]:checked');
        if (!tipoFactura) {
            alert('Por favor, selecciona un tipo de factura.');
            return;
        }

        const articles = [];
        document.querySelectorAll('#articleTable tr').forEach(row => {
            const articuloID = row.children[0].textContent.trim();
            const cantidad = row.querySelector('.cantidad').value.trim();
            const precioUnitario = row.querySelector('.cantidad').getAttribute('data-price');

            if (articuloID && cantidad > 0) {
                articles.push({
                    articuloID,
                    cantidad,
                    precioUnitario
                });
            }
        });

        if (articles.length === 0) {
            alert('Por favor, agrega al menos un artículo.');
            return;
        }

        const data = {
            action: 'save',
            clienteId: clienteInput.split(' ')[0], 
            tipoFactura: tipoFactura.value,
            articulos: articles
        };

        fetch('backend/routes/sales.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Venta registrada exitosamente.');
                location.reload(); 
            } else {
                alert('Error al registrar la venta: ' + (result.error || ''));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al registrar la venta.');
        });
    });

    //---------------VENTAS-----------------------------

    
    
    //----------------- LISTADO Y DETALLE DE VENTAS -------------------

    const salesModalTableBody = document.querySelector('#salesModal tbody');
    const viewSalesButton = document.querySelector('button[data-bs-target="#salesModal"]'); 

    viewSalesButton.addEventListener('click', function () {
        salesModalTableBody.innerHTML = '<tr><td colspan="5">Cargando ventas...</td></tr>';

        fetch('backend/routes/sales.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'list' }) 
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                salesModalTableBody.innerHTML = data.data.map(sale => `
                    <tr>
                        <td>${sale.VentaID}</td>
                        <td>${sale.Cliente}</td>
                        <td>${sale.FechaVenta}</td>
                        <td>${sale.Total}</td>
                        <td>
                            <button 
                                class="btn btn-info viewSaleDetailBtn" 
                                data-id="${sale.VentaID}">Ver Detalle</button>
                        </td>
                    </tr>
                `).join('');

                assignViewSaleDetailEvents();
            } else {
                salesModalTableBody.innerHTML = '<tr><td colspan="5">No se encontraron ventas registradas.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            salesModalTableBody.innerHTML = '<tr><td colspan="5">Ocurrió un error al listar las ventas.</td></tr>';
        });
    });

    function assignViewSaleDetailEvents() {
        document.querySelectorAll('.viewSaleDetailBtn').forEach(button => {
            button.addEventListener('click', function () {
                const ventaID = this.getAttribute('data-id');

                salesModalTableBody.innerHTML = '<tr><td colspan="5">Cargando detalles de la venta...</td></tr>';

                fetch('backend/routes/sales.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'view', ventaId: ventaID }) 
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        const sale = data.data;

                        const articleRows = sale.articulos.map(article => `
                            <tr>
                                <td>${article.ArticuloID}</td>
                                <td>${article.Nombre}</td>
                                <td>${article.Cantidad}</td>
                                <td>${article.PrecioUnitario}</td>
                                <td>${(article.Cantidad * article.PrecioUnitario).toFixed(2)}</td>
                            </tr>
                        `).join('');

                        salesModalTableBody.innerHTML = `
                            <tr>
                                <td colspan="5">
                                    <strong>Cliente:</strong> ${sale.Cliente} <br>
                                    <strong>Fecha:</strong> ${sale.FechaVenta} <br>
                                    <strong>Total:</strong> $${sale.Total}
                                </td>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                            ${articleRows}
                        `;
                    } else {
                        salesModalTableBody.innerHTML = '<tr><td colspan="5">No se encontraron detalles para esta venta.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    salesModalTableBody.innerHTML = '<tr><td colspan="5">Ocurrió un error al obtener los detalles de la venta.</td></tr>';
                });
            });
        });
    }

    //----------------- FIN LISTADO Y DETALLE DE VENTAS -------------------


    //BUGFIXS
    document.getElementById('salesModal').addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    document.getElementById('clientModal').addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    document.getElementById('articleModal').addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

});
