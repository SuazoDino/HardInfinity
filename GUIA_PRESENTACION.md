# 🎯 GUÍA RÁPIDA DE PRESENTACIÓN - HARDINFINITY

## 🚀 ANTES DE EMPEZAR

### Verificar que los servidores estén corriendo:
```bash
# Terminal 1: Laravel (Backend)
php artisan serve
# Debe estar en: http://localhost:8000

# Terminal 2: Vite (Frontend)
npm run dev
# Debe estar en: http://localhost:5173
```

---

## 📋 FLUJO DE PRESENTACIÓN RECOMENDADO (10-15 minutos)

### 1️⃣ **INICIO - PÁGINA PRINCIPAL** (2 min)
- Abre: `http://localhost:8000`
- Muestra el diseño moderno y profesional
- Destaca las marcas (NVIDIA, AMD, Intel, etc.)
- Muestra productos destacados

**Qué decir:**
> "HardInfinity es un e-commerce completo para venta de hardware de PC. Tiene un diseño moderno con Vue.js y Laravel como backend."

---

### 2️⃣ **CATÁLOGO Y FILTROS** (3 min)
- Ve a: **"Productos"** en el menú
- **Demuestra los filtros:**
  - Filtra por **Marca** (ej: NVIDIA)
  - Filtra por **Categoría** (ej: Tarjetas Gráficas)
  - Filtra por **Precio** (ej: Min: 100, Max: 500)
  - Usa el **buscador**
  - Cambia el **ordenamiento** (precio bajo a alto)

**Qué decir:**
> "El catálogo tiene filtros dinámicos que se aplican en tiempo real sin recargar la página. Los usuarios pueden buscar por marca, categoría, rango de precios y ordenar los resultados."

---

### 3️⃣ **DETALLE DE PRODUCTO** (1 min)
- Haz clic en cualquier producto
- Muestra:
  - Imágenes del producto
  - Especificaciones técnicas
  - Precio y stock
  - Botón "Agregar al carrito"
  - Botón "Agregar a favoritos"

---

### 4️⃣ **CARRITO DE COMPRAS** (2 min)
- Agrega 2-3 productos al carrito
- Ve al carrito (ícono en el navbar)
- Muestra:
  - Lista de productos
  - Actualizar cantidades
  - Eliminar productos
  - Cálculo de subtotal

**Qué decir:**
> "El carrito funciona con sesiones de Laravel. Los usuarios pueden modificar cantidades y ver el total actualizado en tiempo real."

---

### 5️⃣ **CHECKOUT Y CUPONES** (2 min)
- Haz clic en **"Proceder al Pago"**
- Llena el formulario:
  - Dirección: `Av. Principal 123`
  - Ciudad: `Lima`
  - Teléfono: `987654321`
  - Método de pago: **Tarjeta** (o Yape/Contra Entrega)
- **IMPORTANTE:** Aplica un cupón:
  - Código: `VERANO2024` (10% descuento)
  - O: `PRIMERACOMPRA` (15% descuento)
- Completa la orden

**Qué decir:**
> "El sistema tiene checkout completo con validación de cupones de descuento. Los pagos son simulados para este demo, pero en producción se conectaría a Stripe o PayPal."

---

### 6️⃣ **PANEL DE ADMINISTRACIÓN** (5 min)

#### A. Login como Admin
- Ve a: `http://localhost:8000/login`
- **Credenciales:**
  - Email: `admin@hardinfinity.com`
  - Password: `password`

#### B. Dashboard
- Muestra las **estadísticas** en tiempo real:
  - Total de ventas
  - Órdenes pendientes
  - Productos más vendidos
  - Gráficos

**Qué decir:**
> "El panel de administración tiene un dashboard con métricas en tiempo real sobre ventas, inventario y productos."

#### C. Gestión de Órdenes
- Ve a **"Órdenes"** en el menú lateral
- Abre la orden que acabas de crear
- Muestra:
  - Detalles completos de la orden
  - Estado de pago
  - Productos comprados
  - **Descarga el PDF** de la orden

**Qué decir:**
> "Los administradores pueden ver todas las órdenes, cambiar estados, y generar PDFs para impresión o envío por email."

#### D. Reportes PDF ⭐ (LO MÁS IMPORTANTE)
- En el **Dashboard**, haz clic en:
  - **"📄 Reporte Ventas PDF"** → Se descarga un PDF con estadísticas de ventas
  - **"📦 Reporte Inventario PDF"** → Se descarga un PDF con el estado del inventario

