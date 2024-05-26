# API con FlightPHP y JWT
Esta es una API construida con el microframework FlightPHP y utiliza JWT (JSON Web Tokens) para la autenticación y autorización de usuarios. 
En esta API se puede implementar más endpoints para acceder a diferentes recursos y realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en la base de datos.

## Requisitos
* PHP 7.0 o superior
* Composer (Gestor de paquetes)
* Base de datos MySQL u otro compatible
### Instalar 
```
composer require firebase/php-jwt
composer require mikecao/flight
```

## Endpoints
  ### Autenticación
  * `POST /login`: Permite a un usuario autenticarse, se debe enviar un JSON con las credenciales de usuario (correo y contraseña) y devuelve un JSON con el token JWT y status `OK` si la autenticación es exitosa.
  ### Usuarios
  * `POST /registerUser`: Crea un nuevo usuario, se deben proporcionar los datos del usuario en un JSON en el cuerpo de la solicitud.
  * `GET /getUsers`: Obtiene todos los usuarios registrados en la base de datos (Para acceder a este recurso es necesario enviar el token en la cabecera de la solicitud para validar el token)

## Autenticación con JWT
Para acceder a los endpoints protegidos, debes incluir el token JWT en la cabecera `Authorization` de la solicitud. El token se obtiene después de iniciar sesión exitosamente en el endpoint `/login`.
### Ejemplo
```
Authorization: Bearer <token>
```
> [!NOTE]
> Para proteger los endpoints que se vaya a implementar llamar a la función `validarToken` en un condicional.

## Ejemplo de solicitud y respuesta
### Solicitud
```
POST /login
Content-Type: application/json

{
    "email": "test@test.com",
    "contraseña": "test"
}
```
### Respuesta Exitosa
```
HTTP/1.1 200 OK
Content-Type: application/json

{
    "message": "Inicio de sesión exitoso",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxMjM0NTY3ODkwLCJpYXQiOjE2MzI4MzM2NjAsImV4cCI6MTYzMjgzMzc2MH0",
    "status": "OK"
}
```
### Contribuciones
Si deseas contribuir a este proyecto, ¡siéntete libre de hacer un fork y enviar tus pull requests!

### Licencia
Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](https://github.com/jeangr-dev/Authentication_API-JWT/blob/main/LICENSE) para más detalles.


