## API Ventas-PC (Resumen del Proyecto)

Instancia Laravel (API REST) para catálogo de **productos** y **servicios** con autenticación basada en tokens, control de roles y documentación OpenAPI.

### Características Implementadas
- Versionado: prefijo `/api/v1`.
- Recursos: `products`, `services` (lectura pública, escritura sólo admin).
- Roles: `admin`, `customer`, `guest` (no autenticado).
- Validación con Form Requests (store/update).
- Serialización uniforme con API Resources.
- Filtros y ordenación: `search`, `category/type`, `status`, rangos `min_price`, `max_price`, `min_stock`, `max_stock`, `min_time`, `max_time`, `sort`, `direction`, paginación `per_page` (1–100).
- Autenticación: **Laravel Sanctum** (Bearer Token).
- Autorización: Policies y Gate `admin`; endpoints protegidos con verificación de rol.
- Rate limiting: 60 req/min por usuario/IP (`throttle:api`).
- CORS configurable vía `CORS_ALLOWED_ORIGINS`.
- Manejo centralizado de errores JSON (estructura fija de validación y errores genéricos).
- Seeders + factories realistas (incluye usuario admin por defecto).
- Pruebas Feature para auth, filtros, autorización y CRUD.
- Documentación OpenAPI consolidada en `docs/openapi.yaml`.

### Tabla de Roles y Permisos
| Recurso / Acción | guest | customer | admin |
|------------------|:-----:|:--------:|:-----:|
| Listar productos/servicios | ✔ | ✔ | ✔ |
| Ver detalle producto/servicio | ✔ | ✔ | ✔ |
| Crear producto/servicio | ✖ | ✖ | ✔ |
| Actualizar producto/servicio | ✖ | ✖ | ✔ |
| Eliminar producto/servicio | ✖ | ✖ | ✔ |
| Registrar usuario (`/auth/register`) | ✔ | ✔ | ✔ |
| Ver perfil (`/auth/me`) | ✖ | ✔ | ✔ |
| Listar usuarios | ✖ | ✖ | ✔ |
| Cambiar rol usuario | ✖ | ✖ | ✔ |

### Endpoints Principales
| Método | Endpoint | Descripción | Roles |
|--------|----------|-------------|-------|
| POST | `/api/v1/auth/register` | Registro nuevo usuario (customer) | guest, customer, admin |
| POST | `/api/v1/auth/login` | Obtener token Sanctum | guest |
| POST | `/api/v1/auth/logout` | Revocar token | customer, admin |
| GET | `/api/v1/auth/me` | Perfil autenticado | customer, admin |
| GET | `/api/v1/products` | Listado productos (filtros) | todos |
| GET | `/api/v1/products/{id}` | Detalle producto | todos |
| POST | `/api/v1/products` | Crear producto | admin |
| PUT | `/api/v1/products/{id}` | Actualizar producto | admin |
| DELETE | `/api/v1/products/{id}` | Eliminar producto | admin |
| GET | `/api/v1/services` | Listado servicios (filtros) | todos |
| GET | `/api/v1/services/{id}` | Detalle servicio | todos |
| POST | `/api/v1/services` | Crear servicio | admin |
| PUT | `/api/v1/services/{id}` | Actualizar servicio | admin |
| DELETE | `/api/v1/services/{id}` | Eliminar servicio | admin |
| GET | `/api/v1/users` | Listar usuarios | admin |
| PATCH | `/api/v1/users/{id}/role` | Cambiar rol | admin |

### Formato de Errores
Errores genéricos:
```json
{
	"error": {
		"message": "Recurso no encontrado",
		"code": 404
	},
	"meta": { "version": "v1" }
}
```
Errores de validación (HTTP 422):
```json
{
	"message": "Datos de entrada inválidos",
	"errors": {
		"name": ["El campo name es obligatorio."],
		"price": ["El campo price debe ser numérico."]
	}
}
```

### Variables de Entorno Clave
```
APP_ENV=local
APP_URL=http://localhost:8000
CORS_ALLOWED_ORIGINS=http://localhost:3000
SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost
```

### Flujo de Autenticación y Registro
1. `POST /api/v1/auth/register` (name, email, password) crea usuario rol `customer` y retorna token.
2. `POST /api/v1/auth/login` obtiene nuevo token para credenciales válidas.
3. Usar `Authorization: Bearer <token>` en endpoints protegidos.
4. `GET /api/v1/auth/me` devuelve perfil y rol.
5. `POST /api/v1/auth/logout` revoca token.

### Ejemplo de Petición (cURL)
```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
	-H "Content-Type: application/json" \
	-d '{"name":"Juan","email":"juan@example.com","password":"secret123"}'

curl -X POST http://localhost:8000/api/v1/auth/login \
	-H "Content-Type: application/json" \
	-d '{"email":"juan@example.com","password":"secret123"}'
```

### Ejemplo Listado con Filtros
```bash
curl "http://localhost:8000/api/v1/products?category=computadoras&min_price=500&sort=price&direction=asc&per_page=15"
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

### Futuras Mejoras Opcionales
- Métricas y observabilidad (Prometheus / OpenTelemetry).
- Cache de consultas frecuentes (ej. Redis para listados más vistos).
- Búsqueda avanzada (full-text / Elasticsearch).
- Webhooks o colas para eventos de stock.

### Notas
- `cost_price` no se expone para proteger margen.
- Ajustar `SANCTUM_STATEFUL_DOMAINS` si se usan cookies en SPA; este proyecto usa tokens Bearer personales.
- Revisar `docs/openapi.yaml` para detalles completos (incluye `x-roles` en operaciones protegidas).

### Referencia Rápida OpenAPI -> Postman
Se puede importar `docs/openapi.yaml` directamente en Postman / Insomnia para generar colección. Endpoints con seguridad requieren agregar encabezado `Authorization: Bearer <token>`.

