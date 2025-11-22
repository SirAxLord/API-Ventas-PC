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

