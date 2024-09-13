<?php

class Live
{
    private $id;
    private $idUsuario;
    private $idVideo;
    private $plataforma;
    private $live;

    public function __construct()
    {
        if (func_num_args() != 0) {
            $atributos = func_get_args()[0];
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor) && property_exists(get_class($this), $atributo)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }

    public function atualizar($atributos)
    {
        foreach ($atributos as $atributo => $valor) {
            if (isset($valor) && property_exists(get_class($this), $atributo)) {
                $this->$atributo = $valor;
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario): self
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    public function getIdVideo()
    {
        return $this->idVideo;
    }

    public function setIdVideo($idVideo): self
    {
        $this->idVideo = $idVideo;

        return $this;
    }

    public function getPlataforma()
    {
        return $this->plataforma;
    }

    public function setPlataforma($plataforma): self
    {
        $this->plataforma = $plataforma;

        return $this;
    }

    public function getLive()
    {
        return $this->live;
    }

    public function setLive($live): self
    {
        $this->live = $live;

        return $this;
    }

    public function __toString()
    {
        return "ID: " . $this->id .
            " ID Usuario: " . $this->idUsuario .
            " ID Video: " . $this->idVideo .
            " Plataforma: " . $this->plataforma .
            " Live: " . $this->live .
            "<br><br>";
    }
}
