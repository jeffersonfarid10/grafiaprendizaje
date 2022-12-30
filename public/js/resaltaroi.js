//ANALISIS ENUNCIADO UNO

//CAPTURAR LA RESPUESTA ENUNCIADO UNO DEL USUARIO
let enunciadousuariouno = document.getElementById('enunciadousuariouno');
//CAPTURAR LA RESPUESTA CORRECTA UNO 
let enunciadocorrectouno = document.getElementById('enunciadocorrectouno');



//CAPTURAR LAS SECCIONES DE LA ORACION UNO DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTAUNO
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASENUNCIADOUSUARIOUNO
let incorrectsectionsusersentenceone = document.getElementsByName('seccionesIncorrectasEnunciadoUsuarioUno');
let seccionesIncorrectasEnunciadoUsuarioUno = new Array();
let seccionesIncorrectasUsuarioUno = [].map.call(incorrectsectionsusersentenceone, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasEnunciadoUsuarioUno.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasEnunciadoUsuarioUno);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOENUNCIADOUNO
let missedsectionsusersentenceone = document.getElementsByName('seccionesEnunciadoQueLeFaltaronAlUsuarioUno');
let seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoUno = new Array();
let seccionesFaltantesUsuarioUno = [].map.call(missedsectionsusersentenceone, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoUno.push(dataInput.textContent);
});
//console.log(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoUno);



//ANALISIS ENUNCIADO DOS

//CAPTURAR LA RESPUESTA ENUNCIADO UNO DEL USUARIO
let enunciadousuariodos = document.getElementById('enunciadousuariodos');
//CAPTURAR LA RESPUESTA CORRECTA UNO 
let enunciadocorrectodos = document.getElementById('enunciadocorrectodos');

//CAPTURAR LAS SECCIONES DE LA ORACION UNO DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTAUNO
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASENUNCIADOUSUARIOUNO
let incorrectsectionsusersentencetwo = document.getElementsByName('seccionesIncorrectasEnunciadoUsuarioDos');
let seccionesIncorrectasEnunciadoUsuarioDos = new Array();
let seccionesIncorrectasUsuarioDos = [].map.call(incorrectsectionsusersentencetwo, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasEnunciadoUsuarioDos.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasEnunciadoUsuarioDos);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOENUNCIADOUNO
let missedsectionsusersentencetwo = document.getElementsByName('seccionesEnunciadoQueLeFaltaronAlUsuarioDos');
let seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoDos = new Array();
let seccionesFaltantesUsuarioDos = [].map.call(missedsectionsusersentencetwo, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoDos.push(dataInput.textContent);
});
//console.log(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoDos);


//ANALISIS ENUNCIADO TRES

//CAPTURAR LA RESPUESTA ENUNCIADO UNO DEL USUARIO
let enunciadousuariotres = document.getElementById('enunciadousuariotres');
//CAPTURAR LA RESPUESTA CORRECTA UNO 
let enunciadocorrectotres = document.getElementById('enunciadocorrectotres');

//CAPTURAR LAS SECCIONES DE LA ORACION UNO DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTAUNO
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASENUNCIADOUSUARIOUNO
let incorrectsectionsusersentencethree = document.getElementsByName('seccionesIncorrectasEnunciadoUsuarioTres');
let seccionesIncorrectasEnunciadoUsuarioTres = new Array();
let seccionesIncorrectasUsuarioTres = [].map.call(incorrectsectionsusersentencethree, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasEnunciadoUsuarioTres.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasEnunciadoUsuarioTres);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOENUNCIADOUNO
let missedsectionsusersentencethree = document.getElementsByName('seccionesEnunciadoQueLeFaltaronAlUsuarioTres');
let seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoTres = new Array();
let seccionesFaltantesUsuarioTres = [].map.call(missedsectionsusersentencethree, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoTres.push(dataInput.textContent);
});
//console.log(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoTres);


//ANALISIS ENUNCIADO CUATRO

//CAPTURAR LA RESPUESTA ENUNCIADO UNO DEL USUARIO
let enunciadousuariocuatro = document.getElementById('enunciadousuariocuatro');
//CAPTURAR LA RESPUESTA CORRECTA UNO 
let enunciadocorrectocuatro = document.getElementById('enunciadocorrectocuatro');

