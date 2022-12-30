//CAPTURAR LA PALABRA QUE DEBE ENCONTRAR EL USUARIO
//IMPORTANTE
//PARA OBTENER EL CONTENIDO DE UNA ETIQUETA SE USA VALUE CUANDO ES INPUT
//INNERHTML PARA OBTENER EL HTML CONTENIDO EN UNA ETIQUETA
//TEXTCONTENT PARA OBTENER EL CONTENIDO DE UNA ETIQUETA
//EN ESTE CASO SE UTILIZA VALUE PORQUE SE CAPTURA EL CONTENIDO DE UN INPUT
let palabra = document.getElementById('answerjuego');
let palabra_correcta = palabra.value;
//console.log(palabra_correcta);


//CAPTURAR EL BOTON DE GUARDAR RESPUESTA Y QUE INICIE DESHABILITADO
let btn_guardar_respuesta = document.getElementById('guardar_respuesta');
btn_guardar_respuesta.disabled = true;


/////////////////////////////////////////////////////////////////////////////JUEGO AHORCADO///////////////////////////////////////////////////

//VARIABLE QUE CONTIENE LA PALABRA A ADIVINAR
palabra_adivinar_usuario = palabra_correcta.toString();
//VARIABLES PARA CONTAR LOS ERRORES Y ACIERTOS DEL USUARIO CADA VEZ QUE HACE CLICK EN UNA PALABRA
let aciertos = 0;
let errores = 0;
//CONSTANTE PARA CAPTURAR EL BOTON DE INICIAR JUEGO DEL HTML
const btn_iniciar_juego = document.getElementById('iniciar_juego');
//BUSCAR EN EL ARCHIVO HTML LA ETIQUETA CON ID IMAGEN Y GUARDARLA EN UNA VARIABLE
//ESTA IMAGEN CADA VEZ QUE HAYA UN NUEVO JUEGO, DEBE RESETEARSE A LA IMAGEN CON NRO 0
const imagen = document.getElementById('imagen_juego');
//CONSTANTE QUE VA A ALMACENAR EN UN ARRAY, LAS LETRAS A LAS QUE EL USUARIO HAYA HECHO CLICK
//VA A TOMAR LAS LETRAS QUE EL USUARIO HAYA ESCOGIDO DE LOS BOTONES DEL HTML DEL DIV CON ID LETRAS
const btn_letras = document.querySelectorAll('#letras button');
//LOS BOTONES QUE CONTIENEN A LAS LETRAS INICIAN DESHABILITADOS HASTA QUE EL USUARIO HAGA CLICK EN INICIAR JUEGO
btn_letras.disabled = true;
//AL INICIAR EL JUEGO LOS BOTONES DE LAS LETRAS DEBEN PERMANECER DESACTIVADOS
//CUANDO EL JUEGO TERMINE QUE SE DESHABILITEN LOS BOTONES DE LAS LETRAS QUE ES LO QUE HACIA LA FUNCION JUEGO_TERMINADO
for(a=0; a<btn_letras.length; a++){
    btn_letras[a].disabled = true;
    //btn_letras[a].style.color = "red";
}

//CUANDO SE HAGA CLICK EN EL BOTON INICIAR JUEGO DEL HTML, EL METODO INICIAR_JUEGO DESDE ESTAR LISTO QUE AUN NO SE EJECUTE
//CUANDO SE PONE () AL LADO DE LOS EVENTOS ESTOS SE EJECUTAN CUANDO SE LEE ESA LINEA, MIENTRAS TANTO NO
btn_iniciar_juego.addEventListener('click', iniciar_juego);

