//CAPTURAR EL TEXTO RESPUESTA DEL USUARIO
//let textoUsuario =document.getElementById('textousuario').textContent;
let textoUsuario = document.getElementById('textousuario');

//CAPTURAR EL TEXTO QUE CONTIENE LA RESPUESTA CORRECTA
//let textoCorrecto = document.getElementById('textocorrecto').textContent;
let textoCorrecto = document.getElementById('textocorrecto');


//CAPTURAR LAS PALABRAS QUE PUSO EL USUARIO EN SU TEXTO QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY PALABRASINCORRECTASTEXTOUSUARIO
let userincorrectwords = document.getElementsByName('palabrasIncorrectasTextoUsuario');
let palabrasIncorrectasTextoUsuario = new Array();
let palabrasIncorrectas = [].map.call(userincorrectwords, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    palabrasIncorrectasTextoUsuario.push(dataInput.textContent);
});
 


//CAPTURAR LOS SIGNOS ORTOGRAFICOS DE LA RESPUESTA DEL USUARIO QUE ESTAN MAL COLOCADOS O NO TIENEN NADA QUE VER CON EL TEXTO CORRECTO
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SIGNOSINCORRECTOSTEXTOUSUARIO
let userincorrectsigns = document.getElementsByName('signosIncorrectosTextoUsuario');
let signosIncorrectosTextoUsuario = new Array();
let signosIncorrectos = [].map.call(userincorrectsigns, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    signosIncorrectosTextoUsuario.push(dataInput.textContent);
});


//CAPTURAR LOS SIGNOS ORTOGRAFICOS QUE LE FALTARON COLOCAR AL USUARIO EN SU RESPUESTA
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SIGNOSQUELEFALTARONALTEXTOUSUARIO
let usermissedsigns = document.getElementsByName('signosQueLeFaltaronAlUsuario');
let signosQueLeFaltaronAlUsuario = new Array();
let signosFaltantes = [].map.call(usermissedsigns, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    signosQueLeFaltaronAlUsuario.push(dataInput.textContent);
});


//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN SU RESPUESTA
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIO
let usermissedsections = document.getElementsByName('seccionesQueLeFaltaronAlUsuario');
let seccionesQueLeFaltaronAlUsuario = new Array();
let seccionesFaltantes = [].map.call(usermissedsections, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesQueLeFaltaronAlUsuario.push(dataInput.textContent);
});


console.log(palabrasIncorrectasTextoUsuario);


 //EN EL METODO WINDOW.ONLOAD SE VAN A AGREGAR LAS FUNCIONES PARA PINTAR LAS PALABRAS TANTO EN EL TEXTO CORRECTO COMO EN LA RESPUESTA DEL USUARIO
 window.onload = function(){

    //METODO PARA PINTAR EN LA RESPUESTA CORRECTA, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
    pintar_seccionesnoencontradas();
    //METODO PARA PINTAR EN LA RESPUESTA DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA
    pintar_palabrasincorrectasTextoUsuario();
}



//METODO PARA PINTAR EN EL TEXTO CORRECTO, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO.
function pintar_seccionesnoencontradas(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS EL TEXTO CORRECTO
    let palabras = textoCorrecto.innerHTML.split(" ");

    textoCorrecto.innerHTML = palabras.map((elemento)=>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONES QUE LE FALTARON AL USUARIO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIDOS TODO EL TEXTO CORRECTO DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesQueLeFaltaronAlUsuario.length; i++){

            if(seccionesQueLeFaltaronAlUsuario[i] === elemento){

                return `<span class="bg-success font-bold">${elemento}</span>`;

            }
        }

        return elemento;
    }).join(" ");
}


//METODO PARA PINTAR EN EL TEXTO DEL USUARIO LAS PALABRAS QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA RESPUESTA CORRECTA
function pintar_palabrasincorrectasTextoUsuario(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS EL TEXTO DEL USUARIO
    let palabras = textoUsuario.innerHTML.split(" ");

    textoUsuario.innerHTML = palabras.map((elemento)=>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONES QUE LE FALTARON AL USUARIO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODO EL TEXTO DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<palabrasIncorrectasTextoUsuario.length; i++){

            if(palabrasIncorrectasTextoUsuario[i] === elemento){

                return `<span class="bg-danger font-bold">${elemento}</span>`;
            }
        }

        return elemento;

    }).join(" ");
}
