import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');



document.addEventListener("turbo:load", () => {
    console.log(window.location.pathname);
    if((window.location.pathname ==='/viaje/new')||(/^\/viaje\/\d+\/edit$/.test(window.location.pathname))) {
        const elemNumKm = document.querySelector('#viaje_num_kilometros');
        const elemEspera = document.querySelector('#viaje_horas_espera');
        const elemTarifaEspera = document.querySelector('#viaje_id_tarifa_espera');
        const elemTarifaKm = document.querySelector('#viaje_id_tarifa_km');
        const tarifasEspera = JSON.parse(document.querySelector('#tarifas_espera').value);
        const tarifasKm = JSON.parse(document.querySelector('#tarifas_km').value);
        const elemTotal = document.querySelector('#total');

        function calcularTotal() {
            let horas=0;
            if(!isNaN(elemEspera.value)){
                console.log(elemEspera.value);
                horas=elemEspera.value;
            } else {
                console.log('hola');
                elemEspera.value='';
            }

                let numKm=0;
                if(isNaN(elemNumKm.value)){
                elemNumKm.value='';
                horas=0;
            } else if((elemNumKm.value.trim()!=="")&&(!isNaN(elemNumKm.value))){
                numKm=elemNumKm.value;
            }


            const precioKm=tarifasKm[elemTarifaKm.value];
            const precioHora=tarifasEspera[elemTarifaEspera.value];
            const total=numKm*precioKm+horas*precioHora;
            elemTotal.value=total;
            console.log("numKm="+numKm+" horas="+horas+" precioKm="+precioKm+" precioHora="+precioHora+" total="+total);
        }

        elemNumKm.addEventListener('input', calcularTotal);
        elemEspera.addEventListener('input', calcularTotal);
        elemTarifaEspera.addEventListener('change', calcularTotal);
        elemTarifaKm.addEventListener('change', calcularTotal);
    }
});
