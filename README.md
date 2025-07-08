# TIENDA DE TENIS

Este proyecto es una aplicación web desarrollada en PHP y MySQL para la gestión y venta de tenis deportivos. Permite la administración de productos, categorías, usuarios y pedidos, diferenciando entre usuarios administradores y clientes.

## Funcionalidades principales

### Para clientes
- **Registro de clientes:** Los usuarios pueden registrarse como clientes, con contraseña protegida mediante hash.
- **Inicio de sesión:** Acceso seguro para clientes.
- **Catálogo de productos:** Visualización de todos los productos disponibles, con imágenes, tallas, categorías y precios.
- **Solicitud de compra:** Los clientes pueden seleccionar productos, elegir la cantidad y realizar pedidos.

### Para administradores
- **Inicio de sesión de administrador:** Solo los usuarios con rol `admin` pueden acceder al panel de administración.
- **Panel de administración:** Acceso a funcionalidades exclusivas para la gestión de la tienda.
- **Gestión de productos:**
  - Agregar nuevos productos con imagen, talla, precio y categoría.
  - Visualizar productos registrados.
  - Eliminar productos.  **EN PROCESO**
- **Gestión de categorías:**
  - Crear nuevas categorías.
  - Visualizar y eliminar categorías (no se pueden eliminar si tienen productos asociados). **EN PROCESO**
- **Gestión de pedidos:**
  - Visualizar pedidos realizados por los clientes.

### Seguridad
- **Contraseñas hasheadas:** Todas las contraseñas se almacenan usando `password_hash`.
- **Validación de roles:** Solo los administradores pueden acceder a las funciones de administración.
- **Restricción de eliminación:** No se pueden eliminar categorías si tienen productos asociados (clave foránea). **EN PROCESO**
- **Validación de archivos:** Solo se permiten imágenes JPG y PNG para los productos.

### Técnicas y tecnologías usadas
- **PHP** (Programación orientada a objetos)
- **MySQL** (Base de datos relacional)
- **HTML5 y CSS3** (Frontend)
- **JavaScript** (para confirmaciones y acciones en el panel admin)
- **MVC básico** (Modelo, Vista, Controlador)

## Estructura del proyecto

- `/Controlador` - Lógica de control y flujo de la aplicación.
- `/Modelo` - Clases de acceso a datos y lógica de negocio.
- `/Vista/html` - Vistas HTML para cliente y administrador.
- `/uploads` - Carpeta para imágenes de productos.

## Instalación y uso

1. Clona el repositorio en tu servidor local (XAMPP, WAMP, etc.).
2. Importa el archivo SQL de la base de datos.
3. Configura la conexión a la base de datos en `Modelo/Conexion.php`.
4. Asegúrate de que la carpeta `/uploads` tenga permisos de escritura.
5. Accede a `index.php` desde tu navegador.

## Notas adicionales

- El sistema diferencia entre clientes y administradores mediante el campo `rol` en la tabla `usuarios`.
- El administrador debe ser creado manualmente en la base de datos o mediante un registro especial.
- El sistema muestra mensajes de alerta para operaciones exitosas o errores (por ejemplo, al eliminar categorías con productos asociados). **EN PROCESO**


