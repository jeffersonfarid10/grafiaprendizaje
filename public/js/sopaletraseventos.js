//CAPTURAR EL ARRAY DE PALABRAS CORRECTAS
let answers = document.getElementsByName('answer');
let palabras = new Array();
let correctas = [].map.call(answers, function(dataInput){
    palabras.push(dataInput.value);
});
//console.log(palabras);

//CAPTURAR EL ARRAY DE PALABRAS INCORRECTAS
let visible_answers = document.getElementsByName('visible_answer');
let palabras_incorrectas = new Array();
let incorrectas = [].map.call(visible_answers, function(dataInput){
    palabras_incorrectas.push(dataInput.value);
});
//console.log(palabras_incorrectas);

//CAPTURAR EL ARRAY CON LAS ORACIONES 
//PARA CAPTURAR LAS ORACIONES TRAIGO TODO EL OBJETO ANSWER DESDE LA VISTA
//let second_answers = document.getElementsByName('second_answer');
//let arrayprincipal = [];
//let oracionuno = [].map.call(second_answers, function(dataInput){
//    arrayprincipal.push(dataInput.value);
//});
//console.log(typeof(arrayprincipal[0]));

//DECLARAR UNA VARIABLE QUE CONTIENE OTRAS SUBVARIABLES
//LA VARIABLE PRINCIPAL SE LLAMA JUEGO 
//LA SUBVARIABLE C CONTIENE EL NUMERO DE COLUMNAS QUE ES 16
//LA SUBVARIABLE F CONTIENE EL NUMERO DE FILAS QUE ES 16
//LA SUBVARIABLE NUMEROPALABRAS CONTIENE LAS PALABRAS QUE SE VAN A AGREGAR EN ESTE CASO 10
//LA SUBVARIABLE LETRAS[] VA A CONTENER TODAS LAS LETRAS DEL TABLERO
//LA SUBVARIABLE PALABRAS_ESCOGIDAS[] VA A CONTENER TODAS LAS PALABRAS QUE INGRESAN EN LA SOPA DE LETRAS
//LA SUBVARIABLE PALABRAS_SELECCIONADAS[] VA A CONTENER LAS LETRAS DE LAS PALABRAS QUE EL USUARIO HAYA ENCONTRADO
//ACTUALIZACION 
//SE AGREGAN DOS CAMPOS MAS A LA SOPA DE LETRAS
//EL CAMPO NUMEROPALABRASINCORRECTAS QUE ES 10 POR LAS 10 PALABRAS INCORRECTAS QUE VIENEN DESDE VISIBLE_ANSWER
//EL CAMPO PALABRAS_DISTRACTORAS QUE ES UN ARRAY
let juego = {c:16, f:16, numeroPalabras:10, letras:[], palabras_escogidas:[], palabras_seleccionadas:[], numeroPalabrasDistractoras:10, palabras_distractoras:[]};
//VARIABLES ETIQUETA Y ATRIBUTO PARA CREAR OBJETOS
let etiqueta, atributo;

//METODOS QUE SE VAN A EJECUTAR CUANDO SE CARGUE LA VENTANA
//window.onload = function(){
//    crearTabla();
//    agregarPalabras();
//    rellenarTabla();
    //SE COMENTA EL METODO PALABRAS_ESCOGIDAS QUE ES METODO QUE LISTA LAS PALABRAS DE UNA PARA QUE EN EL METODO CREAR TABLA
    //VAYA MOSTRANDO LAS PALABRAS CORRECTAS AUTOMATICAMENTE LUEGO DE QUE EL USUARIO ENCUENTRE DICHA PALABRA EN LA SOPA DE LETRAS
    //palabrasEscogidas();
//    resultados();
//}
//console.log(juego.palabras_escogidas);


//ACTUALIZACION YA NO SE UTILIZA EL METODO WINDOW ON LOAD SINO QUE SE SIGUE EL SIGUIENTE PROCESO
//1. CUANDO EL USUARIO INGRESA A LA VENTANA DE LA SOPA DE LETRAS LE APARECEN TRES BOTONES: INICIAR JUEGO, FINALIZAR JUEGO, SALIR
//AQUI SOLO EL BOTON DE INICIAR JUEGO VA A ESTAR HABILITADO Y LOS DEMAS DESHABILITADOS
//2. CUANDO HAGA CLICK EN INICIAR JUEGO ENTONCES ESTE BOTON SE DESHABILITA Y SE DIBUJA LA SOPA DE LETRAS Y SE CARGAN LOS METODOS 
//QUE ESTABAN ANTES EN WINDOW.ONLOAD
//EL BOTON DE INICIAR JUEGO SE DESHABILITA Y EL BOTON DE SALIR PERMANECE DESHABILITADO
//3. COMO LA SOPA DE LETRAS Y LOS DEMAS METODOS YA ESTAN CARGADOS ENTONCES EL USUARIO PUEDE HACER CLICK EN EL BOTON FINALIZAR JUEGO
//EN ESTE MOMENTO LA SOPA DE LETRAS DE DESHABILITAN CLICKS, EL BOTON DE FINALIZAR SE DESHABILITA Y EL BOTON DE SALIR SE HABILITA

//PASO 1. CUANDO EL USUARIO INGRESE A LA VENTANA DE LA SOPA DE LETRAS QUE APAREZCAN TRES BOTONES
//CAPTURAR LOS BOTONES Y TENER ACTIVADO EL BOTON EMPEZAR JUEGO, MIENTRAS QUE LOS OTROS DOS BOTONES ESTARAN DESHABILITADOS

const btn_empezar_juego = document.getElementById('empezar_juego');
btn_empezar_juego.disabled = false;
const btn_finalizar_juego = document.getElementById('ver_respuesta');
btn_finalizar_juego.disabled = true;
const btn_salir_sopaletras = document.getElementById('guardar_respuesta_sl');
btn_salir_sopaletras.disabled = true;

//CUANDO SE HAGA CLICK EN EL BOTON EMPEZAR_JUEGO SE EJECUTEN LOS METODOS PARA QUE SE EJECUTE LA SOPA DE LETRAS
//QUE ESTABAN EN WINDOW.LOAD
btn_empezar_juego.addEventListener('click', empezar_juego);

//FUNCION EMPEZAR_JUEGO
function empezar_juego(event){

    //DESACTIVAR EL BOTON EMPEZAR JUEGO
    btn_empezar_juego.disabled = true;
    //ACTIVAR EL BOTON FINALIZAR JUEGO
    btn_finalizar_juego.disabled = false;
    //EJECUTAR LOS METODOS PARA CREAR LA SOPA DE LETRAS
    crearTabla();
    agregarPalabras();
    rellenarTabla();
    resultados();
}


//AGREGAR UN EVENTO CLICK AL BOTON DE FINALIZAR JUEGO
btn_finalizar_juego.addEventListener('click', finalizar_juego);

//FUNCION FINALIZAR JUEGO
function finalizar_juego(event){

    //CUANDO SE HAGA CLICK A FINALIZAR JUEGO QUE SE DESHABILITE EL BOTON DE FINALIZAR_JUEGO
    btn_finalizar_juego.disabled = true;
    //EL BOTON DE SALIR DEBE ACTIVARSE
    btn_salir_sopaletras.disabled = false;

    //QUITAR EL EVENTO CLICK DE LOS DIVS DE LA TABLA
    //IMPORTANTE EN ESTA VERSION DEL JUEGO SE CAMBIARON LOS DIVS DE LA TABLA POR BUTTONS
    //AHORA MEDIANTE EL METODO DISABLED CUANDO HAGA CLICK EN EL BOTON FINALIZAR JUEGO
    //SE MUESTRA LA UBICACION DE LAS PALABRAS Y TODOS LOS BOTONES DE LA TABLA SE DESACTIVAN
    let casillas = document.querySelectorAll('#tabla button');
    for(let i=0; i<casillas.length; i++){
        casillas[i].disabled = true;
    }
    //casillas.stopListen('click');
    //casillas[1].disabled = true;
    //console.log(casillas[1]);
}


