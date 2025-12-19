@echo off
echo ===================================================
echo      INSTALADOR AUTOMATICO HARDINFINITY
echo ===================================================
echo.

echo [1/6] Instalando dependencias de PHP (Composer)...
call composer install --no-interaction

echo.
echo [2/6] Instalando dependencias de JS (NPM)...
call npm install

echo.
echo [3/6] Configurando archivo de entorno (.env)...
if not exist .env copy .env.example .env
call php artisan key:generate

echo.
echo [4/6] Configurando Base de Datos...
echo IMPORTANTE: Asegurate de que PostgreSQL este corriendo y la BD 'hardinfinity' exista.
call php artisan migrate:fresh --seed

echo.
echo [5/6] ARREGLANDO IMAGENES (Creando enlace simbolico)...
if exist public\storage rmdir public\storage
call php artisan storage:link

echo.
echo [6/6] Compilando frontend...
call npm run build

echo.
echo ===================================================
echo      INSTALACION COMPLETADA EXITOSAMENTE
echo ===================================================
echo.
echo Puedes iniciar el servidor con: php artisan serve
pause

