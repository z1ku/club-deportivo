"use strict"

let lista=[];

const cargando=document.getElementById("cargando");
const tabla=document.querySelector("#contenedor_api");

//GESTIONAR LOS ENLACES
const pag_sig = document.getElementById("next");
const pag_ant = document.getElementById("prev");

pag_sig.addEventListener("click",cambiarPagina);

pag_ant.addEventListener("click",cambiarPagina);

function cambiarPagina(eventos){
  eventos.preventDefault();
  Inicio(eventos.target.href);
}

Inicio();

async function Inicio(url_api="noticiasLista.php") {

    cargando.style.display="block";
  
    //BUSCAMOS LOS DATOS DE LA PAGINA
    const respuesta=await fetch(url_api);
    const datos=await respuesta.json();
  
    lista=datos["datos"];
    console.log(datos);
  
    //Establecemos los enlaces si procede
    if(datos["siguiente"]!=="null"){
      pag_sig.setAttribute("href","http://"+datos["siguiente"]);
      pag_sig.style.display="inline";
    }else{
      pag_sig.setAttribute("href","");
      pag_sig.style.display="none";
    }
  
    if(datos["anterior"]!=="null"){
      pag_ant.setAttribute("href","http://"+datos["anterior"]);
      pag_ant.style.display="inline";
    }else{
      pag_ant.style.display="none";
      pag_ant.setAttribute("href","");
    }
  
    renderizar(lista,tabla,crearNoticia);
  
    cargando.style.display="none";
}

function renderizar(lista_noticias, contenedor_dom, crear_dom) {
    contenedor_dom.innerHTML="";
    lista_noticias.forEach(n=>{
        const noticia = crear_dom(n);
        contenedor_dom.appendChild(noticia);
    });
}

function crearNoticia(n){
    let contenido_short=n.contenido.substring(0,50);
    let fecha_formateada = new Date(n.fecha_publicacion);
    fecha_formateada=fecha_formateada.toLocaleDateString();

    const noticia = document.createElement("tr");
    noticia.innerHTML=`<td><img src="../img/noticias/${n.imagen}"></td>
    <td>${n.titulo}</td>
    <td>${contenido_short}</td>
    <td>${fecha_formateada}</td>
    <td>
        <form action="noticia_completa.php" method="post">
            <input type="hidden" name="id_noticia" value="${n.id}">
            <input type="submit" name="ver_noticia" value="Ver">
        </form>
    </td>`;

    return noticia;
}