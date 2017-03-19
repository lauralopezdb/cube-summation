/********************* CODING CHALLENGE IMPLEMENTATION DESCRIPTION *********************/

La capa de presentación está representada por un única vista ubicada en resources/views/index.blade.php que contiene código HTML para mostrar mediante un formulario los campos que permitirán al usuario:
.- El ingreso de texto de entrada (input format).
.- Visualización de mensajes de error en caso de que existan datos inválidos en el texto de entrada.
.- Visualización de texto de salida o mensaje de respuesta (output).

La capa de lógica de negocios está representada por un script de JS y dos controladores:
1.- public/js/cube.js: este script es enlazado en la vista y contiene los métodos para el llamado ajax de ambos controladores tomando como parámetro el texto de entrada. 
El primer método (validate) se ejecuta con el evento onSubmit del formulario y permite actualizar la vista con mensajes de los posibles errores presentes en el texto de entrada. 
El segundo método (operate) es un método anidado del primero que se ejecuta cuando el texto de entrada es correcto y permite actualizar la vista con el texto de salida, mostrando el resultado de las operaciones de tipo QUERY realizadas para cada test case.

2.- app/Http/Controllers/InputController.php: este controlador se ejecuta por medio del llamado ajax del primer método JS (validate) y se encarga de recorrer el texto de entrada por cada línea para realizar las siguientes validaciones:
.- La primera línea debe contener un único valor numérico T, para la cantidad de test cases a esperar.
.- T debe tener un valor entre 1 y 50. 
.- La línea incial de cada test case debe contener dos valores numéricos N y M separados por un espacio simple, para la dimensión de la matriz a crear y la cantidad de operaciones a realizar en esa matriz, respectivamente.
.- N debe tener un valor entre 1 y 100.
.- M debe tener un valor entre 1 y 1000.
.- Luego de la línea inicial de cada test case, deben existir M cantidad de líneas de operaciones a continuación.
.- Las líneas de operación deben ser de tipo UPDATE o QUERY.
.- Las líneas de operación UPDATE deben contener cuatro parámetros de valor numérico X, Y, Z, W.
.- X, Y, Z deben tener un valor entre 1 y N.
.- W debe tener un valor entre -10^9 y 10^9.
.- Las líneas de operación QUERY deben contener seis parámetros de valor numérico X1, Y1, Z1, X2, Y2, Z2.
.- X1, Y1, Z1 deben tener un valor entre 1 y N y deben ser menor o igual a x2, Y2, Z2 respectivamente.
El controlador retorna un arreglo bidimensional de T posiciones que contiene el valor N y las operaciones para cada test case a realizar a continuación.

3.- app/Http/Controllers/SummationController.php: este controlador se ejecuta por medio del llamado ajax del segundo método JS (operate) tomando como parámetro la respuesta retornada por el método anterior y es responsable de realizar los dos propósitos de cada test case dado en el texto de entrada:
3.1.- Crear la matriz tridimensional (según el valor N) con valor inicial cero para todas las posiciones de la matriz.
3.2.- Realizar las M operaciones sobre la matriz de la siguiente manera:
.- Las operaciones de tipo UPDATE asignan el valor W en la posición de la matriz con coodernadas X, Y, Z.
.- Las operaciones de tipo QUERY realizan la sumatoria de los valores en las posiciones de la matriz que se encuentren dentro de las coordenadas X1, Y1, Z1 y X2, Y2, Z2.
El controlador retorna un arreglo que contiene todos los resultados de las operaciones de tipo QUERY para todos los test cases que será mostrado en el orden de ejecución como texto de salida en la vista.


1.- El principio de responsabilidad única está relacionado con el paradigma de Programación Orientada a Objetos porque indica que cada clase o módulo debe tener una funcionalidad única y específica que de la mano con la encapsulación permite definir, diferenciar e interrelacionar más fácilmente cada rol o parte dentro del sistema. Por ejemplo, dada mi implementación de coding challenge, cada controlador tiene su propósito único, la clase InputController se dedica a realizar todas las validaciones necesarias para cumplir con el formato de entrada esperado. Por su parte la clase SummationController delegando este primer paso de validaciones a InputController, únicamente es responsable de realizar las operaciones solicitadas.

2.- Un buen código o código limpio, en mi opinión debe presentar lo siguiente: 
.- Tener la indentación correcta de anidación, apertura, cierre para mejor legibilidad.
.- Utilizar nombres relacionados con la funcionalidad, que sean descriptivos, para archivos, clases, métodos, variables.
.- No reescribir bloques de códigos, si se requiere un mismo bloque más de una vez, debe estar en único lugar y ser llamado para cada caso que se necesite.
.- Desarrollar las funcionalidades lo más sencillo posible descomponiendo en submódulos los procesos complejos y/o largos.
.- Contar con el principio de responsabilidad única para facilitar en entendimiento.
.- Agregar comentarios en operaciones complejas o ambiguas para futuras modificaciones en el código escrito.