//METODO PARA CREAR EL TABLERO DE LA SOPA DE LETRAS
function crearTabla(){

    //ANTES DE CREAR LA TABLA
    //ENVIAR LOS ESTILOS AL DIV CON ID ESPACIOS
    let dibujar = document.getElementById('espacios');
    dibujar.style.width = "640px";
    dibujar.style.margin = "0";
    dibujar.style.textAlign = "center";
    dibujar.style.backgroundColor = "#ddd";


    //DECLARAR VARIABLE I
    let i = 0;
    //CON EL PRIMER FOR SE RECORREN LAS FILAS Y CON EL SEGUNDO FOR SE RECORREN LAS COLUMNAS DEL RECUADRO DE LA SOPA DE LETRAS
    for(let f=0; f<juego.f; f++){
        for(let c=0; c<juego.c; c++){

            //CON LA VARIABLE ETIQUETA SE CREA UN DIV POR CADA ITERACION EN LA POSICION X,Y
            //etiqueta = document.createElement("div");
            etiqueta = document.createElement("button");
            //Y SE ENVIA EL VALOR DE #
            etiqueta.innerText = "#";
            //EN LA VARIABLE ATRIBUTO SE CREA EL ATRIBUTO ID
            atributo = document.createAttribute("id");
            //CON ESTA LINEA DE CODIGO SE PUEDE VER EN CONSOLA QUE AL HACER CLICK EN UNA CASILLA EN ESPECIFICO APARECEN LAS COORDENADAS DE LA CASILLA QUE SE HIZO CLICK
            //atributo.value = "casilla en la columna: " + c + " y en la fila: " + f;
            atributo.value = "casilla-" + c + "-" + f;
            //EN LOS DIVS CREADOS CON ETIQUETA, SE ENVIA COMO ATRIBUTOS LOS ID CREADOS EN ATRIBUTO
            etiqueta.setAttributeNode(atributo);
            //AGREGAR LOS ESTILOS A CADA DIV QUE SE CREA POR CADA CASILLA
            etiqueta.style.padding = "5px";
            etiqueta.style.border = "1px solid black";
            etiqueta.style.width = "40px";
            etiqueta.style.height = "40px";
            etiqueta.style.float = "left";
            etiqueta.style.textAlign = "center";



            //AGREGAR EL EVENTO CLICK EN LA VARIABLE ETIQUETA

            etiqueta.addEventListener("click", (e)=>{

              //SE DECLARA LA VARIABLE ID QUE CAPTURA EL ID DEL CASILLERO O DIV DONDE EL USUARIO HACE CLICK
              let id = e.target.id;  

              //LINEAS DE CODIGO PARA VERIFICAR SI UNA CASILLA SELECCIONADA POR EL USUARIO AL HACER CLICK, FORMA PARTE DE UNA PALABRA O ES UNA LETRA DE RELLENO

              //AL MOMENTO DE HACER CLICK EN UNA CASILLA, EL CONSOLE.LOG ARROJA EL RESULTADO DEL ID COMO: casilla en la columna 0 y en la fila 10 POR EJEMPLO, DONDE EL 0 ES LA COLUMNA
              //Y EL 10 ES LA FILA
              //ENTONCES EN LA VARIABLE DIVIDIR VAMOS A SEPARAR LA INFORMACION DEL ID POR PARTE SEGUN EL GUION
              //POR LO QUE QUEDARIA ASI: casilla 0 10 donde la posicion de CASILLA ES 0 LA POSICION DE 0 ES UNO Y 10 ES 2
              //ASI: [{0}: casilla , {1}: 0, {2}: 10]
              let dividir = id.split("-");
              //EN LA VARIABLE I SE VA A PASAR A ENTEROS EL VALOR DE LA FILA Y DE LA COLUMNA DE LA CASILLA HECHA CLICK POR EL USUARIO Y SE MULTIPLICA POR EL NRO TOTAL DE COLUMNAS
              //DE LA SOPA DE LETRAS
              let i = parseInt(dividir[2])*juego.c + parseInt(dividir[1]);
              //EN LA VARIABLE COMPROBAR SE ENVIAN COMO VALORES INICIALES EN VALOR = 0 Y EN PALABRA ALGO VACIO
              //AQUI SE VAN A ALMACENAR LOS DATOS CUANDO UNA PALABRA HAYA SIDO ENCONTRADA POR EL USUARIO, NO SOLO UNA LETRA
              let comprobar = {valor:0, palabra:""};
              //EN EL ARRAY JUEGO.PALABRAS_SELECCIONADAS QUE VA A CONTENER LAS PALABRAS ENCONTRADAS POR EL USUARIO, SE INICIALIZA COMO TRUE
              juego.palabras_seleccionadas[i] = true;
              //SE RECORRE EL ARRAY JUEGO.PALABRAS_ESCOGIDAS QUE CONTIENE LAS PALABRAS A ENCONTRAR
              juego.palabras_escogidas.forEach((palab)=>{

                //SE PREGUNTA SI LA LETRA A LA QUE EL USUARIO HA HECHO CLICK, PERTENECE A ALGUNA PALABRA QUE SE ENCUENTRA EN ESTE ARRAY
                //ESTA COMPROBACION SE HACE COMPROBANDO LA POSICION DE LA LETRA A LA QUE EL USUARIO HIZO CLIC QUE PUEDE SER POR EJEMPLO EL CASILLERO: 7,7 
                //Y COMO CADA REGISTRO DEL ARRAY JUEGO.PALABRAS_ESCOGIDAS TIENE UN CAMPO QUE ES SUBARRRAY LLAMADO POSICION DONDE ALMACENA TODAS ESAS POSICIONES DE LA PALABRA A LA QUE PERTENECE
                //ENTONCES LA VARIABLE I SE COMPARA CON TODAS LAS POSICIONES DEL SUBARRAY POSICION DE LA PALABRA ACTUAL DEL ARRAY JUEGO.PALABRAS_ESCOGIDAS
                if(palab.posicion.includes(i)){
                    //SI ES ASI ENCONTRAR QUE COMPROBAR Y SU CAMPO VALOR AUMENTE
                    comprobar.valor++;
                    //Y COMPROBAR Y SU CAMPO PALABRA SE LE ASIGNA LA LETRA A LA QUE HIZO CLICK
                    comprobar.palabra = palab.palabra; 
                }

                
              });

              

              //SI LA LETRA A LA QUE SE HIZO CLICK PERTENECE A UNA PALABRA A ENCONTRAR ESO SIGNIFICA QUE COMPROBAR.VALOR ES MAYOR A CERO
              //YA QUE POR DEFECTO COMPROBAR.VALOR INICIA CON 0
              if(comprobar.valor){

                //SI ES ASI, ENTONCES QUE LA CASILLA SE PINTE DE VERDE
                document.getElementById(id).style.backgroundColor = "green";
              }
              else{
                //SI LA LETRA QUE SE HIZO CLICK NO PERTENECE A UNA PALABRA A ENCONTRAR ENTONCES QUE LA CASILLA SE PINTE DE ROJO
                document.getElementById(id).style.backgroundColor = "red";
              }

              //LUEGO DE HABER HECHO CLICK EN UNA LETRA, SE DEBE VERIFICAR SI CON ESA LETRA YA SE COMPLETO ENCONTRAR UNA PALABRA
              //ES DECIR SI LA LETRA QUE SE HIZO CLICK ES LA ULTIMA LETRA QUE LE FALTA A UNA PALABRA PARA SER ENCONTRADA
              //POR ESO SE UTILIZA EL METODO VERIFICARPALABRAS() PARA VERIFICAR SI UNA PALABRA YA FUE ENCONTRADA COMPLETAMENTE, CADA VEZ QUE UN USUARIO
              //HAGA CLICK EN UNA CASILLA
              verificarPalabras();

              console.log(id);

            }, false);

            ///////////FIN METODO EVENTO CLICK EN LA VARIABLE ETIQUETA




            //ASIGNAR EL LISTENER DE LA VARIABLE ETIQUETA A LA ETIQUETA DEL TABLERO DEL HTML
            //AGREGAR AL DIV LLAMADO TABLA TODOS LOS DIVS CREADOS CON #
            document.getElementById("tabla").appendChild(etiqueta);
            //EN LA VARIABLE PRINCIPAL LLAMADA JUEGO EN SU SUBVARIABLE LETRAS, AGREGAR EL NUMERO DE COLUMNAS, FILAS, EL VALOR DE I Y RELLENAR EL ARRAY DE LETRAS
            //CON # QUE DE MOMENTO ES CON LO QUE SE LLENAN TODOS LOS CASILLEROS
            //EN F SE RELLENA LA POSICION EN F QUE TIENE EL CASILLERO CON UNA LETRA
            //EN C SE RELLENA CON LA POSICION C QUE TIENE UN CASILLERO CON UNA LETRA 
            //EN I SE ALMACENA EL NUMERO ACTUAL DE LA ITERACION YA QUE LETRAS ES UN ARRAY ENTONCES LA VARIABLE I EJERCE COMO SU ID 
            //Y EN LETRA SE ALMACENA DE MOMENTO # Y POSTERIORMENTE SE IRA LLENANDO CON LETRAS
            juego.letras.push({f:f, c:c, i:i, letra:"#"});
            //LUEGO DE CADA ITERACION DE LOS DOS FOR, SE AUMENTA I
            i++;
        }

    }

    //DESPUES DE QUE SE EJECUTEN LOS DOS FOR, ES DECIR LUEGO QUE SE DIBUJE LA TABLA DE LA SOPA DE LETRAS SE PUEDE VER POR CONSOLA 
    //LA INFORMACION QUE CONTIENE EL ARRAY LETRAS QUE ES UNA SUBVARIABLE DE LA VARIABLE PRINCIPAL JUEGO
    //console.log(juego.letras);
}



