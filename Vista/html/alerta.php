<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
    icon: "<?php echo $_GET['tipo'] ?? 'info'; ?>",
    title: "<?php echo $_GET['msg'] ?? 'Mensaje'; ?>",
    showConfirmButton: false,
    timer: 1800
    }).then(() => {
        window.location.href = "<?php echo $_GET['redir'] ?? 'index.php'; ?>";
    });
</script>
</body>
</html>
