//CAPTURAR EL ARRAY DE LAS PALABRAS SECCIONES QUE LE FALTARON AL USUARIO
let sections = document.getElementsByName('seccion');
const secciones = new Array();
let seccionQueFaltaron = [].map.call(sections, function(dataInput){
    //COMO SE ESTA CAPTURANDO EL CONTENIDO DE UNA ETIQUETA DIFERENTE A INPUT, SE CAPTURA EL TEXTO CON TEXTCONTENT
    secciones.push(dataInput.textContent);
});
console.log(secciones[0]);


//CODIGO PARA RESALTAR LAS SECCIONES QUE LE FALTARON AL USUARIO EN EL TEXTO DE RESPUESTA DEL USUARIO
//document.designMode = "on";
//let seleccion = window.getSelection();
//seleccion.collapse(document.getElementById("textousuario"), 0);

//while(window.find(secciones[0])){
//    while(window.find("la")){
//    document.execCommand("HiliteColor", false, "lightgreen");
//    seleccion.collapseToEnd();
//}
//document.designMode = "off";


let textoUsuario = document.getElementById('textocorrecto').textContent;
console.log(textoUsuario);

//let re = new RegExp(secciones[0], 'g');
//let re = new RegExp("inmensa", 'g');

//let resultado = textoUsuario.replace(re, '<span class="text-green-500 font-bold">$&</span>');

//document.getElementById('textocorrecto').innerHTML = resultado;


////////////////

//let resultado = textoUsuario.replace(secciones[0], '<span class="text-green-500 font-bold">' + secciones[0] + '</span>');
//let resultado = textoUsuario.replace("baño", '<span class="bg-orange-300 font-bold">' + "baño" + '</span>');
//document.getElementById('textocorrecto').innerHTML = resultado;


const a = document.getElementById('textocorrecto');
const words = a.innerHTML.split(" ");
//console.log(words);


    a.innerHTML = words.map((item)=>{
        //if(item === secciones[0]){
        //if(item === "inmensa."){
        //    return `<span class="bg-orange-300 font-bold">${item}</span>`;
        //}else{
        //    return item;
        //}

        
        for(let i=0; i<secciones.length; i++){
            if(secciones[i] === item){
                return `<span class="bg-orange-300 font-bold">${item}</span>`;
            }
            //else{
            //    return item;
            //}
        }

        return item;

    }).join(" ");




//console.log(typeof(secciones));
//console.log(words);


