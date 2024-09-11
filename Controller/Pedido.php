<?php

class pedido
{
    private $id;
    private $idCarrinho;
    private $idUsuario;
    private $criado;
    private $total;
    private $pagamento;
    private $entrega;
    private $situacao;

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

    public function getIdCarrinho()
    {
        return $this->idCarrinho;
    }

    public function setIdCarrinho($idCarrinho): self
    {
        $this->idCarrinho = $idCarrinho;

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

    public function getCriado()
    {
        return $this->criado;
    }

    public function setCriado($criado): self
    {
        $this->criado = $criado;

        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getPagamento()
    {
        return $this->pagamento;
    }

    public function setPagamento($pagamento): self
    {
        $this->pagamento = $pagamento;

        return $this;
    }

    public function getEntrega()
    {
        return $this->entrega;
    }

    public function setEntrega($entrega): self
    {
        $this->entrega = $entrega;

        return $this;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    public function setSituacao($situacao): self
    {
        $this->situacao = $situacao;

        return $this;
    }

    public function __toString()
    {
        return "ID: " . $this->id .
            " idCarrinho: " . $this->idCarrinho .
            " idUsuario: " . $this->idUsuario .
            " Criação: " . $this->criado .
            " Total: " . $this->total .
            " Pagamento: " . $this->pagamento .
            " Entrega: " . $this->entrega .
            " Situação: " . $this->situacao .
            "<br><br>";
    }
}