//FUNCION INICIAR JUEGO
function iniciar_juego(event){

    //DESACTIVAR EL BOTON GUARDAR RESPUESTA CUANDO SE REINICIE EL JUEGO
    btn_guardar_respuesta.disabled = true;
    //AL BOTON INICIAR JUEGO QUE ES EL BOTON MEDIANTE EL CUAL SE OBTIENE LA PALABRA A ADIVINAR, DARLE LA PROPIEDAD DISABLED PARA QUE SE DESHABILITE
    //UNA VEZ QUE EL USUARIO HAYA HECHO CLICK EN ESE BOTON Y HAYA INICIADO EL JUEGO
    btn_iniciar_juego.disabled = true;
    //CADA VEZ QUE SE INICIE EL JUEGO, RESETEAR LOS ERRORES Y ACIERTOS
    aciertos = 0;
    errores = 0;
    //TAMBIEN AL INICIAR EL JUEGO SE DEBE RESETEAR LA IMAGEN INICIAL A LA IMAGEN 0
    //imagen.src = '/img/img0.png';
    //IMAGEN FINAL
    imagen.src = '/imagenesja/imagen0.png';
    //RESETEAR EL MENSAJE DE PERDISTE O GANASTE
    document.getElementById('resultado').innerHTML = '';
    //ACTIVAR LOS BOTONES DE LAS LETRAS CUANDO SE INICIE EL JUEGO
    for(let i=0; i<btn_letras.length; i++){
        btn_letras[i].disabled = false;
    }


    //VARIABLE PARRAFO QUE HACE REFERENCIA AL <P> DEL HTML CON ID PALABRA_ADIVINAR 
    //QUE ES DONDE SE VAN A GENERAR LAS LINEAS SEGUN EL NUMERO DE LETRAS DE LA PALABRA
    const span_palabra_adivinar = document.getElementById('palabra_adivinar');
    //CON EL INNER HTML SE VA A VACIAR LO QUE TENEMOS DENTRO DEL <P> PARA QUE AL DARLE DE NUEVO AL BOTON
    //OBTENER PALABRA O INICIAR JUEGO, SE LIMPIEN LOS GUIONES O LETRAS DE LA PALABRA ANTERIOR
    span_palabra_adivinar.innerHTML = '';

    //CAPTURAR EL NUMERO DE LETRAS QUE TIENE LA PALABRA A ADIVINAR
    const nro_letras = palabra_adivinar_usuario.length;
    //console.log(nro_letras);
    //CON EL FOR SE RECORRE EL NUMERO DE ESPACIOS NECESARIOS PARA LA PALABRA ACTUAL Y CREAR LOS SPAN NECESARIOS
    //ES DECIR, CREAR LAS LINEAS SEGUN EL NUMERO DE LETRAS DE LA PALABRA
    for(let j=0; j<nro_letras; j++){
        //LINEAS DE CODIGO PARA QUE POR CADA LETRA DE LA PALABRA, SE CREE UN SPAN CON UN GUION 
        const span_letra = document.createElement('span');

        //NUEVO AGREGAR UN ID A CADA SPAN CREADO
        span_letra.id = `letra${j}`;

        //SE DAN LOS ESTILOS A LOS SPAN PARA QUE MUESTRE LOS GUIONES CORRESPONDIENTES CON CSS
        span_letra.style.verticalAlign= "bottom";
        span_letra.style.fontSize="2em";
        span_letra.style.borderBottom="2px solid black";
        span_letra.style.width="30px";
        span_letra.style.textAlign="center";
        span_letra.style.marginRight="6px";
        span_letra.style.display="inline-block";
 
        //LOS SPAN CREADOS SE VAN A MOSTRAR EN LA ETIQUETA <P> CON ID PALABRA_ADIVINAR QUE ESTA CONTENIDA EN LA VARIABLE
        //SPAN__PALABRA_ADIVINAR
        span_palabra_adivinar.appendChild(span_letra);
    }


}


//CON UN FOR SE VA RECORRIENDO EL LARGO DE BOTONES QUE TENGAMOS
//Y POR CADA CLICK QUE SE HAGA EN UN BOTON DE LAS LETRAS, SE ACTIVA UN LISTENER QUE DIRIJE
//AL METODO CLICK LETRAS
//QUE SE DONDE SE VERIFICA SI LA LETRA COINCIDE O NO COINCIDE CON LA LETRA CORRECTA
for(let k=0; k<btn_letras.length; k++){
    btn_letras[k].addEventListener('click', comprobar_letras);
}