//METODO PARA VERIFICAR SI X PALABRA QUE YA FUE AGREGADA EN LA SOPA DE LETRAS YA FUE SELECCIONADA COMPLETAMENTE POR EL USUARIO
//SE VERIFICA PALABRA A PALABRA, TODAS LAS PALABRAS DE GAME.PALABRAS_ESCOGIDAS, SI YA FUERON SELECCIONADAS TODAS SUS CASILLAS Y SI ES ASI
//ENTONCES SE MARCA LA PALABRA EN EL LISTADO DE PALABRAS
function verificarPalabras(){

    let arrayenviado = [];

    //CON UN FOREACH SE RECORRE EL ARRAY JUEGO.PALABRAS_ESCOGIDAS
    //PALAB HACE REFERENCIA A UNA PALABRA[I] DEL ARRAY JUEGO.PALABRAS_ESCOGIDAS 
    //EL ARRAY JUEGO.PALABRAS_ESCOGIDAS TIENE TRES CAMPOS: palabra, posicion, encontrada
    juego.palabras_escogidas.forEach((palab, i)=>{

        //SE INICIALIZA LA VARIABLE VERIFICAR EN 0
        let verificar = 0;
        //INICIALIZAR VARIABLES ATRIBUTO Y ETIQUETA PARA CREAR DIVS POR CADA PALABRA QUE EL USUARIO VA ENCONTRANDO
        //let etiqueta, atributo;

        //SE RECORRE EL ARRAY DE JUEGO.PALABRAS_SELECCIONADAS, ES DECIR PALABRAS A LAS QUE EL USUARIO HIZO CLICK LETRA POR LETRA EN LA TABLA
        //LA VARIABLE WORD HACE REFERENCIA AL CAMPO PALABRA DEL ARRAY JUEGO.PALABRAS_SELECCIONADAS
        juego.palabras_seleccionadas.forEach((word, j)=>{

            //SI LA POSICION DE LETRA ACTUAL DE LA PALABRA ACTUAL X DE JUEGO.PALABRAS_ESCOGIDAS COINCIDE CON POSICION IGUAL DE ALGUNA LETRA ACTUAL DE ALGUNA PALABRA QUE EL USUARIO HAYA SELECCIONADO QUE ESTAN
            //ALMACENADAS EN JUEGO.PALABRAS_SELECCIONADAS
            //ENTONCES QUE VERIFICAR AUMENTE EN 1
            //ES DECIR CON EL IF SE PREGUNTA SI LAS POSICIONES DEL SUBARRAY POSICION DE LA PALABRA ACTUAL DEL ARRAY JUEGO.PALABRAS_ESCOGIDAS COINCIDE CON LAS POSICIONES DEL SUBARRAY
            //POSICION DE ALGUNA DE LAS PALABRAS QUE ESTAN EN EL ARRAY JUEGO.PALABRAS_SELECCIONADAS
            if(palab.posicion.includes(j)){
                verificar++;
            }
        });


        //LUEGO DE SALIR DEL FOREACH, SIGNIFICA QUE YA EVALUO SI SE HA ENCONTRADO LA PALABRA A LA QUE EL USUARIO HA HECHO CLICK
        //ENTONCES SE PREGUNTA SI VERIFICAR TIENE LA MISMA LONGITUD DE X PALABRA ACTUAL, LO QUE SIGNIFICA QUE YA SE HAN ENCONTRADO TODAS LAS LETRAS DE UNA PALABRA
        //POR EL USUARIO. Y ESA PALABRA ENCONTRADA DEL ARRAU JUEGO.PALABRAS_SELECCIONADAS, SE ENCONTRARON LAS MISMAS POSICIONES EN UNA DE LAS PALABRAS DEL ARRAY
        //JUEGO.PALABRAS_ESCOGIDAS Y SU SUBARRAY POSICION
        if(verificar === palab.palabra.length){
            //SI ES ASI ENTONCES QUE LA PALABRA SE PINTE DE ROJO Y SE SUBRAYE
            //document.getElementById(palab.palabra).style.color = "red";
            //document.getElementById(palab.palabra).style.textDecoration = "line-through";
            //LA VARIABLE PALAB.ENCONTRADA DEBE CAMBIAR EN SU ATRIBUTO ENCONTRADA A TRUE, YA QUE PERTENECE AL ARRAY JUEGO.PALABRAS_ESCOGIDAS
            palab.encontrada = true;

            //ACTUALIZACION

            //EN EL INPUT DEL FORMULARIO CON ID = PALABRA_ENCONTRADA SE VAN AGREGANDO LAS PALABRAS QUE EL USUARIO VA ENCONTRANDO DE LA SOPA DE LETRAS
            //let arrayenviado = [];
            let variable = arrayenviado.push(palab.palabra);
            document.getElementById('palabra_encontrada').value = arrayenviado;
            //console.log(palab.palabra);
            //AGREGAR CADA PALABRA ENCONTRADA A LA LISTA CON ID LISTADO PALABRAS
            document.getElementById('listado_palabras').textContent = arrayenviado;
            //EN EL DIV CON ID LISTADO_PALABRAS IR CREANDO UN DIV CON CADA PALABRA ENCONTRADA
            //CADA DIV CREADO POR CADA PALABRA QUE EL USUARIO ENCUENTRE, SE ENVIA AL DIV PADRE CON ID LISTADO_PALABRAS
            //let etiqueta, atributo;
            //etiqueta = document.createElement("div");
            //etiqueta.innerText = palab.palabra;
            //atributo = document.createAttribute("id");
            //atributo.value = palab.palabra;
            //etiqueta.setAttributeNode(atributo);
            //document.getElementById("listado_palabras").appendChild(etiqueta);
            
        }

        
    });

    //POR CADA VEZ QUE SE HAGA CLICK EN UN CASILLERO SE DEBE REFRESCAR EL ENCABEZADO PARA QUE MUESTRE EN TIEMPO REAL CUANDO UNA PALABRA ES ENCONTRADA
    resultados();
}



