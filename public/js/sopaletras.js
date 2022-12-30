//CAPTURAR EL ARRAY QUE CONTIENE LAS PALABRAS CORRECTAS
let correct_answers = document.getElementsByName('answer');
//console.log(correct_answers);

var palabras_correctas = new Array();
let valores;
valores = [].map.call(correct_answers, function(dataInput){
    palabras_correctas.push(dataInput.value);
});
console.log(palabras_correctas);


//SE CREA LA VARIABLE SOPALETRAS QUE CONTIENE LAS SIGUIENTES SUBVARIABLES
//LETRAS CONTIENE LAS LETRAS DEL TABLERO DEL JUEGO
//NROPALABRAS CONTIENE EL NUMERO DE PALABRAS DEL ARRAY PALABRAS_CORRECTAS
//PALABRAS[] ALMACENARA LAS PALABRAS QUE SE UTILIZAN EN LA SOPA DE LETRAS
//EN PALABRAS_ENCONTRADAS SE GUARDAN LAS PALABRAS Y LETRAS QUE EL USUARIO HA ENCONTRADO
//C HACE REFERENCIA AL NUMERO DE COLUMNAS Y F AL NUMERO DE FILAS
var sopaletras = {c:16, f:16, nroPalabras:10, letras:[], palabras_escogidas:[], palabras_encontradas:[]};
//LAS SIGUIENTES VARIABLES SIRVEN PARA CREAR OBJETOS
let b,a;

//CUANDO SE CARGUE LA VENTANA DEL EJERCICIO, SE EJECUTAN LOS SIGUIENTES METODOS
window.onload = function(){
    crearTabla();
    agregarPalabras();
    llenarTabla();
    mostrarPalabras();
    encabezado();
}


//METODO PARA CREAR LA TABLA DE LA SOPA DE LETRAS
function crearTabla(){

    //NUEVO
    //ANTES DE CREAR LA TABLA
    //ENVIAR LOS ESTILOS AL DIV CON ID ESPACIOSP
    let dibujar = document.getElementById('espaciosp');    
    dibujar.style.width = "640px";
    dibujar.style.margin = "0";
    dibujar.style.textAlign = "center";
    dibujar.style.backgroundColor = "#ddd";



    let i = 0;
    //CON EL PRIMER FOR SE VAN A RECORRER LAS FILAS Y CON EL SEGUNDO FOR SE RECORREN LAS COLUMNAS
    for(let f=0; f<sopaletras.f; f++){
        for(let c=0; c<sopaletras.c; c++){
            //CON LA VARIABLE UNO SE CREA UN DIV POR CADA ITERACION
            b = document.createElement("div");
            //A ESE DIV CREADO SE ENVIA UN #
            b.innerText = "#";
            //EN LA VARIABLE DOS SE CREA EL ATRIBUTO ID
            a = document.createAttribute("id");
            //CON ESTA LINEA DE CODIGO SE PUEDE VER EN LA CONSOLA QUE AL HACER CLICK EN UNA CASILLA EN ESPECIFICO APARACEN LAS COORDENADAS DE LA CASILLA
            //COMENTAR ESTA LINEA MAS ADELANTE
            a.value = "celda seleccionada en la fila: " + f +  " y columna: " + c;
            //console.log(a.value);
            //EN LOS DIVS CREADOS CON VARIABLE UNO, ENVIAR LOS ATRIBUTOS LOS ELEMENTOS CREADOS CON VARIABLEDOS
            b.setAttributeNode(a);
            //CON LAS SIGUIENTES LINEAS DE CODIGO SE AGREGAN LOS ESTILOS AL DIV QUE SE CREA POR CADA LETRA DEL TABLERO
            //a = document.createAttribute("class");
            //a.value = "padding: 5px; border: 1px solid black; width: 40px; float: left; text-align: center;"
            //b.setAttributeNode(a);
            b.style.padding = "5px";
            b.style.border = "1px solid black";
            b.style.width = "40px";
            b.style.height = "40px";
            b.style.float = "left";
            b.style.textAlign = "center";
            //AGREGAR EL EVENTO CLICK A LA VARIABLE UNO
            
            ////

            //ASIGNAR EL LISTENER DE LA VARIABLE B A LA ETIQUETA TABLA DEL HTML
            document.getElementById("tabla").appendChild(b);
            //AGREGAR LAS LETRAS PARA QUE SE LLENE EL TABLERO
            sopaletras.letras.push({f:f, c:c, i:i, letra:"#"});
            //AUMENTAR I
            i++;


        }
    }
    //console.log(sopaletras.letras);
}



