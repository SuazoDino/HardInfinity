# 📧 Configuración de Correo Electrónico

## Configuración de Gmail para envío de correos

Para que la aplicación pueda enviar correos electrónicos reales a través de Gmail, sigue estos pasos:

### 1️⃣ Obtener Contraseña de Aplicación de Gmail

1. Ve a tu cuenta de Google: https://myaccount.google.com/
2. En el menú lateral, selecciona "Seguridad"
3. En "Cómo inicias sesión en Google", activa la **Verificación en 2 pasos** (si no la tienes activada)
4. Una vez activada, regresa a "Seguridad" y busca "Contraseñas de aplicaciones"
5. Haz clic en "Contraseñas de aplicaciones"
6. Selecciona:
   - **Aplicación:** Correo
   - **Dispositivo:** Otro (personalizado) → escribe "HardInfinity"
7. Haz clic en "Generar"
8. **Copia la contraseña de 16 caracteres que aparece** (sin espacios)

### 2️⃣ Configurar el archivo .env

Abre el archivo `.env` en la raíz del proyecto y actualiza estas líneas:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="HardInfinity"
```

**Reemplaza:**
- `tu_email@gmail.com` → Tu correo de Gmail
- `xxxx xxxx xxxx xxxx` → La contraseña de aplicación generada (puedes copiarla con o sin espacios)

### 3️⃣ Reiniciar el servidor

Después de editar el `.env`, **DEBES reiniciar el servidor** para que los cambios surtan efecto:

```bash
# Detén el servidor (Ctrl+C si está corriendo)
# Luego vuelve a iniciarlo:
npm run dev
```

### 4️⃣ Probar el envío de correos

Realiza una compra de prueba en tu tienda. Si todo está configurado correctamente:
- ✅ Recibirás un correo de confirmación en tu bandeja de entrada de Gmail
- ✅ El correo incluirá todos los detalles del pedido
- ✅ Tendrá un diseño profesional con el logo de HardInfinity

### 🔧 Solución de Problemas

**Si NO recibes el correo:**

1. **Verifica tu archivo .env:**
   - Asegúrate de que no haya espacios extras
   - Verifica que el email y la contraseña sean correctos
   
2. **Revisa la carpeta de Spam:**
   - A veces Gmail marca los primeros correos como spam
   
3. **Verifica los logs de Laravel:**
   ```bash
   # En Windows PowerShell:
   Get-Content storage\logs\laravel.log -Tail 50
   ```
   
4. **Si aparece error "Username and Password not accepted":**
   - Verifica que la Verificación en 2 pasos esté activada
   - Genera una nueva contraseña de aplicación
   - Asegúrate de estar usando MAIL_PORT=587 y MAIL_ENCRYPTION=tls

### 📝 Ejemplo de configuración completa

```env
# Configuración de correo
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=dinosuazo@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=dinosuazo@gmail.com
MAIL_FROM_NAME="HardInfinity"
```

### ✅ Características del correo

Los correos que se envían incluyen:
- ✨ Diseño moderno y profesional
- 📦 Detalles completos del pedido
- 💰 Total pagado
- 📍 Dirección de envío
- 🎯 Número de orden único
- 🔗 Link para ver el pedido

---

**¡Listo!** Una vez configurado, todos tus clientes recibirán automáticamente un correo de confirmación cuando realicen una compra. 🚀

