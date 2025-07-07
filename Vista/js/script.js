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

function cambiarEstadoPedido(id) {
    Swal.fire({
        title: '¿Marcar como enviado?',
        text: 'El estado del pedido se actualizará.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, marcar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?accion=cambiarEstadoPedido&id=' + id;
        }
    });
}

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