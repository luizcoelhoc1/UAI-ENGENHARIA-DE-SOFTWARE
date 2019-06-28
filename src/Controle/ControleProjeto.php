<?php

/**
 * TODO Auto-generated comment.
 */
class ControleProjeto {

    /**
     * TODO Auto-generated comment.
     */
    public function doar($idProjeto, $idFinanciador, $quantidade) {
        $conexao = Transacao::get();

        $resultado = $conexao->query("select * from financiador where idUsuario=$idFinanciador");
        $financiador = $resultado->fetchObject();
        if ($financiador->carteira >= $quantidade) {
            $conexao->query("UPDATE projeto set fundo=fundo+$quantidade where id = $idProjeto");
            $conexao->query("UPDATE financiador set carteira=carteira-$quantidade where idUsuario = $idFinanciador");
            $historicoExiste = $conexao->query("select * from historicodoacao where idProjeto = $idProjeto and idFinanciador = $idFinanciador");
            if ((boolean) $historicoExiste->rowCount() == 1) {
                $conexao->query("UPDATE `historicodoacao` "
                        . "SET `quantia`=quantia+$quantidade "
                        . "WHERE idProjeto=$idProjeto and idFinanciador=$idFinanciador");
            } else {
                $conexao->query("INSERT INTO `historicodoacao`"
                        . "(`idProjeto`, `idFinanciador`, `quantia`)"
                        . " VALUES ('$idProjeto', '$idFinanciador', $quantidade)");
            }
        } else {
            throw new Exception("Dinheiro insuficiente");
        }

        return true;
    }

    /**
     * TODO Auto-generated comment.
     */
    public function designarFuncionario($idFuncionario, $idProjeto) {
        return false;
    }

    /**
     * TODO Auto-generated comment.
     */
    public function excluirProjeto($idProjeto) {
        $conexao = Transacao::get();
        $resultado = $conexao->query("SELECT * FROM `historicodoacao` where idProjeto = $idProjeto");
        $financiador = $resultado->fetchObject();
        while ($financiador != null) {
            $quantidade = $financiador->quantia;
            $idFinanciador = $financiador->idFinanciador;
            $conexao->query("UPDATE financiador set carteira=carteira+$quantidade where idUsuario = $idFinanciador");
            $financiador = $resultado->fetchObject();
        }
        $resultado = $conexao->query("DELETE FROM projeto WHERE id = $idProjeto");
        if ($resultado->rowCount()) {
            return true;
        }
        return false;
    }

    public function getHistoricos() {
        $conexao = Transacao::get();
        $resultado = $conexao->query("SELECT "
                . "projeto.nome as projeto, "
                . "usuario.nome as financiador, "
                . "historicodoacao.quantia "
                . " FROM `historicodoacao` "
                . "inner join projeto on projeto.id = historicodoacao.idProjeto "
                . "inner join usuario on usuario.id = historicodoacao.idFinanciador "
                . "");

        $historico = $resultado->fetchObject();
        $retorno = array();
        while ($historico != null) {
            $retorno[] = $historico;
            $historico = $resultado->fetchObject();
        }
        return $retorno;
    }

    /**
     * TODO Auto-generated comment.
     */
    public function getProjetos() {
        $conexao = Transacao::get();
        $resultado = $conexao->query("SELECT * FROM projeto ORDER BY `projeto`.`dataDeCriacao` DESC");
        $projetos = array();
        $projeto = $resultado->fetchObject();
        while ($projeto != null) {
            $projetos[] = $projeto;
            $projeto = $resultado->fetchObject();
        }
        return $projetos;
    }

    /**
     * TODO Auto-generated comment.
     */
    public function getProjeto($idProjeto) {
        $conexao = Transacao::get();
        $resultado = $conexao->query("SELECT * FROM projeto WHERE id = $idProjeto");
        $obj = $resultado->fetchObject();
        if ($obj == null) {
            return null;
        }

        $projeto = new Projeto();
        foreach ($obj as $atr => $valor) {
            $set = "set" . ucfirst($atr);
            $projeto->$set($valor);
        }
        return $projeto;
    }

    /**
     * TODO Auto-generated comment.
     */
    public function setProjeto($projeto) {
        $conexao = Transacao::get();
        $updateSet = array();

        $reflect = new ReflectionClass($projeto);
        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            $atr = $prop->getName();
            $get = "get" . ucfirst($prop->getName());
            $value = $projeto->$get();
            $updateSet[] = "$atr = '$value'";
        }

        $resultado = $conexao->query("UPDATE projeto SET " . implode(", ", $updateSet) . " WHERE id =' " . $projeto->getId() . "'");
        if ($resultado->rowCount()) {
            return true;
        }
        return false;
    }

    /**
     * TODO Auto-generated comment.
     */
    public function criarProjeto($projeto) {
        $conexao = Transacao::get();

        $nome = $projeto->getNome();
        $fonte = $projeto->getFonte();
        $autor = $projeto->getAutor();
        $sinopse = $projeto->getSinopse();
        $generos = $projeto->getGeneros();
        $fundo = $projeto->getFundo();
        $resultado = $conexao->query("INSERT INTO `projeto` "
                . "(`nome`, `fonte`, `autor`, `sinopse`, `generos`, `fundo`) "
                . "VALUES ('$nome', '$fonte', '$autor', '$sinopse', '$generos', '$fundo');");
        if ($resultado->rowCount()) {
            return true;
        }
        return false;
    }

}