//METODO PARA VERIFICAR PALABRAS
//SE VERIFICA PALABRA A PALABRA TODAS LAS PALABRAS DE SOPALETRAS.PALABRAS SI YA FUERON SELECCIONADAS TODAS SUS CELDAS Y ES ASI, ENTONCES
//SE MARCA LA PALABRA
function comprobarPalabra(){

}


//METODO QUE INGRESA DE FORMA ALEATORIA EN LA TABLA DE LA SOPA DE LETRAS, LAS PALABRAS DEL ARRAY
//OJO EXISTEN DOS ARRAYS DE PALABRAS
//PALABRAS_CORRECTAS[] QUE CONTIENEN LAS PALABRAS QUE VAMOS A INGRESAR EN LA SOPA DE LETRAS PARA BUSCAR
//SOPALETRAS.PALABRAS_ESCOGIDAS[] QUE ES EL ARRAY QUE ESTA DENTRO DE SOPA LETRAS Y ES DONDE SE VAN A GUARDAR LAS PALABRAS DEL OTRO ARRAY
//QUE FUERON SELECCIONADAS POR EL ALGORITMO PARA QUE ESTEN EN LA SOPA DE LETRAS
//LO QUE HACE EL ALGORITMO ES BUSCAR ESPACIOS DONDE PUEDAN INGRESAR UNA PALABRA LETRA POR LETRA, SI CABEN LAS LETRAS EN LOS CASILLEROS
//QUE TIENEN #, AGREGA LAS PALABRAS AL ARRAY SOPALETRAS.PALABRAS_ESCOGIDAS
function agregarPalabras(){

    //CON EL FOR SE RECORRE EL ARRAY DE PALABRAS QUE CONTIENE LAS PALABRAS A AGREGAR EN LA SOPA DE LETRAS
    //Y CON EL METODO COMPROBAR_AGREGAR_PALABRA SE COMPRUEBA SI X PALABRA CABE EN LA SOPA DE LETRAS
    for(let i=0; i<sopaletras.nroPalabras; i++){
        //EN LA VARIABLE comprobacion, MEDIANTE EL METODO ANADIR_PALABRA SE COMPRUEBA SI LA PALABRA PUEDE SER AGREGADA EN LA TABLA DE LA SOPA DE LETRAS
        comprobacion = anadirPalabra(palabras_correctas[i].toUpperCase());
        //LA VARIABLE COMPROBACION DEVUELVE TRUE O FALSE
        //SI LA PALABRA CABE DENTRO DE LA SOPA DE LETRAS, ENTONCES QUE GUARDE LA PALABRA EN EL ARRAY SOPALETRAS.PALABRAS_ESCOGIDAS
        if(comprobacion){
            sopaletras.palabras_escogidas.push({
                //DENTRO DEL ARRAY SOPALETRAS.PALABRAS_ESCOGIDAS SE GUARDA UN ARRAY DE OBJETOS CON LOS SIGUIENTES ATRIBUTOS: ID, PALABRAS, POSICION, ENCONTRADA
                //SE PUEDE VERIFICAR CON CONSOLE.LOG(SOPALETRAS.PALABRAS_ESCOGIDAS)
                palabra:palabras_correctas[i].toUpperCase(),
                //EN LA VARIABLE POSICION, SE GUARDA LA POSICION DONDE ESTA ORIGINALMENTE LA PALABRA
                //DICHA POSICION SE ENCUENTRA EN LA VARIABLE COMPROBACIO
                posicion: comprobacion,
                //EN ENCONTRADA SE GUARDA FALSE YA QUE LA PALABRA AUN NO HA SIDO ENCONTRADA
                encontrada: false
            });
        }

        
    }
    //MEDIANTE ESTE CONSOLE LOG SE PUEDE VER LAS PALABRAS QUE FUERON SELECCIONADAS PARA ESTAR EN LA SOPA DE LETRAS
    console.log(sopaletras.palabras_escogidas);
}


