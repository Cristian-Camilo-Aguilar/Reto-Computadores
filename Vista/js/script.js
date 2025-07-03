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
