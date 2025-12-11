<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>API Ventas-PC · Documentación</title>
    
    <!-- Fuentes: Inter para texto, JetBrains Mono para código -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Estilos CSS -->
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary: #3b82f6; /* Azul brillante */
            --primary-dark: #1d4ed8;
            --border: #e2e8f0;
            
            /* Métodos HTTP Colors (estilo Postman) */
            --get-bg: #dcfce7; --get-text: #14532d; --get-border: #86efac;      /* GET: verde */
            --post-bg: #fef3c7; --post-text: #7c2d12; --post-border: #fcd34d;  /* POST: amarillo */
            --put-bg: #dbeafe; --put-text: #1e3a8a; --put-border: #93c5fd;    /* PUT: azul */
            --patch-bg: #ede9fe; --patch-text: #4c1d95; --patch-border: #c4b5fd;/* PATCH: morado */
            --delete-bg: #fee2e2; --delete-text: #7f1d1d; --delete-border: #fca5a5;/* DELETE: rojo */
        }

        /* Reset & Base */
        * { box-sizing: border-box; }
        body { 
            margin: 0; 
            font-family: 'Inter', system-ui, sans-serif; 
            background: var(--bg); 
            color: var(--text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Utility Layouts */
        .container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
        .grid { display: grid; gap: 24px; }
        .grid-2 { grid-template-columns: 1fr; }
        .grid-3 { grid-template-columns: 1fr; }
        
        @media (min-width: 768px) {
            .grid-2 { grid-template-columns: repeat(2, 1fr); }
            .grid-3 { grid-template-columns: repeat(3, 1fr); }
            .hero { text-align: center; }
            .hero-actions { justify-content: center; }
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 60px 20px;
            margin-bottom: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 200px; height: 200px;
            background: linear-gradient(to bottom left, #dbeafe, transparent);
            border-radius: 50%;
            z-index: 0;
            opacity: 0.6;
        }

        .hero-content { position: relative; z-index: 1; }
        
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            border: 1px solid #bfdbfe;
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin: 0 0 16px 0;
            background: -webkit-linear-gradient(315deg, #1e293b 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.125rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 32px auto;
        }

        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        .btn-primary {
            background: var(--primary);
            color: white;
            border: 1px solid var(--primary);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }
        .btn-secondary {
            background: white;
            color: var(--text-main);
            border: 1px solid var(--border);
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .btn-secondary:hover { border-color: var(--text-muted); background: #f8fafc; }

        /* Cards */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }
        .card-header { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
        .card-icon {
            width: 36px; height: 36px;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .card h2 { margin: 0; font-size: 1.1rem; font-weight: 700; }
        .card p { color: var(--text-muted); font-size: 0.9rem; margin: 0; }

        /* Lists */
        .feature-list { list-style: none; padding: 0; margin: 16px 0 0 0; }
        .feature-list li {
            display: flex; justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }
        .feature-list li:last-child { border-bottom: none; }
        .mono { 
            font-family: 'JetBrains Mono', monospace; 
            font-size: 0.8rem; 
            background: #f1f5f9; 
            padding: 2px 6px; 
            border-radius: 4px; 
            color: var(--text-main);
        }

        /* Endpoints Styling */
        .endpoint-group { margin-bottom: 16px; }
        .endpoint-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid var(--border);
            margin-bottom: 8px;
            border-radius: 8px;
            background: #fff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            transition: border-color 0.2s;
        }
        .endpoint-item:hover { border-color: var(--primary); }
        
        .method {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            width: 60px;
            text-align: center;
            border: 1px solid transparent;
        }
            .get { background: var(--get-bg); color: var(--get-text); border-color: var(--get-border); }
            .post { background: var(--post-bg); color: var(--post-text); border-color: var(--post-border); }
        .put { background: var(--put-bg); color: var(--put-text); border-color: var(--put-border); }
        .patch { background: var(--patch-bg); color: var(--patch-text); border-color: var(--patch-border); }
        .delete { background: var(--delete-bg); color: var(--delete-text); border-color: var(--delete-border); }

        .path { color: var(--text-main); font-weight: 500; margin-left: 12px; }
        .pill-role { 
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem; 
            color: var(--text-muted); 
            background: #f1f5f9; 
            padding: 2px 8px; 
            border-radius: 99px; 
        }

        /* Table */
        .role-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        .role-table th { text-align: left; color: var(--text-muted); font-weight: 500; padding: 10px; border-bottom: 2px solid #f1f5f9; }
        .role-table td { padding: 10px; border-bottom: 1px solid #f1f5f9; color: var(--text-main); }
        .check { color: #16a34a; font-weight: bold; }
        .cross { color: #e2e8f0; }

        /* Footer */
        footer { margin-top: 60px; text-align: center; font-size: 0.9rem; color: var(--text-muted); border-top: 1px solid var(--border); padding-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    
    <!-- Hero Principal -->
    <div class="hero">
        <div class="hero-content">
            <div class="badge-pill">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                v1.0 Stable
            </div>
            <h1>API Ventas-PC</h1>
            <p>Una API RESTful robusta y escalable para la gestión de inventario tecnológico. <br>Seguridad con Sanctum, roles granulares y respuestas estandarizadas.</p>
            
            <div class="hero-actions">
                <a href="https://github.com/SirAxLord/API-Ventas-PC" target="_blank" class="btn btn-primary">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 3a7 7 0 110 14 7 7 0 010-14z"/></svg>
                    Ver en GitHub
                </a>
                <a href="{{ route('postman.collection.download') }}" class="btn btn-secondary">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Descargar JSON para Postman
                </a>
            </div>
        </div>
    </div>

    <!-- Grid de Información -->
    <div class="grid grid-3">
        <!-- Tech Stack -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h2>Stack Tecnológico</h2>
            </div>
            <p>Construida sobre estándares modernos de la industria.</p>
            <ul class="feature-list">
                <li><span>Core</span> <span class="mono">Laravel 10</span></li>
                <li><span>Auth</span> <span class="mono">Sanctum</span></li>
                <li><span>Docs</span> <span class="mono">OpenAPI 3.0</span></li>
                <li><span>DB</span> <span class="mono">MySQL 8</span></li>
            </ul>
        </div>

        <!-- Instrucciones Rápidas -->
        <div class="card" style="grid-column: span 2;">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 11 9 13.5 9 11l-2-2m0 0l5-5m-5 5l-5 5"/></svg>
                </div>
                <h2>Primeros Pasos</h2>
            </div>
            <p style="margin-bottom: 12px;">El flujo de autenticación es simple y seguro.</p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <strong style="font-size:0.9rem; display:block; margin-bottom:4px;">1. Obtén tu Token</strong>
                    <p style="font-size:0.85rem">Realiza un POST a <span class="mono">/api/v1/auth/login</span> con tus credenciales.</p>
                </div>
                <div>
                    <strong style="font-size:0.9rem; display:block; margin-bottom:4px;">2. Autoriza</strong>
                    <p style="font-size:0.85rem">Incluye el header <span class="mono">Authorization: Bearer {token}</span>.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Endpoints -->
    <h2 style="margin: 40px 0 20px 0; font-size: 1.5rem;">Recursos Disponibles</h2>
    
    <div class="grid grid-2">
        <!-- Productos -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h2>Productos</h2>
            </div>
            <div class="endpoint-group">
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method get">GET</span>
                        <span class="path">/api/v1/products</span>
                    </div>
                    <span class="pill-role">Public</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method get">GET</span>
                        <span class="path">/api/v1/products/{id}</span>
                    </div>
                    <span class="pill-role">Public</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method post">POST</span>
                        <span class="path">/api/v1/products</span>
                    </div>
                    <span class="pill-role">Admin</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method put">PUT</span>
                        <span class="path">/products/{id}</span>
                    </div>
                    <span class="pill-role">Admin</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method delete">DELETE</span>
                        <span class="path">/products/{id}</span>
                    </div>
                    <span class="pill-role">Admin</span>
                </div>
            </div>
        </div>

        <!-- Servicios (NUEVO) -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h2>Servicios</h2>
            </div>
            <div class="endpoint-group">
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method get">GET</span>
                        <span class="path">/api/v1/services</span>
                    </div>
                    <span class="pill-role">Public</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method get">GET</span>
                        <span class="path">/api/v1/services/{id}</span>
                    </div>
                    <span class="pill-role">Public</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method post">POST</span>
                        <span class="path">/api/v1/services</span>
                    </div>
                    <span class="pill-role">Admin</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method put">PUT</span>
                        <span class="path">/api/v1/services/{id}</span>
                    </div>
                    <span class="pill-role">Admin</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method delete">DELETE</span>
                        <span class="path">/api/v1/services/{id}</span>
                    </div>
                    <span class="pill-role">Admin</span>
                </div>
            </div>
        </div>

        <!-- Auth -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2>Autenticación</h2>
            </div>
            <div class="endpoint-group">
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method post">POST</span>
                        <span class="path">/api/v1/auth/register</span>
                    </div>
                    <span class="pill-role">Guest</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method post">POST</span>
                        <span class="path">/api/v1/auth/login</span>
                    </div>
                    <span class="pill-role">Guest</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method get">GET</span>
                        <span class="path">/api/v1/auth/me</span>
                    </div>
                    <span class="pill-role">Auth</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method post">POST</span>
                        <span class="path">/api/v1/auth/logout</span>
                    </div>
                    <span class="pill-role">Auth</span>
                </div>
            </div>
        </div>

        <!-- Usuarios (NUEVO) -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h2>Usuarios</h2>
            </div>
            <div class="endpoint-group">
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method get">GET</span>
                        <span class="path">/api/v1/users</span>
                    </div>
                    <span class="pill-role">Admin</span>
                </div>
                <div class="endpoint-item">
                    <div style="display:flex; align-items:center;">
                        <span class="method patch">PATCH</span>
                        <span class="path">/api/v1/users/{id}/role</span>
                    </div>
                    <span class="pill-role">Admin</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Roles -->
    <div class="card" style="margin-top: 24px;">
        <div class="card-header">
            <div class="card-icon">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h2>Matriz de Permisos</h2>
        </div>
        <div style="overflow-x: auto;">
            <table class="role-table">
                <thead>
                    <tr>
                        <th>Acción</th>
                        <th style="text-align:center">Invitado</th>
                        <th style="text-align:center">Cliente</th>
                        <th style="text-align:center">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ver Catálogo</td>
                        <td style="text-align:center"><span class="check">✔</span></td>
                        <td style="text-align:center"><span class="check">✔</span></td>
                        <td style="text-align:center"><span class="check">✔</span></td>
                    </tr>
                    <tr>
                        <td>Modificar Inventario</td>
                        <td style="text-align:center"><span class="cross">●</span></td>
                        <td style="text-align:center"><span class="cross">●</span></td>
                        <td style="text-align:center"><span class="check">✔</span></td>
                    </tr>
                    <tr>
                        <td>Gestión de Usuarios</td>
                        <td style="text-align:center"><span class="cross">●</span></td>
                        <td style="text-align:center"><span class="cross">●</span></td>
                        <td style="text-align:center"><span class="check">✔</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>© {{ date('Y') }} API Ventas-PC. Diseñado para demostración técnica.</p>
        <p style="font-size: 0.8rem">Rate Limit: 60 req/min · Timezone: UTC</p>
    </footer>

</div>

</body>
</html>