<?php

include_once __DIR__ . '/../Conexao/Conexao.php';
include_once __DIR__ . '/../Controller/Usuario.php';

class UsuarioDAO
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function cadastro(Usuario $usuario)
    {
        $pstmt = $this->conexao->prepare("INSERT INTO usuario (cpf, nome, email, cidade, endereco, numero, estado, cep, telefone, senha, adm) 
                 VALUES (:cpf, :nome, :email, :cidade, :endereco, :numero, :estado, :cep, :telefone, :senha, :adm)");
        $pstmt->bindValue(":cpf", $usuario->getCpf());
        $pstmt->bindValue(":nome", $usuario->getNome());
        $pstmt->bindValue(":email", $usuario->getEmail());
        $pstmt->bindValue(":cidade", $usuario->getCidade());
        $pstmt->bindValue(":endereco", $usuario->getEndereco());
        $pstmt->bindValue(":numero", $usuario->getNumero());
        $pstmt->bindValue(":estado", $usuario->getEstado());
        $pstmt->bindValue(":cep", $usuario->getCep());
        $pstmt->bindValue(":telefone", $usuario->getTelefone());
        $pstmt->bindValue(":senha", $usuario->getSenha());
        $pstmt->bindValue(":adm", $usuario->getAdm());
        $pstmt->execute();
        if ($pstmt) {
            echo "<script> alert('Cadastrado com sucesso.');
            window.location.href = 'index.php';
            </script>";
        } else {
            echo "Erro " . $pstmt . "<br>" . $this->conexao->errorInfo();
        }
    }

    public function login()
    {
        $login = new Usuario($_POST);
        $pstmt = $this->conexao->prepare("SELECT id, email, senha, adm FROM usuario WHERE email = :email");
        $pstmt->bindValue(":email", $login->getEmail());
        $pstmt->execute();
        $linha = $pstmt->fetch();
        if ($linha != null) {
            if ($linha['senha'] == $login->getSenha()) {
                $login->atualizar($linha); // Atualiza os demais atributos...
                session_start();
                session_regenerate_id();
                $sessaoID = session_id();
                $pstmt = $this->conexao->prepare("UPDATE usuario SET sessaoID = :sessaoID WHERE id = :id");
                $pstmt->bindValue(":sessaoID", $sessaoID);
                $pstmt->bindValue(":id", $login->getId());
                $pstmt->execute();
                $_SESSION['id'] = $linha['id'];
                $_SESSION['sessaoID'] = $sessaoID;
                $_SESSION['adm'] = $linha['adm'];
                echo "DEU CERTO:";
                header('location:../index.php');
            } else {
                header('location:../login.php?erro');
            }
        } else {
            header('location:../login.php?erro');
        }
    }

    public function logout()
    {
        session_id($_SESSION['sessaoID']);
        session_start();
        $_SESSION = array();
        session_destroy();
        header('location:../index.php');
    }

    public function checkLogin()
    {
        session_start();
        $pstmt = $this->conexao->prepare("SELECT sessaoID FROM usuario WHERE id = :id");
        $pstmt->bindValue(":id", $_SESSION['id']);
        $pstmt->execute();
        $linha = $pstmt->fetch();
        if ($linha != null) {
            if ($_SESSION['sessaoID'] != $linha['sessaoID']) {
                $data['saida'] = 'logout';
            } else {
                $data['saida'] = 'login';
            }
            echo json_encode($data);
        }
    }

    public function consultaEndereco()
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM usuario WHERE id = :id");
        $pstmt->bindValue(":id", $_SESSION['id']);
        $pstmt->execute();
        $usuario = $pstmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);
        return $usuario;
    }

    public function consultaUsuario($idUsuario)
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM usuario WHERE id = :id");
        $pstmt->bindValue(":id", $idUsuario);
        $pstmt->execute();
        $usuario = $pstmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);
        return $usuario;
    }

    public function consultaNome()
    {
        $pstmt = $this->conexao->prepare("SELECT nome FROM usuario WHERE id = :id");
        $pstmt->bindValue(":id", $_SESSION['id']);
        $pstmt->execute();
        $nome = $pstmt->fetchColumn();
        return (string) $nome;
    }

    public function selectUsuarios()
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM usuario WHERE adm = 0 ORDER BY nome");
        $pstmt->execute();
        $usuario = $pstmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);
        return $usuario;
    }

    public function atualizaCadastro(Usuario $usuario)
    {
        $pstmt = $this->conexao->prepare("UPDATE usuario SET nome=:nome, email=:email, cidade=:cidade, endereco=:endereco, numero=:numero, estado=:estado, cep=:cep, telefone=:telefone, senha=:senha WHERE cpf=:cpf");
        $pstmt->bindValue(":nome", $usuario->getNome());
        $pstmt->bindValue(":email", $usuario->getEmail());
        $pstmt->bindValue(":cidade", $usuario->getCidade());
        $pstmt->bindValue(":endereco", $usuario->getEndereco());
        $pstmt->bindValue(":numero", $usuario->getNumero());
        $pstmt->bindValue(":estado", $usuario->getEstado());
        $pstmt->bindValue(":cep", $usuario->getCep());
        $pstmt->bindValue(":telefone", $usuario->getTelefone());
        $pstmt->bindValue(":senha", $usuario->getSenha());
        $pstmt->bindValue(":cpf", $usuario->getCpf());
        if ($pstmt->execute()) {
            echo "<script> alert('Atualizado com sucesso.');
            window.location.href = 'perfil.php';
            </script>";
        } else {
            echo "Erro: " . $this->conexao->errorInfo();
        }
    }

    public function buscaUsuarios($termo)
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM usuario WHERE nome LIKE :termo OR cpf LIKE :termo OR email LIKE :termo OR cidade LIKE :termo ORDER BY nome, email, cpf, cidade");
        $termo = "%" . $termo . "%";
        $pstmt->bindParam(':termo', $termo, PDO::PARAM_STR);
        $pstmt->execute();
        $usuario = $pstmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);
        return $usuario;
    }

    public function buscaPorEmail($email)
    {
        $pstmt = $this->conexao->prepare("SELECT * FROM usuario WHERE email = ?");
        $pstmt->execute([$email]);
        $row = $pstmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Usuario($row);
        }
        return null;
    }

    public function atualizaSessao($user, $sessaoID)
    {
        $pstmt = $this->conexao->prepare("UPDATE usuario SET sessaoID = :sessaoID WHERE id = :id");
        $pstmt->bindValue(":id", $user);
        $pstmt->bindValue(":sessaoID", $sessaoID);
        $pstmt->execute();
    }

    function validarForcaSenha($senha)
    {
        return strlen($senha) >= 8 &&
            preg_match('/[A-Z]/', $senha) &&
            preg_match('/[a-z]/', $senha) &&
            preg_match('/[0-9]/', $senha) &&
            preg_match('/[\W]/', $senha);
    }
}
