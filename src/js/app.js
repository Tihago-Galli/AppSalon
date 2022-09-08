let paso = 1;
const pasoAnterior= 1;
const pasoSiguiente = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []

}

document.addEventListener('DOMContentLoaded', function(){

    iniciarApp();
})


function iniciarApp(){  
    mostrarSeccion(); //muestra y oculta las secciones
    tabs(); //cambiar las seccion segun se presione el tab 
    botonesPaginador(); //agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();
    consutarAPI();

    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();
}

function mostrarSeccion(){
    //ocultar la seccion
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    //muestra la seccion seleccionada
    const pasoSelect = `#paso-${paso}`; 
    const seccion = document.querySelector(pasoSelect);

    seccion.classList.add('mostrar')

    //ocultar tabs 
    const tabAnterior = document.querySelector('.actual');

    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    const tab = document.querySelector(`[data-paso="${paso}"]`);

    tab.classList.add('actual')

}
function tabs(){

    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton =>{
        boton.addEventListener('click', (e)=>{
        paso = parseInt(e.target.dataset.paso)

        mostrarSeccion();
        botonesPaginador();
        })
    })
}

function botonesPaginador(){
    
    const paginaAnterior= document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){

    const paginaAnterior = document.querySelector('#anterior');

    paginaAnterior.addEventListener('click', ()=>{

        if(paso <= pasoAnterior) return;
            paso--;
            botonesPaginador();
    });

    
}


function paginaSiguiente(){

    const paginaSiguiente = document.querySelector('#siguiente');

    paginaSiguiente.addEventListener('click', ()=>{

        if(paso >= pasoSiguiente) return;
            paso++;
            botonesPaginador();
    });
    
}

async function consutarAPI(){
    try{
        const url = 'http://localhost:3000/api/servicios' //leemos la url de donde traemos todos los resultados de la db
        const resultado = await fetch(url);//funcion que nos va a permitir consumir nuestra api
        const servicios = await resultado.json(); //transfoma el arreglo asociativo en json, js no trabaja con arry asoc
       mostrarServicios(servicios);
    } catch(error){
        console.log(error);
    }
}

function mostrarServicios(servicios){

    servicios.forEach(servicio =>{
        const {id, nombre , precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent= nombre;
        
      
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent= `$${precio}`;
        

        const ServicioDiv = document.createElement('DIV');
        ServicioDiv.classList.add('servicios');
        ServicioDiv.dataset.idServicio = id;

        ServicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        }

        ServicioDiv.appendChild(nombreServicio);
        ServicioDiv.appendChild(precioServicio);

       

        document.querySelector('#servicios').appendChild(ServicioDiv);



    })
}

function seleccionarServicio(servicio){
    const {id} = servicio
    //extraemos los servicios de cita
    const { servicios} = cita;

    //identificamos el objeto al que le dimos click
    const servicioDiv = document.querySelector(`[data-id-servicio="${id}"]`);

    //verificamos si tenemos el objeto en memoria con el metodo some
    if(servicios.some(agregado => agregado.id === id)){

        //Eliminar la seleccion del objeto
        //este metodo permite eliminar un objeto basado en cierta condicion
        cita.servicios = servicios.filter(agregado => agregado.id !== id)
        servicioDiv.classList.remove('seleccionado');

    }else{
        cita.servicios = [...servicios, servicio];
        servicioDiv.classList.add('seleccionado');
    }
    //tomamos una copia de los servicios y le agregamos el nuevo servicio
    //la sintaxis de "..." toma una copia de lo que esta en memoria
   
}

function idCliente(){
    cita.id = document.querySelector('#id').value;

}
function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;

}

function seleccionarFecha(){
    const fecha = document.querySelector('#fecha');

    fecha.addEventListener('input', (e)=>{

        //seleccionamos el numero del dia, para saber si es sabado o domingo
        const dia = new Date(e.target.value).getUTCDay();

        //controlamos de que el usuario seleccione un dia no laboral
       if([6,0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Los fines de semana no trabajamos', 'error', '.formulario');
       }else{
        cita.fecha = e.target.value;
   
       }
    })

}

function seleccionarHora(){
    const horaFecha = document.querySelector('#hora');

    horaFecha.addEventListener('input', (e)=>{
      const horaCita = e.target.value;
      //separamos el string a travez de los ':' y seleccionamos el primer lugar del array
        const hora = horaCita.split(':')[0];

        if(hora < 10 || hora > 18){
            e.target.value = ' ';
            mostrarAlerta('El salon se encuentra cerrado en ese horario', 'error', '.formulario');
        }else{
            cita.hora = e.target.value;
        }
      
    })

    
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenedor-resumen');

    //Limpiar el contenido del resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios === 0){
        mostrarAlerta("Faltan completar campos para reservar una cita", "error", ".contenedor-resumen", false);
        return;
    }

   

    const {nombre, fecha, hora, servicios} = cita;

            
        //Heading para los servicios
        const headingServicios = document.createElement('H3');
        headingServicios.textContent = "Resumen de los servicios solicitados"
        resumen.appendChild(headingServicios);


            servicios.forEach(servicio =>{
                const {precio, nombre} = servicio;
    
                const contenedorServicio = document.createElement('DIV');
                contenedorServicio.classList.add('contenedor-servicio')
    
                const textoServicio = document.createElement('P');
                textoServicio.textContent = nombre;
    
                const precioServicio = document.createElement('P');
                precioServicio.innerHTML = `<span>Precio: </span>$${precio}`;
    
                contenedorServicio.appendChild(textoServicio);
                contenedorServicio.appendChild(precioServicio);
                resumen.appendChild(contenedorServicio);
        })

        //Heading para la citas
        const headingCita = document.createElement('H3');
        headingCita.textContent = "Resumen de la Cita"
        resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span>${nombre}`;

    //Formatear Fecha
    const fechaObj = new Date(fecha);

    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() +2;
    const year = fechaObj.getFullYear();
    
    //mustra la fecha mas legible
    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    //especificando el formato de la fecha
    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day:'numeric'}
        
    //modificando el idioma en que se va a mostrar la fecha
    const fechaFormateada = fechaUTC.toLocaleDateString('es-AR', opciones);


    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span>${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span>${hora} horas`;

    const botonReservarCita = document.createElement('BUTTON');
    botonReservarCita.classList.add('boton');
    botonReservarCita.textContent = "Reservar Cita";

    botonReservarCita.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
     resumen.appendChild(botonReservarCita);

}

 async function reservarCita(){

    const { nombre, fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map( servicio => servicio.id );
    // console.log(idServicios);

    const datos = new FormData();
    
    datos.append('fecha', fecha);
    datos.append('hora', hora );
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);
 
    //console.log(...datos); con los 3 puntos podemos verlo formateado en array y ver que contiene

try {
    const url = "http://localhost:3000/api/citas";

    const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
    })

    const resultado = await respuesta.json();

    console.log(resultado);

    if(resultado.resultado){
        Swal.fire({
            icon: 'success',
            title: 'Cita creada',
            text: 'La cita fue reservada exitosamente',
            button: 'OK'
          }).then(()=>{
            window.location.reload();
          });
    }
} catch (error) {
    Swal.fire({
        icon: 'error',
        title: 'Cita no creada',
        text: 'Hubo un problema a la hora de cargar la cita'
       
      })
}
    
    //peticion hacia la Api
    

}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true){
    const alertaPrevia = document.querySelector('.alerta');
    //Evitamos de que se generen muchas alertas
    if(alertaPrevia){
alertaPrevia.remove();
    } 

    //script para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    //eliminamos la alerta 
    if (desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
    

}

