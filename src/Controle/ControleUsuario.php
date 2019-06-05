<?php

/**
 * TODO Auto-generated comment.
 */
class ControleUsuario {

    public function realizarLogin($email, $senha) {
        $conexao = Transacao::get();
        $resultado = $conexao->query("select id from usuario where email = '$email' and senha = '$senha'");
        if (!$resultado->rowCount()) {
            return false;
        } else {
            ob_start();
            setcookie("uaiid", $resultado->fetchObject()->id);
            ob_end_flush();
            return true;
        }
    }

    private function isTipoUsuario($tipo, $id) {
        $conexao = Transacao::get();
        $resultado = $conexao->query("select idUsuario from $tipo where idUsuario = '$id'");
        if ($resultado->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTipoUsuario($id) {
        $tipos = array("financiador", "administrador", "funcionario");
        foreach ($tipos as $tipo) {
            if ($this->isTipoUsuario($tipo, $id)) {
                return $tipo;
            }
        }
        return null;
    }

    public function novoFinanciador($nome, $cpf, $email, $senha) {
        $conexao = Transacao::get();
        if (Transacao::exists("usuario", "cpf", $cpf) || Transacao::exists("usuario", "email", $email)) {
            return false;
        }
        $conexao->query("INSERT INTO `usuario`(`nome`, `cpf`, `email`, `senha`) VALUES ('$nome', '$cpf', '$email', '$senha')");
        $idUsuario = Transacao::ultimoIdInserido();
        $conexao->query("INSERT INTO `financiador`(`idUsuario`, `carteira`) VALUES ('$idUsuario', 0)");

        return $this->realizarLogin($email, $senha);
    }

    /**
     * TODO Auto-generated comment.
     */
    public function setUsuario($usuario) {
        $conexao = Transacao::get();
        
        //montando o where do select para verificação de email e cpf existentes
        $selectWhere = array();
        $selectWhere[] = " cpf = '" . $usuario->getCpf() . "'";
        $selectWhere[] = " email = '" . $usuario->getEmail() . "'";
        $update = $selectWhere;
        
        //Verifica se existe email ou cpf editados
        $selectWhere = implode(" or ", $update);
        $resultado = $conexao->query($sql = "select * from usuario where (id <> '" . $_COOKIE["uaiid"]. "') and ($selectWhere)");
        if ($resultado->rowCount()) {
            return false;
        }
        
        //update
        $update[] = " nome = '" . $usuario->getNome() . "'";
        $update[] = " cpf = '" . $usuario->getCpf() . "'";
        $update[] = " email = '" . $usuario->getEmail() . "'";
        if ($usuario->getSenha() != null) {
            $update[] = " senha = '" . $usuario->getSenha() . "'";
        }
        $conexao->query("UPDATE `usuario` SET " . implode(", ",$update) . " WHERE id = '" . $_COOKIE["uaiid"] . "'");
        
        return true;
    }

    /**
     * TODO Auto-generated comment.
     */
    public function getAdministrador($id) {
        return null;
    }

    /**
     * TODO Auto-generated comment.
     */
    public function getFinanciador($id) {
        $conexao = Transacao::get();
        $resposta = $conexao->query("select * from usuario inner join financiador on usuario.id = financiador.idUsuario where usuario.id = '$id'");
        $std = $resposta->fetchObject();
        if ($std == null) {
            return null;
        }
        return new Financiador($std->cpf, $std->email, $std->nome, $std->senha, $std->carteira, $std->id);
    }

    public function getUsuario($id) {
        $conexao = Transacao::get();
        $resposta = $conexao->query("select * from usuario where id = '$id'");
        $std = $resposta->fetchObject();
        if ($std == null) {
            return null;
        }
        return new Usuario($std->id, $std->cpf, $std->email, $std->nome, $std->senha);
    }

    /**
     * TODO Auto-generated comment.
     */
    public function getFuncionarios() {
        return null;
    }

}
