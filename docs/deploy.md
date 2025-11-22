# Guía de Despliegue (Producción)

## Requisitos Previos
- PHP versión compatible con Laravel (>=8.x según framework base).
- Extensiones: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`.
- Servidor web (Nginx/Apache) apuntando a `public/`.
- Base de datos configurada (MySQL/PostgreSQL) y credenciales en `.env`.
- Composer instalado.

## Variables .env Clave
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.midominio.com
LOG_CHANNEL=stack
LOG_LEVEL=info
CORS_ALLOWED_ORIGINS=https://frontend.midominio.com
SANCTUM_STATEFUL_DOMAINS=frontend.midominio.com
SESSION_DOMAIN=midominio.com
```

## Pasos de Despliegue
1. Clonar repositorio y entrar al directorio.
2. Instalar dependencias:
   ```bash
   composer install --no-dev --prefer-dist --optimize-autoloader
   ```
3. Generar clave (si es primera vez):
   ```bash
   php artisan key:generate
   ```
4. Migraciones + seed (solo si se requiere datos iniciales):
   ```bash
   php artisan migrate --force
   ```
5. Cachear y optimizar:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```
6. Asignar permisos (Linux):
   ```bash
   chown -R www-data:www-data storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```
7. Configurar cron para tareas programadas (si aplica):
   ```bash
   * * * * * php /ruta/al/proyecto/artisan schedule:run >> /dev/null 2>&1
   ```
8. Verificar salud:
   - `GET /v1/products` responde 200
   - `POST /v1/auth/login` emite token

## Limpieza / Rollback
- Limpiar caches:
  ```bash
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  php artisan optimize:clear
  ```
- Rollback migraciones (con cautela):
  ```bash
  php artisan migrate:rollback --step=1
  ```

## Logs y Monitoreo
- Revisa `storage/logs/laravel.log`.
- Ajusta `LOG_LEVEL` a `warning` para menos ruido.

## Seguridad Adicional
- Forzar HTTPS (redirección en Nginx/Apache).
- Revisar encabezados (CSP, X-Frame-Options, X-Content-Type-Options).
- Rotar tokens largos periódicamente si se usan.

## Próximos Mejoras (Opcional)
- Implementar cache Redis para consultas frecuentes.
- Integrar herramientas APM (NewRelic, Laravel Telescope en pre-producción).
- Separar workers (queue) del proceso web.

## Comando Único (script opcional)
Puedes crear un script de despliegue:
```bash
#!/usr/bin/env bash
set -e
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

Listo: la API está preparada para producción.
