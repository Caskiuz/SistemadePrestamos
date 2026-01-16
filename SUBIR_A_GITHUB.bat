@echo off
echo ========================================
echo PASOS PARA SUBIR A GITHUB
echo ========================================
echo.
echo 1. Ve a: https://github.com/settings/tokens
echo 2. Click en "Generate new token (classic)"
echo 3. Nombre: Railway Deploy
echo 4. Marca: [X] repo (acceso completo)
echo 5. Click "Generate token"
echo 6. COPIA EL TOKEN (solo se muestra una vez)
echo.
echo 7. Ejecuta este comando reemplazando TU_TOKEN:
echo.
echo    git remote set-url origin https://TU_TOKEN@github.com/Caskiuz/SistemadePrestamos.git
echo    git push -u origin master
echo.
echo ========================================
echo ALTERNATIVA: Subir manualmente
echo ========================================
echo.
echo 1. Ve a: https://github.com/Caskiuz/SistemadePrestamos
echo 2. Click en "Add file" -^> "Upload files"
echo 3. Arrastra toda la carpeta del proyecto
echo 4. Commit changes
echo.
pause
