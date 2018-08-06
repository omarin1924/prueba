Esta carpeta contiene el código fuente y el script para la creación de la base de datos con su table y registros.

Configuración:
Se debe modificar el archivo variables.php que se encuentra en la carpeta conexión, de tal manera que se coloquen las credenciales correspondientes al equipo donde se este instalando la aplicación.
Ejemplo:

define("SERVIDOR",     "localhost");
define("USUARIO",    "root");
define("CONTRASEÑA", "");
 --->
define("SERVIDOR",     "localhost");
define("USUARIO",    "usuario123");
define("CONTRASEÑA", "clave123");

Funcionamiento de la aplicación:
Listado de registros:

La aplicación consta de una pagina web en la que se listan los registros en la base de datos en una tabla, cada registro listado cuenta con dos botones, uno para editar y otro para eliminar.
Editar registro:
El botón de editar despliega una ventana emergente en la que se cargan los datos actuales y permite modificarlos presionando el botón guardar.
Eliminar registro:
El botón eliminar despliega una ventana de confirmación en la que se pregunta si en realidad quiere eliminar el registro, esta funcionalidad no elimina el registro de la base de datos, sino que lo desactiva, para garantizar la integridad de los datos.

Agregar registro
La aplicación cuenta con un botón para agregar nuevos registros, al presionar se despliega una ventana emergente en la que se solicitaran los datos correspondientes.

Filtros:
La aplicación cuenta con un botón para filtrar los datos de la tabla principal, al seleccionar una opción de la lista desplegable se actualizara automáticamente.
Imprimir:
Existe un botón de imprimir que genera un pdf con los datos que se encuentran en la tabla principal de la pagina, teniendo en cuenta los filtros que se han aplicado.