//CAPTURAR LAS SECCIONES DE LA ORACION UNO DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTAUNO
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASENUNCIADOUSUARIOUNO
let incorrectsectionsusersentencefour = document.getElementsByName('seccionesIncorrectasEnunciadoUsuarioCuatro');
let seccionesIncorrectasEnunciadoUsuarioCuatro = new Array();
let seccionesIncorrectasUsuarioCuatro = [].map.call(incorrectsectionsusersentencefour, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasEnunciadoUsuarioCuatro.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasEnunciadoUsuarioCuatro);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOENUNCIADOUNO
let missedsectionsusersentencefour = document.getElementsByName('seccionesEnunciadoQueLeFaltaronAlUsuarioCuatro');
let seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCuatro = new Array();
let seccionesFaltantesUsuarioCuatro = [].map.call(missedsectionsusersentencefour, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCuatro.push(dataInput.textContent);
});
//console.log(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCuatro);



//ANALISIS ENUNCIADO CINCO

//CAPTURAR LA RESPUESTA ENUNCIADO UNO DEL USUARIO
let enunciadousuariocinco = document.getElementById('enunciadousuariocinco');
//CAPTURAR LA RESPUESTA CORRECTA UNO 
let enunciadocorrectocinco = document.getElementById('enunciadocorrectocinco');

//CAPTURAR LAS SECCIONES DE LA ORACION UNO DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTAUNO
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASENUNCIADOUSUARIOUNO
let incorrectsectionsusersentencefive = document.getElementsByName('seccionesIncorrectasEnunciadoUsuarioCinco');
let seccionesIncorrectasEnunciadoUsuarioCinco = new Array();
let seccionesIncorrectasUsuarioCinco = [].map.call(incorrectsectionsusersentencefive, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasEnunciadoUsuarioCinco.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasEnunciadoUsuarioCinco);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOENUNCIADOUNO
let missedsectionsusersentencefive = document.getElementsByName('seccionesEnunciadoQueLeFaltaronAlUsuarioCinco');
let seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCinco = new Array();
let seccionesFaltantesUsuarioCinco = [].map.call(missedsectionsusersentencefive, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCinco.push(dataInput.textContent);
});
//console.log(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCinco);



//EN EL METODO WINDOW.ONLOAD SE VAN A AGREGAR LAS FUNCIONES PARA PINTAR LAS PALABRAS TANTO EN LAS ORACION CORRECTAS COMO EN LAS ORACIONES DEL USUARIO
window.onload = function(){

    //METODOS ENUNCIADO UNO
    //METODO PARA PINTAR EN EL ENUNCIADO CORRECTO UNO, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
    pintar_seccionesnoencontradasenunciadouno();
    //METODO PARA PINTAR EN EL ENUNCIADO UNO DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA UNO
    pintar_seccionesincorrectasenunciadousuariouno();

    //METODOS ENUNCIADO DOS
    //METODO PARA PINTAR EN EL ENUNCIADO CORRECTO UNO, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
    pintar_seccionesnoencontradasenunciadodos();
    //METODO PARA PINTAR EN EL ENUNCIADO UNO DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA UNO
    pintar_seccionesincorrectasenunciadousuariodos();


    //METODOS ENUNCIADO TRES
    //METODO PARA PINTAR EN EL ENUNCIADO CORRECTO UNO, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
    pintar_seccionesnoencontradasenunciadotres();
    //METODO PARA PINTAR EN EL ENUNCIADO UNO DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA UNO
    pintar_seccionesincorrectasenunciadousuariotres();


    //METODOS ENUNCIADO CUATRO
    //METODO PARA PINTAR EN EL ENUNCIADO CORRECTO UNO, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
    pintar_seccionesnoencontradasenunciadocuatro();
    //METODO PARA PINTAR EN EL ENUNCIADO UNO DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA UNO
    pintar_seccionesincorrectasenunciadousuariocuatro();


    //METODOS ENUNCIADO CINCO
    //METODO PARA PINTAR EN EL ENUNCIADO CORRECTO UNO, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
    pintar_seccionesnoencontradasenunciadocinco();
    //METODO PARA PINTAR EN EL ENUNCIADO UNO DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA UNO
    pintar_seccionesincorrectasenunciadousuariocinco();


}




//METODOS ENUNCIADO UNO

//METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO UNO
function pintar_seccionesnoencontradasenunciadouno(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasenunciadocorrectouno = enunciadocorrectouno.innerHTML.split(" ");

    enunciadocorrectouno.innerHTML = palabrasenunciadocorrectouno.map((seccionuno) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoUno.length; i++){

            if(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoUno[i] === seccionuno){

                return `<span class="bg-green-500 font-bold">${seccionuno}</span>`;
            }
        }

        return seccionuno;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA DOS
function pintar_seccionesincorrectasenunciadousuariouno(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasenunciadousuariouno = enunciadousuariouno.innerHTML.split(" ");

    enunciadousuariouno.innerHTML = palabrasenunciadousuariouno.map((seccionuno) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasEnunciadoUsuarioUno.length; j++){

            if(seccionesIncorrectasEnunciadoUsuarioUno[j] === seccionuno){

                return `<span class="bg-red-500 font-bold">${seccionuno}</span>`;
            }
        }

        return seccionuno;
    }).join(" ");
}



