Laboratorio 4 - Preguntas de Análisis
Integrantes:

Adalid Gutiérrez Torricos

Carlos Matias Villarroel Tarraga

1. Diferencia entre textContent e innerHTML, función escapar y ataque que se evita
textContent inserta texto plano tal cual, mientras que innerHTML interpreta las etiquetas HTML que contenga. En el Ejercicio 2 los datos pasan por la función escapar para convertir símbolos como menor y mayor que en texto seguro, evitando ataques XSS donde un usuario inyecte código HTML o JavaScript malicioso.

2. Delegación de eventos y qué pasaría al filtrar
La delegación de eventos consiste en colocar un solo escuchador en un contenedor fijo y detectar qué botón fue presionado dentro de él. Si el escuchador se pusiera en cada botón Agregar por separado, al filtrar el catálogo las tarjetas se borran y se crean nuevamente, dejando a los nuevos botones sin evento y sin funcionar.

3. Cómo detectar errores 404 o 500 con fetch y cuándo se ejecuta catch
Se detecta revisando si la respuesta fue exitosa mediante su propiedad ok y lanzando un error manual en caso negativo. El bloque catch se ejecuta cuando hay fallos de red, cuando el servidor está caído, cuando la respuesta no es un JSON válido o cuando lanzamos ese error manual.

4. Función cargarVista con XMLHttpRequest y comparación con fetch
Con XMLHttpRequest se muestra el mensaje de carga, se crea el objeto de petición, se abre en modo GET hacia la dirección, se vigila el cambio de estado hasta confirmar que terminó con éxito para colocar el texto recibido en el contenedor y finalmente se envía. En comparación, fetch con async y await resulta mucho más corto, se lee de forma ordenada de arriba hacia abajo y agrupa todos los errores en un solo bloque try y catch.

5. Por qué no fijar Content-Type con FormData y qué pasa si se usa JSON
No se debe fijar porque el navegador necesita generar automáticamente el tipo de contenido multiparte junto con un separador interno que divide los campos de texto y el archivo. Si se fuerza a formato JSON, PHP no reconoce el envío multiparte y tanto los datos POST como los archivos llegan completamente vacíos.

6. Por qué PHP vuelve a validar y relación con la prueba 7
La validación en JavaScript solo ayuda al usuario a ver errores rápido, pero no brinda seguridad porque cualquiera puede saltársela desde la consola del navegador, justo como ocurre en la prueba 7 al enviar un formulario vacío directo al servidor. Por eso PHP siempre vuelve a validar y responde con error 422 para proteger la base de datos.

7. Comparación entre localStorage, sessionStorage y cookies
localStorage dura de forma permanente hasta que se borra, solo lo lee el cliente y conviene para guardar pedidos o preferencias locales. sessionStorage dura únicamente mientras la pestaña está abierta, solo lo lee el cliente y sirve para datos temporales de esa pestaña. La cookie tiene una duración configurable, la pueden leer tanto el cliente como el servidor y conviene para mantener sesiones de usuario.

8. Qué es el debounce, peticiones al escribir "pollo" y su importancia
El debounce es una técnica que espera un breve tiempo sin teclear antes de lanzar la búsqueda. Sin él, escribir la palabra pollo enviaría 5 peticiones seguidas al servidor, lo cual en una aplicación con muchos usuarios saturaría a PHP y MySQL con consultas innecesarias.