//FUNCION PARA VERIFICAR SI X PALABRA DEL ARRAY PALABRAS_CORRECTAS, TIENE ESPACIOS SUFICIENTES PARA ENTRAR EN LA SOPA
function anadirPalabra(palabra){

    //EN LA VARIABLE ARRAY_PALABRA SE TRANSFORMA LA PALABRA X QUE SE ESTA EVALUANDO EN UN ARRAY DE LETRAS EJ: COMPUTADOR = [C O M P U T A D O R A]
    let array_palabra = palabra.split("");
    //LAS PALABRAS SOLO SE PUEDEN ALMACENAR DE FORMA HORIZONTAL INICIANDO DE IZQUIERDA A DERECHA
    //SE DEFINE LA VARIABLE COMPROBACION COMO FALSE
    let comprobacion = false;
    //DEFINIR LA VARIABLE INTENTOS QUE VA A SER EL NRO MAXIMO DE VECES QUE SE VA A REVISAR EN EL TABLERO LOS LUGARES DONDE PUEDE ENTRAR LA PALABRA
    let intentos = 300;
    //CON UN CICLO WHILE SE PROCEDE A VER LOS SITIOS DONDE SE PUEDE COLOCAR LA PALABRA MIENTRAS COMPROBACION SEA VERDADERO Y LA VARIABLE INTENTOS 
    //SEA MAYOR QUE 0, ES DECIR, MIENTRAS NO ENCUENTRE UN LUGAR DONDE PONER LA PALABRA
    while(!comprobacion && intentos>0){

        //POR CADA ITERACION LOS INTENTOS VAN DISMINUYENDO
        intentos--;
        //SE CREA LA VARIABLE POSICION Y DENTRO LA VARIABLE COLUMN Y ROW
        //ESTO SIRVE PARA SAVER EN QUE POSICION EXACTA INICIA LA PRIMERA LETRA DE LA PALABRA QUE SE VA A PONER DENTRO DE LA SOPA DE LETRAS
        let posicioninicial = {column:0, row:0};
        //SE CREA LA VARIABLE DIRECCION PARA DETERMINAR SI LA PALABRA VA A SER VERTICAL O HORIZONTAL
        let direccion = (Math.random()>0.5)?true:false;
        //CON EL IF SE PREGUNTA SI DIRECCION DEVOLVIO VERDADERO O FALSO
        //SI DEVOLVIO VERDADERO, ENTONCES QUE LA PALABRA SE AGREGUE HORIZONTALMENTE
        //SI DEVOLVIO FALSO, ENTONCES QUE LA PALABRA SE AGREGUE VERTICALMENTE
        if(direccion && array_palabra.length<=sopaletras.c){
            //PALABRA HORIZONTAL
            //EN POSICION.COLUMN SE ENVIA AL METODO CALCULARCOORDENADA()  EL NRO DE LETRAS QUE CONTIENE LA PALABRA ACTUAL Y EL NUMERO DE COLUMNAS TOTALES QUE EES 16
            //ESTE METODO SIRVE PARA ASIGNAR UNA POSICION INICIAL EN UNA COLUMNA A LA PRIMERA LETRA DE LA X PALABRA
            posicioninicial.column = calcularCoordenada(array_palabra.length, sopaletras.c);
            //EN POSICION,ROW SE RECIBE UN NUMERO RANDOM QUE ES MULTIPLICADO POR EL NUMERO DE FILAS QUE ES 16
            posicioninicial.row = Math.floor(Math.random()*sopaletras.f);
            //EN LA VARIABLE COMPROBACION, A TRAVES DEL METODO VERIFICARPALABRAACTUAL SE VERIFICA QUE LA POSICION INICIAL X,Y DONDE SE VA A PONER LA PALABRA
            //NO ESTEN OCUPADAS
            comprobacion = colocarPalabraHorizontal(posicioninicial, array_palabra);
        }
        else if (!direccion && array_palabra.length<=sopaletras.f){
            //PALABRA VERTICAL
            posicioninicial.row = calcularCoordenada(array_palabra.length, sopaletras.f);
            posicioninicial.col = Math.floor(Math.random()*sopaletras.c);
            comprobacion = colocarPalabraVertical(posicioninicial, array_palabra);
        }

    }

    //FINALMENTE SE DEVUELVE TRUE O FALSE
    return comprobacion;
}


