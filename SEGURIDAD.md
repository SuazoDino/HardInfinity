# 🔒 GUÍA DE SEGURIDAD - HardInfinity

## ✅ Estado Actual de Seguridad

### 1. **Credenciales y Contraseñas** ✅
- ✅ **Contraseñas hasheadas**: Todas las contraseñas de usuarios usan `bcrypt` (Laravel Hashing)
- ✅ **`.env` protegido**: El archivo `.env` está en `.gitignore` y NUNCA se sube a GitHub
- ✅ **Sin credenciales hardcodeadas**: No hay contraseñas en el código fuente
- ✅ **Tarjetas seguras**: Solo se guardan los últimos 4 dígitos (NUNCA el número completo)

### 2. **Autenticación** ✅
- ✅ Laravel Breeze con sesiones seguras
- ✅ CSRF Protection habilitado por defecto
- ✅ Middleware de autenticación en rutas protegidas

### 3. **Base de Datos** ✅
- ✅ Prepared Statements (Eloquent ORM) - Protección contra SQL Injection
- ✅ Credenciales en `.env` (no en el código)

---

## 🔐 IMPORTANTE: Configuración de Producción

### **1. Variables de Entorno (.env)**

Tu archivo `.env` contiene información **MUY SENSIBLE**. Asegúrate de:

#### ✅ **NUNCA subas el `.env` a GitHub**
```bash
# Ya está configurado en .gitignore
.env
.env.backup
.env.production
```

#### ✅ **Genera claves seguras únicas**

```env
# IMPORTANTE: Genera una clave única para tu aplicación
APP_KEY=base64:TU_CLAVE_UNICA_AQUI

# NUNCA uses 'root' sin contraseña en producción
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=hardinfinity
DB_USERNAME=tu_usuario_seguro
DB_PASSWORD=TU_PASSWORD_SUPER_SEGURA_AQUI

# Gmail - Usa contraseñas de aplicación
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx  # Contraseña de aplicación
```

#### 🔑 **Generar APP_KEY segura:**
```bash
php artisan key:generate
```

---

## 🛡️ Mejores Prácticas de Seguridad

### **1. Contraseñas Seguras**

#### Para Administradores:
- ✅ Mínimo 12 caracteres
- ✅ Combinar mayúsculas, minúsculas, números y símbolos
- ✅ Ejemplo: `Admin2025$HardInfinity!`

#### Para Base de Datos:
- ✅ Mínimo 16 caracteres aleatorios
- ✅ Ejemplo: `xK9$mP2#vL8@wN5%qR7!`

#### Para Correo (Gmail):
- ✅ Usar **Contraseña de Aplicación** (16 dígitos)
- ✅ NUNCA usar tu contraseña personal de Gmail

---

### **2. Configuración de Producción**

Cuando subas a producción (servidor real), asegúrate de:

```env
# DEBE estar en 'production'
APP_ENV=production

# DEBE estar en FALSE en producción
APP_DEBUG=false

# Usa HTTPS siempre
APP_URL=https://tudominio.com
```

---

### **3. Protección de Tarjetas de Crédito** 🛡️

#### ✅ **Lo que SÍ guardamos:**
- Marca (Visa, Mastercard, Amex)
- Últimos 4 dígitos
- Nombre del titular
- Mes y año de expiración

#### ❌ **Lo que NUNCA guardamos:**
- ❌ Número completo de tarjeta
- ❌ CVV/CVC
- ❌ PIN
- ❌ Datos biométricos

