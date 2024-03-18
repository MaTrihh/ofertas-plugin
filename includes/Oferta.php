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

    // Métodos Setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setIdAsociado($idAsociado) {
        $this->idAsociado = $idAsociado;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setUnidades($unidades) {
        $this->unidades = $unidades;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    // Métodos Getter
    public function getId() {
        return $this->id;
    }

    public function getIdAsociado() {
        return $this->idAsociado;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getUnidades() {
        return $this->unidades;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }
}
