<div class="row">
    <div class="col-12">
      <nav class="navbar navbar-expand-lg navbar-light border-bottom border-2" style="border-bottom-color: #CCC !important;background-color: rgb(248, 248, 248);">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="{{ url('/') }}/inc/file/img/logo.png" alt="" width="47" height="24" class="d-inline-block align-text-top">                
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Configurações
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a data-page="type" class="dropdown-item" href="{{ route('adm.type') }}">Tipo de Eleição</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.form') }}">Forma de Eleição</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.rule') }}">Regras de Eleição</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.company') }}">Dados Associação</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.communication') }}">Comunicação</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.mailing') }}">Mailing</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.uploads') }}">Uploads</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Usuários
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="{{ route('adm.user') }}">Cadastrar Usuário</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.users') }}">Editar/Excluir Usuário</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Categorias
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="{{ route('adm.category') }}">Cadastrar Categoria</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.categories') }}">Editar/Excluir Categoria</a></li>
                </ul>
              </li> 
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Localidades
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="{{ route('adm.location') }}">Cadastrar Localidade</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.locations') }}">Editar/Excluir Localidade</a></li>
                </ul>
              </li> 
              <li class="nav-item">
                <a class="nav-link" href="{{ route('adm.election') }}">Eleição</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Eleitores
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="{{ route('adm.voter') }}">Cadastrar Eleitor</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.voters') }}">Editar/Excluir Eleitor</a></li>
                  <li><a class="dropdown-item" href="#">Importar Eleitor</a></li>
                </ul>
              </li>   
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Cédulas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="#">Cadastrar Cédula</a></li>
                  <li><a class="dropdown-item" href="#">Editar/Excluir Cédula</a></li>
                </ul>
              </li>    
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Candidatos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="#">Cadastrar Candidato</a></li>
                  <li><a class="dropdown-item" href="#">Editar/Excluir Candidato</a></li>
                </ul>
              </li> 
              <li class="nav-item">
                <a class="nav-link" href="#">Apuração</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Relatório</a>
              </li>                
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>  