# HardInfinity

Una tienda en línea de equipos de cómputo, que servirá de uso por todo el Perú.

## Laravel con PostgreSQL - Instalación Básica

✅ Laravel 10 instalado y configurado
✅ PostgreSQL como base de datos

### Configuración

1. **Crea un archivo `.env`** en la raíz del proyecto con tu configuración de PostgreSQL:

```env
APP_NAME=HardInfinity
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tu_base_de_datos
DB_USERNAME=postgres
DB_PASSWORD=tu_password
```

2. **Genera la clave de aplicación:**
```bash
php artisan key:generate
```

3. **Crea la base de datos en PostgreSQL:**
```sql
CREATE DATABASE tu_base_de_datos;
```

4. **Ejecuta las migraciones:**
```bash
php artisan migrate
```

5. **Inicia el servidor:**
```bash
php artisan serve
```

Tu aplicación estará disponible en `http://localhost:8000`
