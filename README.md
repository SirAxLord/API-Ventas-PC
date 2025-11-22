<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## API Ventas-PC (Resumen del Proyecto)

Esta instancia Laravel funciona como API REST para catálogo de **productos** y **servicios** de una tienda de computación.

### Características Implementadas
- Versionado de rutas: prefijo `/v1`.
- Recursos: `products`, `services` (CRUD con separación lectura pública / escritura protegida).
- Validación con Form Requests (crear/actualizar productos y servicios).
- Respuestas estandarizadas mediante API Resources (`ProductResource`, `ServiceResource`).
- Filtros y ordenación avanzados (precio, stock, tipo, tiempo, estado, sort, direction, paginación `per_page`).
- Autenticación con **Laravel Sanctum** (Bearer Token).
- Rate limiting (`throttle:api` 60 req/min). 
- CORS configurable vía `CORS_ALLOWED_ORIGINS`.
- Manejo centralizado de errores con respuesta JSON uniforme.
- Seeders y factories con datos realistas.
- Pruebas Feature (CRUD + auth + filtros).
- Documentación OpenAPI en `docs/openapi.yaml`.

### Endpoints Principales
| Método | Endpoint | Descripción | Auth |
|--------|----------|-------------|------|
| POST | `/v1/auth/login` | Obtener token Sanctum | Público |
| POST | `/v1/auth/logout` | Revocar token | Bearer |
| GET | `/v1/products` | Listado productos (filtros) | Público |
| GET | `/v1/products/{id}` | Detalle producto | Público |
| POST | `/v1/products` | Crear producto | Bearer |
| PUT | `/v1/products/{id}` | Actualizar producto | Bearer |
| DELETE | `/v1/products/{id}` | Eliminar producto | Bearer |
| GET | `/v1/services` | Listado servicios (filtros) | Público |
| GET | `/v1/services/{id}` | Detalle servicio | Público |
| POST | `/v1/services` | Crear servicio | Bearer |
| PUT | `/v1/services/{id}` | Actualizar servicio | Bearer |
| DELETE | `/v1/services/{id}` | Eliminar servicio | Bearer |

### Variables de Entorno Clave
```
APP_ENV=local
APP_URL=http://localhost:8000
CORS_ALLOWED_ORIGINS=http://localhost:3000
SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost
```

### Flujo de Autenticación
1. `POST /v1/auth/login` con `email` y `password`.
2. Recibir `token` y usar encabezado: `Authorization: Bearer <token>` para rutas protegidas.
3. `POST /v1/auth/logout` para revocar.

### Ejemplo de Petición (cURL)
```bash
curl -X POST http://localhost:8000/v1/auth/login \
	-H "Content-Type: application/json" \
	-d '{"email":"test@example.com","password":"password"}'
```

### Ejemplo Listado con Filtros
```bash
curl http://localhost:8000/v1/products?category=computadoras&min_price=500&sort=price&direction=asc
```

### Estructura de Respuesta (Producto)
```json
{
	"data": {
		"id": 1,
		"sku": "PC-LAP-001",
		"name": "Laptop Gamer",
		"price": 1850.00,
		"category": "computadoras",
		"stock": 12,
		"status": "active",
		"created_at": "2025-11-22T10:00:00Z",
		"updated_at": "2025-11-22T10:00:00Z"
	},
	"meta": {
		"version": "v1"
	}
}
```

### Ejecución Local
```bash
composer install
php artisan migrate:fresh --seed
php artisan serve
```

### Pruebas
```bash
php artisan test
```

### Optimización para Deploy (Producción)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```
Invalida cachés tras cambios en config/rutas:
```bash
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```

### Futuras Mejores Opcionales
- Roles y policies (autorización granular).
- Exposición de métricas (Prometheus / logs enriquecidos).
- Webhooks para eventos de inventario.
- Cache de respuestas frecuentes (productos más vistos).

### Notas
- `cost_price` no se expone en el Resource público para evitar filtrado de margen.
- Para entornos con front-end SPA en otro dominio, ajustar `SANCTUM_STATEFUL_DOMAINS` y cookies si se usa autenticación basada en sesión.

