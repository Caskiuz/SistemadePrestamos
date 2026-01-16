@echo off
echo ========================================
echo Verificando archivos para Git...
echo ========================================
echo.

echo Archivos que NO se subiran (ignorados):
git status --ignored --short | findstr "!!"
echo.

echo Archivos que SI se subiran:
git status --short
echo.

echo ========================================
echo Tamaño estimado del repositorio:
echo ========================================
git count-objects -vH 2>nul || echo Git no inicializado aun
echo.

pause
