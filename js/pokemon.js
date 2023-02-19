"use strict"

const cargando=document.querySelector("#cargando");
const contenedor=document.querySelector("#contenedor_api");

let pagina_inicial="https://pokeapi.co/api/v2/pokemon?limit=6";

let num_ale;
let poke_ale;
let pokemon;

Iniciar(pagina_inicial);

async function Iniciar(pagina){
    contenedor.innerHTML="";
    cargando.style.display="block";
    let respuesta=await fetch(pagina);
    let datos=await respuesta.json();
    
    const total=datos["count"];
    respuesta=await fetch("https://pokeapi.co/api/v2/pokemon?limit="+total);
    datos=await respuesta.json();
    const lista_pokemon=datos["results"];

    do{
        num_ale=Math.floor(Math.random()*total);
        poke_ale=lista_pokemon[num_ale];
        console.log(poke_ale);

        respuesta=await fetch(poke_ale.url);
        pokemon=await respuesta.json();
        console.log(pokemon);
    }while(pokemon.sprites.other["official-artwork"].front_default==null);
    
    contenedor.appendChild(crearPokemon(pokemon));

    cargando.style.display="none";
}

function crearPokemon(p){
    const pokemon=document.createElement("div");
    pokemon.classList.add("pokemon");
    pokemon.innerHTML=`<img src="${p.sprites.other["official-artwork"].front_default}">
    <h2>${p.name}</h2>`;

    return pokemon;
}

// MODO NOCHE Y DIA
const pagina=document.querySelector("#pagina");
const sol=document.querySelector("#id-sun");
const luna=document.querySelector("#id-moon");

const modo=localStorage.getItem("modo");
if(modo==="dia" || modo===null){
    pagina.classList.remove('dark-mode');
    luna.classList.remove('active');
    sol.classList.add('active');
}else{
    pagina.classList.add('dark-mode');
    luna.classList.add('active');
    sol.classList.remove('active');
}

sol.addEventListener("click",()=>{
    pagina.classList.remove('dark-mode');
    luna.classList.remove('active');
    sol.classList.add('active');
    localStorage.setItem("modo","dia");
});

luna.addEventListener("click",()=>{
    pagina.classList.add('dark-mode');
    luna.classList.add('active');
    sol.classList.remove('active');
    localStorage.setItem("modo","noche");
});