//FUNCION PARA COMPROBAR SI EL BOTON AL QUE EL USUARIO HACE CLICK, CONTIENE UNA LETRA QUE FORMA PARTE DE LA PALABRA 
//O NO FORMA PARTE
function comprobar_letras(event){

    //CONSTANTE SPAN QUE DEVUELVE UN ARRAY
    //CON LO QUE SE SELECCIONE DEL ID PALABRA A ADIVINAR Y SUS SPANS
    const spans = document.querySelectorAll('#palabra_adivinar span');
    //console.log(spans);
    //EN LA CONSTANTE BOTON_SELECCIONADO SE ALMACENA CUAL DE TODOS LOS BOTONES LLAMO A LA FUNCION COMPROBAR_LETRAS
    const boton_seleccionado = event.target;
    //LUEGO SE SELECCIONAR UN BOTON CON UNA LETRA SE DESHABILITA ESE BOTON YA QUE NO SE PUEDE VOLVER A UTILIZAR
    boton_seleccionado.disabled = true;

    //SE CAPTURA LA LETRA QUE ESTA DENTRO DEL BOTON PULSADO
    //let letra_seleccionada = boton_seleccionado.innerHTML.toLowerCase();
    //SE GUARDA LA PALABRA A ADIVINAR COMO TODO EN MINUSCULAS
    //let palabra_minusculas = palabra_adivinar_usuario.toLowerCase();
    //ACTUALIZACION YA NO SE HACE MINUSCULAS A LA LETRA QUE SELECCIONA EL USUARIO
    //AHORA SE CAPTURA TAL COMO VIENE DE LA VISTA ES DECIR SI ES MINUSCULA O MAYUSCULA
    let letra_seleccionada = boton_seleccionado.textContent;
    let palabra_minusculas = palabra_adivinar_usuario;
    //console.log(letra_seleccionada);

    //DECLARAR VARIABLE BOOLEAN QUE COMPRUEBA SI EL USUARIO HIZO CLICK EN UN BOTON DE UNA LETRA QUE SI PERTENECE A LA PALABRA
    //CORRECTA
    let acierta_letra = false; 
    //CON EL FOR SE RECORRE LA PALABRA QUE TIENE QUE ADIVINAR Y SE VA COMPARANDO LETRA A LETRA 
    //SI ALGUNA LETRA COINCIDE CON LA LETRA QUE EL USUARIO SELECCIONO HACIENDO CLICK EN EL BOTON
    for(let i=0; i<palabra_minusculas.length; i++){
        //SI LA LETRA QUE ESTA RECORRIENDOSE ACTUALMENTE CON EL FOR, ES LA MISMA QUE SELECCIONO EL USUARIO 
        //ENTONCES QUE ACIERTA_LETRA CAMBIE A TRUE
        if(letra_seleccionada === palabra_minusculas[i]){
            //HACER QUE SE MUESTRE EN EL GUION CORRESPONDIENTE, LA LETRA QUE EL USUARIO HIZO CLICK
            spans[i].innerHTML = letra_seleccionada;
            //SI ACERTO CON LA LETRA TAMBIEN SE SUMA 1 PUNTO A LOS ACIERTOS Y ACIERTA_LETRA CAMBIA A TRUE
            aciertos++;
            acierta_letra = true;
        }
    }


    //SI YA TERMINO EL CICLO FOR Y ACIERTA_LETRA SIGUE SIENDO FALSE, SIGNIFICA QUE EL BOTON QUE HIZO CLICK EL USUARIO
    //NO PERTENECE A LA PALABRA QUE TIENE QUE ADIVINAR Y ENTONCES QUE HAGA LO SIGUIENTE
    if(acierta_letra == false){
        //SI NO ACERTO LA LETRA, SE SUMA 1 A ERRORES
        errores++;
        //MIENTRAS VAYA AUMENTANDO LOS ERRORES, SE CAMBIA LA IMAGEN 
        //const nueva_imagen = `/img/img${errores}.png`;
        //IMAGENES FINALES QUE VAN CAMBIANDO MIENTRAS AUMENTEN LOS ERRORES
        const nueva_imagen = `/imagenesja/imagen${errores}.png`;
        //REEMPLAZAR EN LA IMAGEN ACTUAL, LO QUE ESTA ALMACENADO EN LA VARIABLE NUEVA_IMAGEN
        imagen.src = nueva_imagen;
    } 


    //COMO SON 7 IMAGENES DE ERRORES, LA CANTIDAD MAXIMA DE ERRORES DEBE SER 7
    //SI EL USUARIO COMETE 7 ERRORES, QUE LE SALGA UN MENSAJE DE PERDISTE
    //SI EL USUARIO TIENE LA VARIABLE ACIERTOS = AL LENGTH O NRO DE LETRAS DE LA PALABRA QUE ESTA ADIVINANDO
    //QUE LE SALGA UN MENSAJE QUE HA GANADO
    if(errores === 7){

        //ENVIAR AL <P> CON ID RESULTADO EL MENSAJE
        document.getElementById('resultado').innerHTML = "Perdiste, la palabra era: " + palabra_minusculas;
        //SE LLAMA A LA FUNCION JUEGO_TERMINADO()
        //juego_terminado();
        //ENVIAR AL INPUT DE LA VISTA RESPONSE EL MENSAJE DE INCORRECTO MEDIANTE EL CUAL SE CALCULA EL PUNTAJE EN EL CONTROLADOR
        //let respuestafinal = document.getElementById('answer_user');
        //respuestafinal.value = 'Incorrecto';
        //console.log(respuestafinal);
        //CUANDO YA HA TERMINADO EL JUEGO QUE SE HABILITE EL BOTON DE GUARDAR RESPUESTA Y ENVIAR LA RESPUESTA AL FORMULARIO
        btn_guardar_respuesta.disabled = false;
        //CUANDO EL JUEGO TERMINE QUE SE DESHABILITE EL BOTON DE INICIAR JUEGO
        btn_iniciar_juego.disabled = true;
        //CUANDO EL JUEGO TERMINE QUE SE DESHABILITEN LOS BOTONES DE LAS LETRAS QUE ES LO QUE HACIA LA FUNCION JUEGO_TERMINADO
        for(a=0; a<btn_letras.length; a++){
            btn_letras[a].disabled = true;
        }

        //IMPORTANTE
        //PARA OBTENER EL CONTENIDO DE UNA ETIQUETA SE USA VALUE CUANDO ES INPUT
        //INNERHTML PARA OBTENER EL HTML CONTENIDO EN UNA ETIQUETA
        //TEXTCONTENT PARA OBTENER EL CONTENIDO DE UNA ETIQUETA

        //RECORRER LAS LETRAS QUE EL USUARIO HA SELECCIONADO Y GUARDARLAS EN UNA VARIABLE
        //SE CREA UN ARRAY QUE CONTENDRA LAS LETRAS QUE EL USUARIO HA ADIVINADO 
        let respuestausuariofinal = new Array();
        //CON UN ARRAY SE RECORRE EL NUMERO DE ESPACIOS DE LA PALABRA A ADIVINAR
        for(k=0; k<palabra_minusculas.length; k++){
            //EN LA VARIABLE LETRA FINAL SE VAN A CAPTURAR LOS SPAN DE LA RESPUESTA DEL USUARIO
            let letrafinal = document.getElementById(`letra${k}`);
            //EN LA VARIABLE LETRAF SE CAPTURA EL CONTENIDO DE CADA SPAN
            let letraf = letrafinal.textContent;
            //SI EL SPAN ESTA VACIO SE COLOCA UNA LINEA EN ESE SITIO
            if(letraf === ""){
                letraf = "_";
                
            }
            //EN EL ARRAY RESPUESTA USUARIO FINAL SE VAN ALMACENANDO LAS LETRAS DEL USUARIO
            respuestausuariofinal.push(letraf);

        }
        //let cadenarespuestausuario = respuestausuariofinal.toString();
        //EN LA VARIABLE CADENA RESPUESTA USUARIO SE TRANSFORMA EL ARRAY A STRING
        let cadenarespuestausuario = respuestausuariofinal.join(" ");
        //console.log(typeof(cadenarespuestausuario));
        //SE ENVIA AL INPUT DE LA VISTA RESPONSE EL MENSAJE CON LAS LETRAS QUE EL USUARIO ADIVINO 
        let respuestafinal = document.getElementById('answer_user');
        respuestafinal.value = cadenarespuestausuario;



        

    }else if(aciertos === palabra_minusculas.length){

        //SI EL USUARIO HA ACERTADO TODAS LAS LETRAS Y GANADO EL JUEGO ENTONCES
        //SE ENVIA AL <P> CON ID RESULTADO EL MENSAJE
        document.getElementById('resultado').innerHTML = "Ganaste, has acertado la palabra.";
        //SE LLAMA A LA FUNCION JUEGO_TERMINADO()
        //juego_terminado();
        //SE ENVIA AL INPUT DE LA VISTA RESPONSE EL MENSAJE DE CORRECTO, ES DECIR LA MISMA PALABRA QUE TENIA QUE ADIVINAR
        //YA QUE EL USUARIO ADIVINO CORRECTAMENTE LA PALABRA
        let respuestafinal = document.getElementById('answer_user');
        respuestafinal.value = palabra_minusculas;
        //CUANDO YA TERMINO EL JUEGO QUE SE HABILITE EL BOTON SALIR Y ENVIE LA RESPUESTA AL FORMULARIO
        btn_guardar_respuesta.disabled = false;
        //CUANDO EL JUEGO TERMINE QUE SE DESHABILITE EL BOTON DE INICIAR JUEGO
        btn_iniciar_juego.disabled = true;
        //CUANDO EL JUEGO TERMINE QUE SE DESHABILITEN LOS BOTONES DE LAS LETRAS QUE ES LO QUE HACIA LA FUNCION JUEGO_TERMINADO
        for(a=0; a<btn_letras.length; a++){
            btn_letras[a].disabled = true;
        }
    }


    //EN LA CONSOLA PROBAR SI FUNCIONAN LAS PALABRAS Y BOTONES
    console.log("La letra " + letra_seleccionada + " en la palabra " + palabra_minusculas + "¿existe?: " + acierta_letra);

}
