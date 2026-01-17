@echo off
echo Creando ZIP optimizado SIN borrar archivos originales...

cd /d "c:\Users\rijar\Proyectos\app-hc"

echo Creando directorio temporal...
if exist "temp_deploy" rmdir /s /q "temp_deploy"
mkdir temp_deploy

echo Copiando archivos esenciales (SIN fotos ni vendor)...
xcopy "app" "temp_deploy\app" /e /i /q
xcopy "bootstrap" "temp_deploy\bootstrap" /e /i /q
xcopy "config" "temp_deploy\config" /e /i /q
xcopy "database" "temp_deploy\database" /e /i /q

echo Copiando public SIN fotos...
mkdir "temp_deploy\public"
xcopy "public\*" "temp_deploy\public\" /q /exclude:equipos_fotos
for /d %%i in (public\*) do (
    if not "%%~ni"=="equipos_fotos" xcopy "%%i" "temp_deploy\public\%%~ni" /e /i /q
)

xcopy "resources" "temp_deploy\resources" /e /i /q
xcopy "routes" "temp_deploy\routes" /e /i /q

echo Copiando storage SIN logs...
mkdir "temp_deploy\storage"
xcopy "storage\app" "temp_deploy\storage\app" /e /i /q 2>nul
xcopy "storage\framework" "temp_deploy\storage\framework" /e /i /q 2>nul

copy ".env" "temp_deploy\" >nul 2>nul
copy "artisan" "temp_deploy\" >nul
copy "composer.json" "temp_deploy\" >nul
copy "composer.lock" "temp_deploy\" >nul

echo Creando ZIP...
powershell -command "Compress-Archive -Path 'temp_deploy\*' -DestinationPath 'laravel-deploy.zip' -Force"

echo Limpiando temporal...
rmdir /s /q "temp_deploy"

echo.
echo ✅ ZIP creado: laravel-deploy.zip
echo ✅ Archivos originales intactos (no se borró nada)
echo.
dir "laravel-deploy.zip" | find "laravel-deploy.zip"

pause