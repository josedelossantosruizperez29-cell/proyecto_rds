# API REST - Proyecto RDS

API REST desarrollada en Laravel para la gestión de empleados, cargos y funciones cargo, con autenticación mediante Laravel Sanctum.

---

## Descripción

Este proyecto permite realizar operaciones CRUD sobre:

- Empleados
- Cargos
- Funciones cargo

Además, protege las rutas mediante autenticación con token Bearer usando Sanctum.

---

## Requisitos

Antes de ejecutar el proyecto asegúrate de tener instalado:

- PHP 8.x o superior
- Composer
- MySQL
- Node.js y NPM
- Git
- Laravel compatible con la versión del proyecto

---

## Instalación del proyecto

### 1. Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
cd NOMBRE_DEL_PROYECTO
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Crear el archivo de entorno

Copia el archivo `.env.example` y renómbralo a `.env`.

```bash
cp .env.example .env
```

En Windows Git Bash también puedes hacerlo manualmente.

### 4. Configurar la base de datos

Abre el archivo `.env` y ajusta estos datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Generar la llave de la aplicación

```bash
php artisan key:generate
```

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

### 7. Ejecutar seeders, si deseas datos de prueba

```bash
php artisan db:seed
```

Si deseas crear la base de datos desde cero con datos de prueba:

```bash
php artisan migrate:fresh --seed
```

### 8. Levantar el servidor

```bash
php artisan serve
```

La aplicación normalmente quedará disponible en:

```text
http://127.0.0.1:8000
```

---

## Autenticación

La API utiliza Laravel Sanctum.  
Para consumir los endpoints protegidos debes enviar el token en la cabecera:

```http
Authorization: Bearer TU_TOKEN_AQUI
```
## De esta forma nos registramos en caso tal deque nuestro usuario no exista
```bash
curl -X POST http://127.0.0.1:8000/api/register \ -H "Accept: application/json" \ -H "Content-Type: application/json" \ -d "{"name":"Juan Perez","email":"juan@example.com","password":"12345678"}"  
Respuesta esperada: mensaje de confirmación, datos básicos del usuario y token.
```
### Ejemplo de autenticación con curl de esta forma nos auttenticamos y obtendremos nuestro token el cual nos servira para hacer las peticiones 
```bash
curl -X POST http://127.0.0.1:8000/api/login \ -H "Accept: application/json" \ -H "Content-Type: application/json" \ -d "{"email":"juan@example.com","password":"12345678"}"  
La respuesta incluye el token que debe copiarse para consumir las rutas protegidas.
```
```bash
curl http://127.0.0.1:8000/api/cargos \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

---

## Uso de la API

La API organiza sus recursos en tres módulos principales:

- Empleados
- Cargos
- Funciones cargo

Cada módulo permite consultar, crear, actualizar y eliminar registros.

---

# 1. Empleados

## Listar empleados

```bash
curl http://127.0.0.1:8000/api/empleados \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

## Obtener un empleado por ID

```bash
curl http://127.0.0.1:8000/api/empleados/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

## Crear empleado

```bash
curl -X POST http://127.0.0.1:8000/api/empleados \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{
    "nombre": "Juan",
    "apellido": "Pérez",
    "fecha_nacimiento": "1998-05-10",
    "fecha_de_ingreso": "2024-01-15",
    "salario": 2500000,
    "estado": "activo",
    "id_cargo": 1
}'
```

## Actualizar empleado

```bash
curl -X PUT http://127.0.0.1:8000/api/empleados/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{
    "nombre": "Juan Carlos",
    "apellido": "Pérez Gómez",
    "fecha_nacimiento": "1998-05-10",
    "fecha_de_ingreso": "2024-01-15",
    "salario": 3000000,
    "estado": "activo",
    "id_cargo": 1
}'
```

## Eliminar empleado

```bash
curl -X DELETE http://127.0.0.1:8000/api/empleados/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

---

# 2. Cargos

## Listar cargos

```bash
curl http://127.0.0.1:8000/api/cargos \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

## Obtener un cargo por ID

```bash
curl http://127.0.0.1:8000/api/cargos/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

## Crear cargo

```bash
curl -X POST http://127.0.0.1:8000/api/cargos \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{
    "nombre_cargo": "Desarrollador Backend",
    "descripcion": "Encargado de desarrollar y mantener la API"
}'
```

## Actualizar cargo

```bash
curl -X PUT http://127.0.0.1:8000/api/cargos/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{
    "nombre_cargo": "Arquitecto de Software",
    "descripcion": "Diseña la estructura técnica del sistema"
}'
```

## Eliminar cargo

```bash
curl -X DELETE http://127.0.0.1:8000/api/cargos/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

---

# 3. Funciones cargo

## Listar funciones cargo

```bash
curl http://127.0.0.1:8000/api/funcionCargos \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

## Obtener una función cargo por ID

```bash
curl http://127.0.0.1:8000/api/funcionCargos/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

## Crear función cargo

```bash
curl -X POST http://127.0.0.1:8000/api/funcionCargos \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{
    "descripcion_funcion": "Gestionar la base de datos",
    "estado": "activo",
    "id_cargo": 1
}'
```

## Actualizar función cargo

```bash
curl -X PUT http://127.0.0.1:8000/api/funcionCargos/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{
    "descripcion_funcion": "Administrar servidores",
    "estado": "inactivo",
    "id_cargo": 1
}'
```

## Eliminar función cargo

```bash
curl -X DELETE http://127.0.0.1:8000/api/funcionCargos/1 \
-H "Authorization: Bearer TU_TOKEN_AQUI" \
-H "Accept: application/json"
```

---

## Respuestas esperadas

### Éxito

- `200 OK` para consultas, actualizaciones y eliminaciones exitosas
- `201 Created` para creación de registros

### Errores comunes

- `401 Unauthorized`: no se envió token o el token no es válido
- `404 Not Found`: el registro no existe
- `422 Unprocessable Content`: datos inválidos o campos requeridos faltantes

---

## Ejecución de pruebas

El proyecto cuenta con pruebas automatizadas para validar autenticación y CRUD.

### Ejecutar todas las pruebas

```bash
php artisan test
```

### Ejecutar pruebas de cargos

```bash
php artisan test --filter=CargoTest
```

### Ejecutar pruebas de funciones cargo

```bash
php artisan test --filter=FuncionCargoTest
```

### Ejecutar pruebas de empleados

```bash
php artisan test --filter=EmpleadoTest
```

---

## Validación con Sanctum

Las rutas protegidas requieren autenticación.  
El formato correcto del encabezado es:

```http
Authorization: Bearer TU_TOKEN_AQUI
```

Sin este token la API responderá con acceso denegado.

---

## Notas importantes

- Para probar correctamente los endpoints primero debes autenticarte.
- Los ejemplos de `curl` están pensados para Git Bash o terminal similar.
- Si tu proyecto usa nombres de rutas diferentes, reemplaza el endpoint por el que aparezca en `php artisan route:list`.
- Antes de enviar un `POST` o `PUT`, asegúrate de que el `id_cargo` exista si el campo es requerido por la relación.

---

## Autor
Jose de Los Santos Ruiz Perez