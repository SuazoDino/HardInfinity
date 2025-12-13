# 📘 DOCUMENTACIÓN COMPLETA - HARDINFINITY E-COMMERCE

## 📋 ÍNDICE
1. [Descripción General](#descripción-general)
2. [Tecnologías Utilizadas](#tecnologías-utilizadas)
3. [Arquitectura del Sistema](#arquitectura-del-sistema)
4. [Base de Datos](#base-de-datos)
5. [Funcionalidades Implementadas](#funcionalidades-implementadas)
6. [Estructura del Proyecto](#estructura-del-proyecto)
7. [Instalación y Configuración](#instalación-y-configuración)
8. [Rutas del Sistema](#rutas-del-sistema)
9. [Modelos y Relaciones](#modelos-y-relaciones)
10. [Controladores](#controladores)
11. [Componentes Frontend](#componentes-frontend)
12. [Características Destacadas](#características-destacadas)
13. [Credenciales de Acceso](#credenciales-de-acceso)

---

## 1. DESCRIPCIÓN GENERAL

**HardInfinity** es una plataforma de comercio electrónico especializada en hardware y componentes de computadoras, desarrollada como proyecto universitario. El sistema implementa un e-commerce completo con panel de administración, gestión de productos, carrito de compras, sistema de pagos simulados, y características avanzadas como recomendaciones basadas en IA, cupones de descuento, y sistema de reviews con verificación de compra.

### Objetivo del Proyecto
Crear una solución e-commerce robusta, escalable y visualmente atractiva que permita la gestión completa de productos tecnológicos, desde la administración hasta la compra final, con una experiencia de usuario moderna y profesional.

### Características Principales
- Sistema de autenticación con roles (Admin/Cliente)
- Catálogo de productos con filtros avanzados
- Carrito de compras con sesión
- Checkout con múltiples métodos de pago simulados
- Panel de administración completo
- Sistema de cupones y descuentos
- Reviews y calificaciones verificadas
- Wishlist/Favoritos
- Recomendaciones inteligentes
- Generación de PDFs para órdenes
- Tracking de envíos
- Diseño responsive "Tech Premium"

---

## 2. TECNOLOGÍAS UTILIZADAS

### Backend
- **PHP 8.2+**: Lenguaje de programación principal
- **Laravel 10**: Framework PHP para desarrollo web
- **PostgreSQL**: Sistema de gestión de base de datos relacional
- **Composer**: Gestor de dependencias PHP

### Frontend
- **Vue.js 3**: Framework JavaScript progresivo (Composition API)
- **Inertia.js**: Adaptador para crear SPAs con Laravel
- **TailwindCSS**: Framework CSS utility-first
- **Vite**: Herramienta de construcción frontend
- **Ziggy.js**: Uso de rutas de Laravel en frontend
- **NPM**: Gestor de paquetes JavaScript

### Librerías Adicionales
- **barryvdh/laravel-dompdf**: Generación de PDFs
- **Laravel Sanctum**: Autenticación API (incluido por defecto)
- **Intervention Image**: Procesamiento de imágenes (opcional)

### Herramientas de Desarrollo
- **Git**: Control de versiones
- **VSCode/Cursor**: Editor de código
- **Artisan**: CLI de Laravel

---

## 3. ARQUITECTURA DEL SISTEMA

### Patrón de Diseño
El proyecto sigue el patrón **MVC (Model-View-Controller)** de Laravel, con Inertia.js como puente entre backend y frontend.

```
┌─────────────────────────────────────────────┐
│           ARQUITECTURA HARDINFINITY         │
├─────────────────────────────────────────────┤
│                                             │
│  ┌─────────────┐      ┌─────────────┐     │
│  │   Vue.js    │◄────►│  Inertia.js │     │
│  │  Frontend   │      │   Adapter   │     │
│  └─────────────┘      └──────┬──────┘     │
│                              │             │
│                              ▼             │
│                    ┌──────────────────┐    │
│                    │  Laravel Routes  │    │
│                    └────────┬─────────┘    │
│                             │              │
│            ┌────────────────┼────────────┐ │
│            ▼                ▼            ▼ │
│    ┌────────────┐  ┌─────────────┐  ┌─────┴─────┐
│    │Controllers │  │ Middleware  │  │  Models   │
│    └─────┬──────┘  └─────────────┘  └─────┬─────┘
│          │                                 │
│          └──────────────┬──────────────────┘
│                         ▼
│                 ┌───────────────┐
│                 │  PostgreSQL   │
│                 │   Database    │
│                 └───────────────┘
│                                             │
└─────────────────────────────────────────────┘
```

### Flujo de Datos
1. **Usuario** interactúa con la interfaz Vue.js
2. **Inertia.js** captura la acción y la envía al backend
3. **Laravel Routes** dirige la petición al controlador correspondiente
4. **Controller** procesa la lógica de negocio
5. **Model** interactúa con la base de datos PostgreSQL
6. **Controller** retorna datos mediante Inertia
7. **Vue.js** renderiza la respuesta sin recargar la página

---

## 4. BASE DE DATOS

### Diagrama Entidad-Relación (Simplificado)

```
┌──────────────┐       ┌──────────────┐       ┌──────────────┐
│    roles     │───┐   │    users     │───┬───│user_addresses│
└──────────────┘   │   └──────────────┘   │   └──────────────┘
                   └───────────┘           │
                                           │
┌──────────────┐       ┌──────────────┐   │   ┌──────────────┐
│  categories  │───────│   products   │◄──┼───│user_interactions
└──────────────┘       └──────┬───────┘   │   └──────────────┘
                              │           │
┌──────────────┐              │           │   ┌──────────────┐
│    brands    │──────────────┘           ├───│   reviews    │
└──────────────┘                          │   └──────────────┘
                                          │
┌──────────────┐       ┌──────────────┐  │   ┌──────────────┐
│product_images│───────│specifications│  ├───│  wishlists   │
└──────────────┘       └──────────────┘  │   └──────────────┘
                                          │
┌──────────────┐       ┌──────────────┐  │   ┌──────────────┐
│    orders    │◄──────│ order_items  │◄─┘   │   coupons    │
└──────┬───────┘       └──────────────┘      └──────────────┘
       │
       ├───────────────┬──────────────┬──────────────┐
       ▼               ▼              ▼              ▼
┌──────────────┐ ┌──────────┐ ┌──────────┐ ┌───────────┐
│transactions  │ │shipments │ │payment_  │ │personal_  │
│              │ │          │ │methods   │ │access_    │
│              │ │          │ │          │ │tokens     │
└──────────────┘ └──────────┘ └──────────┘ └───────────┘
```

### Tablas Principales

#### 1. **roles**
- `id`: BIGINT (PK)
- `name`: VARCHAR(50) - Nombre del rol
- `timestamps`

#### 2. **users**
- `id`: BIGINT (PK)
- `role_id`: BIGINT (FK → roles)
- `name`: VARCHAR(255)
- `email`: VARCHAR(255) UNIQUE
- `phone`: VARCHAR(20) NULLABLE
- `password`: VARCHAR(255)
- `email_verified_at`: TIMESTAMP NULLABLE
- `remember_token`: VARCHAR(100) NULLABLE
- `timestamps`

#### 3. **user_addresses**
- `id`: BIGINT (PK)
- `user_id`: BIGINT (FK → users)
- `address_line`: VARCHAR(255)
- `city`: VARCHAR(100)
- `state`: VARCHAR(100)
- `postal_code`: VARCHAR(20)
- `country`: VARCHAR(100)
- `is_default`: BOOLEAN
- `timestamps`

#### 4. **categories**
- `id`: BIGINT (PK)
- `name`: VARCHAR(100)
- `slug`: VARCHAR(100) UNIQUE
- `description`: TEXT NULLABLE
- `is_active`: BOOLEAN
- `is_main`: BOOLEAN
- `timestamps`

#### 5. **brands**
- `id`: BIGINT (PK)
- `name`: VARCHAR(100)
- `slug`: VARCHAR(100) UNIQUE
- `logo`: VARCHAR(255) NULLABLE
- `timestamps`

#### 6. **products**
- `id`: BIGINT (PK)
- `category_id`: BIGINT (FK → categories)
- `brand_id`: BIGINT (FK → brands)
- `name`: VARCHAR(255)
- `slug`: VARCHAR(255) UNIQUE
- `description`: TEXT
- `price`: DECIMAL(10,2)
- `stock`: INTEGER
- `sku`: VARCHAR(100) UNIQUE
- `is_active`: BOOLEAN
- `is_featured`: BOOLEAN
- `view_count`: INTEGER DEFAULT 0
- `timestamps`

#### 7. **product_images**
- `id`: BIGINT (PK)
- `product_id`: BIGINT (FK → products)
- `image_path`: VARCHAR(255)
- `is_primary`: BOOLEAN
- `order`: INTEGER
- `timestamps`

#### 8. **specifications**
- `id`: BIGINT (PK)
- `product_id`: BIGINT (FK → products)
- `key`: VARCHAR(100) - Ej: "Procesador", "RAM"
- `value`: VARCHAR(255) - Ej: "Intel i7", "16GB"
- `timestamps`

#### 9. **orders**
- `id`: BIGINT (PK)
- `order_number`: VARCHAR(50) UNIQUE
- `user_id`: BIGINT (FK → users)
- `status`: VARCHAR(50) - pending, paid, shipped, delivered, cancelled
- `subtotal`: DECIMAL(10,2)
- `tax`: DECIMAL(10,2)
- `shipping_cost`: DECIMAL(10,2)
- `discount`: DECIMAL(10,2)
- `coupon_code`: VARCHAR(50) NULLABLE
- `total_amount`: DECIMAL(10,2)
- `payment_method`: VARCHAR(50) - card, yape, cash
- `payment_status`: VARCHAR(50) - pending, paid, failed
- `shipping_address`: TEXT
- `notes`: TEXT NULLABLE
- `timestamps`

#### 10. **order_items**
- `id`: BIGINT (PK)
- `order_id`: BIGINT (FK → orders)
- `product_id`: BIGINT (FK → products)
- `quantity`: INTEGER
- `unit_price`: DECIMAL(10,2)
- `total_price`: DECIMAL(10,2)
- `timestamps`

#### 11. **payment_methods**
- `id`: BIGINT (PK)
- `name`: VARCHAR(100) - Ej: "Tarjeta de Crédito/Débito"
- `code`: VARCHAR(50) - Ej: "credit_card"
- `is_active`: BOOLEAN
- `timestamps`

#### 12. **transactions**
- `id`: BIGINT (PK)
- `order_id`: BIGINT (FK → orders)
- `payment_method_id`: BIGINT (FK → payment_methods)
- `transaction_code`: VARCHAR(100) UNIQUE
- `status`: VARCHAR(50) - pending, completed, failed
- `amount`: DECIMAL(10,2)
- `details`: TEXT NULLABLE
- `timestamps`

#### 13. **user_interactions**
- `id`: BIGINT (PK)
- `user_id`: BIGINT (FK → users)
- `product_id`: BIGINT (FK → products)
- `interaction_type`: VARCHAR(50) - view, cart_add, purchase
- `timestamps`

#### 14. **reviews**
- `id`: BIGINT (PK)
- `user_id`: BIGINT (FK → users)
- `product_id`: BIGINT (FK → products)
- `order_item_id`: BIGINT NULLABLE (FK → order_items)
- `rating`: INTEGER (1-5)
- `comment`: TEXT NULLABLE
- `verified_purchase`: BOOLEAN
- `timestamps`

#### 15. **wishlists**
- `id`: BIGINT (PK)
- `user_id`: BIGINT (FK → users)
- `product_id`: BIGINT (FK → products)
- `timestamps`
- UNIQUE(user_id, product_id)

#### 16. **coupons**
- `id`: BIGINT (PK)
- `code`: VARCHAR(50) UNIQUE
- `type`: ENUM('percentage', 'fixed')
- `value`: DECIMAL(8,2)
- `min_purchase`: DECIMAL(8,2)
- `max_uses`: INTEGER NULLABLE
- `uses_count`: INTEGER DEFAULT 0
- `expires_at`: TIMESTAMP NULLABLE
- `is_active`: BOOLEAN
- `timestamps`

#### 17. **shipments**
- `id`: BIGINT (PK)
- `order_id`: BIGINT (FK → orders)
- `tracking_code`: VARCHAR(255) NULLABLE
- `carrier`: VARCHAR(255) NULLABLE
- `status`: VARCHAR(50) - preparing, shipped, in_transit, delivered
- `status_history`: JSON NULLABLE
- `shipped_at`: TIMESTAMP NULLABLE
- `delivered_at`: TIMESTAMP NULLABLE
- `timestamps`

---

## 5. FUNCIONALIDADES IMPLEMENTADAS

### 5.1 MÓDULO PÚBLICO (TIENDA)

#### A. Página de Inicio
- Banner promocional dinámico
- Productos destacados (marcados por admin)
- Categorías principales con imágenes
- Marcas destacadas
- Recomendaciones personalizadas basadas en IA
- Sección "Nuevos Productos"

#### B. Catálogo de Productos
- Grid responsive de productos
- Filtros en tiempo real:
  - Por categoría
  - Por marca
  - Rango de precio
  - Búsqueda por nombre
- Ordenamiento:
  - Más recientes
  - Precio: bajo a alto
  - Precio: alto a bajo
  - Nombre (A-Z)
- Paginación
- Indicadores de stock bajo
- Badge de "Destacado"

#### C. Página de Ofertas
- Muestra solo productos marcados como "destacados"
- Mantiene todos los filtros del catálogo
- Título y descripción personalizados

#### D. Detalle de Producto
- Galería de imágenes (múltiples)
- Información detallada:
  - Nombre y marca
  - Precio
  - Stock disponible
  - Descripción completa
  - Especificaciones técnicas dinámicas
- Selector de cantidad
- Botón "Agregar al carrito"
- Botón "Agregar a Wishlist" (corazón)
- Sistema de calificaciones (estrellas)
- Sección de reviews:
  - Solo usuarios que compraron pueden reseñar
  - Verificación de compra
  - Edición/eliminación de propia review
- Productos relacionados (misma categoría)
- Tracking de vistas para recomendaciones

#### E. Carrito de Compras
- Visualización de productos agregados
- Actualización de cantidades
- Eliminación de productos
- Cálculo automático de subtotal
- Cálculo de envío (gratis sobre S/ 500)
- Persistencia en sesión
- Contador en navbar
- Botón "Proceder al Checkout"

#### F. Checkout
- Validación de autenticación
- Formulario de datos de envío:
  - Dirección completa
  - Ciudad/Distrito
  - Teléfono
- Selección de método de pago simulado:
  - Tarjeta de Crédito/Débito
  - Yape/Plin
  - Pago contra entrega
- Campo para cupón de descuento
- Validación en tiempo real de cupones
- Resumen del pedido
- Vista previa de productos
- Cálculo de totales con descuento
- Generación de orden

#### G. Página de Éxito
- Confirmación de orden
- Número de orden
- Resumen de compra
- Botón para ver pedidos

#### H. Perfil de Usuario
Sidebar con navegación:

**Mis Pedidos:**
- Lista de todas las órdenes
- Estado de cada orden
- Detalles de productos comprados
- Descarga de PDF de factura
- Filtros por estado

**Mi Cuenta:**
- Edición de información personal
- Nombre, email, teléfono
- Actualización de datos

**Seguridad:**
- Cambio de contraseña
- Contraseña actual
- Nueva contraseña y confirmación

**Direcciones:**
- Gestión de direcciones de envío
- Agregar nueva dirección
- Eliminar dirección
- Marcar como predeterminada

**Wishlist:**
- Productos guardados como favoritos
- Eliminación de favoritos
- Agregar al carrito directo

#### I. Sistema de Reviews
- Calificación de 1 a 5 estrellas
- Comentario opcional
- Badge "Compra verificada"
- Edición de review propia
- Eliminación de review propia
- Solo usuarios autenticados que compraron

#### J. Recuperación de Contraseña
- Formulario de solicitud
- Envío de email con token
- Formulario de restablecimiento
- Validación de token

---

### 5.2 MÓDULO ADMINISTRATIVO (PANEL ADMIN)

#### A. Dashboard
- Estadísticas clave:
  - Total de ventas
  - Total de órdenes
  - Total de productos
  - Total de usuarios
- Gráfico de ventas recientes
- Tabla de órdenes recientes
- Productos con stock bajo
- Top 5 productos más vendidos

#### B. Gestión de Productos
**Listado:**
- Tabla con todos los productos
- Información visible: imagen, nombre, precio, stock, categoría, marca, estado
- Acciones rápidas:
  - Editar
  - Eliminar
  - Activar/Desactivar
  - Marcar como destacado
- Búsqueda y filtros
- Paginación
- Botón "Crear Producto"

**Crear/Editar:**
- Información básica:
  - Nombre
  - Categoría (select)
  - Marca (select)
  - Precio
  - Stock
  - SKU
  - Descripción
- Carga de múltiples imágenes:
  - Drag & drop
  - Previsualización
  - Marcar imagen principal
  - Ordenamiento
  - Eliminación
- Especificaciones dinámicas:
  - Agregar campos key-value
  - Eliminar campos
  - Ejemplos: Procesador, RAM, Almacenamiento, etc.
- Checkboxes:
  - Producto activo
  - Producto destacado

**Acciones especiales:**
- Toggle de estado (activo/inactivo)
- Toggle de destacado (oferta)

#### C. Gestión de Categorías
**Listado:**
- Tabla con categorías
- Nombre, slug, estado, es principal
- Acciones: Editar, Eliminar, Activar/Desactivar

**Crear/Editar:**
- Nombre
- Descripción
- Checkboxes:
  - Categoría activa
  - Categoría principal (aparece en home)

#### D. Gestión de Marcas
**Listado:**
- Tabla con marcas
- Nombre, slug
- Acciones: Editar, Eliminar

**Crear/Editar:**
- Nombre
- Logo (opcional)

#### E. Gestión de Órdenes
**Listado:**
- Tabla con todas las órdenes
- Número de orden, cliente, total, estado, fecha
- Filtros por estado
- Búsqueda por número de orden
- Botón "Ver Detalle"

**Detalle de Orden:**
- Información del cliente
- Dirección de envío
- Lista de productos comprados
- Método de pago
- Estado de pago
- Subtotal, envío, descuento, total
- Botones para cambiar estado:
  - Pendiente
  - Pagado
  - Enviado
  - Entregado
  - Cancelado
- Descarga de PDF de factura
- Sección de tracking de envío

#### F. Gestión de Usuarios
**Listado:**
- Tabla con usuarios
- Nombre, email, rol, fecha de registro
- Filtros por rol
- Búsqueda
- Acciones: Editar, Eliminar

**Crear/Editar:**
- Nombre
- Email
- Teléfono
- Contraseña
- Rol (Admin/Customer)

#### G. Gestión de Cupones
**Listado:**
- Tabla con cupones
- Código, descuento, mínimo, usos, expiración, estado
- Acciones: Editar, Eliminar

**Crear/Editar:**
- Código (único)
- Tipo (porcentaje o monto fijo)
- Valor
- Compra mínima
- Usos máximos
- Fecha de expiración
- Activo/Inactivo

#### H. Perfil de Admin
- Edición de información personal
- Cambio de contraseña
- Avatar generado dinámicamente

#### I. Notificaciones
- Badge en navbar con contador
- Muestra órdenes pendientes
- Link directo a gestión de órdenes

---

## 6. ESTRUCTURA DEL PROYECTO

```
HardInfinity-1/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── AuthController.php
│   │   │   │   └── PasswordResetController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── BrandController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── CouponController.php
│   │   │   │   └── ShipmentController.php
│   │   │   └── Shop/
│   │   │       ├── HomeController.php
│   │   │       ├── ProductController.php
│   │   │       ├── CategoryController.php
│   │   │       ├── CartController.php
│   │   │       ├── CheckoutController.php
│   │   │       ├── ProfileController.php
│   │   │       ├── ReviewController.php
│   │   │       ├── WishlistController.php
│   │   │       └── CouponController.php
│   │   │
│   │   └── Middleware/
│   │       ├── CheckAdmin.php
│   │       └── HandleInertiaRequests.php
│   │
│   └── Models/
│       ├── User.php
│       ├── Role.php
│       ├── UserAddress.php
│       ├── Category.php
│       ├── Brand.php
│       ├── Product.php
│       ├── ProductImage.php
│       ├── Specification.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── PaymentMethod.php
│       ├── Transaction.php
│       ├── UserInteraction.php
│       ├── Review.php
│       ├── Wishlist.php
│       ├── Coupon.php
│       └── Shipment.php
│
├── database/
│   ├── migrations/
│   │   ├── 2025_12_05_194725_create_roles_table.php
│   │   ├── 2025_12_05_194726_create_users_table.php
│   │   ├── 2025_12_05_194732_create_user_addresses_table.php
│   │   ├── 2025_12_05_194733_create_brands_table.php
│   │   ├── 2025_12_05_194733_create_categories_table.php
│   │   ├── 2025_12_05_194733_create_products_table.php
│   │   ├── 2025_12_05_194734_create_orders_table.php
│   │   ├── 2025_12_05_194734_create_product_images_table.php
│   │   ├── 2025_12_05_194734_create_specifications_table.php
│   │   ├── 2025_12_05_194736_create_payment_methods_table.php
│   │   ├── 2025_12_05_194736_create_transactions_table.php
│   │   ├── 2025_12_05_194736_create_user_interactions_table.php
│   │   ├── 2025_12_05_194737_create_order_items_table.php
│   │   ├── 2025_12_05_194750_create_reviews_table.php
│   │   ├── 2025_12_05_194751_create_wishlists_table.php
│   │   ├── 2025_12_05_194752_create_shipments_table.php
│   │   ├── 2025_12_05_194753_create_coupons_table.php
│   │   ├── 2025_12_05_194754_add_coupon_fields_to_orders_table.php
│   │   └── 2025_12_05_194755_add_payment_fields_to_orders_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RoleSeeder.php
│       ├── AdminUserSeeder.php
│       ├── BrandSeeder.php
│       ├── PaymentMethodSeeder.php
│       ├── CategorySeeder.php
│       ├── ProductSeeder.php
│       └── CouponSeeder.php
│
├── resources/
│   ├── css/
│   │   └── app.css
│   │
│   ├── js/
│   │   ├── app.js
│   │   ├── Components/
│   │   │   ├── UI/
│   │   │   │   ├── TextInput.vue
│   │   │   │   ├── InputLabel.vue
│   │   │   │   ├── InputError.vue
│   │   │   │   ├── PrimaryButton.vue
│   │   │   │   ├── NavLink.vue
│   │   │   │   ├── StatCard.vue
│   │   │   │   └── Toast.vue
│   │   │   └── Shop/
│   │   │       ├── Navbar.vue
│   │   │       ├── Footer.vue
│   │   │       └── ProductCard.vue
│   │   │
│   │   ├── Layouts/
│   │   │   ├── GuestLayout.vue
│   │   │   ├── AppLayout.vue
│   │   │   ├── AdminLayout.vue
│   │   │   └── ProfileLayout.vue
│   │   │
│   │   └── Pages/
│   │       ├── Auth/
│   │       │   ├── Login.vue
│   │       │   ├── Register.vue
│   │       │   ├── ForgotPassword.vue
│   │       │   └── ResetPassword.vue
│   │       ├── Admin/
│   │       │   ├── Dashboard.vue
│   │       │   ├── Profile.vue
│   │       │   ├── Products/
│   │       │   │   ├── Index.vue
│   │       │   │   ├── Create.vue
│   │       │   │   └── Edit.vue
│   │       │   ├── Categories/
│   │       │   │   ├── Index.vue
│   │       │   │   ├── Create.vue
│   │       │   │   └── Edit.vue
│   │       │   ├── Brands/
│   │       │   │   ├── Index.vue
│   │       │   │   ├── Create.vue
│   │       │   │   └── Edit.vue
│   │       │   ├── Orders/
│   │       │   │   ├── Index.vue
│   │       │   │   └── Show.vue
│   │       │   ├── Users/
│   │       │   │   ├── Index.vue
│   │       │   │   ├── Create.vue
│   │       │   │   └── Edit.vue
│   │       │   └── Coupons/
│   │       │       ├── Index.vue
│   │       │       ├── Create.vue
│   │       │       └── Edit.vue
│   │       └── Shop/
│   │           ├── Home.vue
│   │           ├── Categories/
│   │           │   └── Index.vue
│   │           ├── Products/
│   │           │   ├── Index.vue
│   │           │   └── Show.vue
│   │           ├── Cart/
│   │           │   └── Index.vue
│   │           ├── Checkout/
│   │           │   ├── Index.vue
│   │           │   └── Success.vue
│   │           └── Profile/
│   │               ├── Orders.vue
│   │               ├── Edit.vue
│   │               ├── Security.vue
│   │               ├── Addresses.vue
│   │               └── Wishlist.vue
│   │
│   └── views/
│       ├── app.blade.php
│       └── pdf/
│           └── order.blade.php
│
├── routes/
│   └── web.php
│
├── public/
│   ├── images/
│   └── storage/ (symlink)
│
├── storage/
│   └── app/
│       └── public/
│           └── products/
│
├── .env
├── composer.json
├── package.json
├── vite.config.js
├── tailwind.config.js
└── README.md
```

---

## 7. INSTALACIÓN Y CONFIGURACIÓN

### Requisitos Previos
- PHP 8.2 o superior
- PostgreSQL 13+
- Composer
- Node.js 18+ y NPM
- Git

### Pasos de Instalación

#### 1. Clonar el Repositorio
```bash
git clone <url-repositorio>
cd HardInfinity-1
```

#### 2. Instalar Dependencias PHP
```bash
composer install
```

#### 3. Instalar Dependencias JavaScript
```bash
npm install
```

#### 4. Configurar Variables de Entorno
Copiar `.env.example` a `.env`:
```bash
cp .env.example .env
```

Configurar la base de datos en `.env`:
```env
APP_NAME=HardInfinity
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=HardInfinity
DB_USERNAME=postgres
DB_PASSWORD=LiamNeeson24
```

#### 5. Generar Clave de Aplicación
```bash
php artisan key:generate
```

#### 6. Crear Base de Datos
En PostgreSQL:
```sql
CREATE DATABASE "HardInfinity";
```

#### 7. Ejecutar Migraciones
```bash
php artisan migrate
```

#### 8. Ejecutar Seeders
```bash
php artisan db:seed
```

#### 9. Crear Symlink de Storage
```bash
php artisan storage:link
```

#### 10. Compilar Assets
Para desarrollo:
```bash
npm run dev
```

Para producción:
```bash
npm run build
```

#### 11. Iniciar Servidor
```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

---

## 8. RUTAS DEL SISTEMA

### 8.1 Rutas Públicas

```php
// HOME
GET  /                              → home

// PRODUCTOS
GET  /productos                     → shop.products.index
GET  /productos/{slug}              → shop.products.show
GET  /ofertas                       → shop.ofertas

// CATEGORÍAS
GET  /categorias                    → shop.categories.index
GET  /categoria/{slug}              → shop.category

// CARRITO
GET  /carrito                       → cart.index
POST /carrito/agregar               → cart.store
PUT  /carrito/actualizar/{id}       → cart.update
DEL  /carrito/eliminar/{id}         → cart.destroy

// CUPONES (validación)
POST /coupon/validate               → coupon.validate
```

### 8.2 Rutas Autenticadas (Middleware: auth)

```php
// CHECKOUT
GET  /checkout                      → shop.checkout.index
POST /checkout                      → shop.checkout.store
GET  /checkout/exito/{order_number} → shop.checkout.success

// PERFIL USUARIO
GET  /mi-cuenta/pedidos             → profile.orders
GET  /mi-cuenta/pedidos/{order}/pdf → profile.orders.download-pdf
GET  /mi-cuenta/perfil              → profile.edit
PATCH /mi-cuenta/perfil             → profile.update
GET  /mi-cuenta/seguridad           → profile.security
PUT  /mi-cuenta/password            → profile.password
GET  /mi-cuenta/direcciones         → profile.addresses
POST /mi-cuenta/direcciones         → profile.addresses.store
DEL  /mi-cuenta/direcciones/{id}    → profile.addresses.destroy

// WISHLIST
GET  /mi-cuenta/wishlist            → profile.wishlist.index
POST /mi-cuenta/wishlist/{product}  → profile.wishlist.store
DEL  /mi-cuenta/wishlist/{product}  → profile.wishlist.destroy

// REVIEWS
POST /reviews                       → shop.reviews.store
PUT  /reviews/{review}              → shop.reviews.update
DEL  /reviews/{review}              → shop.reviews.destroy
```

### 8.3 Rutas de Autenticación (Middleware: guest)

```php
// LOGIN/REGISTER
GET  /login                         → login
POST /login
GET  /register                      → register
POST /register

// RECUPERACIÓN DE CONTRASEÑA
GET  /forgot-password               → password.request
POST /forgot-password               → password.email
GET  /reset-password/{token}        → password.reset
POST /reset-password                → password.update
```

### 8.4 Rutas de Administración (Middleware: auth, admin)

```php
// DASHBOARD
GET  /admin/dashboard               → admin.dashboard

// PERFIL ADMIN
GET  /admin/profile                 → admin.profile
PUT  /admin/profile                 → admin.profile.update
PUT  /admin/profile/password        → admin.profile.password

// PRODUCTOS
GET    /admin/products              → admin.products.index
GET    /admin/products/create       → admin.products.create
POST   /admin/products              → admin.products.store
GET    /admin/products/{id}         → admin.products.show
GET    /admin/products/{id}/edit    → admin.products.edit
PUT    /admin/products/{id}         → admin.products.update
DELETE /admin/products/{id}         → admin.products.destroy
POST   /admin/products/{id}/toggle-status   → admin.products.toggle-status
POST   /admin/products/{id}/toggle-featured → admin.products.toggle-featured

// CATEGORÍAS
GET    /admin/categories            → admin.categories.index
GET    /admin/categories/create     → admin.categories.create
POST   /admin/categories            → admin.categories.store
GET    /admin/categories/{id}/edit  → admin.categories.edit
PUT    /admin/categories/{id}       → admin.categories.update
DELETE /admin/categories/{id}       → admin.categories.destroy
POST   /admin/categories/{id}/toggle-status → admin.categories.toggle-status

// MARCAS
GET    /admin/brands                → admin.brands.index
GET    /admin/brands/create         → admin.brands.create
POST   /admin/brands                → admin.brands.store
GET    /admin/brands/{id}/edit      → admin.brands.edit
PUT    /admin/brands/{id}           → admin.brands.update
DELETE /admin/brands/{id}           → admin.brands.destroy

// ÓRDENES
GET  /admin/orders                  → admin.orders.index
GET  /admin/orders/{order}          → admin.orders.show
PUT  /admin/orders/{order}/status   → admin.orders.update-status
GET  /admin/orders/{order}/pdf      → admin.orders.download-pdf

// USUARIOS
GET    /admin/users                 → admin.users.index
GET    /admin/users/create          → admin.users.create
POST   /admin/users                 → admin.users.store
GET    /admin/users/{id}/edit       → admin.users.edit
PUT    /admin/users/{id}            → admin.users.update
DELETE /admin/users/{id}            → admin.users.destroy

// CUPONES
GET    /admin/coupons               → admin.coupons.index
GET    /admin/coupons/create        → admin.coupons.create
POST   /admin/coupons               → admin.coupons.store
GET    /admin/coupons/{id}/edit     → admin.coupons.edit
PUT    /admin/coupons/{id}          → admin.coupons.update
DELETE /admin/coupons/{id}          → admin.coupons.destroy

// ENVÍOS
POST /admin/orders/{order}/shipment → admin.orders.shipment.store
```

---

## 9. MODELOS Y RELACIONES

### User
**Relaciones:**
- `belongsTo(Role::class)` - role
- `hasMany(UserAddress::class)` - addresses
- `hasMany(Order::class)` - orders
- `hasMany(Review::class)` - reviews
- `hasMany(Wishlist::class)` - wishlists
- `hasMany(UserInteraction::class)` - interactions

**Métodos:**
- `isAdmin()`: boolean
- `isCustomer()`: boolean

### Product
**Relaciones:**
- `belongsTo(Category::class)` - category
- `belongsTo(Brand::class)` - brand
- `hasMany(ProductImage::class)` - images
- `hasMany(Specification::class)` - specifications
- `hasMany(OrderItem::class)` - orderItems
- `hasMany(Review::class)` - reviews
- `hasMany(Wishlist::class)` - wishlists

**Scopes:**
- `scopeActive($query)`
- `scopeFeatured($query)`
- `scopeInStock($query)`

**Accessors:**
- `primary_image`: Retorna la imagen principal

### Order
**Relaciones:**
- `belongsTo(User::class)` - user
- `hasMany(OrderItem::class)` - items
- `hasMany(Transaction::class)` - transactions
- `hasOne(Shipment::class)` - shipment

**Métodos:**
- `generateOrderNumber()`: static
- `scopeByStatus($query, $status)`

### Coupon
**Métodos:**
- `isValid($subtotal)`: boolean
- `calculateDiscount($subtotal)`: decimal
- `incrementUse()`: void
- `scopeActive($query)`

---

## 10. CONTROLADORES

### AuthController
- `showLogin()`: Muestra formulario de login
- `login(Request)`: Procesa login
- `showRegister()`: Muestra formulario de registro
- `register(Request)`: Procesa registro
- `logout()`: Cierra sesión

### PasswordResetController
- `requestForm()`: Formulario solicitud reset
- `sendResetLink(Request)`: Envía email con token
- `resetForm($token)`: Formulario de reset
- `reset(Request)`: Procesa cambio de contraseña

### Admin/DashboardController
- `index()`: Dashboard con estadísticas
- `profile()`: Muestra perfil admin
- `updateProfile(Request)`: Actualiza perfil
- `updatePassword(Request)`: Cambia contraseña

### Admin/ProductController
- `index()`: Lista productos
- `create()`: Formulario crear
- `store(Request)`: Guarda producto nuevo
- `edit($id)`: Formulario editar
- `update(Request, $id)`: Actualiza producto
- `destroy($id)`: Elimina producto
- `toggleStatus($id)`: Activa/desactiva
- `toggleFeatured($id)`: Marca/desmarca destacado

### Admin/OrderController
- `index()`: Lista órdenes
- `show($id)`: Detalle de orden
- `updateStatus(Request, $id)`: Cambia estado
- `downloadPdf($id)`: Genera y descarga PDF

### Shop/HomeController
- `index()`: Home con productos destacados y recomendaciones

### Shop/ProductController
- `index(Request)`: Catálogo con filtros
- `show($slug)`: Detalle de producto
- `ofertas(Request)`: Solo productos destacados

### Shop/CartController
- `index()`: Muestra carrito
- `store(Request)`: Agrega producto
- `update(Request, $id)`: Actualiza cantidad
- `destroy($id)`: Elimina producto

### Shop/CheckoutController
- `index()`: Muestra formulario checkout
- `store(Request)`: Procesa orden
- `success($order_number)`: Página de éxito

### Shop/ProfileController
- `orders()`: Lista órdenes del usuario
- `downloadOrderPdf($id)`: Descarga PDF
- `edit()`: Formulario editar perfil
- `update(Request)`: Actualiza perfil
- `security()`: Página de seguridad
- `password(Request)`: Cambia contraseña
- `addresses()`: Gestión direcciones
- `addressStore(Request)`: Nueva dirección
- `addressDestroy($id)`: Elimina dirección

### Shop/ReviewController
- `store(Request)`: Crea review
- `update(Request, $id)`: Actualiza review
- `destroy($id)`: Elimina review

### Shop/WishlistController
- `index()`: Lista wishlist
- `store($product_id)`: Agrega a wishlist
- `destroy($product_id)`: Elimina de wishlist

### Shop/CouponController
- `validateCoupon(Request)`: Valida cupón (API)

---

## 11. COMPONENTES FRONTEND

### Layouts

#### GuestLayout.vue
- Layout para páginas de autenticación
- Fondo oscuro con grid pattern
- Logo centrado
- Card de contenido

#### AppLayout.vue
- Layout principal del sitio público
- Navbar fijo con search
- Slot para contenido
- Footer
- Toast de notificaciones

#### AdminLayout.vue
- Layout del panel administrativo
- Sidebar con navegación
- Topbar con perfil y notificaciones
- Badge de órdenes pendientes
- Dropdown de usuario
- Slot para contenido

#### ProfileLayout.vue
- Layout para perfil de usuario
- Sidebar con menú de opciones
- Card de usuario
- Slot para contenido

### Componentes UI

#### TextInput.vue
- Input de texto reutilizable
- Soporte para v-model
- Estilos consistentes

#### InputLabel.vue
- Label para inputs
- Estilos consistentes

#### InputError.vue
- Mensaje de error de validación
- Color rojo

#### PrimaryButton.vue
- Botón principal
- Soporte para estado disabled

#### NavLink.vue
- Link de navegación
- Clase activa automática
- Transiciones

#### StatCard.vue
- Tarjeta de estadística
- Icono, título, valor
- Usado en dashboard

#### Toast.vue
- Notificación flotante
- Tipos: success, error
- Auto-cierre

### Componentes Shop

#### Navbar.vue
- Navegación principal
- Logo
- Menú (Productos, Categorías, Ofertas)
- Buscador
- Carrito con contador
- Dropdown de usuario/autenticación

#### Footer.vue
- Footer del sitio
- Links importantes
- Copyright

#### ProductCard.vue
- Tarjeta de producto
- Imagen clicable
- Badge de destacado/stock bajo
- Nombre, marca, precio
- Botón agregar al carrito

---

## 12. CARACTERÍSTICAS DESTACADAS

### 12.1 Recomendaciones con IA
El sistema registra las interacciones del usuario (vistas, agregados al carrito, compras) en la tabla `user_interactions`. Con esta información, genera recomendaciones personalizadas basadas en:
- Productos que el usuario ha visto
- Productos que ha agregado al carrito
- Historial de compras
- Productos de categorías similares

### 12.2 Sistema de Cupones Avanzado
- Cupones de porcentaje o monto fijo
- Validación de compra mínima
- Límite de usos globales
- Fecha de expiración
- Validación en tiempo real durante checkout
- Aplicación automática de descuento

### 12.3 Reviews Verificadas
- Solo usuarios que compraron pueden reseñar
- Badge "Compra verificada"
- Sistema de estrellas (1-5)
- Comentario opcional
- Edición/eliminación de propia review
- Cálculo de promedio de calificación

### 12.4 Gestión de Imágenes Múltiples
- Carga de múltiples imágenes por producto
- Drag & drop
- Previsualización en tiempo real
- Marcar imagen principal
- Ordenamiento visual
- Eliminación individual

### 12.5 Especificaciones Dinámicas
- Agregar campos key-value ilimitados
- Personalización por producto
- Ejemplos: Procesador, RAM, Almacenamiento, etc.

### 12.6 Generación de PDFs
- Facturas de órdenes
- Disponible para admin y usuarios
- Diseño profesional
- Información completa de la orden

### 12.7 Tracking de Envíos
- Estado del envío
- Historial de cambios
- Código de tracking
- Transportista
- Fecha de envío y entrega

### 12.8 Pagos Simulados
- Tarjeta de Crédito/Débito
- Yape/Plin
- Pago contra entrega
- Transacciones registradas
- Estados de pago

### 12.9 Wishlist
- Productos favoritos
- Agregar/eliminar
- Vista dedicada en perfil
- Botón en detalle de producto

### 12.10 Diseño "Tech Premium"
- Tema oscuro moderno
- Scrollbars personalizados
- Animaciones sutiles
- Gradientes y efectos de luz
- Totalmente responsive
- Inspiración en sitios tech modernos

---

## 13. CREDENCIALES DE ACCESO

### Administrador
- **Email:** admin@hardinfinity.com
- **Contraseña:** admin123

### Cliente de Prueba
- **Email:** cliente@hardinfinity.com
- **Contraseña:** cliente123

### Cupones de Prueba
- **BIENVENIDO10**: 10% de descuento, mínimo S/ 100
- **VERANO2025**: S/ 50 de descuento, mínimo S/ 500
- **PRIMERACOMPRA**: 15% de descuento, mínimo S/ 200

### Base de Datos
- **Database:** HardInfinity
- **User:** postgres
- **Password:** LiamNeeson24

---

## CONCLUSIÓN

HardInfinity es un e-commerce completo y funcional que implementa las mejores prácticas de desarrollo web moderno. El sistema está preparado para escalar y agregar nuevas funcionalidades según las necesidades del negocio.

El proyecto demuestra conocimientos sólidos en:
- Desarrollo full-stack con Laravel y Vue.js
- Diseño de bases de datos relacionales
- Arquitectura MVC
- SPAs con Inertia.js
- Diseño UI/UX moderno y responsive
- Gestión de sesiones y autenticación
- Integración de APIs internas
- Generación de documentos PDF
- Sistema de recomendaciones

---

**Desarrollado por:** [Tu Nombre]
**Fecha:** Diciembre 2025
**Versión:** 1.0.0