//METODO QUE INGRESA DE FORMA ALEATORIA EN EL TABLERO DE LA SOPA DE LETRAS, LAS PALABRAS DEL ARRAY PALABRAS[] QUE CONTIENE LAS PALABRAS
//QUE VIENEN DESDE EL BACKEND
//OJO EXISTEN VARIOS ARRAYS DE PALABRAS
//PALABRAS[] ES EL ARRAY QUE CONTIENE LAS PALABRAS QUE VIENEN DESDE EL BACKEND
//JUEGO.PALABRAS_ESCOGIDAS[] ES EL ARRAY QUE ESTA DENTRO DE LA VARIABLE PRINCIPAL JUEGO Y QUE ES DONDE SE VAN A GUARDAR LAS PALABRAS DEL OTRO ARRAY
//QUE FUERON SELECCIONADAS POR EL ALGORITMO PARA QUE ESTEN EN LA SOPA DE LETRAS
//EL ALGORITMO LO QUE HACE ES BUSCAR ESPACIOS DONDE SE PUEDA INGRESAR UNA PALABRA LETRA POR LETRA, SI CABEN LAS LETRAS EN LOS CASILLEROS EN BLANCO
//AGREGA LAS PALABRAS AL ARRAY JUEGO.PALABRAS_ESCOGIDAS
function agregarPalabras(){

    //CON EL FOR SE RECORRE EL ARRAY DE PALABRAS QUE CONTIENE LAS PALABRAS CORRECTAS QUE VIENEN DESDE EL BACKEND
    //Y CON EL METODO ANADIRPALABRA SE COMPRUEBA SI X PALABRA CABE EN LA SOPA DE LETRAS
    //SI ES ASI, ENTONCES SE GUARDA LA PALABRA EN EL ARRAY JUEGO.PALABRAS_ESCOGIDAS
    for(let i=0; i<juego.numeroPalabras; i++){

        //LA VARIABLE RESPUESTA CONTIENE FALSE EN CASO DE QUE NO SE PUEDA ANADIR X PALABRA DEL ARRAY PALABRAS[] EN EL TABLERO
        //Y CONTIENE LAS COORDENADAS DONDE SE VA A AGREGAR LA PALABRA EN CASO DE QUE SI HAYA ESPACIOS DONDE AGREGAR LA PALABRA EN EL TABLERO
        respuesta = anadirPalabra(palabras[i].toUpperCase());
        //SI LA VARIABLE RESPUESTA NO ES FALSE Y CONTIENE LAS COORDENADAS DONDE SE VA A AGREGAR LA PALABRA EN EL TABLERO ENTONCES HACER LO SIGUIENTEE
        if(respuesta){

            //SE AGREGA EN EL ARRAY JUEGO.PALABRAS_ESCOGIDAS UN REGISTRO CON LOS SIGUIENTES DATOS
            juego.palabras_escogidas.push({

                //SE AGREGA EN EL CAMPO PALABRA, LA PALABRA ACTUAL QUE SE ESTA REVISANDO QUE VIENE DESDE EL ARRAY PALABRAS[] QUE VIENE DEL BACKEND
                palabra:palabras[i].toUpperCase(),
                //EN LA VARIABLE POSICION, SE AGREGAN LAS POSICIONES DE LAS LETRAS DE CADA PREGUNTA QUE ESTAN ALMACENADAS EN LA VARIABLE
                //RESPUESTA
                posicion: respuesta,
                //EN LA VARIABLE ENCONTRADA SE GUARDA FALSE, YA QUE AUN NO HA SIDO ENCONTRADA DICHA PALABRA, SOLO SE ESTAN AGREGANDO A LA TABLA
                encontrada: false
            });
        }
    }

    //IMPRIMIR EN CONSOLA EL ARRAY RESULTANTE PARA COMPROBAR
    //console.log(juego.palabras_escogidas); 


    //ACTUALIZACION
    //AGREGAR LAS PALABRAS_INCORRECTAS A LA SOPA DE LETRAS
    //CON EL METODO FOR SE RECORRE EL ARRAY DE PALABRAS QUE CONTIENE LAS PALABRAS INCORRECTAS QUE VIENEN DESDE EL BACKEND
    //Y CON EL METODO ANADIR PALABRA SE COMPRUEBA SI X PALABRA CABE EN LA SOPA DE LETRAS
    //SI ES ASI, ENTONCES SE GUARDA LA PALABRA EN EL ARRAY JUEGO.PALABRAS_DISTRACTORAS
    //numeroPalabrasDistractoras:10, palabras_distractoras:[], palabras_incorrectas[]
    for(let j=0; j<juego.numeroPalabrasDistractoras; j++){

        //LA VARIABLE RESPUESTA CONTIENE FALSE EN CASO DE QUE NO SE PUEDA ANADIR X PALABRA DEL ARRAY PALABRAS_INCORRECTAS EN EL TABLERO
        //Y CONTIENE LAS POSICIONES DONDE SE VA A AGREGAR LA PALABRA EN CASO DE QUE SI HAYA ESPACIOS DONDE AGREGAR LA PALABRA EN EL TABLERO
        respuestaincorrecta = anadirPalabra(palabras_incorrectas[j].toUpperCase());
        //SI LA VARIABLE RESPUESTAINCORRECTA NO ES FALSE Y CONTIENE LAS COORDENADAS DONDE SE VA A AGREGAR LA PALABRA EN EL TABLERO, ENTONCES HACER LO SIGUIENTE
        if(respuestaincorrecta){

            //SE AGREGA EN EL ARRAY JUEGO.PALABRAS_DISTRACTORAS UN REGISTRO CON LOS SIGUIENTES CAMPOS
            juego.palabras_distractoras.push({

                //LA PALABRA ACTUAL QUE SE ESTA REVISANDO QUE VIENE DESDE EL ARRAY PALABRAS_INCORRECTAS[] QUE VIENE DEL BACKEND
                palabraincorrecta:palabras_incorrectas[j].toUpperCase(),
                //EN LA VARIABLE POSICIONINCORRECTA, SE AGREGAN LAS POSICIONES DE LAS LETRAS DE CADA PALABRA QUE ESTAN ALMACENADAS EN LA VARIABLE RESPUESTA
                posicionincorrecta: respuestaincorrecta,
                //EN LA VARIABLE ENCONTRADAINCORRECTA SE GUARDA FALSE, YA QUE UN NO HA SIDO ENCONTRADA DICHA PALABRA, SOLO SE ESTAN AGREGANDO A LA TABLA
                encontrada:false 
            });
        }
    }
}