//METODOS ENUNCIADO DOS

//METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO UNO
function pintar_seccionesnoencontradasenunciadodos(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasenunciadocorrectodos = enunciadocorrectodos.innerHTML.split(" ");

    enunciadocorrectodos.innerHTML = palabrasenunciadocorrectodos.map((secciondos) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoDos.length; i++){

            if(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoDos[i] === secciondos){

                return `<span class="bg-green-500 font-bold">${secciondos}</span>`;
            }
        }

        return secciondos;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA DOS
function pintar_seccionesincorrectasenunciadousuariodos(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasenunciadousuariodos = enunciadousuariodos.innerHTML.split(" ");

    enunciadousuariodos.innerHTML = palabrasenunciadousuariodos.map((secciondos) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasEnunciadoUsuarioDos.length; j++){

            if(seccionesIncorrectasEnunciadoUsuarioDos[j] === secciondos){

                return `<span class="bg-red-500 font-bold">${secciondos}</span>`;
            }
        }

        return secciondos;
    }).join(" ");
}



//METODOS ENUNCIADO TRES

//METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO UNO
function pintar_seccionesnoencontradasenunciadotres(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasenunciadocorrectotres = enunciadocorrectotres.innerHTML.split(" ");

    enunciadocorrectotres.innerHTML = palabrasenunciadocorrectotres.map((secciontres) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoTres.length; i++){

            if(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoTres[i] === secciontres){

                return `<span class="bg-green-500 font-bold">${secciontres}</span>`;
            }
        }

        return secciontres;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA DOS
function pintar_seccionesincorrectasenunciadousuariotres(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasenunciadousuariotres = enunciadousuariotres.innerHTML.split(" ");

    enunciadousuariotres.innerHTML = palabrasenunciadousuariotres.map((secciontres) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasEnunciadoUsuarioTres.length; j++){

            if(seccionesIncorrectasEnunciadoUsuarioTres[j] === secciontres){

                return `<span class="bg-red-500 font-bold">${secciontres}</span>`;
            }
        }

        return secciontres;
    }).join(" ");
}



//METODOS ENUNCIADO CUATRO

//METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO UNO
function pintar_seccionesnoencontradasenunciadocuatro(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasenunciadocorrectocuatro = enunciadocorrectocuatro.innerHTML.split(" ");

    enunciadocorrectocuatro.innerHTML = palabrasenunciadocorrectocuatro.map((seccioncuatro) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCuatro.length; i++){

            if(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCuatro[i] === seccioncuatro){

                return `<span class="bg-green-500 font-bold">${seccioncuatro}</span>`;
            }
        }

        return seccioncuatro;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA DOS
function pintar_seccionesincorrectasenunciadousuariocuatro(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasenunciadousuariocuatro = enunciadousuariocuatro.innerHTML.split(" ");

    enunciadousuariocuatro.innerHTML = palabrasenunciadousuariocuatro.map((seccioncuatro) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasEnunciadoUsuarioCuatro.length; j++){

            if(seccionesIncorrectasEnunciadoUsuarioCuatro[j] === seccioncuatro){

                return `<span class="bg-red-500 font-bold">${seccioncuatro}</span>`;
            }
        }

        return seccioncuatro;
    }).join(" ");
}


//METODOS ENUNCIADO CINCO

//METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO UNO
function pintar_seccionesnoencontradasenunciadocinco(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasenunciadocorrectocinco = enunciadocorrectocinco.innerHTML.split(" ");

    enunciadocorrectocinco.innerHTML = palabrasenunciadocorrectocinco.map((seccioncinco) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCinco.length; i++){

            if(seccionesEnunciadoQueLeFaltaronAlUsuarioEnunciadoCinco[i] === seccioncinco){

                return `<span class="bg-green-500 font-bold">${seccioncinco}</span>`;
            }
        }

        return seccioncinco;
    }).join(" ");
}

//METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA DOS
function pintar_seccionesincorrectasenunciadousuariocinco(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasenunciadousuariocinco = enunciadousuariocinco.innerHTML.split(" ");

    enunciadousuariocinco.innerHTML = palabrasenunciadousuariocinco.map((seccioncinco) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasEnunciadoUsuarioCinco.length; j++){

            if(seccionesIncorrectasEnunciadoUsuarioCinco[j] === seccioncinco){

                return `<span class="bg-red-500 font-bold">${seccioncinco}</span>`;
            }
        }

        return seccioncinco;
    }).join(" ");
}