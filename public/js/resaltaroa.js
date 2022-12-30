//ANALISIS ORACION UNO

//CAPTURAR LA RESPUESTA ORACION UNO DEL USUARIO
let oracionusuariouno = document.getElementById('oracionusuariouno');
//CAPTURAR LA RESPUESTA CORRECTA UNO 
let oracioncorrectauno = document.getElementById('oracioncorrectauno');

//CAPTURAR LAS SECCIONES DE LA ORACION UNO DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTAUNO
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
let incorrectsectionsusersentenceone = document.getElementsByName('seccionesIncorrectasOracionUsuarioUno');
let seccionesIncorrectasOracionUsuarioUno = new Array();
let seccionesIncorrectasUsuarioUno = [].map.call(incorrectsectionsusersentenceone, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasOracionUsuarioUno.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasOracionUsuarioUno);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIONUNO
let missedsectionsusersentenceone = document.getElementsByName('seccionesQueLeFaltaronAlUsuarioUno');
let seccionesQueLeFaltaronAlUsuarioOracionUno = new Array();
let seccionesFaltantesUsuarioUno = [].map.call(missedsectionsusersentenceone, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesQueLeFaltaronAlUsuarioOracionUno.push(dataInput.textContent);
});
//console.log(seccionesQueLeFaltaronAlUsuarioOracionUno);





//ANALISIS ORACION DOS

//CAPTURAR LA RESPUESTA ORACION DOS DEL USUARIO
let oracionusuariodos = document.getElementById('oracionusuariodos');
//CAPTURAR LA RESPUESTA CORRECTA DOS 
let oracioncorrectados = document.getElementById('oracioncorrectados');

//CAPTURAR LAS SECCIONES DE LA ORACION DOS DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTADOS
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIODOS
let incorrectsectionsusersentencetwo = document.getElementsByName('seccionesIncorrectasOracionUsuarioDos');
let seccionesIncorrectasOracionUsuarioDos = new Array();
let seccionesIncorrectasUsuarioDos = [].map.call(incorrectsectionsusersentencetwo, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasOracionUsuarioDos.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasOracionUsuarioDos);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIONUNO
let missedsectionsusersentencetwo = document.getElementsByName('seccionesQueLeFaltaronAlUsuarioDos');
let seccionesQueLeFaltaronAlUsuarioOracionDos = new Array();
let seccionesFaltantesUsuarioDos = [].map.call(missedsectionsusersentencetwo, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesQueLeFaltaronAlUsuarioOracionDos.push(dataInput.textContent);
});
//console.log(seccionesQueLeFaltaronAlUsuarioOracionDos);



//ANALISIS ORACION TRES

//CAPTURAR LA RESPUESTA ORACION TRES DEL USUARIO
let oracionusuariotres = document.getElementById('oracionusuariotres');
//CAPTURAR LA RESPUESTA CORRECTA TRES 
let oracioncorrectatres = document.getElementById('oracioncorrectatres');

//CAPTURAR LAS SECCIONES DE LA ORACION TRES DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTATRES
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOTRES
let incorrectsectionsusersentencethree = document.getElementsByName('seccionesIncorrectasOracionUsuarioTres');
let seccionesIncorrectasOracionUsuarioTres = new Array();
let seccionesIncorrectasUsuarioTres = [].map.call(incorrectsectionsusersentencethree, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasOracionUsuarioTres.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasOracionUsuarioTres);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION TRES
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIONTRES
let missedsectionsusersentencethree = document.getElementsByName('seccionesQueLeFaltaronAlUsuarioTres');
let seccionesQueLeFaltaronAlUsuarioOracionTres = new Array();
let seccionesFaltantesUsuarioTres = [].map.call(missedsectionsusersentencethree, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesQueLeFaltaronAlUsuarioOracionTres.push(dataInput.textContent);
});
//console.log(seccionesQueLeFaltaronAlUsuarioOracionTres);



//ANALISIS ORACION CUATRO

