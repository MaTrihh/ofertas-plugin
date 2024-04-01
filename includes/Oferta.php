<?php
class Oferta {
    public $id;
    public $idAsociado;
    public $titulo;
    public $descripcion;
    public $cantidad;
    public $precio_normal;
    public $precio_rebajado;
    public $foto;
    public $fecha_inicio;
    public $fecha_fin;
    public $trash;

    // Constructor de la clase
    public function __construct($id, $idAsociado, $titulo, $descripcion, $cantidad, $precio_normal, $precio_rebajado, $foto, $fecha_inicio, $fecha_fin, $trash) {
        $this->id = $id;
        $this->idAsociado = $idAsociado;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
        $this->precio_normal = $precio_normal;
        $this->precio_rebajado = $precio_rebajado;
        $this->foto = $foto;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->trash = $trash;
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

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setPrecioNormal($precio_normal) {
        $this->precio_normal = $precio_normal;
    }

    public function setPrecioRebajado($precio_rebajado) {
        $this->precio_rebajado = $precio_rebajado;
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

    public function setTrash($trash) {
        $this->trash = $trash;
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

    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function getPrecioNormal() {
        return $this->precio_normal;
    }

    public function getPrecioRebajado() {
        return $this->precio_rebajado;
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

    public function getTrash() {
        return $this->trash;
    }

    public static function ToArray($oferta) {
        return array(
            'id' => $oferta->id,
            'idAsociado' => $oferta->idAsociado,
            'titulo' => $oferta->titulo,
            'descripcion' => $oferta->descripcion,
            'cantidad' => $oferta->cantidad,
            'precio_normal' => $oferta->precio_normal,
            'precio_rebajado' => $oferta->precio_rebajado,
            'foto' => $oferta->foto,
            'fecha_inicio' => $oferta->fecha_inicio,
            'fecha_fin' => $oferta->fecha_fin,
            'trash' => $oferta->trash
        );
    }
}