//FUNCION QUE SIRVE PARA ASIGNAR UNA COLUMNA A LA PRIMERA LETRA DE X PALABRA
//TIENE COMO ARGUMENTOS LA LONGITUD DE LA PALABRA Y EL NRO TOTAL DE COLUMNAS
//VERIFICA UN ESPACIO DE LA TABLA DONDE HAYA ESPACIOS PARA EL NRO DE LETRAS DE FORMA HORIZONTAL DE X PALABRA
//Y ENVIA ESA COLUMNA ENCONTRADA COMO POSICION INICIAL EN POSICIONINICIAL.COLUMN DEL METODO ANADIRPALABRA
//ESTE METODO REVISA DE FORMA ALEATORIA TODAS LAS COLUMNAS DISPONIBLES HASTA ENCONTRAR UNA POSICION DONDE PUEDA EMPEZAR LA PALABRA
function calcularCoordenada(arraypalabra, nrototalcolumnas){
    return Math.floor(Math.random()*(nrototalcolumnas-arraypalabra+1));
}


//METODO QUE SIRVE PARA VERIFICAR QUE LA POSICION INICIAL X,Y DONDE SE VA A AGREGAR UNA PALABRA EN LA SOPA DE LETRAS NO ESTE OCUPADA
//RECIBE COMO ARGUMENTOS LA VARIABLE POSICIONINICIAL QUE TIENE COMO SUBARGUMENTOS LAS POSICIONES DE COLUMN Y ROW DE LA PALABRA ACTUAL
//Y TAMBIEN LA PALABRA ACTUAL CONVERTIDA EN ARRAY DE LETRAS
function colocarPalabraHorizontal(posicioninicial, array_palabra){

    let palabra = array_palabra;
    //EN LA VARIABLE FILAINICIO SE CAPTURA LA POSICION DE LA FILA DONDE VA A EMPEZAR LA PRIMERA LETRA DE LA PALABRA
    let inicio = (posicioninicial.row*sopaletras.c) + posicioninicial.column;

    //CREAR VARIABLE CONTADOR
    let contador = 0;
    //CREAR ARRAY VACIO DONDE SE VAN A GUARDAR LAS POSICIONES DE LAS LETRAS DE LA PALABRA
    let posiciones = [];

    //CON EL FOR SE VA A REVISAR EN LA TABLA SI LA POSICION DONDE SE ENCONTRO ESPACIOS PARA AGREGAR LA PALABRA ACTUAL ESTA DISPONIBLE
    //ES DECIR, SI ESTA EN X,Y POSICION DEL TABLERO, VA A VERIFICAR QUE DE FORMA HORIZONTAL A LA DERECHA, ESAS CASILLAS TENGAN UN # LO QUE SIGNIFICA QUE 
    //ESTAN DISPONIBLES Y ENVIAR ESAS POSICIONES PARA SABER DONDE ESTAMOS GUARDANDO LA LETRA
    //SI POR EJEMPLOS LA PALABRA ES: COMIDA ENTONCES CON EL FOR SE HACEN 6 ITERACIONES Y VA PREGUNTANDO SI DESDE LA POSICION DE LA VARIABLE FILA INICIAL 
    //HACIA LA DERECHA HAY SEIS POSICIONES LIBRES QUE ESTEN CON #
    for(let k=0; k<palabra.length; k++){
        if(sopaletras.letras[inicio+k].letra === "#"){
            contador++;
        }
    }


    //UNA VEZ TERMINADO EL CICLO FOR, SE VERIFICA SI EL CONTADOR TIENE EL MISMO NUMERO DE LETRAS QUE LA PALABRA ACTUAL QUE SE ESTA REVISANDO
    //LO QUE SIGNIFICA QUE SI HAY CASILLEROS DE FORMA HORIZONTAL DISPONIBLES PARA GUARDAR TODAS LAS LETRAS DE LA PALABRA ACTUAL
    //POR LO QUE SE HACE OTRO CICLO FOR QUE VA A RECORRER LA PALABRA ACTUAL
    if(contador === palabra.length){

        for(let n=0; n<palabra.length; n++){
            //SE PREGUNTA MEDIANTE SOPALETRAS.LETRAS[INICIO+N] QUE SE REFIERE A LA POSICION ACTUAL DEL TABLERO DONDE SE VA A COLOCAR LA PALABRA
            //SI LOS CASILLEROS QUE SE VAN A OCUPAR ESTAN VACIOS, ES DECIR TIENEN # Y NO UNA LETRA
            if(sopaletras.letras[inicio+n].letra === "#"){
                //SI ESTAN LOS CASILLEROS DISPONIBLES, ENTONCES SE AGREGA LETRA POR LETRA LA PALABRA ACTUAL
                sopaletras.letras[inicio+n].letra = palabra[n];
                //EN LA VARIABLE ID SE VA A ALMACENAR LAS POSICIONES DONDE SE ESTAN GUARDANDO CADA LETRA DE LA PALABRA
                let id = "casilla: " + sopaletras.letras[inicio+n].c + " - " + sopaletras.letras[inicio+n].f;
                //SE ENVIA LA LETRA QUE LE CORRESPONDE A CADA ESPACIO DE LA TABLA DE SOPA DE LETRAS MEDIANTE EL ID
                document.getElementById(id).innerText = palabra[n];
                //EN EL ARRAY POSICIONES SE VA A ENVIAR LAS POSICIONES DE CADA LETRA PERO SUMANDO N
                posiciones.push(inicio+n);
            }
        }

        //RETORNAR EL ARRAY CON LAS POSICIONES DONDE ESTA X PALABRA
        return posiciones;

    }

    //SI EL IF NO SE CUMPLIO, ES DECIR, SI LA PALABRA NO CABE EN LA SOPA DE LETRAS, QUE RETORNE FALSE
    return false;

}




