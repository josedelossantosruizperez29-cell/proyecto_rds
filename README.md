# API REST - Proyecto RDS

API REST desarrollada en Laravel para gestionar empleados, cargos y funciones de cargo. La API usa autenticacion con tokens Bearer mediante Laravel Sanctum, por lo tanto primero se debe registrar o iniciar sesion para obtener un token y despues consumir los endpoints protegidos.

---

## Tabla de contenido

- [Descripcion](#descripcion)
- [Requisitos](#requisitos)
- [Instalacion desde cero](#instalacion-desde-cero)
- [Configuracion de la base de datos](#configuracion-de-la-base-de-datos)
- [Ejecutar el proyecto](#ejecutar-el-proyecto)
- [Autenticacion](#autenticacion)
- [Uso del token](#uso-del-token)
- [Endpoints de empleados](#endpoints-de-empleados)
- [Endpoints de cargos](#endpoints-de-cargos)
- [Endpoints de funciones cargo](#endpoints-de-funciones-cargo)
- [Errores comunes](#errores-comunes)
- [Pruebas](#pruebas)

---

## Descripcion

Este proyecto permite realizar operaciones CRUD sobre:

- Empleados
- Cargos
- Funciones cargo

Tambien incluye un endpoint especial para consultar el detalle completo de un empleado, incluyendo su nombre, cargo, salario y funciones asociadas al cargo.

Todas las rutas principales estan protegidas con Sanctum. Las unicas rutas publicas son:

- `POST /api/register`
- `POST /api/login`

---

## Requisitos

Antes de instalar el proyecto, asegurate de tener instalado:

- PHP 8.3 o superior
- Composer
- MySQL o MariaDB
- Node.js y NPM
- Git
- Laravel compatible con la version del proyecto
- Postman, Insomnia o `curl` para probar la API

El proyecto usa:

- Laravel `^13.8`
- Laravel Sanctum `^4.0`
- PHP `^8.3`
- Vite para los assets del frontend

---

## Instalacion desde cero

### 1. Clonar el repositorio

Primero clona el repositorio en tu maquina:

```bash
git clone URL_DEL_REPOSITORIO
```

Despues entra a la carpeta del proyecto:

```bash
cd proyecto_rds
```

> Reemplaza `URL_DEL_REPOSITORIO` por la URL real del repositorio.

---

### 2. Instalar dependencias de PHP

Ejecuta:

```bash
composer install
```

Este comando instala todas las dependencias de Laravel definidas en `composer.json`.

---

### 3. Instalar dependencias de Node

Ejecuta:

```bash
npm install
```

Este comando instala las dependencias de frontend definidas en `package.json`.

---

### 4. Copiar el archivo de entorno

Laravel usa un archivo `.env` para guardar la configuracion local del proyecto.

Copia el archivo de ejemplo:

```bash
cp .env.example .env
```

Si estas usando PowerShell en Windows, tambien puedes usar:

```powershell
Copy-Item .env.example .env
```

Despues de copiarlo, el archivo generado se llamara:

```text
.env
```

En ese archivo debes colocar tus credenciales, el nombre de la base de datos y la configuracion local del proyecto.

---

### 5. Generar la llave de la aplicacion

Ejecuta:

```bash
php artisan key:generate
```

Este comando genera el valor de `APP_KEY` dentro del archivo `.env`.

---

## Configuracion de la base de datos

Abre el archivo `.env` y configura estas variables:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_rds
DB_USERNAME=root
DB_PASSWORD=
```

Modifica los valores segun tu entorno:

- `DB_DATABASE`: nombre de tu base de datos.
- `DB_USERNAME`: usuario de MySQL.
- `DB_PASSWORD`: contrasena del usuario de MySQL.

Si la base de datos no existe, creala primero antes de ejecutar las migraciones.

Ejemplo desde MySQL:

```sql
CREATE DATABASE proyecto_rds CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Tambien puedes hacerlo desde consola:

```bash
mysql -u root -p
```

Luego ejecutas:

```sql
CREATE DATABASE proyecto_rds CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

Una vez creada la base de datos y configurado el archivo `.env`, ejecuta las migraciones.

---

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

Este comando crea las tablas necesarias en la base de datos.

---

### 7. Ejecutar seeders

```bash
php artisan db:seed
```

Este comando inserta datos iniciales, como cargos y funciones de cargo.

Si quieres reiniciar la base de datos desde cero y cargar los seeders, puedes usar:

```bash
php artisan migrate:fresh --seed
```

> Este ultimo comando elimina las tablas y las vuelve a crear. Usalo solo si no necesitas conservar los datos actuales.

---

## Ejecutar el proyecto

Levanta el servidor de Laravel:

```bash
php artisan serve
```

La API quedara disponible en:

```text
http://127.0.0.1:8000
```

Si necesitas levantar Vite para los assets del frontend:

```bash
npm run dev
```

La URL base para consumir la API sera:

```text
http://127.0.0.1:8000/api
```

---

## Autenticacion

Para consumir los endpoints protegidos primero necesitas un token.

Puedes obtener el token de dos formas:

1. Registrando un usuario nuevo.
2. Iniciando sesion con un usuario existente.

Guarda el token que devuelve la API, porque sera necesario para consultar, crear, actualizar y eliminar empleados, cargos y funciones cargo.

---

## Registrar usuario

Usa este endpoint si el usuario todavia no existe.

```http
POST /api/register
```

Ejemplo con `curl`:

```bash
curl -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Santos",
    "email": "santos@example.com",
    "password": "12345678"
  }'
```

Respuesta esperada:

```json
{
  "message": "Usuario creado correctamente",
  "user": "Santos con sus datos de gmail santos@example.com",
  "token": "TOKEN_GENERADO_POR_LA_API"
}
```

El campo `token` es importante. Debes guardarlo para usarlo en las siguientes peticiones protegidas.

---

## Iniciar sesion

Usa este endpoint si el usuario ya existe.

```http
POST /api/login
```

Ejemplo con `curl`:

```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "santos@example.com",
    "password": "12345678"
  }'
```

Respuesta esperada cuando las credenciales son correctas:

```json
{
  "message": "Login exitoso",
  "token": "TOKEN_GENERADO_POR_LA_API",
  "user": {
    "id": 1,
    "name": "Santos",
    "email": "santos@example.com"
  },
  "mensaje": "Bienvenido: Santos"
}
```

Si el usuario no existe o la contrasena es incorrecta, la API responde:

```json
{
  "message": "Credenciales incorrectas"
}
```

En ese caso debes revisar las credenciales o registrar el usuario primero.

---

## Cerrar sesion

Este endpoint elimina el token actual del usuario autenticado.

```http
POST /api/logout
```

Ejemplo:

```bash
curl -X POST http://127.0.0.1:8000/api/logout \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Respuesta esperada:

```json
{
  "message": "Logout exitoso"
}
```

Despues de cerrar sesion, ese token ya no debe usarse para consumir endpoints protegidos.

---

## Uso del token

Todas las rutas protegidas necesitan este header:

```http
Authorization: Bearer TU_TOKEN_AQUI
```

Tambien se recomienda enviar:

```http
Accept: application/json
Content-Type: application/json
```

Ejemplo:

```bash
curl http://127.0.0.1:8000/api/empleados \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Reemplaza `TU_TOKEN_AQUI` por el token recibido al registrarte o iniciar sesion.

---

## Resumen de endpoints

| Modulo | Metodo | Ruta | Protegida | Descripcion |
| --- | --- | --- | --- | --- |
| Auth | POST | `/api/register` | No | Registrar usuario y generar token |
| Auth | POST | `/api/login` | No | Iniciar sesion y generar token |
| Auth | POST | `/api/logout` | Si | Cerrar sesion y eliminar token actual |
| Empleados | GET | `/api/empleados` | Si | Listar empleados |
| Empleados | POST | `/api/empleados` | Si | Crear empleado |
| Empleados | GET | `/api/empleados/{id}` | Si | Buscar empleado por ID |
| Empleados | GET | `/api/detalle_empleado/{id}` | Si | Consultar detalle completo del empleado |
| Empleados | PUT/PATCH | `/api/empleados/{id}` | Si | Actualizar empleado |
| Empleados | DELETE | `/api/empleados/{id}` | Si | Eliminar empleado |
| Cargos | GET | `/api/cargos` | Si | Listar cargos |
| Cargos | POST | `/api/cargos` | Si | Crear cargo |
| Cargos | GET | `/api/cargos/{id}` | Si | Buscar cargo por ID |
| Cargos | PUT/PATCH | `/api/cargos/{id}` | Si | Actualizar cargo |
| Cargos | DELETE | `/api/cargos/{id}` | Si | Eliminar cargo |
| Funciones cargo | GET | `/api/funcionCargos` | Si | Listar funciones cargo |
| Funciones cargo | POST | `/api/funcionCargos` | Si | Crear funcion cargo |
| Funciones cargo | GET | `/api/funcionCargos/{id}` | Si | Buscar funcion cargo por ID |
| Funciones cargo | PUT/PATCH | `/api/funcionCargos/{id}` | Si | Actualizar funcion cargo |
| Funciones cargo | DELETE | `/api/funcionCargos/{id}` | Si | Eliminar funcion cargo |

---

## Endpoints de empleados

Los empleados pertenecen a un cargo mediante el campo `id_cargo`.

Campos principales:

| Campo | Tipo | Descripcion |
| --- | --- | --- |
| `nombre` | string | Nombre del empleado |
| `apellido` | string | Apellido del empleado |
| `fecha_nacimiento` | date | Fecha de nacimiento en formato `YYYY-MM-DD` |
| `fecha_de_ingreso` | date | Fecha de ingreso en formato `YYYY-MM-DD` |
| `salario` | decimal | Salario del empleado |
| `estado` | enum | Puede ser `activo` o `inactivo` |
| `id_cargo` | integer | ID de un cargo existente |

---

### Consultar todos los empleados

```http
GET /api/empleados
```

```bash
curl http://127.0.0.1:8000/api/empleados \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Si existen empleados, devuelve un arreglo con todos los registros.

Si no hay empleados registrados:

```json
{
  "message": "No se encontraron empleados registrados"
}
```

---

### Buscar empleado por ID

```http
GET /api/empleados/{id}
```

Ejemplo:

```bash
curl http://127.0.0.1:8000/api/empleados/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Si el empleado no existe:

```json
{
  "message": "Empleado no encontrado"
}
```

---

### Consultar detalle de empleado

Este endpoint devuelve un resumen del empleado con su cargo, salario y funciones del cargo.

```http
GET /api/detalle_empleado/{id}
```

Ejemplo:

```bash
curl http://127.0.0.1:8000/api/detalle_empleado/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Respuesta esperada:

```json
{
  "empleado": "Juan Perez",
  "cargo": "Desarrollador Backend",
  "salario": "25000.00",
  "funciones": [
    "Gestionar la base de datos",
    "Administrar servidores"
  ]
}
```

---

### Crear empleado

```http
POST /api/empleados
```

Ejemplo:

```bash
curl -X POST http://127.0.0.1:8000/api/empleados \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nombre": "Juan",
    "apellido": "Perez",
    "fecha_nacimiento": "1998-05-10",
    "fecha_de_ingreso": "2024-01-15",
    "salario": 25000,
    "estado": "activo",
    "id_cargo": 1
  }'
```

Respuesta esperada:

```json
{
  "message": "Empleado creado correctamente",
  "Empleado Creado": {
    "nombre": "Juan",
    "apellido": "Perez",
    "fecha_nacimiento": "1998-05-10",
    "fecha_de_ingreso": "2024-01-15",
    "salario": 25000,
    "estado": "activo",
    "id_cargo": 1
  }
}
```

---

### Actualizar empleado

```http
PUT /api/empleados/{id}
```

Ejemplo:

```bash
curl -X PUT http://127.0.0.1:8000/api/empleados/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nombre": "Juan Carlos",
    "apellido": "Perez Gomez",
    "fecha_nacimiento": "1998-05-10",
    "fecha_de_ingreso": "2024-01-15",
    "salario": 3000000,
    "estado": "activo",
    "id_cargo": 1
  }'
```

Respuesta esperada:

```json
{
  "message": "Datos del empleado actualizados correctamente",
  "Empleado Actualizado": {
    "id": 1,
    "nombre": "Juan Carlos",
    "apellido": "Perez Gomez"
  }
}
```

---

### Eliminar empleado

```http
DELETE /api/empleados/{id}
```

Ejemplo:

```bash
curl -X DELETE http://127.0.0.1:8000/api/empleados/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Respuesta esperada:

```json
{
  "message": "Empleado eliminado correctamente"
}
```

---

## Endpoints de cargos

Los cargos representan los puestos o roles que pueden tener los empleados.

Campos principales:

| Campo | Tipo | Descripcion |
| --- | --- | --- |
| `nombre_cargo` | string | Nombre del cargo |
| `descripcion` | string | Descripcion del cargo |

---

### Consultar todos los cargos

```http
GET /api/cargos
```

```bash
curl http://127.0.0.1:8000/api/cargos \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Si no existen cargos:

```json
{
  "message": "No se encontraron cargos"
}
```

---

### Buscar cargo por ID

```http
GET /api/cargos/{id}
```

```bash
curl http://127.0.0.1:8000/api/cargos/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Si el cargo no existe:

```json
{
  "message": "Cargo no encontrado"
}
```

---

### Crear cargo

```http
POST /api/cargos
```

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

Respuesta esperada:

```json
{
  "message": "Cargo creado correctamente",
  "Cargo Creado": {
    "nombre_cargo": "Desarrollador Backend",
    "descripcion": "Encargado de desarrollar y mantener la API"
  }
}
```

---

### Actualizar cargo

```http
PUT /api/cargos/{id}
```

```bash
curl -X PUT http://127.0.0.1:8000/api/cargos/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nombre_cargo": "Arquitecto de Software",
    "descripcion": "Disena la estructura tecnica del sistema"
  }'
```

Respuesta esperada:

```json
{
  "message": "Datos del cargo actualizados correctamente",
  "Cargo Actualizado": {
    "id": 1,
    "nombre_cargo": "Arquitecto de Software",
    "descripcion": "Disena la estructura tecnica del sistema"
  }
}
```

---

### Eliminar cargo

```http
DELETE /api/cargos/{id}
```

```bash
curl -X DELETE http://127.0.0.1:8000/api/cargos/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Respuesta esperada:

```json
{
  "message": "Cargo eliminado correctamente"
}
```

---

## Endpoints de funciones cargo

Las funciones cargo representan las actividades o responsabilidades asociadas a un cargo.

La ruta usa el nombre:

```text
/api/funcionCargos
```

Campos principales:

| Campo | Tipo | Descripcion |
| --- | --- | --- |
| `descripcion_funcion` | string | Descripcion de la funcion |
| `estado` | enum | Puede ser `activo` o `inactivo` |
| `id_cargo` | integer | ID de un cargo existente |

---

### Consultar todas las funciones cargo

```http
GET /api/funcionCargos
```

```bash
curl http://127.0.0.1:8000/api/funcionCargos \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Si no existen funciones cargo:

```json
{
  "message": "No se encontraron funciones de cargos"
}
```

---

### Buscar funcion cargo por ID

```http
GET /api/funcionCargos/{id}
```

```bash
curl http://127.0.0.1:8000/api/funcionCargos/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Si la funcion cargo no existe:

```json
{
  "message": "Funcion de cargo no encontrado"
}
```

---

### Crear funcion cargo

```http
POST /api/funcionCargos
```

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

Respuesta esperada:

```json
{
  "message": "Funcion de cargo creada correctamente",
  "Funcion de Cargo Creada": {
    "descripcion_funcion": "Gestionar la base de datos",
    "estado": "activo",
    "id_cargo": 1
  }
}
```

---

### Actualizar funcion cargo

```http
PUT /api/funcionCargos/{id}
```

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

Respuesta esperada:

```json
{
  "message": "Datos de la funcion de cargo actualizados correctamente",
  "Funcion de Cargo Actualizado": {
    "id": 1,
    "descripcion_funcion": "Administrar servidores",
    "estado": "inactivo",
    "id_cargo": 1
  }
}
```

---

### Eliminar funcion cargo

```http
DELETE /api/funcionCargos/{id}
```

```bash
curl -X DELETE http://127.0.0.1:8000/api/funcionCargos/1 \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

Respuesta esperada:

```json
{
  "message": "Funcion de cargo eliminada correctamente"
}
```

---

## Flujo recomendado para probar la API

1. Clona el repositorio.
2. Instala dependencias con `composer install` y `npm install`.
3. Copia `.env.example` como `.env`.
4. Configura las credenciales de base de datos en `.env`.
5. Crea la base de datos si no existe.
6. Ejecuta `php artisan key:generate`.
7. Ejecuta `php artisan migrate --seed`.
8. Levanta el servidor con `php artisan serve`.
9. Registra un usuario o inicia sesion.
10. Guarda el token generado.
11. Usa el token en el header `Authorization: Bearer TU_TOKEN_AQUI`.
12. Consume los endpoints de cargos, funciones cargo y empleados.

Un orden practico para probar los datos es:

1. Crear o listar cargos.
2. Crear funciones para un cargo.
3. Crear empleados usando un `id_cargo` existente.
4. Consultar el detalle del empleado con `/api/detalle_empleado/{id}`.

---

## Errores comunes

### Token no enviado o invalido

Si intentas consumir una ruta protegida sin token, Laravel respondera con un error de autenticacion.

Solucion:

```http
Authorization: Bearer TU_TOKEN_AQUI
```

---

### Credenciales incorrectas al iniciar sesion

Respuesta:

```json
{
  "message": "Credenciales incorrectas"
}
```

Solucion:

- Verifica el correo.
- Verifica la contrasena.
- Si el usuario no existe, registralo primero en `/api/register`.

---

### Registro con email repetido

El campo `email` debe ser unico. Si intentas registrar dos veces el mismo correo, Laravel devolvera un error de validacion.

Solucion:

- Usa otro correo.
- O inicia sesion con el usuario existente.

---

### ID no encontrado

Si consultas, actualizas o eliminas un registro que no existe, la API devuelve mensajes como:

```json
{
  "message": "Empleado no encontrado"
}
```

```json
{
  "message": "Cargo no encontrado"
}
```

```json
{
  "message": "Funcion de cargo no encontrado"
}
```

Solucion:

- Revisa que el ID exista.
- Lista primero los registros con `GET`.

---

### Error de base de datos

Puede ocurrir si:

- La base de datos no existe.
- Las credenciales del `.env` estan mal.
- No se han ejecutado las migraciones.
- Se envia un `id_cargo` que no existe.

Solucion:

```bash
php artisan migrate --seed
```

Y revisa:

```env
DB_DATABASE=proyecto_rds
DB_USERNAME=root
DB_PASSWORD=
```

---

## Pruebas

Para ejecutar todas las pruebas:

```bash
php artisan test
```

Para ejecutar pruebas especificas:

```bash
php artisan test --filter=CargoTest
```

```bash
php artisan test --filter=FuncionCargoTest
```

```bash
php artisan test --filter=EmpleadoTest
```

Tambien existen pruebas relacionadas con crear, buscar, actualizar y eliminar empleados.

---

## Autor

Jose de Los Santos Ruiz Perez
