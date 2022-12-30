//CAPTURAR EL TEXTO RESPUESTA DEL USUARIO
let textoUsuario = document.getElementById('textousuario');
//CAPTURAR EL TEXTO CORRECTO
let textoCorrecto = document.getElementById('textocorrecto');

//CAPTURAR LAS SECCIONES DEL TEXTO DEL USUARIO QUE NO SE ENCONTRARON EN EL TEXTO CORRECTO
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASPARRAFOUSUARIO
let userincorrectsections = document.getElementsByName('palabrasIncorrectasParrafoUsuario');
let seccionesIncorrectasParrafoUsuario = new Array();
let seccionesIncorrectasUsuario = [].map.call(userincorrectsections, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasParrafoUsuario.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasParrafoUsuario);


//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN SUS RESPUESTAS
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIO
let usermissedsections = document.getElementsByName('seccionesQueLeFaltaronAlUsuario');
let seccionesQueLeFaltaronAlUsuario = new Array();
let seccionesFaltantes = [].map.call(usermissedsections, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXT CONTENT
    seccionesQueLeFaltaronAlUsuario.push(dataInput.textContent);
});
//console.log(seccionesQueLeFaltaronAlUsuario);


//EN EL METODO WINDOW.ONLOEAD SE VAN A AGREGAR LAS FUNCIONES PARA PINTAR LAS PALABRAS TANTO EEN EL TEXTO CORRECTO COMO EN EL TEXTO DEL USUARIO
window.onload = function(){

    //METODO PARA PINTAR EN LA RESPUESTA CORRECTA, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
    pintar_seccionesnoencontradas();
    //METODO PARA PINTAR EN LA RESPUESTA DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VEN CON LA RESPUESTA CORRECTA
    pintar_seccionesincorrectasTextoUsuario();
}



//METODO PARA PINTAR EN EL TEXTO CORRECTO, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
function pintar_seccionesnoencontradas(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS EL TEXTO CORRECTO
    let palabras = textoCorrecto.innerHTML.split(" ");

    textoCorrecto.innerHTML = palabras.map((elemento)=>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONES QUE LE FALTARON AL USUARIO
        //Y SI LA SECCION EN LA POSICION I COINCIDEE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODO EL TEXTO CORRECTO DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesQueLeFaltaronAlUsuario.length; i++){

            if(seccionesQueLeFaltaronAlUsuario[i] === elemento){

                return `<span class="bg-success font-bold">${elemento}</span>`;
            }
        }

        return elemento;
    }).join(" ");
}


//METODO PARA PINTAR EN EL TEXTO DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA RESPUESTA CORRECTA
function pintar_seccionesincorrectasTextoUsuario(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS EL TEXTO DEL USUARIO
    let palabras = textoUsuario.innerHTML.split(" ");

    textoUsuario.innerHTML = palabras.map((elemento)=>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONES QUE LE FALTARON AL USUARIO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODO EL TEXTO DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesIncorrectasParrafoUsuario.length; i++){

            if(seccionesIncorrectasParrafoUsuario[i] === elemento){

                return `<span class="bg-danger font-bold">${elemento}</span>`;
            }
        }

        return elemento;

    }).join(" ");
}