function eliminarCategoria(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la categoría.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?accion=eliminarCategoria&id=' + id;
        }
    });
}

function eliminarProducto(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el producto.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?accion=eliminarProducto&id=' + id;
        }
    });
}

// Estado Pedido

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.estadoPedido').forEach(select => {
        select.addEventListener('change', () => {
            const id = select.dataset.id;
            const nuevoEstado = select.value;

            fetch('index.php?accion=actualizarEstadoPedido', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ id, estado: nuevoEstado })
            })
            .then(res => res.json())
            .then(respuesta => {
                Swal.fire({
                    title: respuesta.title,
                    text: respuesta.text,
                    icon: respuesta.icon,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                console.error("Error al actualizar estado:", error);
                Swal.fire('Error', 'No se pudo actualizar el estado del pedido', 'error');
            });
        });
    });
});

// Filtro y Busqueda

document.getElementById('filtro-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const buscar = document.getElementById('buscar').value;
    const categoria = document.getElementById('categoria').value;
    fetch('ajax/catalogo-filtrado.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ buscar, categoria })
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById('catalogo-resultados').innerHTML = data;
    });
});


