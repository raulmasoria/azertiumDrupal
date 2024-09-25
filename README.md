Bienvenidos a la prueba de Azertium.

En esta prueba se pide la creación de un bloque custom de código que tiene que mostrar lo siguiente:

    1. El total de comentarios del usuario.
    2.Listar los cinco últimos comentarios y el título del nodo asociado del usuario.
    3. Mostrar el número total de palabras de todos los comentarios del usuario.

La manera de funcionar seria la siguiente:
    - Si coloco el bloque en una página de usuario (el ID del usuario está presente en la URL), devuelve los datos de ese usuario.
    - Si lo coloco en otra parte del site donde no hay contexto del usuario, utiliza el usuario activo (logueado).

 Para ello tendremos que clonar el repositorio en nuestro entorno local.
 
 git clone https://github.com/raulmasoria/azertiumDrupal.git
 
 Si tenemos instalado ddev, nos situaremos dentro de la carpeta clonada y escribiremos "ddev config", especificaremos el nombre del proyecto, la ubicación de la carpeta web y la versión de drupal. 

 Realizaremos "composer install"  
 
 Una vez acabada esta configuración podremos realizar la importación de la base de datos que encontraremos en este repositorio. Para ello escribiremos "ddev import-db -f=db_export.sql.gz -d=db". 
 
 Una vez importada la base de datos ya podremos iniciar nuestro contenedor con "ddev start", nos facilitará una url en la cual ya podremos ver nuestro drupal funcionando.
 
 Tendremos que loguearnos con un usuario para probar el bloque.

 User: admin
 pass: admin

 En la página de inicio podremos ver el bloque colocado con los resultados del usuario actual.
 Si visitamos /user/70 podremos ver el bloque con los datos de este usuario.

 El bloque por defecto está colocado en todas las páginas.


