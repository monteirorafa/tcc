<?php

class cartao
{
    private $id;
    private $idUsuario;
    private $numero;
    private $vencimento;
    private $cvv;

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

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getVencimento()
    {
        return $this->vencimento;
    }

    public function setVencimento($vencimento): self
    {
        $this->vencimento = $vencimento;

        return $this;
    }

    public function getCvv()
    {
        return $this->cvv;
    }

    public function setCvv($cvv): self
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function __toString()
    {
        return "ID: " . $this->id .
            " ID Usuário: " . $this->idUsuario .
            " Número: " . $this->numero .
            " Vencimento: " . $this->vencimento .
            " CVV: " . $this->cvv .
            "<br><br>";
    }
}