<?php

class Pagina {

    private $controle;
    private $atributosProjeto;

    public function __construct() {
        $this->controle = new Controle();
        $this->$atributosProjeto = ["nome", "generos", "autor", "fonte", "sinopse"];
    }

    /**
     * TODO Auto-generated comment.
     */
    public function projeto() {
        if (isset($_COOKIE["uaiid"])) {
          $tipoPagina = $this->controle->usuario->getTipoUsuario($_COOKIE["uaiid"]);
        } else {
          $tipoPagina = "anonimo";
        }
        $tipoPagina = ucfirst($tipoPagina);

        $pagina = new Template(__DIR__ . "/html/projeto/index.html");

        // Navegação
        $pagina->set("navegacao", $this->navegacao($tipoPagina));

        // projetos
        $projetos = $this->controle->projeto->getProjetos();
        if (count($projetos) == 0) {
          $semProjetos = new Template(__DIR__ . "/html/projeto/semProjetos.html");
          $pagina->set("projetos", $semProjetos->output());
        } else {
          $projetosHTML = "";
          foreach ($projetos as $projeto) {
            $projetoTemplate = new Template(__DIR__ . "/html/projeto/projeto$tipoPagina.html");
            foreach ($projeto as $key => $value)
              $projetoTemplate->set($key, $value);
            $projetosHTML .= $projetoTemplate->output();
          }
          $pagina->set("projetos", $projetosHTML);
        }

        return $pagina->output();
    }

    /***
     * Retorna a página de login e caso o usuário mande um POST é feito o login e retornado a pagina inicial
     */
    public function login() {
        $pagina = new Template(__DIR__ . "/html/login/login.html");

        //Caso exista post
        if (isset($_POST["email"]) && $_POST["senha"]) {
            $estaLogado = $this->controle->usuario->realizarLogin($_POST["email"], $_POST["senha"]);
            //Login realizado
            if ($estaLogado) {
                $tipo = $this->controle->usuario->getTipoUsuario($_COOKIE["uaiid"]);
                return $this->projeto($tipo);
            } else {
            // Login errado
                $pagina->set("erro", "block");
                $pagina->set("email", $_POST["email"]);
                $pagina->set("senha", $_POST["senha"]);
            }
        } else {
        //Caso não exista
            $pagina->set("erro", "none");
            $pagina->set("email", "");
            $pagina->set("senha", "");
        }

        return $pagina->output();
    }

    /***
     * Retorna a página de cadastrar-se ou cadastra um novo financiador verificando se existe POST ou não
     */
    public function cadastrarSe() {
        //Caso exista post (usuário clicou no botão de cadastrar-se)
        if (isset($_POST["nome"]) && isset($_POST["cpf"]) && isset($_POST["email"]) && isset($_POST["senha"])) {
            $pagina = new Template(__DIR__ . "/html/login/cadastrarSe.html");
            if ($this->controle->usuario->novoFinanciador($_POST["nome"], $_POST["cpf"], $_POST["email"], $_POST["senha"])) {
                echo "novo usuario feito";
            } else {
                $pagina = new Template(__DIR__ . "/html/login/cadastrarSe.html");
                foreach ($_POST as $key => $value) {
                    $pagina->set($key, $value);
                }
                $pagina->set("erroMsg", "Cpf ou email j&aacute; existentes");
            }
        } else {
        //Caso tenha acabado de clicar na página de cadastrar-se
            $pagina = new Template(__DIR__ . "/html/login/cadastrarSe.html");
            $pagina->set("nome", "");
            $pagina->set("email", "");
            $pagina->set("senha", "");
            $pagina->set("cpf", "");
            $pagina->set("erroMsg", "");
        }
        return $pagina->output();
    }

    /**
     * TODO Auto-generated comment.
     */
    public function adicionarDinheiroCarteira() {
      $pagina = new Template(__DIR__ . "/html/carteira/index.html");
      if (isset($_POST["fundo"])) {
        $adicionado = $this->controle->usuario($_COOKIE["uaiid"], $_POST["fundo"]);
        if ($adicionado) {
          $_COOKIE["MSG"] = "Adicionado com sucesso";
          return $this->projeto();
        } else {
          $pagina->set("msg", "Não foi possível adicionar");
        }
      }
    }

    /**
     * TODO Auto-generated comment.
     */
    public function criarContas() {
    }