//METODO PARA VERIFICAR SI UNA PALABRA CABE VERTICALMENTE
function colocarPalabraVertical(posicioninicial, palabra){

    //EN LA VARIABLE INICIO SE CAPTURA LA POSICION DE LA CASILLA DONDE VA A EMPEZAR LA PRIMERA LETRA DE LA PALABRA
    let inicio = (posicioninicial.row * sopaletras.c) + posicioninicial.column;

    //CREAR CONTADOR
    let contador = 0;
    //CREAR ARRAY VACIO
    let posiciones = [];

    //CON EL FOR SE VA A REVISAR EN EL TABLERO SI LA POSICION DONDE ENCONTRO ESPACIOS PARA AGREGAR LA PALABRA ACTUAL ESTA DISPONIBLE
    //ES DECIR, SI NOS ENCONTRAMOS EN X,Y POSICION DEL TABLERO, VA A VERIFICAR QUE DE FORMA VERTICAL HACIA ABAJO, LAS CASILLAS TENGAN UN # LO QUE
    //SIGNIFICA QUE ESTAN DISPONIBLES Y SEGUN ENCUENTRE LAS POSICIONES DISPONIBLES VAYA AUMENTANDO EL CONTADOR
    for(let j=0; j<palabra.length; j++){
        if(sopaletras.letras[inicio+ (j+sopaletras.c)].letra == "#"){
            contador++;
        }
    }


    //UNA VEZ HAYA TERMINADO EL FOR, SE VERIFICA SI EL CONTADOR TIENE EL MISMO NUMERO QUE EL NUMERO DE LETRAS DE LA PALABRA ACTUAL QUE SE ESTA REVISANDO
    //SI ES ASI, ENTONCES SIGNIFICA QUEE SE ENCONTRARON LAS POSICIONES DONDE CABE LA PALABRA VERTICALMENTE
    //POR LO QUE SE HACE OTRO FOR QUE VA A RECORRER DE NUEVO LA PALABRA ACTUAL Y VA A COLOCAR LAS LETRAS EN LOS CASILLEROS
    if(contador === palabra.length){

        for(let i=0; i<palabra.length; i++){
            //SE PREGUNTA MEDIANTEE SOPALETRAS.LETRAS[INICIO+I] QUE SE REFIERE A LAS POSICIONES QUE VA A IR OCUPANDO CADA LETRA
            //SI DICHO CASILLERO ESTA DISPONIBLE, ES DECIR, TIENE #
            if(sopaletras.letras[inicio + (i*sopaletras.c)].letra === "#"){
                //SI ESTAN LOS CASILLEROS VACIOS, ENTONCES SE VA A AGREGAR LETRA POR LETRA LA PALABRA ACTUAL
                sopaletras.letras[inicio + (i*sopaletras.c)].letra = palabra[i];
                //EN LA VARIABLE ID SE VA A ALMACENAR LAS POSICIONES DONDE ESTAN GUARDANDO CADA LETRA DE LA PALABRA
                let id = "casilla: " + sopaletras.letras[inicio + (i*sopaletras.c)].c + " - " + sopaletras.letras[inicio + (i * sopaletras.c)].f;
                //SE VA A ENVIAR A LA ETIQUETA ID DE CADA DIV, LA LETRA QUE LE CORRESPONDE A ESE CASILLERO ESPECIFICO
                document.getElementById(id).innerText = palabra[i];
                //EN EL ARRAY POSICIONES SE VAN A ENVIAR LAS POSICIONES DE CADA LETRA PERO SUMANDO I
                posiciones.push(inicio + (i*sopaletras.c));
            }

        }

        //RETORNAR EL ARRAY CON LAS POSICIONES DONDE ESTA X PALABRA
        return posiciones;
    }

    //SI EL IF NO SE CUMPLIO, ES DECIR, SI LA PALABRA NO CABE EN LA SOPA DE LETRAS, QUE RETORNE FALSE
    return false;
}


