<?php

/**
 * Se activa en la desactivación del plugin
 * esta clase define todo lo necesario durante la desactivación del plugin
 */

class LES_Deactivator
{

    /**
     * public static function deactivate(): Métododo estatico
     * flush_rewrite_rules(); Esta función es útil cuando se usa con tipos de publicaciones personalizadas, 
     * ya que permite el vaciado automático de las reglas de reescritura de WordPress (por lo general, 
     * debe hacerse manualmente para los nuevos tipos de publicaciones personalizadas). Sin embargo, esta es 
     * una operación costosa, por lo que solo debe usarse cuando sea necesario.
     * 
     * Método que se ejecuta al desactivar el plugin
     */
    public static function deactivate()
    {

        flush_rewrite_rules();
    }
}
