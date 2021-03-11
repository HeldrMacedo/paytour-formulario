<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Currículo</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Fonte google -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="/js/arquivojs.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse" id="navbar">
                <a href="/" class="navbar-brand">
                    <img src="/img/Logo_PayTour.svg" alt="">
                </a>
            </div>
        </nav>
    </header>
    <div class="container-fluid">
        <div class="container">
            <div id="form-create-container" class="col-md-6 offset-md-3">
                @if($msg = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
                    {{$msg}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                
                <h1>Trabalhe Conosco</h1>
                <p>Cadastre seu currículo e participe das nossas seleções para ser um dos nossos colaboradores.</p>
                <form action="/enviar" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" placeholder="Nome Completo" >
                        @error('nome')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Endereço de email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" aria-describedby="emailHelp" placeholder="Seu email" >
                        <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
                        @error('email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telefone">Telefone</label>
                        <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" name="telefone" placeholder="Telefone" >
                        @error('telefone')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cargo">Cargo Desejado</label>
                        <input type="text" class="form-control @error('cargo') is-invalid @enderror" id="cargo" name="cargo" placeholder="Cargo Desejado" >
                        @error('cargo')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="escolaridade">Escolaridade</label>
                        <select class="form-control @error('escolaridade') is-invalid @enderror" name="escolaridade" placeholder="Escolaridade">                           
                            <option value="Ensino Fundamental Incompleto">Ensino Fundamental Incompleto</option>
                            <option value="Ensino Fundamental Cursando">Ensino Fundamental Cursando</option>
                            <option value="Ensino Fundamental Completo">Ensino Fundamental Completo</option>
                            <option value="Ensino Médio Incompleto">Ensino Médio Incompleto</option>
                            <option value="Ensino Médio Cursando">Ensino Médio Cursando</option>
                            <option value="Ensino Médio Completo">Ensino Médio Completo</option>
                            <option value="Ensino Técnico Cursando">Ensino Técnico Cursando</option>
                            <option value="Ensino Técnico Completo">Ensino Técnico Completo</option>
                            <option value="Ensino Superior Incompleto">Ensino Superior Incompleto</option>
                            <option value="Ensino Superior Cursando">Ensino Superior Cursando</option>
                            <option value="Ensino Superior Completo">Ensino Superior Completo</option>
                            <option value="Pós Graduação">Pós Graduação</option>
                            <option value="MBA">MBA</option>
                            <option value="Mestrado">Mestrado</option>
                            <option value="Doutorado">Doutorado</option>
                        </select>
                        @error('cargo')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="observacao">Observações</label>
                        <textarea class="form-control" id="obs" name="observacao" placeholder="Observações"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="file">Seu currículo</label>
                        <input type="file" class="form-control-file @error('arquivo') is-invalid @enderror" name="arquivo" data-max-size="1048576" id="arquivo">
                        @error('arquivo')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>                       
                        @enderror
                    </div>
                    <input type="submit" id="botao-enviar" class="btn btn-primary" value="Enviar">
                    
                </form>
            </div>
        </div>
    </div>

    @yield('content')
    <footer>
        <p>Helder Macedo &copy; <?=date('Y')?></p>
    </footer>
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</body>

</html>