//FUNCION PARA VERIFICAR SI X PALABRA DEL ARRAY DE PALABRAS QUE VIENE DESDE EL BACKEND PUEDE INGREGAR EN EL TABLERO DE LA SOPA DE LETRAS
function anadirPalabra(palabra){

    //EN LA VARIABLE ARRAY_PALABRA SE TRANSFORMA LA PALABRA X ACTUAL QUE SE ESTA EVALUANDO EN UN ARRAY DE LETRAS 
    //EJEMPLO: COMPUTADORA = [C O M P U T A D O R A]
    let array_palabra = palabra.split("");
    //DEFINIR LA VARIABLE RESPUESTA COMO FALSE DE FORMA INICIAL
    let respuesta = false;
    //DEFINIR LA VARIABLE INTENTOS QUE VA A SER EL NRO MAXIMO DE VECES QUE SE VA A REVISAR EN EL TABLERO, LUGARES DONDE PUEDE INGREGAR LA PALABRA
    let intentos = 300;
    //CON EL CICLO WHILE SE PROCEDE A REALIZAR LOS INTENTOS PARA AGREGAR LA PALABRA ACTUAL QUE SE ESTA REVISANDO AL TABLERO DE LA SOPA DE LETRAS
    //ESTE PROCESO SE REALIZA MIENTRAS RESPUESTA SEA VERDADERO Y INTENTOS SEA MAYOR A CERO
    //ES DECIR, MIENTRAS NO ENCUENTRE UN LUEGAR DONDE PONER LA PALABRA
    while(!respuesta && intentos>0 ){

        //POR CADA ITERACION LA VARIABLE INTENTOS SE REDUCE
        intentos--;
        //SE CREA LA VARIABLE POSICION Y SUS SUBVARIABLES FILA Y COLUMNA
        //ESTO SIRVE PARA SABER EN QUE POSICION X,Y EXACTA DEL TABLEERO EMPIEZA LA PRIMERA LETRA DE UNA PALABRA QUE SE VA A AGREGAR EN LA TABLA
        let posicionPalabra = {columna:0, fila:0};
        //SE CREA LA VARIABLE DIRECCION PARA DETERMINAR SI LA PALABRA VA A COLOCARSE DE FORMA VERTICAL O DE FORMA HORIZONTAL
        let direccion = (Math.random()>0.5)?true:false;
        //CON EL IF SE PREGUNTA QUE ES LO QUE DEVOLVIO LA VARIABLE DIRECCION
        //SI DEVOLVIO VERDADERO ENTONCES QUE LA PALABRA SE AGREGUE HORIZONTALMENTE
        //SI DEVOLVIO FALSO ENTONCES QUE LA PALABRA SE AGREGUE VERTICALMENTE
        //ADEMAS SE VERIFICA SI LA PALABRA ACTUAL QUE SE ESTA REVISANDO, SU NRO DE LETRAS EL MENOR O IGUAL AL NUMERO DE COLUMNAS DEL TABLERO
        if(direccion && array_palabra.length<=juego.c){
            //AGREGAR PALABRA DE FORMA HORIZONTAL
            //EN POSICION.COLUMNA SE ENVIA AL METODO CALCULARCOORDENADA() EL NRO DE LETRAS QUE CONTIENE LA X PALABRA ACTUAL Y EL NRO DE COLUMNAS TOTALES
            //QUE ES 16 DEL TABLERO. ESTE METODO SIRVE PARA ASIGNAR UNA POSICION INICIAL A LA PRIMERA LETRA DE UNA PALABRA EN LA POSICION X,Y 
            posicionPalabra.columna = calcularCoordenada(array_palabra.length, juego.c);
            //EN POSICION.FILA SE RECIBE UN NUMERO RANDOM QUE ES MULTIPLICADO POR EL NUMERO DE FILAS QUE ES 16
            posicionPalabra.fila = Math.floor(Math.random() * juego.f);
            //EN LA VARIABLE RESPUESTA, A TRAVES DEL METODO VERIFICARPALABRAVERTICAL SE VERIFICA QUE LA POSICION INICIAL X,Y DE LA PRIMERA LETRA
            //NO ESTE OCUPADA Y SE AGREGAN LAS LETRAS HACIA ABAJO
            respuesta = colocarPalabraHorizontal(posicionPalabra, array_palabra);
        }
        else if(!direccion && array_palabra.length<=juego.f){
            //PARA AGREGAR LA PALABRA DE FORMA VERTICAL SE REALIZA CASI LO MISMO QUE ANTES
            posicionPalabra.fila = calcularCoordenada(array_palabra.length, juego.f);
            posicionPalabra.columna = Math.floor(Math.random() * juego.c);
            respuesta = colocarPalabraVertical(posicionPalabra, array_palabra);
        }
    }

    //FINALMENTE SE DEVUELVE RESPUESTA
    //CONTIENE FALSE SI NO SE ENCONTRO UN SITIO DONDE AGREGAR LA PALABRA EN EL TABLERO
    //O CONTIENE LAS POSICIONES DONDE SE AGREGARON CADA LETRA EN EL TABLERO DE LA PALABRA ACTUAL
    return respuesta;
}


//FUNCION QUE SIRVE PARA ASIGNAR UNA COLUMNA O FILA A LA PRIMERA LETRA DE X PALABRA
//TIENE COMO ARGUMENTOS LA LONGITUD LENGTH DE LA PALABRA ACTUAL Y EL NRO TOTAL DE FILAS O COLUMNAS
//VERIFICA UN ESPACIO DE LA TABLA DONDE HAYA ESPACIOS PARA EL NRO DE LETRAS DE FORMA HORIZONTAL O VERTICAL DE X PALABRA
//Y ENVIA ESA POSICION ENCONTRADA COMO POSICION INICIAL EN POSICION.COLUMNA DEL METODO ANADIRPALABRA
//ESTE METODO REVISA DE FORMA ALEATORIA TODAS LAS COLUMNAS O FILAS DISPONIBLES HASTA ENCONTRAR UNA POSICION DONDE PUEDA EMPEZAR LA PALABRA
function calcularCoordenada(numeroLetras, totalfilacolumna){

    return Math.floor(Math.random() * (totalfilacolumna - numeroLetras + 1));
}