//CAPTURAR LA RESPUESTA ORACION CUATRO DEL USUARIO
let oracionusuariocuatro = document.getElementById('oracionusuariocuatro');
//CAPTURAR LA RESPUESTA CORRECTA CUATRO 
let oracioncorrectacuatro = document.getElementById('oracioncorrectacuatro');

//CAPTURAR LAS SECCIONES DE LA ORACION DOS DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTADOS
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIODOS
let incorrectsectionsusersentencefour = document.getElementsByName('seccionesIncorrectasOracionUsuarioCuatro');
let seccionesIncorrectasOracionUsuarioCuatro = new Array();
let seccionesIncorrectasUsuarioCuatro = [].map.call(incorrectsectionsusersentencefour, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasOracionUsuarioCuatro.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasOracionUsuarioCuatro);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIONUNO
let missedsectionsusersentencefour = document.getElementsByName('seccionesQueLeFaltaronAlUsuarioCuatro');
let seccionesQueLeFaltaronAlUsuarioOracionCuatro = new Array();
let seccionesFaltantesUsuarioCuatro = [].map.call(missedsectionsusersentencefour, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesQueLeFaltaronAlUsuarioOracionCuatro.push(dataInput.textContent);
});
//console.log(seccionesQueLeFaltaronAlUsuarioOracionCuatro);



//ANALISIS ORACION CINCO

//CAPTURAR LA RESPUESTA ORACION CINCO DEL USUARIO
let oracionusuariocinco = document.getElementById('oracionusuariocinco');
//CAPTURAR LA RESPUESTA CORRECTA CINCO 
let oracioncorrectacinco = document.getElementById('oracioncorrectacinco');

//CAPTURAR LAS SECCIONES DE LA ORACION DOS DEL USUARIO QUE NO SE ENCONTRARON EN LA ORACION CORRECTADOS
//ESTOS DATOS VIENEN EN UN ARRAY POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIODOS
let incorrectsectionsusersentencefive = document.getElementsByName('seccionesIncorrectasOracionUsuarioCinco');
let seccionesIncorrectasOracionUsuarioCinco = new Array();
let seccionesIncorrectasUsuarioCinco = [].map.call(incorrectsectionsusersentencefive, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesIncorrectasOracionUsuarioCinco.push(dataInput.textContent);
});
//console.log(seccionesIncorrectasOracionUsuarioCinco);

//CAPTURAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN LA ORACION UNO
//ESTOS DATOS VIENEN EN UN ARRAY, POR LO QUE SE DEBE ALMACENARLOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIONUNO
let missedsectionsusersentencefive = document.getElementsByName('seccionesQueLeFaltaronAlUsuarioCinco');
let seccionesQueLeFaltaronAlUsuarioOracionCinco = new Array();
let seccionesFaltantesUsuarioCinco = [].map.call(missedsectionsusersentencefive, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    seccionesQueLeFaltaronAlUsuarioOracionCinco.push(dataInput.textContent);
});
//console.log(seccionesQueLeFaltaronAlUsuarioOracionCinco);






//EN EL METODO WINDOW.ONLOAD SE VAN A AGREGAR LAS FUNCIONES PARA PINTER LAS PALABRAS TANTO LAS ORACIONES CORRECTAS COMO EN LAS RESPUESTAS DEL USUARIO
window.onload = function(){

    //METODOS ORACION UNO
    //METODO PARA PINTAR EN LA ORACION CORRECTA UNO, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
    pintar_seccionesnoencontradasoracionuno();
    //METODO PARA PINTAR EN LA ORACION UNO DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VEN CON LA RESPUESTA CORRECTA
    pintar_seccionesincorrectasoracionusuariouno();


    //METODOS ORACION DOS
    //METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO DOS
    pintar_seccionesnoencontradasoraciondos();
    //METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA DOS
    pintar_seccionesincorrectasoracionusuariodos();


    //METODOS ORACION TRES
    //METODO PARA PINTAR EN LA ORACION CORRECTA TRES, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO TRES
    pintar_seccionesnoencontradasoraciontres();
    //METODO PARA PINTAR EN LA ORACION TRES DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA TRES
    pintar_seccionesincorrectasoracionusuariotres();


    //METODOS ORACION CUATRO
    //METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO DOS
    pintar_seccionesnoencontradasoracioncuatro();
    //METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA DOS
    pintar_seccionesincorrectasoracionusuariocuatro();


    //METODOS ORACION CINCO
    //METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES DE AQUI QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO DOS
    pintar_seccionesnoencontradasoracioncinco();
    //METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO, LAS PALABRAS O SECCIONES QUE NO TIENEN QUE VER CON LA RESPUESTA CORRECTA DOS
    pintar_seccionesincorrectasoracionusuariocinco();
}


