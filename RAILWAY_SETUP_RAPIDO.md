# ⚡ SETUP RÁPIDO - RAILWAY (10 MINUTOS)

## 1. CLOUDINARY (2 min)
```
1. https://cloudinary.com/users/register/free
2. Copiar del Dashboard:
   - Cloud Name
   - API Key  
   - API Secret
```

## 2. RAILWAY (3 min)
```
1. https://railway.app → Login con GitHub
2. "New Project" → "Deploy from GitHub repo"
3. Seleccionar: HardInfinity-1
4. "+ New" → "Database" → "Add PostgreSQL"
```

## 3. VARIABLES DE ENTORNO (3 min)

En Railway → Variables:

```env
APP_NAME=HardInfinity
APP_ENV=production
APP_DEBUG=false
FILESYSTEM_DISK=cloudinary
CLOUDINARY_CLOUD_NAME=pegar_aqui
CLOUDINARY_API_KEY=pegar_aqui
CLOUDINARY_API_SECRET=pegar_aqui
```

## 4. GENERAR APP_KEY (2 min)

En tu PC:
```bash
php artisan key:generate --show
```

Copiar el resultado y agregarlo en Railway:
```env
APP_KEY=base64:...resultado...
```

## 5. PUSH A GITHUB
```bash
git add .
git commit -m "Deploy a producción"
git push
```

## ✅ LISTO!

Railway detectará el push y desplegará automáticamente.

**URL:** https://tu-proyecto.railway.app

---

## 🎯 USUARIO ADMIN PARA DEMOSTRACIÓN

Después del deploy, crea un admin desde tinker:

```bash
# En Railway: Settings → Run Command
php artisan tinker

# Ejecutar:
$admin = new App\Models\User();
$admin->name = "Admin";
$admin->email = "admin@hardinfinity.com";
$admin->password = bcrypt("password123");
$admin->role_id = 1;
$admin->save();
```

**Login:**
- Email: admin@hardinfinity.com
- Password: password123

---

## 📊 POBLAR CON DATOS DE PRUEBA

```bash
php artisan db:seed --class=BrandSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=CouponSeeder
```

---

**¡Listo para presentar! 🚀**