//METODO QUE SIRVE PARA VERIFICAR QUE LA POSICION INICIAL X,Y DONDE SE VA A AGREGAR LA PRIMERA LETRA DE UNA PALABRA EN EL TABLERO
//NO ESTE OCUPADA. RECIBE COMO ARGUMENTOS LA VARIABLE POSICIOPALABRA QUE TIENE COMO SUBVARIABLES A FILA Y COLUMNA
//Y TAMBIEN A LA PALABRA ACTUAL CONVERTIDA EN ARRAY YA QUE VA A IR AGREGANDO LA PALABRA LETRA POR LETRA
function colocarPalabraHorizontal(posicionPalabra, array_palabra){

    //EN LA VARIABLE INICIO SE CAPTURA LA POSICION DE LA FILA DONDE VA A EMPEZAR LA PRIMERA LETRA DE LA PALABRA
    let inicio = (posicionPalabra.fila * juego.c) + posicionPalabra.columna;
    //CREAR VARIABLE CONTADOR
    let contador = 0;
    //CREAR ARRAY VACIO DONDE SE GUARDARAN LAS POSICIONES
    let posicionesPalabra = [];
    //CON EL CICLO FOR SE VA A REVISAR EN LA TABLA SI LA POSICION DONDE SE ENCONTRO ESPACIOS PARA AGREGAR LA PALABRA ACTUAL ESTA DISPONIBLE
    //ES DECIR, SI ESTAMOS EN X,Y POSICION DEL TABLERO, VA A VERIFICAR DE FORMA HORIZONTAL A DE IZQUIERDA A DERECHA, QUE ESAS CASILLAS TENGA UN #
    //LO QUE SIGNIFICA QUE ESTAN DISPONIBLES Y ENVIAR ESAS POSICIONES PARA SABER DONDE EESTAMOS GUARDANDO LA LETRA
    //SI POR EJEMPLO: LA PALABRA ES COMIDA, ENTONCES CON EL FOR SE HACEN SEIS ITERACIONES Y VA PREGUNTANDO SI DESDE LA POSICION DE LA VARIABLE INICIO
    //HACIA LA DERECHA HAY SEIS CASILLAS LIBRES QUE ESTEN CON # Y POR CADA CASILLA LIBRE EL CONTADOR AUMENTA EN 1
    for(let j=0; j<array_palabra.length; j++){
        if(juego.letras[inicio+j].letra === "#"){
            contador++;
        }
    }


    //UNA VEZ TERMINADO EL CICLO FOR, SE VERIFICA SI EL CONTADOR TIENE EL MISMO NUMERO DE LETRAS QUE LA PALABRA ACTUAL QUE SE ESTA REVISANDO
    //LO QUE SIGNIFICA QUE SI HAY CASILLAS DE FORMA HORIZONTAL DISPONIBLES PARA GUARDAR TODAS LAS LETRAS DE LA PALABRA ACTUAL
    //POR LO QUE SE HACE OTRO CICLO FOR, QUE VA INSERTANDO LETRA POR LETRA EN CADA CASILLERO DISPONIBLE DE IZQUIERDA A DERECHA
    if(contador === array_palabra.length){

        for(let i=0; i<array_palabra.length; i++){
            //SE PREGUNTA SI EN JUEGO.LETRAS[INICIO+I] QUE SE REFIERE A LA POSICION ACTUAL DEL TABLERO DONDE SE VA A COLOCAR X LETRA DE LA PALABRA ACTUAL
            //ESTA DISPONIBLE
            if(juego.letras[inicio+i].letra === "#"){

                //SI ESTA EL CASILLERO ACTUAL VACIO, ENTONCES SE VA A AGREGAR LETRA POR LETRA LA PALABRA ACTUAL
                juego.letras[inicio+i].letra = array_palabra[i];
                //EN LA VARIABLE ID SE VA A ALMACENAR LAS POSICIONES DONDE SE ESTAN GUARDANDO CADA LETRA DE LA PALABRA
                //OJO LA VARIABLE ID DEDE TENER LA MISMA NOMENCLATURA QUE EL ID QUE SE AGREGO AL INICIO, SINO NO FUNCIONA
                //DEBE TENER ESTA MISMA NOMENCLATURA: atributo.value = "casilla en la columna: " + c + " y en la fila: " + f;
                //NOMENCLATURAFINAL atributo.value = "casilla-" + c + "-" + f;
                let id = "casilla-" + juego.letras[inicio+i].c + "-" + juego.letras[inicio+i].f;
                //SE BUSCA EL ID DEL DIV ACTUAL DONDE SE VA A COLOCAR LA LETRA Y SE REEEMPLAZA # POR LA LETRA ACTUAL
                document.getElementById(id).innerText = array_palabra[i];
                //EN EL ARRAY POSICIONES PALABRA, SE VAN A ENVIAR LAS POSICIONES DE CADA LETRA, SUMANDO I
                posicionesPalabra.push(inicio + i);
            }
        }

        //SE RETORNA EL ARRAY CON LAS POSICIONES DE LOS CASILLEROS DONDE ESTAN LAS LETRAS DE LA PALABRA ACTUAL
        return posicionesPalabra;
        //console.log(posicionesPalabra);
    }

    //SI EL IF NO SE CUMPLIO, ES DECIR, SI LA PALABRA NO CABE EN LA SOPA DE LETRAS, QUE RETORNE FALSEE
    return false;
    

    //SE PUEDE IMPRIMIR EN CONSOLA EL ARRAY POSICIONES PALABRA PARA VER LAS POSICIONES DE CADA PALABRA
    //console.log(posicionesPalabra);
}




//METODO PARA VERIFICAR SI UNA PALABRA PUEDE COLOCARSE VERTICALMENTE
function colocarPalabraVertical(posicionPalabra, array_palabra){

    //EN LA VARIABLE INICIO SE CAPTURA LA POSICION DE LA CASILLA DONDE VA A EMPEZAR LA PRIMERA LETRA DE LA PALABRA ACTUAL
    let inicio = (posicionPalabra.fila * juego.c) + posicionPalabra.columna;
    //CREAR VARIABLE CONTADOR
    let contador = 0;
    //CREAR ARRAY VACIO DONDE SE GUARDARAN LAS POSICIONES 
    let posicionesPalabra = [];

    //CON EL FOR SE VA A REVISAR EN EL TABLERO SI LA POSICION DONDE ENCONTRO ESPACIOS PARA AGREGAR LA PALABRA ACTUAL ESTA DISPONIBLE
    //ES DECIR, SI ESTAMOS EN X,Y POSICION DEL TABLERO, VA A VERIFICAR QUE DE FORMA VERTICAL HACIA ABAJO, ESAS CASILLAS TENGAN #
    //LO QUE SIGNIFICA QUE ESTAN DISPONIBLES Y CADA VEZ QUE ENCUENTRE UNA CASILLA DISPONIBLE EL CONTADOR AUMENTA
    for(let i=0; i<array_palabra.length; i++){

        if(juego.letras[inicio+(i*juego.c)].letra === "#"){
            contador++;
        }
    }


    //UNA VEZ QUE HAYA TERMINADO EL FOR, SE VERIFICA SI EL CONTADOR TIENE EL MISMO NUMERO DE LETRAS DE LA PALABRA ACTUAL QUE SE ESTA REVISANDO
    //SI ES ASI ENTONCES ES PORQUE ENCONTRO CASILLAS DONDE CABE LA PALABRA VERTICALMENTE
    if(contador === array_palabra.length){

        //SE RECORRE LAS LETRAS DE LA PALABRA Y SE VA INSERTANDO UNA LETRA EN CADA CASILLA
        for(let i=0; i<array_palabra.length; i++){

            //SE PREGUNTA SI LA LETRA ACTUAL DE JUEGO.LETRAS[INICIO+(I*JUEGO.C)] ESTA LIBRE, SI ES ASI ENTONCES EN DICHO CASILLERO
            //SE COLOCA LA LETRA ACTUAL DE LA PALABRA
            if(juego.letras[inicio + (i*juego.c)].letra === "#"){

                //SI ESTA EL CASILLERO DISPONIBLE ENTONCES SE AGREGA LA LETRA ACTUAL
                juego.letras[inicio + (i*juego.c)].letra = array_palabra[i];
                //EN LA VARIABLE ID SE VA A ALMACENAR LAS POSICIONES DONDE SE ESTAN GUARDANDO CADA LETRA DE LA PALABRA
                //OJO LA VARIABLE ID DEDE TENER LA MISMA NOMENCLATURA QUE EL ID QUE SE AGREGO AL INICIO, SINO NO FUNCIONA
                //DEBE TENER ESTA MISMA NOMENCLATURA: atributo.value = "casilla en la columna: " + c + " y en la fila: " + f;
                //NOMENCLATURA FINAL: atributo.value = "casilla-" + c + "-" + f;
                let id = "casilla-" + juego.letras[inicio+ (i*juego.c)].c + "-" + juego.letras[inicio+ (i*juego.c)].f;
                //SE BUSCA EL ID DEL DIV ACTUAL DONDE SE VA A COLOCAR LA LETRA Y SE REEMPLAZA EL # POR LA LETRA ACTUAL
                document.getElementById(id).innerText = array_palabra[i];
                //EN EL ARRAY POSICIONESPALABRA SE VAN A ENVIAR LAS POSICIONES DE CADA LETRA, SUMANDO I
                posicionesPalabra.push(inicio + (i*juego.c));
            }
        }

        //RETORNAR EL ARRAY CON LAS POSICIONES DE LOS CASILLEROS DONDE ESTAN LAS LETRAS DE LA PALABRA ACTUAL
        return posicionesPalabra;
    }

    //SI EL IF NO SE CUMPLIO, ES DECIR, SI LA PALABRA NO CABE EN LA SOPA DE LETRAS, QUE RETORNE FALSE
    return false;
}