**Qué decir:**
> "El sistema genera reportes PDF profesionales para ventas e inventario. Estos reportes incluyen estadísticas, productos más vendidos, y análisis de stock."

#### E. Gestión de Productos
- Ve a **"Productos"**
- Muestra la lista completa
- Haz clic en **"Editar"** en algún producto
- Muestra que puedes:
  - Cambiar precio
  - Actualizar stock
  - Subir imágenes
  - Activar/desactivar

#### F. Gestión de Cupones
- Ve a **"Cupones"**
- Muestra los cupones activos
- Explica que se pueden crear cupones con:
  - Porcentaje o monto fijo
  - Fecha de expiración
  - Uso máximo

---

## 🎯 PUNTOS CLAVE A DESTACAR

### ✅ Funcionalidades Implementadas:
1. **Frontend moderno** con Vue.js + Inertia.js
2. **Catálogo con filtros** dinámicos (marca, categoría, precio)
3. **Carrito de compras** funcional
4. **Sistema de cupones** de descuento
5. **Checkout completo** con validación
6. **Panel de administración** completo
7. **Gestión de productos, categorías, marcas**
8. **Gestión de órdenes** con cambio de estados
9. **Control de inventario** automático
10. **Reportes PDF** profesionales ⭐
11. **Sistema de roles** (Admin/Usuario)
12. **Wishlist** (favoritos)
13. **Sistema de reviews** (reseñas)

### ⚠️ Limitaciones (Ser honesto):
- Los **pagos son simulados** (no hay integración real con Stripe/PayPal)
- Los **emails no se envían** (falta configurar SMTP)
- Es un **entorno de desarrollo**, no está en producción

---

## 💡 FRASES PARA LA PRESENTACIÓN

**Al inicio:**
> "HardInfinity es un e-commerce completo desarrollado con Laravel y Vue.js, especializado en venta de hardware para PC."

**Al mostrar filtros:**
> "Implementé filtros dinámicos que funcionan sin recargar la página, mejorando la experiencia del usuario."

**Al mostrar el carrito:**
> "El carrito usa sesiones de Laravel para mantener los productos incluso si el usuario no está logueado."

**Al mostrar cupones:**
> "El sistema valida cupones en tiempo real, verificando fechas de expiración y límites de uso."

**Al mostrar el admin:**
> "El panel de administración es completo, permitiendo gestionar productos, órdenes, usuarios y generar reportes."

**Al mostrar los PDFs:**
> "Implementé generación de reportes PDF usando DomPDF, que permite a los administradores descargar análisis de ventas e inventario."

**Al hablar de pagos:**
> "El sistema tiene un módulo de pagos configurado para desarrollo, que simula transacciones. En producción se conectaría a Stripe o PayPal."

---

## 🔑 CREDENCIALES DE ACCESO

### Usuario Admin:
- Email: `admin@hardinfinity.com`
- Password: `password`

### Usuario Normal (si lo necesitas):
- Email: `user@hardinfinity.com`
- Password: `password`

### Cupones de Descuento:
- `VERANO2024` - 10% de descuento
- `PRIMERACOMPRA` - 15% de descuento
- `NAVIDAD2024` - $50 de descuento

---

## ⚡ TIPS FINALES

1. **Practica el flujo** 2-3 veces antes de presentar
2. **Ten los servidores corriendo** antes de empezar
3. **Abre las pestañas** que necesitarás de antemano
4. **Enfócate en los reportes PDF** - es lo más impresionante
5. **Sé honesto** sobre las limitaciones (pagos simulados)
6. **Destaca la arquitectura** (Laravel + Vue.js + PostgreSQL)

---

## 🚨 SI ALGO FALLA

### Si el servidor no responde:
```bash
php artisan config:clear
php artisan cache:clear
php artisan serve
```

### Si Vite no compila:
```bash
npm run dev
```

### Si hay error de base de datos:
```bash
php artisan migrate:fresh --seed
```

---

## ✅ CHECKLIST PRE-PRESENTACIÓN

- [ ] Servidores corriendo (Laravel + Vite)
- [ ] Base de datos con datos de prueba
- [ ] Navegador abierto en `http://localhost:8000`
- [ ] Credenciales de admin a mano
- [ ] Cupones de descuento memorizados
- [ ] Esta guía impresa o en otra pantalla

---

**¡MUCHA SUERTE EN TU PRESENTACIÓN! 🚀**

