@echo off
echo Démarrage de PostgreSQL...
C:\Users\adelie.saunier\postgresql\postgresql-16.13-2-windows-x64-binaries\pgsql\bin\pg_ctl.exe -D "C:\Users\adelie.saunier\postgresql\data" -l "C:\Users\adelie.saunier\postgresql\logfile.txt" start

echo.
echo Démarrage du serveur Symfony...
cd C:\Users\adelie.saunier\Desktop\learning-tracker\learning-tracker
symfony.exe server:start

pause
