# ⚙️ Cómo Configurar el Archivo .env de Forma Segura

## 📋 Paso a Paso

### 1. **Crear el archivo .env**

Si no tienes un archivo `.env`, créalo en la raíz del proyecto:

```bash
# En Windows PowerShell:
Copy-Item .env.example .env

# O simplemente crea un archivo nuevo llamado .env
```

### 2. **Configuración Básica**

```env
# ==========================================
# INFORMACIÓN DE LA APLICACIÓN
# ==========================================

APP_NAME=HardInfinity
APP_ENV=local          # Cambiar a 'production' en servidor real
APP_KEY=                # Se genera con: php artisan key:generate
APP_DEBUG=true         # Cambiar a 'false' en producción
APP_URL=http://localhost:8000
```

### 3. **Generar APP_KEY (MUY IMPORTANTE)**

Esta es tu clave de encriptación. DEBE ser única y segura:

```bash
php artisan key:generate
```

Esto generará algo como:
```env
APP_KEY=base64:TGVnYWN5U3RyaW5nVGVzdEtleUZvckhhc2hpbmdGdW5jdGlvbg==
```

### 4. **Configurar Base de Datos (PostgreSQL)**

```env
# ==========================================
# BASE DE DATOS
# ==========================================

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=hardinfinity
DB_USERNAME=tu_usuario_db
DB_PASSWORD=TU_PASSWORD_SUPER_SEGURA_AQUI
```

#### ⚠️ **IMPORTANTE - Seguridad de Contraseñas**:

**❌ MAL:**
```env
DB_PASSWORD=123456
DB_PASSWORD=admin
DB_PASSWORD=password
```

**✅ BIEN:**
```env
DB_PASSWORD=xK9$mP2#vL8@wN5%qR7!zT3&
```

#### 💡 **Generar contraseña segura:**

```powershell
# En PowerShell (Windows):
-join ((48..57) + (65..90) + (97..122) + (33,35,36,37,38,42,43,45,61,63,64) | Get-Random -Count 20 | ForEach-Object {[char]$_})
```

### 5. **Configurar Correo (Gmail)**

```env
# ==========================================
# CONFIGURACIÓN DE CORREO
# ==========================================

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="HardInfinity"
```

#### 🔑 **Obtener Contraseña de Aplicación de Gmail:**

1. Ve a: https://myaccount.google.com/
2. Clic en **"Seguridad"** (menú lateral izquierdo)
3. Activa la **"Verificación en 2 pasos"** (si no la tienes)
4. Vuelve a **"Seguridad"** → busca **"Contraseñas de aplicaciones"**
5. Selecciona:
   - **Aplicación:** Correo
   - **Dispositivo:** Otro (personalizado) → escribe "HardInfinity"
6. Haz clic en **"Generar"**
7. Copia la contraseña de **16 caracteres**

```env
MAIL_PASSWORD=abcd efgh ijkl mnop
# ↑ Copia exactamente como aparece (puedes incluir espacios o no)
```

### 6. **Configuración de Sesión y Cache**

```env
# ==========================================
# SESIÓN Y CACHE
# ==========================================

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 🛡️ Configuración para PRODUCCIÓN

Cuando subas tu tienda a un servidor real, cambia estos valores:

```env
APP_ENV=production      # ← Cambiar de 'local' a 'production'
APP_DEBUG=false        # ← MUY IMPORTANTE: false en producción
APP_URL=https://tudominio.com

# Base de datos en servidor real
DB_HOST=tu_servidor_db
DB_DATABASE=tu_base_de_datos_produccion
DB_USERNAME=usuario_produccion
DB_PASSWORD=PASSWORD_MUY_SEGURA_DE_PRODUCCION
```

---

## ✅ Checklist de Verificación

Antes de ejecutar la aplicación:

- [ ] El archivo `.env` existe en la raíz del proyecto
- [ ] `APP_KEY` está generada (no está vacía)
- [ ] Contraseñas son fuertes (16+ caracteres)
- [ ] Gmail usa "Contraseña de Aplicación" (no tu contraseña personal)
- [ ] `.env` está en `.gitignore` (NUNCA se sube a GitHub)

---

## 🚀 Después de Configurar

1. **Limpiar cache de configuración:**
```bash
php artisan config:clear
php artisan cache:clear
```

2. **Ejecutar migraciones:**
```bash
php artisan migrate
```

3. **Generar almacenamiento público:**
```bash
php artisan storage:link
```

4. **Iniciar servidor:**
```bash
npm run dev        # En una terminal
php artisan serve  # En otra terminal
```

---

## 🆘 Problemas Comunes

### Error: "No application encryption key has been specified"
**Solución:**
```bash
php artisan key:generate
```

### Error: "SQLSTATE[08006] [7] connection refused"
**Solución:**
- Verifica que PostgreSQL esté corriendo
- Revisa DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

### Error: "Failed to authenticate on SMTP server"
**Solución:**
- Usa "Contraseña de Aplicación" de Gmail (no tu contraseña normal)
- Verifica que MAIL_PORT=587 y MAIL_ENCRYPTION=tls

---

## 📁 Ejemplo Completo de .env

```env
# APLICACIÓN
APP_NAME=HardInfinity
APP_ENV=local
APP_KEY=base64:xK9mP2vL8wN5qR7zT3hG6jC4yB1nM0kP5sD8fW3xL9a=
APP_DEBUG=true
APP_URL=http://localhost:8000

# BASE DE DATOS
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=hardinfinity
DB_USERNAME=postgres
DB_PASSWORD=MiPassword$uperSegur@2025!

# CORREO
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=mitienda@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=mitienda@gmail.com
MAIL_FROM_NAME="HardInfinity"

# SESIÓN Y CACHE
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 🔒 Seguridad Final

**RECUERDA:**
- ✅ `.env` NUNCA se sube a GitHub
- ✅ Usa contraseñas únicas y fuertes
- ✅ En producción: `APP_DEBUG=false`
- ✅ En producción: `APP_ENV=production`
- ✅ Cambia las contraseñas cada cierto tiempo
- ✅ Nunca compartas tu `.env` por email/WhatsApp

---

**¡Listo!** Con esto tu aplicación estará configurada de forma segura. 🛡️✅

