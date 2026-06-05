# CRUD de Empleados - Laravel API

## 1. Clonar el proyecto

```bash
git clone <url-del-repositorio>
cd proyecto_rds
```

## 2. Instalar dependencias

```bash
composer install
```

## 3. Configurar el archivo .env

Copiar el archivo de ejemplo:

```bash
cp .env.example .env
```

Abrir el archivo `.env` y configurar la conexión a la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_rds
DB_USERNAME=root
DB_PASSWORD=
```

## 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

## 5. Ejecutar las migraciones y los seedear esto para crear cargos asi podemos crear un empleado sin obstaculos

```bash
php artisan migrate --seed
```

## 6. Iniciar el servidor

```bash
php artisan serve
```

La API estará disponible en:

```text
http://127.0.0.1:8000
```

# Operaciones CRUD de Empleados

## Listar empleados

### Solicitud

```http
GET /api/empleados
```

### Ejemplo

```bash
$ curl http://127.0.0.1:8000/api/empleados -H "Authorization: Bearer TU_TOKEN" -H "Content-Type: application/json"

```

---

## Crear empleado

### Solicitud

```http
POST /api/empleados
```

### Ejemplo

```bash
curl -X POST http://127.0.0.1:8000/api/empleados -H "Authorization: Bearer TU_TOKEN" -H "Content-Type: application/json" -d '{"nombre":"Jose","apellido":"Ruiz","fecha_nacimiento":"2000-05-10","fecha_de_ingreso":"2024-01-15","salario":20000,"id_cargo":1}'

```

---

## Actualizar empleado

### Solicitud

```http
PUT /api/empleados/{id}
```

### Ejemplo

```bash
$ curl -X PUT http://127.0.0.1:8000/api/empleados/6 -H "Authorization: Bearer 5|7TVnTp5G1KMXo6m2pmA5S5wYc2zFLyEiLbCYnr9q8a379168" -H "Content-Type: application/json" -d '{"nombre":"Ruiz","apellido":"perez"}'

```

---

## Eliminar empleado

### Solicitud

```http
DELETE /api/empleados/{id}
```

### Ejemplo

```bash
curl -X DELETE http://127.0.0.1:8000/api/empleados/1 \
-H "Accept: application/json"
```

# Ejecutar pruebas

Para ejecutar todas las pruebas automatizadas:

```bash
php artisan test
```
