# 4-5 Actividad Integradora - Modelo Vista Controlador

## Descripción

Aplicación web desarrollada con CodeIgniter 4 que implementa el patrón de diseño MVC (Modelo-Vista-Controlador) para la gestión de usuarios con sistema de autenticación.

## Tecnologías utilizadas

- **Framework**: CodeIgniter 4.3.5
- **Base de datos**: MySQL 8.0
- **Servidor web**: PHP 8.2 Built-in Server
- **Contenedorización**: Docker & Docker Compose
- **Gestión de dependencias**: Composer

## Requisitos previos

- Docker Desktop instalado
- Docker Compose instalado
- Puerto 8000 disponible (aplicación web)
- Puerto 3306 disponible (MySQL)

## Instalación y configuración

### 1. Clonar el repositorio y navegar al directorio

```bash
cd 4-5-actividad-integradora-modelo-vista-controlador
```

### 2. Construir las imágenes Docker

```bash
docker compose build --no-cache
```

### 3. Iniciar los contenedores

```bash
docker compose up -d
```

Esto iniciará dos servicios:
- `php_app_integradora_4_5`: Servidor PHP con CodeIgniter 4
- `mysql_integradora_4_5`: Base de datos MySQL

### 4. Verificar el estado de los contenedores

```bash
docker compose ps
```

### 5. Instalar dependencias de Composer (si es necesario)

```bash
docker compose exec php composer install
```

### 6. Verificar las migraciones de base de datos

```bash
docker compose exec php php spark migrate:status
```

Si las migraciones no se han ejecutado, ejecutar:

```bash
docker compose exec php php spark migrate
```

## Acceso a la aplicación

- **URL de la aplicación**: http://localhost:8000
- **MySQL**: localhost:3306
  - Usuario: `root`
  - Contraseña: `root`
  - Base de datos: `elvia`

## Configuración

### Archivo .env

El archivo `.env` contiene la configuración principal:

```env
# Entorno
CI_ENVIRONMENT = development

# URL base de la aplicación
app.baseURL = 'http://localhost:8000/'

# Configuración de base de datos
database.default.hostname = mysql_integradora_4_5
database.default.database = elvia
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi

# Clave de encriptación (generada con php spark key:generate)
encryption.key = hex2bin:5530ef5d2ac0791f5f4b4927b4c09a4f5b1b834cc00f8a39466d2d853314b1c0
```

## Comandos útiles de CodeIgniter 4

### Migraciones

```bash
# Ver estado de migraciones
docker compose exec php php spark migrate:status

# Ejecutar migraciones
docker compose exec php php spark migrate

# Revertir última migración
docker compose exec php php spark migrate:rollback
```

### Generadores de código

```bash
# Crear controlador
docker compose exec php php spark make:controller NombreController

# Crear modelo
docker compose exec php php spark make:model NombreModel

# Crear migración
docker compose exec php php spark make:migration NombreMigracion
```

### Utilidades

```bash
# Listar todos los comandos disponibles
docker compose exec php php spark list

# Limpiar caché
docker compose exec php php spark cache:clear

# Generar nueva clave de encriptación
docker compose exec php php spark key:generate
```

## Gestión de contenedores Docker

```bash
# Iniciar contenedores
docker compose up -d

# Detener contenedores
docker compose down

# Ver logs de PHP
docker compose logs php

# Ver logs de MySQL
docker compose logs mysql

# Reiniciar un servicio específico
docker compose restart php

# Acceder al contenedor PHP
docker compose exec php bash

# Acceder al contenedor MySQL
docker compose exec mysql bash
```

## Estructura del proyecto

```
4-5-actividad-integradora-modelo-vista-controlador/
├── app/
│   ├── Config/          # Archivos de configuración
│   │   ├── App.php      # Configuración general
│   │   ├── Database.php # Configuración de base de datos
│   │   └── Routes.php   # Definición de rutas
│   ├── Controllers/     # Controladores MVC
│   ├── Models/          # Modelos de datos
│   ├── Views/           # Vistas (templates)
│   └── Database/
│       └── Migrations/  # Migraciones de base de datos
├── public/              # Directorio público (DocumentRoot)
│   └── index.php        # Punto de entrada
├── writable/            # Directorio con permisos de escritura
│   ├── cache/           # Caché de la aplicación
│   ├── logs/            # Logs de la aplicación
│   └── session/         # Datos de sesión
├── .env                 # Variables de entorno
├── docker-compose.yml   # Configuración de Docker Compose
├── Dockerfile           # Imagen Docker personalizada
└── composer.json        # Dependencias PHP
```

## Extensiones PHP instaladas

El contenedor Docker incluye las siguientes extensiones PHP:

- `pdo` - Para operaciones de base de datos
- `pdo_mysql` - Driver PDO para MySQL
- `mysqli` - Driver MySQLi para CodeIgniter
- `intl` - Internacionalización
- `opcache` - Optimización de rendimiento
- `sodium` - Funciones criptográficas modernas

## Solución de problemas

### La aplicación no carga

```bash
# Verificar que los contenedores estén corriendo
docker compose ps

# Ver logs de errores
docker compose logs php

# Reiniciar los servicios
docker compose restart
```

### Error de conexión a base de datos

```bash
# Verificar que MySQL esté corriendo
docker compose exec mysql mysql -u root -proot -e "SELECT 1"

# Verificar las tablas creadas
docker compose exec mysql mysql -u root -proot -e "USE elvia; SHOW TABLES;"
```

### Permisos de escritura

```bash
# Dar permisos a directorios writable
docker compose exec php chmod -R 777 writable/
```

## Documentación adicional

- [Documentación oficial de CodeIgniter 4](https://codeigniter4.github.io/userguide/)
- [Guía de instalación de CodeIgniter 4](https://codeigniter.com/user_guide/installation/running.html)
- [Docker Documentation](https://docs.docker.com/)

## Licencia

Este proyecto es parte de una actividad académica integradora.
