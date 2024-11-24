document.addEventListener('DOMContentLoaded', function () {
    const customerModal = new bootstrap.Modal(document.getElementById('customerModal'));
    const customerForm = document.getElementById('customerForm');
    let isEditMode = false; 

    document.getElementById('addCustomerBtn').addEventListener('click', function () {
        isEditMode = false;
        document.getElementById('customerModalLabel').textContent = 'Agregar Cliente';
        customerForm.reset();
        document.getElementById('clienteID').value = '';
    });

    // EDIT MODE
    document.querySelectorAll('.editCustomerBtn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            fetch('backend/routes/customer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
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
                if (data.ClienteID) {
                    document.getElementById('clienteID').value = data.ClienteID;
                    document.getElementById('nombre').value = data.Nombre;
                    document.getElementById('email').value = data.Email;
                    document.getElementById('telefono').value = data.Telefono;
                    document.getElementById('direccion').value = data.Direccion;
                    
                    const customerModal = new bootstrap.Modal(document.getElementById('customerModal'));
                    customerModal.show();
                } else {
                    alert('No se encontraron detalles para este cliente.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al obtener los detalles del cliente.');
            });
        });
    });


    document.getElementById('customerForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const action = 'save'; 
            const payload = {
                action: action,
                id: formData.get('id') || null, 
                nombre: formData.get('nombre'),
                email: formData.get('email'),
                telefono: formData.get('telefono'),
                direccion: formData.get('direccion'),
            };

            fetch('backend/routes/customer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
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
                alert('Ocurrió un error al guardar el cliente.');
            });
     });


    document.querySelectorAll('.deleteCustomerBtn').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        if (confirm('¿Estás seguro de que deseas borrar este cliente?')) {
            fetch('backend/routes/customer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'delete', 
                    id: id 
                })
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
                alert('Ocurrió un error al intentar borrar el cliente.');
            });
        }
      });
    });

 document.getElementById('customerModal').addEventListener('hidden.bs.modal', function () {
    document.body.classList.remove('modal-open');
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
 });

});