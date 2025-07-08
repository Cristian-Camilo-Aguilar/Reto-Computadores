# TIENDA DE TENIS

Este proyecto es una aplicación web desarrollada en **PHP** y **MySQL** para la gestión, venta y visualización dinámica de computadores. Diferencia claramente entre usuarios administradores y clientes, con funcionalidades adaptadas a cada rol y una experiencia interactiva en ambas interfaces.

---

## Funcionalidades principales

### Para clientes
- **Registro seguro:** Alta de usuarios clientes con contraseñas encriptadas con `password_hash`.
- **Inicio de sesión validado por rol:** Solo los usuarios con rol `"cliente"` acceden al entorno de compra.
- **Catálogo interactivo:**
  - Visualización paginada de productos con filtros por nombre y categoría.
  - Carrusel de imágenes por producto con Bootstrap.
  - Filtros dinámicos integrados al sistema de navegación.
- **Ver producto:** Vista detallada con imágenes, descripción, precio y especificaciones.
- **Agregar al carrito:** Disponible solo si el cliente ha iniciado sesión; caso contrario se muestra un SweetAlert informativo.
- **Gestión de pedidos personales:** Acceso a pedidos realizados, carrito actual y funcionalidad para vaciar carrito.

### Para administradores
- **Inicio de sesión exclusivo:** Solo usuarios con rol `"admin"` acceden al panel de control.
- **Panel administrativo completo:**
  - Gestión de productos: crear, modificar, visualizar.
  - Filtrado AJAX y edición del estado de pedidos con recarga dinámica.
  - Vista de productos con opción "Ver producto" para inspección rápida.
- **Gestión de categorías:** Creación de nuevas categorías. Eliminación controlada (no se permite si tiene productos asignados).
- **Gestión de pedidos globales:** Visualización de todos los pedidos recibidos por clientes.

---

## Seguridad
- **Contraseñas protegidas:** Uso de `password_hash` y `password_verify`.
- **Control por rol:** Toda sesión se valida según su tipo (`cliente` o `admin`) antes de mostrar opciones o vistas exclusivas.
- **Protección de rutas:** Redirección automática si el usuario intenta acceder a vistas restringidas sin iniciar sesión.
- **Validación de imágenes:** Solo se aceptan archivos JPG y PNG para los productos.

---

## Tecnologías utilizadas

| Área            | Tecnologías                          |
|----------------|--------------------------------------|
| Backend         | PHP (POO), MySQL, MVC básico         |
| Frontend        | HTML5, CSS3, Bootstrap 5             |
| Interactividad  | JavaScript, SweetAlert2, AJAX        |
| UX/UI           | Diseño responsivo, vistas por rol    |

---

## Estructura del proyecto

- `/Controlador` → Flujo principal del sistema (acciones).
- `/Modelo` → Acceso a datos y lógica de negocio.
- `/Vista/html` → Vistas públicas, privadas y adaptativas por rol.
- `/Vista/css` → Estilos personalizados.
- `/Vista/js` → Scripts JS para interactividad.
- `/uploads` → Imágenes de productos.

---

## Instalación y ejecución

1. Clona el repositorio en tu entorno local (XAMPP/WAMP).
2. Importa la base de datos desde el archivo SQL incluido.
3. Configura los datos de conexión en `Modelo/Conexion.php`.
4. Asegúrate de que la carpeta `/uploads` tiene permisos de escritura.
5. Accede al sistema desde `index.php`.

---

## Notas adicionales

- La sesión de usuario se valida antes de mostrar botones como "Agregar al carrito" o "Solicitar compra".
- El sistema de paginación se adapta a filtros activos (nombre y categoría).
- Los administradores deben ser creados manualmente en la base de datos.
- Los mensajes de éxito y error están integrados con alertas SweetAlert2 para mejorar la experiencia.