//METODO PARA RELLENAR LAS CASILLAS VACIAS DEL TABLERO CON LETRAS ALEATORIAS
function llenarTabla(){
    let id;
    //CON UN FOR RECORRER TODAS LAS POSICIONES (300) QUE SE ENCUENTRAN EN SOPALETRAS.LETRAS
    for(let i =0; i<sopaletras.letras.length; i++){
        //CON EL IF SE PREGUNTA SI LA CASILLA ACTUAL QUE ESTA REVISANDO CONTIENE UN #
        if(sopaletras.letras[i].letra === "#"){
            //SI ES ASI SE CAMBIA EL # POR UNA LETRA RANDOM
            sopaletras.letras[i].letra = generarLetra();
            //EN LA VARIABLE ID SE GUARDA LA POSICION ACTUAL DEL CASILLERO QUE SE AGREGA LA PALABRA RANDOM
            id = "casilla: " + sopaletras.letras[i].c + " - " + sopaletras.letras[i].f;
            //SE ENVIA LA LETRA ALEATORIA GENERADA AL TABLERO
            document.getElementById(id).innerText = sopaletras.letras[i].letra;
        }
    }
}


//METODO PARA GENERAR LETRAS ALEATORIAS
function generarLetra(){
    
    //SE CREA UNA CONSTANTE QUE CONTIENE LAS LETRAS A ENVIAR
    const letrasAleatorias = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";

    //SE CALCULA DE FORMA ALEATORIA UN NUMERO QUE SERA EL INDICE MEDIANTE EL CUAL SE VA A TOMAR LAS LETRAS ALEATORIAS
    let letrarandom = letrasAleatorias.charAt(Math.floor(Math.random() * letrasAleatorias.length));

    return letrarandom;

    //console.log(typeof(letrarandom));
}
