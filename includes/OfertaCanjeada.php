<?php
class OfertaCanjeada {
    public $id;
    public $user_id;
    public $oferta_id;
    public $canjeado;
    public $fecha_canjeado;

    // Constructor de la clase
    public function __construct($id, $user_id, $oferta_id, $canjeado, $fecha_canjeado) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->oferta_id = $oferta_id;
        $this->canjeado = $canjeado;
        $this->fecha_canjeado = $fecha_canjeado;
    }

    // Métodos Setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setOfertaId($oferta_id) {
        $this->oferta_id = $oferta_id;
    }

    public function setCanjeado($canjeado) {
        $this->canjeado = $canjeado;
    }

    public function setFechaCanjeado($fecha_canjeado) {
        $this->fecha_canjeado = $fecha_canjeado;
    }

    // Métodos Getter
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getOfertaId() {
        return $this->oferta_id;
    }

    public function getCanjeado() {
        return $this->canjeado;
    }

    public function getFechaCanjeado() {
        return $this->fecha_canjeado;
    }

    public static function ToArray($oferta_canjeada) {
        return array(
            'id' => $oferta_canjeada->id,
            'user_id' => $oferta_canjeada->user_id,
            'oferta_id' => $oferta_canjeada->oferta_id,
            'canjeado' => $oferta_canjeada->canjeado,
            'fecha_canjeado' => $oferta_canjeada->fecha_canjeado
        );
    }
}
