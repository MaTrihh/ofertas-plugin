<?php
class Oferta {
    public $id;
    public $idAsociado;
    public $titulo;
    public $descripcion;
    public $unidades;
    public $foto;
    public $fecha_inicio;
    public $fecha_fin;

    // Constructor de la clase
    public function __construct($id, $idAsociado, $titulo, $descripcion, $unidades, $foto, $fecha_inicio, $fecha_fin) {
        $this->id = $id;
        $this->idAsociado = $idAsociado;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->unidades = $unidades;
        $this->foto = $foto;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    // Método para obtener la duración de la oferta en días
    public function obtenerDuracionOferta() {
        $inicio = new DateTime($this->fecha_inicio);
        $fin = new DateTime($this->fecha_fin);
        $duracion = $inicio->diff($fin);
        return $duracion->days;
    }
}