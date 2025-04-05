<?php

namespace App\Utils;

class Globales{
    static $globales = null;

    public static function getGlobales(){
        if(self::$globales !== null){
            return self::$globales;
        } else {
            self::cargarGlobales();
            return self::$globales;
        }
    }

    private static function cargarGlobales(){
        self::$globales = [
            'etiqueta_nombre'=> 'Nombre',
            'etiqueta_apellido1'=> 'Apellido 1',
            'etiqueta_apellido2'=> 'Apellido 2',
            'etiqueta_fecha'=> 'Fecha',
            'etiqueta_fecha_alta'=> 'Fecha de alta',
            'etiqueta_fecha_baja'=> 'Fecha de baja',
            'etiqueta_acciones'=> 'Acciones',
            'etiqueta_email'=> 'Email',
            'etiqueta_telefono1'=> 'Teléfono',
            'etiqueta_telefono2'=> 'Teléfono secundario',
            'etiqueta_dni'=> 'DNI',
            'etiqueta_es_socio'=> 'Es socio',
            'etiqueta_codigo_paciente'=> 'Código',
            'etiqueta_nombre_completo_conductor'=> 'Conductor',
            'etiqueta_nif_conductor'=> 'NIF',
            'etiqueta_nombre_completo_paciente'=> 'Paciente',
            'etiqueta_nombre_localidad'=> 'Nombre de la localidad',
            'etiqueta_login'=> 'Login',
            'etiqueta_password'=> 'Password',
            'etiqueta_rol_usuario'=> 'Rol de usuario',
            'etiqueta_es_admin'=> 'Es administrador',
            'etiqueta_es_ida_y_vuelta'=> 'Es ida y vuelta',
            'etiqueta_valoracion_viaje'=> 'Valoración',
            'etiqueta_comentarios_viaje'=> 'Comentarios',
            'etiqueta_kilometros'=> 'Kilómetros',
            'etiqueta_importe_kilometros'=> 'Importe distancia',
            'etiqueta_espera'=> 'Espera',
            'etiqueta_importe_espera'=> 'Importe espera',
            'etiqueta_importe_total'=> 'Total'

        ];
    }
}