//METODOS ORACION UNO

//METODO PARA PINTAR EN LA ORACION CORRECTA UNO, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO
function pintar_seccionesnoencontradasoracionuno(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasoracioncorrectauno = oracioncorrectauno.innerHTML.split(" ");

    oracioncorrectauno.innerHTML = palabrasoracioncorrectauno.map((seccionuno) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesQueLeFaltaronAlUsuarioOracionUno.length; i++){

            if(seccionesQueLeFaltaronAlUsuarioOracionUno[i] === seccionuno){

                return `<span class="bg-green-500 font-bold">${seccionuno}</span>`;
            }
        }

        return seccionuno;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION UNO DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA UNO
function pintar_seccionesincorrectasoracionusuariouno(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasoracionusuariouno = oracionusuariouno.innerHTML.split(" ");

    oracionusuariouno.innerHTML = palabrasoracionusuariouno.map((seccionuno) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasOracionUsuarioUno.length; j++){

            if(seccionesIncorrectasOracionUsuarioUno[j] === seccionuno){

                return `<span class="bg-red-500 font-bold">${seccionuno}</span>`;
            }
        }

        return seccionuno;
    }).join(" ");
}





//METODOS ORACION DOS


//METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO UNO
function pintar_seccionesnoencontradasoraciondos(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasoracioncorrectados = oracioncorrectados.innerHTML.split(" ");

    oracioncorrectados.innerHTML = palabrasoracioncorrectados.map((secciondos) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesQueLeFaltaronAlUsuarioOracionDos.length; i++){

            if(seccionesQueLeFaltaronAlUsuarioOracionDos[i] === secciondos){

                return `<span class="bg-green-500 font-bold">${secciondos}</span>`;
            }
        }

        return secciondos;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA DOS
function pintar_seccionesincorrectasoracionusuariodos(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasoracionusuariodos = oracionusuariodos.innerHTML.split(" ");

    oracionusuariodos.innerHTML = palabrasoracionusuariodos.map((secciondos) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasOracionUsuarioDos.length; j++){

            if(seccionesIncorrectasOracionUsuarioDos[j] === secciondos){

                return `<span class="bg-red-500 font-bold">${secciondos}</span>`;
            }
        }

        return secciondos;
    }).join(" ");
}



//METODOS ORACION TRES

//METODO PARA PINTAR EN LA ORACION CORRECTA TRES, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO TRES
function pintar_seccionesnoencontradasoraciontres(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasoracioncorrectatres = oracioncorrectatres.innerHTML.split(" ");

    oracioncorrectatres.innerHTML = palabrasoracioncorrectatres.map((secciontres) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesQueLeFaltaronAlUsuarioOracionTres.length; i++){

            if(seccionesQueLeFaltaronAlUsuarioOracionTres[i] === secciontres){

                return `<span class="bg-green-500 font-bold">${secciontres}</span>`;
            }
        }

        return secciontres;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION TRES DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA TRES
function pintar_seccionesincorrectasoracionusuariotres(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasoracionusuariotres = oracionusuariotres.innerHTML.split(" ");

    oracionusuariotres.innerHTML = palabrasoracionusuariotres.map((secciontres) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasOracionUsuarioTres.length; j++){

            if(seccionesIncorrectasOracionUsuarioTres[j] === secciontres){

                return `<span class="bg-red-500 font-bold">${secciontres}</span>`;
            }
        }

        return secciontres;
    }).join(" ");
}