//METODO PARA RELLENAR LAS CASILLAS VACIAS DEL TABLERO CON LETRAS ALEATORIAS
function rellenarTabla(){

    //SE DECLARA LA VARIABLE ID
    let id;
    //CON UN FOR SE RECORRE TODAS LAS POSICIONES (256) DEL ARRAY JUEGO.LETRAS QUE CONTIENE TODAS LAS LETRAS DEL TABLERO 
    for(let i=0; i<juego.letras.length; i++){

        //CON EL IF SE PREGUNTA SI LA CASILLA ACTUAL QUE ESTA REVISANDO CONTIENE UN #
        if(juego.letras[i].letra === "#"){

            //SI ES ASI, ENTONCES SE CAMBIA EL # POR UNA LETRA RANDOM
            juego.letras[i].letra = generarLetra();
            //EN LA VARIABLE ID SE GUARDA LA POSICION ACTUAL DEL CASILLERO EN EL QUE SE AGREGO LA PALABRA RANDOM
            //OJO LA VARIABLE ID DEDE TENER LA MISMA NOMENCLATURA QUE EL ID QUE SE AGREGO AL INICIO, SINO NO FUNCIONA
            //DEBE TENER ESTA MISMA NOMENCLATURA: atributo.value = "casilla en la columna: " + c + " y en la fila: " + f;
            //NOMENCLATURA FINAL: atributo.value = "casilla-" + c + "-" + f;
            id = "casilla-" + juego.letras[i].c + "-" + juego.letras[i].f;
            //YA QUE TENEMOS EL ID DEL DIV DONDE SE ENCUENTRA LA LETRA ACTUAL, CAMBIAMOS EL # POR LA LETRA ALEATORIA
            document.getElementById(id).innerText = juego.letras[i].letra;
        }
    }
}



//METODO PARA GENERAR LETRAS ALEATORIAS
function generarLetra(){

    //SE CREA UNA CONSTANTE QUE CONTIENE LAS LETRAS A ENVIAR
    const letrasAleatorias = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";

    //SE CALCULA DE FORMA ALEATORIA UN NUMERO QUE SEA EL INDICE MEDIANTE EL CUAL SE VA A TOMAR LAS LETRAS RANDOM PARA ENVIARLAS
    let letrarandom = letrasAleatorias.charAt(Math.floor(Math.random() * letrasAleatorias.length));

    return letrarandom;

    //console.log(typeof(letrarandom));
}




//METODO PARA LISTAR LAS PALABRAS QUE EL USUARIO VA A TENER QUE ENCONTRAR EN EL JUEGO
function palabrasEscogidas(){

    //DECLARAR VARIABLES
    let etiqueta, atributo;

    //RECORRER EL ARRAY JUEGO.PALABRAS_ESCOGIDAS, QUE CONTIENE LAS PALABRAS A BUSCAR
    for(let i=0; i<juego.palabras_escogidas.length; i++){

        //POR CADA PALABRA DEL ARRAY JUEGO:PALABRAS_ESCOGIDAS SE CREA UN DIV PALABRA ESA PALABRA
        etiqueta = document.createElement("div");
        //EN EL DIV CREADO SE COLOCA LA PALABRA ACTUAL DEL ARRAY JUEGO:PALABRAS_ESCOGIDAS QUE SE ESTA EVALUANDO
        etiqueta.innerText = juego.palabras_escogidas[i].palabra;
        //SE CREA EL ATRIBUTO ID PARA LA PALABRA ACTUAL CON EL DIV ACTUAL
        atributo = document.createAttribute("id");
        //EN EL ID ENVIAR COMO VALOR LA PALABRA ACTUAL QUE SE ESTA RECORRIENDO 
        atributo.value = juego.palabras_escogidas[i].palabra;
        //ENVIAR AL ATRIBUTO CREADO ID COMO ATRIBUTO DEL DIV QUE SE CREO PARA LA PALABRA ACTUAL DEL ARRAY JUEGO:PALABRAS_ESCOGIDAS
        etiqueta.setAttributeNode(atributo);
        //ENVIAR EL DIV CREADO A LA ETIQUETA PALABRAS DEL HTML 
        document.getElementById("palabras").appendChild(etiqueta);
        
    }
}



//FUNCION PARA MOSTRAR LAS PALABRAS QUE EL USUARIO HA ACERTADO
function resultados(){

    //INICIALIZAR VARIABLE DENTRO DE LA VARIABLE PRINCIPAL JUEGO
    juego.aciertos = 0;

    //EN EL ARRAY JUEGO.PALABRAS_ESCOGIDAS QUE CONTIENE LAS PALABRAS QUE EL ALGORITMO SELECCIONO PARA EL JUEGO, SE VA A ANALIZAR
    //MEDIANTE EL METODO FOREACH (PALABRA, I)
    //SI LA PALABRA HA SIDO ENCONTRADA
    juego.palabras_escogidas.forEach((palab, i)=>{

        //PALAB HACE REFERENCIA A LA PALABRA QUE SE ENCUENTRA DENTRO DEL ARRAY PALABRAS ESCOGIDAS
        //CADA REGISTRO DEL ARRAY JUEGO.PALABRAS ESCOGIDAS TIENE 3 CAMPOS: palabra, posicion, encontrada
        //CON EL IF SE PREGUNTA SI EL CAMPO ENCONTRADA EL FALSE O TRUE, SI ES TRUE SIGNIFICA QUE LA PALABRA YA SE ENCONTRO
        if(palab.encontrada){
            //SI ES ASI ENTONCES QUE ACIERTOS AUMENTE
            juego.aciertos++;
        }

       
    });

    //EN LA VARIABLE PALABRAS QUE FALTAN SE CALCULA CUANTAS PALABRAS FALTAN POR ENCONTRAR AL USUARIO
    //RESTANDO EL NUMERO DE ACIERTOS DE LA CANTIDAD DE ELEMENTOS QUE CONTIENE EL ARRAY JUEGO.PALABRAS_ESCOGIDAS
    let palabrasQueFaltan = juego.palabras_escogidas.length - juego.aciertos;

    //CON EL IF SE PREGUNTA SI EL USUARIO HA ENCONTRADO TODAS LAS PALABRAS
    if(palabrasQueFaltan == 0){

        //SI ES ASI, ENTONCES QUE ENVIE UN MENSAJEE QUE HA ENCONTRADO TODAS LAS PALABRAS
        document.getElementById("mensaje").innerText = "Felicidades ha encontrado todas las palabras";
        //ENVIAR AL INPUT CON ID ANSWER_USER EL MENSAJE DE CORRECTO
        let respuestafinal = document.getElementById('answer_user');
        respuestafinal.value = 'Correcto';
        //ENVIAR AL INPUT CON ID TOTALPALABRAS EL MENSAJE CON EL NUMERO DE PALABRAS QUE HA ENCONTRADO
        let totalpalabras = document.getElementById('totalpalabras');
        totalpalabras.value = 10;
    }else{

        //SI AUN NO ENCUENTRE TODAS LAS PALABRAS, QUE ENVIE UN MENSAJE QUE LE FALTAN POR ENCONTRAR TODAVIA PALABRAS
        //document.getElementById("mensaje").innerText = "Encuentra las siguientes " + palabrasQueFaltan + " palabras.";
        document.getElementById("mensaje").innerText = "Faltan " + palabrasQueFaltan + " palabras por encontrar."
        //ENVIAR AL INPUT CON ID ANSWER_USER EL MENSAJE DE INCORRECTO
        let respuestafinal = document.getElementById('answer_user');
        respuestafinal.value = 'Incorrecto';
        //ENVIAR AL INPUT CON ID TOTAL PALABRAS EL MENSAJE CON EL NUMERO DE PALABRAS QUE HA ENCONTRADO
        let totalpalabras = document.getElementById('totalpalabras');
        totalpalabras.value = 10 - palabrasQueFaltan;

        //ACTUALIZACION
        //SE CREO UN NUEVO INPUT CON ID NUMEROPALABRASASIGNADAS DONDE SE ENVIA EL NUMERO DE PALABRAS CORRECTAS QUE INGRESARON EN LA SOPA DE LETRAS
        let numpalabrasasignadas = document.getElementById('numeropalabrasasignadas');
        numpalabrasasignadas.value = juego.palabras_escogidas.length;

        
    }

}