    /**
     * TODO Auto-generated comment.
     */
    public function criarProjeto() {

          $pagina = new Template(__DIR__ . "/html/projeto/criarProjeto.html");

          $pagina->set("navegacao", $this->navegacao());


          if (isSetPost($this->$atributosProjeto)) {
            $criou = $this->controle->criarProjeto();
            if ($criou) {
              $_COOKIE["MSG"] = "Inserido com sucesso o novo projeto";
              return $this->projeto();
            } else {
                foreach ($this->atributosProjeto as $atr) {
                  $pagina->set($atr, $_POST[$atr]);
                }
            }
          } else {
            foreach ($this->atributosProjeto as $atr) {
              $pagina->set($atr, "");
            }
          }
          return $pagina->output();
    }

    /**
     * TODO Auto-generated comment.
     */
    public function designarFuncionario() {
        return "";
    }

    public function editarProjeto() {
      if (!isSetPost($this->atributosProjeto)) {
        $projeto = $controle->projeto->getProjeto($_POST["id"]);
        foreach ($this->atributosProjeto as $key => $atr) {
          $get = "get" . upi($atr);
          $set = "set" . upi($atr);
          if ($projeto->$get == $_POST[$atr]) {
            $set = "set" . upi($atr);
            $projetos->$tmp(null);
          } else {
            $projetos->$tmp($_POST[$atr]);
          }
        }
        $projeto->setId($_POST["id"]);

        $editado = $this->controle->projeto->setProjeto($projeto);
        if ($editado) {
          $_COOKIE["MSG"] = "Editado com sucesso";
        } else {
          $_COOKIE["MSG"] = "Não foi possível editar!";
        }
        return $this->projeto();

      }
    }


    /***
    * Monta a navegação da pagina baseado no cookie uaiid
    */
    public function navegacao($tipo = null) {
        $navegacao = new Template(__DIR__ . "/html/navegacao/navegacao.html");

        //Acha o tipo da navegação
        if ($tipo == null) {
            if (isset($_COOKIE["uaiid"])) {
                $tipo = $this->controle->usuario->getTipoUsuario($_COOKIE["uaiid"]);
            } else {
                $tipo = "anonimo";
            }
        }

        //Monta a navegação
        if (strtolower($tipo) == "anonimo") {
          $navegacao->set("navegacaoEspecifica", Navegacao::navegacaoAnonimo());
        } else {
          $get = "get" . ucfirst($tipo);
          $navegacaoTipo = "navegacao" . ucfirst($tipo);
          $usuario = $this->controle->usuario->$get($_COOKIE["uaiid"]);
          $navegacao->set("navegacaoEspecifica", Navegacao::$navegacaoTipo($usuario));
        }


        return $navegacao->output();
    }


    /***
    * Retorna a página de edição de dados pessoais e realiza as mudanças dependendo se existe ou não POST
    */
    public function editarDadosPessoais() {
        if (isset($_COOKIE["uaiid"])) {
            $pagina = new Template(__DIR__ . "/html/telasComuns/perfil.html");
            if (isSetPost(["nome", "cpf", "email"]) || isset($_POST["senha"])) {
                $usuario = new Usuario($_COOKIE["uaiid"], $_POST["cpf"], $_POST["email"], $_POST["nome"], $_POST["senha"]);
                $this->controle->usuario->setUsuario($usuario);
            }

            $pagina->set("navegacao", $this->navegacao());
            $usuario = $this->controle->usuario->getUsuario($_COOKIE["uaiid"]);
            $pagina->set("cpf", $usuario->getCpf());
            $pagina->set("nome", $usuario->getNome());
            $pagina->set("email", $usuario->getEmail());
            $pagina->set("email", $usuario->getEmail());
            $pagina->set("titulo", "Editar dados pessoais");
        } else {
            return $this->login();
        }
        echo $pagina->output();
    }

    /***
    * Deleta uma conta e retorna a página inicial no modo anonimo
    */
    public function deletarConta() {
        $this->controle->usuario->deletarConta($_COOKIE["uaiid"]);
        return $this->projeto("anonimo");
    }

    /***
    * Desloga e retorna a página inicial no modo anonimo
    */
    public function deslogar() {
        $this->controle->usuario->deslogar();
        return $this->projeto();
    }

}
