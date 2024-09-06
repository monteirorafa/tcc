<?php

class pedido
{
    private $id;
    private $idCarrinho;
    private $idUsuario;
    private $idProduto;
    private $numero;
    private $criacao;
    private $valor;
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

    public function getIdProduto()
    {
        return $this->idProduto;
    }

    public function setIdProduto($idProduto): self
    {
        $this->idProduto = $idProduto;

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

    public function getCriacao()
    {
        return $this->criacao;
    }

    public function setCriacao($criacao): self
    {
        $this->criacao = $criacao;

        return $this;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor): self
    {
        $this->valor = $valor;

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
            " idProduto: " . $this->idProduto .
            " Numero: " . $this->numero .
            " Criação: " . $this->criacao .
            " Valor: " . $this->valor .
            " Pagamento: " . $this->pagamento .
            " Entrega: " . $this->entrega .
            " Situação: " . $this->situacao .
            "<br><br>";
    }
}