//AGREGAR AL BOTON CON ID VER_RESPUESTA UN EVENTO
const btn_ver_respuesta = document.getElementById('ver_respuesta');
btn_ver_respuesta.addEventListener('click', ver_palabras);

//METODO PARA MOSTRAR LA SOLUCION AL USUARIO
//FUNCTION VER_PALABRAS
function ver_palabras(event){

    //let cambiartexto = btn_ver_respuesta.innerText = "Funciona";

    //CAPTURAR ID


    //PINTAR DE AZUL LAS LETRAS A DE LA SOPA DE LETRAS
    //for(let i=0; i<juego.letras.length; i++){

    //    if(juego.letras[i].letra === "A"){
    //        document.getElementById("casilla-" + juego.letras[i].c + "-" + juego.letras[i].f).style.backgroundColor = "pink";
    //    }
    //}
    //console.log(juego.palabras_escogidas);

    //RECORRER TODAS LAS LETRAS Y ALMACENARLAS EN UN ARRAY
    //let posibilidad = document.querySelectorAll('#tabla div');
    //console.log(posibilidad[1].id);

    //IMPRIMIR POR CONSOLA EL ARRAY DE JUEGO.PALABRASESCOGIDAS
    //console.log(juego.palabras_escogidas);

    //AHORA SI RECORRER TODOS LOS DIV DE LA SOPA DE LETRAS Y GUARDAR EN UN ARRAY LOS IDS QUE TIENEN LA SIGUIENTE NOMENCLATURA
    //casilla-1-0 donde 1 es la columna y 0 es la fila
    let divs = document.querySelectorAll('#tabla button');
    //CREAR ARRAY DONDE SE VAN A ALMACENAR LOS IDS DE TODOS LOS DIVS
    let arrayiddivs = [];
    //RECORRER LA COLECCION DE DIVS Y GUARDAR CADA ID DEL DIV ACTUAL QUE SE RECORRE EN ARRAYIDDIVS
    for(let i=0; i<divs.length; i++){
        arrayiddivs.push(divs[i].id);
    }
    //MOSTRAR EN LA CONSOLA LOS IDS DE TODOS LOS DIVS DE LA TABLA DE SOPA DE LETRAS
    //console.log(arrayiddivs);
    //AHORA QUE YA TENGO SOLO LOS IDS SE QUITA LOS STRING PARA SOLO ALMACENAR EL NUMERO
    //Y CON LA FORMULAR ESE NUMERO ES IGUAL DE COINCIDENTE CON LAS POSICIONES DEL ARRAY JUEGO.LETRAS
    //ENTONCES CREO UN NUEVO ARRAY PARA GUARDAR SOLO LA POSICION X,Y DE FILA Y COLUMNA DE CADA ID
    let arrayposiciones = [];
    //SE CREA UNA VARIABLE POSICION QUE SIRVE PARA CAPTURAR SOLO LOS IDS Y CALCULARLOS CON LA FORMULA
    let posicion;
    //RECORRER EL ARRAYIDDIVS Y POR CADA REGISTRO QUITAR LOS STRING Y EN EL ARRAYPOSICIONES SOLO GUARDAR LOS NUMEROS CALCULADOS
    //CON LA FORMULA
    for(let j=0; j<arrayiddivs.length; j++){
        posicion = arrayiddivs[j].split("-");
        arrayposiciones.push(parseInt(posicion[2]) * juego.c + parseInt(posicion[1]));
    }
    //IMPRIMIR EN CONSOLA
    //console.log(arrayposiciones);

    //console.log(juego.palabras_escogidas[8].posicion[1]);

    let arrayprueba = [];
    
    //CON UN FOREACH SE ANALIZA CADA PALABRA DEL ARRAY JUEGO.PALABRAS_ESCOGIDAS
    //POR CADA PALABRA SE VERIFICA SI EN EL SUBARRAY DE CADA PALABRA LLAMADO POSICIONES EXISTEN ALGUN NUMERO QUE ESTA GUARDADO
    //EN EL ARRAY POSICIONES, QUE SON LA UBICACIONES ENTRE TERMINOS DE FILA COLUMNA EJEMPLO: casilla-1-2 donde 1 es la columna y 2 es la fila
    //PERO CON LA FORMULA SE TRANSFORMARON A UN SOLO NUMERO ENTERO QUE ES COMPATIBLE CON LOS ELEMENTOS DEL ARRAY JUEGO.LETRAS QUE VA DE 0 A 256
    //ENTONCES, SI LA POSICION QUE SE ESTA RECORRIENDO CON ARRAYPOSICIONES[K] COINCIDE CON ALGUNA POSICION DE ALGUNA LETRA DE ALGUNA PALABRA
    //DEL ARRAY JUEGO.PALABRASESCOGIDAS QUE ESA CELDA SE PINTE DE AMARILLO
    //SE PUEDE RECONOCER QUE CELDAS PINTAR, GRACIAS AL ARRAYIDDIVS QUE COMO TIENE LA MISMA LONGITUD Y LAS MISMAS POSICIONES QUE EL ARRAYPOSICIONES
    //SE SELECCIONA EL MISMO ELEMENTO DE ARRAYIDDIVS EN LA MISMA POSICION QUE ARRAYPOSICION Y APUNTAN AL MISMO DIV DE LA TABLA
    juego.palabras_escogidas.forEach((w)=>{
        for(let k=0; k<arrayposiciones.length; k++){
            if(w.posicion.includes(arrayposiciones[k])){
                document.getElementById(arrayiddivs[k]).style.backgroundColor = "yellow";
            }
        }

        
    });

    
    //ENVIAR AL INPUT CON ID PALABRA_ENCONTRADA EL ARRAY DE PALABRAS QUE HA ENCONTRADO EL USUARIO
    //document.getElementById('palabra_encontrada').value = juego.palabras_seleccionadas;
    
}