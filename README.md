# BACKEND
Descripción
En este proyecto se utilizó la versión Symfony 5.3.16 (env: dev, debug: true) y como base de datos se usó Mysql (Maria DB).

La carpeta backend.zip se envía sin la carpeta vendor (por favor recordar instalar todas las dependencias con "composer install").

Para la autenticación, se utilizó JWT (JSON Web Tokens), y las llaves privadas y públicas se encuentran en la carpeta JWT de la raíz del proyecto.

Base de datos
El archivo db.sql se envía como referencia ya que con utilizar el comando php bin/console doctrine:schema:update –force se reconstruye la base de datos.

Pruebas
Las funcionalidades de los endpoints fueron desarrolladas para ser validadas con tokens de usuario JWT. Las pruebas se realizaron utilizando POSTMAN.

Para realizar las pruebas con POSTMAN, se debe tener en cuenta que los endpoints de registro y login no requieren de un token, pero sí se debe usar el encabezado "Content-Type: application/json". Para el endpoint de listar usuarios, se utiliza el encabezado "Authorization: Bearer....".

Los endpoints de login y registro se realizan mediante el método POST, mientras que el de listar usuarios se realiza mediante GET.