<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>[@titulo]</title>
        <meta name="description" content="">
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="" /><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">UAI</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Projetos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-plus"></i>
                            Cadastrar nova conta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-file-alt"></i>
                            Cadastrar novo projeto
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-arrows-alt-h"></i>
                            Designar funcion&aacute;narios
                        </a>
                    </li>
                </ul>
                <div class="my-2 my-lg-0">
                    [nome_adm]<i class="fas fa-cog"></i>
                </div>
            </div>
        </nav>

        <div class="container">



            <h1 style="text-align: center;">Criando um novo projeto!</h1>
            <form style="border: lightgray solid 1px; padding: 3% 10% 3% 10%;">
                <div class="form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Nome do projeto</div>
                                </div>
                                <input type="text" class="form-control" placeholder="Digite o nome do projeto">
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">G&ecirc;neros</div>
                                </div>
                                <input type="text" class="form-control" placeholder="Digite os g&ecirc;neros do projeto!">
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Autor</div>
                                </div>
                                <input type="text" class="form-control" placeholder="Digite o nome do autor">
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Fonte original do projeto</div>
                                </div>
                                <input type="text" class="form-control" placeholder="Digite qual a fonte original do projeto">
                            </div>
                        </div>
                    </div>
                    <br />


                    <div class="row">
                        <div class="col-md">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Sinopse</div>
                                </div>
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <br />

                    <div class="row">
                        <div class="col-8"></div>
                        <button type="submit" class="btn btn-outline-success col-4">Criar esse projeto!</button>
                    </div>
                </div>
            </form>

        </div><!-- /.container -->
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>