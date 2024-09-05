<?php

class usuario
{
    private $id;
    private $cpf;
    private $nome;
    private $email;
    private $cidade;
    private $endereco;
    private $numero;
    private $estado;
    private $cep;
    private $telefone;
    private $senha;
    private $adm;
    private $sessaoID;

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

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf): self
    {
        $this->cpf = $cpf;

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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco): self
    {
        $this->endereco = $endereco;

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

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep): self
    {
        $this->cep = $cep;

        return $this;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone): self
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getAdm()
    {
        return $this->adm;
    }

    public function setAdm($adm): self
    {
        $this->adm = $adm;

        return $this;
    }

    public function getSessaoID()
    {
        return $this->sessaoID;
    }

    public function setSessaoID($sessaoID): self
    {
        $this->sessaoID = $sessaoID;

        return $this;
    }

    public function __toString()
    {
        return "ID: " . $this->id .
            " CPF: " . $this->cpf .
            " Nome: " . $this->nome .
            " E-mail: " . $this->email .
            " Cidade: " . $this->cidade .
            " Endereco: " . $this->endereco .
            " Número: " . $this->numero .
            " Estado: " . $this->estado .
            " CEP: " . $this->cep .
            " Telefone: " . $this->telefone .
            " Senha: " . $this->senha .
            " Adm: " . $this->adm .
            " Sessao ID: " . $this->sessaoID .
            "<br><br>";
    }
}