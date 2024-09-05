<?php

class produto
{
    private $id;
    private $nome;
    private $categoria;
    private $valor;
    private $quantidade;
    private $descricao;
    private $imagem;
    private $criado;
    private $atualizado;

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

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria): self
    {
        $this->categoria = $categoria;

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

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setImagem($Imagem): self
    {
        $this->imagem = $Imagem;

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

    public function getAtualizado()
    {
        return $this->atualizado;
    }

    public function setAtualizado($atualizado): self
    {
        $this->atualizado = $atualizado;

        return $this;
    }

    public function __toString()
    {
        return "ID: " . $this->id .
            " Nome: " . $this->nome .
            " Categoria: " . $this->categoria .
            " Valor: " . $this->valor .
            " Quantidade: " . $this->quantidade .
            " Descrição: " . $this->descricao .
            " Imagem: " . $this->imagem .
            " Criado: " . $this->criado .
            " Atualizado: " . $this->atualizado .
            "<br><br>";
    }
}