//METODOS ORACION CUATRO

//METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO UNO
function pintar_seccionesnoencontradasoracioncuatro(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasoracioncorrectacuatro = oracioncorrectacuatro.innerHTML.split(" ");

    oracioncorrectacuatro.innerHTML = palabrasoracioncorrectacuatro.map((seccioncuatro) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesQueLeFaltaronAlUsuarioOracionCuatro.length; i++){

            if(seccionesQueLeFaltaronAlUsuarioOracionCuatro[i] === seccioncuatro){

                return `<span class="bg-green-500 font-bold">${seccioncuatro}</span>`;
            }
        }

        return seccioncuatro;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA DOS
function pintar_seccionesincorrectasoracionusuariocuatro(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasoracionusuariocuatro = oracionusuariocuatro.innerHTML.split(" ");

    oracionusuariocuatro.innerHTML = palabrasoracionusuariocuatro.map((seccioncuatro) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasOracionUsuarioCuatro.length; j++){

            if(seccionesIncorrectasOracionUsuarioCuatro[j] === seccioncuatro){

                return `<span class="bg-red-500 font-bold">${seccioncuatro}</span>`;
            }
        }

        return seccioncuatro;
    }).join(" ");
}




//METODOS ORACION CINCO


//METODO PARA PINTAR EN LA ORACION CORRECTA DOS, LAS SECCIONES QUE NO SE ENCONTRARON EN LA RESPUESTA DEL USUARIO UNO
function pintar_seccionesnoencontradasoracioncinco(){
     
    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION CORRECTA UNO
    let palabrasoracioncorrectacinco = oracioncorrectacinco.innerHTML.split(" ");

    oracioncorrectacinco.innerHTML = palabrasoracioncorrectacinco.map((seccioncinco) =>{

        //CON UN FOR SE RECORRE TODAS LAS SECCIONES QUE TENEMOS EN EL ARRAY SECCIONESQUELEFALTARONALUSUARIOORACIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION CORRECTA DE NUEVO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let i=0; i<seccionesQueLeFaltaronAlUsuarioOracionCinco.length; i++){

            if(seccionesQueLeFaltaronAlUsuarioOracionCinco[i] === seccioncinco){

                return `<span class="bg-green-500 font-bold">${seccioncinco}</span>`;
            }
        }

        return seccioncinco;
    }).join(" ");
}


//METODO PARA PINTAR EN LA ORACION DOS DEL USUARIO LAS PALABRAS O SECCIONES QUE SON INCORRECTAS Y QUE NO COINCIDEN CON LA ORACION CORRECTA DOS
function pintar_seccionesincorrectasoracionusuariocinco(){

    //CREAR VARIABLE QUE VA A DIVIDIR POR ESPACIOS LA ORACION DEL USUARIO UNO
    let palabrasoracionusuariocinco = oracionusuariocinco.innerHTML.split(" ");

    oracionusuariocinco.innerHTML = palabrasoracionusuariocinco.map((seccioncinco) =>{

        //CON UN FOR SE RECORRE TODAS LAS PALABRAS QUE TENEMOS EN EL ARRAY SECCIONESINCORRECTASORACIONUSUARIOUNO
        //Y SI LA SECCION EN LA POSICION I COINCIDE CON EL ELEMENTO QUE SE ESTA REVISANDO CON EL MAP, ENTONCES PINTAMOS LA PALABRA
        //Y SI NO COINCIDE SOLO RETORNAMOS EL ELEMENTO ACTUAL Y AL FINAL UNIMOS TODA LA ORACION DEL USUARIO CON EL JOIN Y LO ENVIAMOS A LA VISTA
        for(let j=0; j<seccionesIncorrectasOracionUsuarioCinco.length; j++){

            if(seccionesIncorrectasOracionUsuarioCinco[j] === seccioncinco){

                return `<span class="bg-red-500 font-bold">${seccioncinco}</span>`;
            }
        }

        return seccioncinco;
    }).join(" ");
}