**IMPORTANTE**: Esta aplicación **NO procesa pagos reales**. Para pagos reales, debes integrar:
- Stripe (https://stripe.com)
- PayPal (https://paypal.com)
- Niubiz/Izipay (Perú)
- Culqi (Perú)

---

### **4. Protección contra Ataques Comunes**

#### ✅ **SQL Injection** - PROTEGIDO
Laravel Eloquent usa prepared statements automáticamente.

#### ✅ **XSS (Cross-Site Scripting)** - PROTEGIDO
Vue.js escapa el HTML automáticamente.

#### ✅ **CSRF (Cross-Site Request Forgery)** - PROTEGIDO
Laravel incluye protección CSRF en todos los formularios.

#### ✅ **Brute Force** - PARCIALMENTE PROTEGIDO
Laravel Breeze incluye rate limiting básico.

---

## 🚨 NUNCA Hagas Esto

### ❌ **NUNCA subas `.env` a GitHub**
```bash
# Si accidentalmente lo subiste:
git rm --cached .env
git commit -m "Remove .env file"
git push
# Luego CAMBIA todas las contraseñas inmediatamente
```

### ❌ **NUNCA uses estas contraseñas:**
- `password`
- `123456`
- `admin`
- `root`
- Tu nombre
- El nombre de tu empresa

### ❌ **NUNCA compartas credenciales por:**
- ❌ Email
- ❌ WhatsApp
- ❌ Mensajes de texto
- ❌ Screenshots públicos
- ❌ Repositorios públicos

### ❌ **NUNCA guardes tarjetas completas:**
```php
// ❌ MAL - NUNCA hagas esto
UserCard::create([
    'card_number' => '4111111111111111', // ❌❌❌
    'cvv' => '123', // ❌❌❌
]);

// ✅ BIEN - Solo últimos 4 dígitos
UserCard::create([
    'last_four' => '1111', // ✅
    // CVV NUNCA se guarda
]);
```

---

## 📋 Checklist de Seguridad Pre-Producción

Antes de lanzar tu tienda:

- [ ] Cambiaste todas las contraseñas por defecto
- [ ] `APP_DEBUG=false` en producción
- [ ] `APP_ENV=production`
- [ ] Generaste nueva `APP_KEY`
- [ ] SSL/HTTPS configurado
- [ ] Respaldos automáticos de base de datos
- [ ] `.env` NUNCA está en GitHub
- [ ] Contraseñas de base de datos son fuertes (16+ caracteres)
- [ ] Gmail usa contraseña de aplicación
- [ ] Logs monitoreados (`storage/logs`)
- [ ] Firewall configurado en el servidor
- [ ] Solo puertos necesarios abiertos (80, 443)

---

## 🔄 Mantenimiento de Seguridad

### **Mensualmente:**
- Revisar logs de errores
- Actualizar dependencias: `composer update`
- Revisar intentos de login fallidos

### **Trimestralmente:**
- Cambiar contraseña de base de datos
- Auditar usuarios administradores
- Revisar accesos no autorizados

### **Anualmente:**
- Cambiar todas las credenciales principales
- Auditoría de seguridad completa
- Actualizar Laravel a la última versión

---

## 📞 En Caso de Brecha de Seguridad

Si detectas un acceso no autorizado:

1. **INMEDIATAMENTE** cambia todas las contraseñas
2. Revisa los logs: `storage/logs/laravel.log`
3. Desactiva usuarios sospechosos
4. Revisa las últimas transacciones/pedidos
5. Notifica a los clientes si es necesario
6. Contacta a tu proveedor de hosting

---

## 📚 Recursos Adicionales

- [Documentación de Seguridad de Laravel](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Seguridad en PHP](https://www.php.net/manual/es/security.php)

---

## ✅ Resumen

Tu aplicación **YA tiene buena seguridad básica**:
- ✅ Contraseñas hasheadas
- ✅ `.env` protegido
- ✅ Tarjetas seguras (solo últimos 4 dígitos)
- ✅ Protección CSRF
- ✅ Protección SQL Injection

**Recuerda**: La seguridad es un proceso continuo. Mantén actualizado tu sistema y sigue las mejores prácticas. 🛡️

---

**Última actualización**: 19 de diciembre, 2025  
**Versión**: 1.0

