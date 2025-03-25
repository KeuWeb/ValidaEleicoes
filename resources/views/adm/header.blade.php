<div class="row">
    <div class="col-12">
      <nav class="navbar navbar-expand-lg navbar-light border-bottom border-2" style="border-bottom-color: #CCC !important;background-color: rgb(248, 248, 248);">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="{{ url('/') . '/' . session('logo') }}" alt="" height="24" class="d-inline-block align-text-top">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav position-relative start-0">
                @if (session('id') == 1)
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
              @endif
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
                  <li><a class="dropdown-item" href="{{ route('adm.import.voters') }}">Importar Eleitores</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Cédulas
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="{{ route('adm.card') }}">Cadastrar Cédula</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.cards') }}">Editar/Excluir Cédula</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Candidatos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li id="cad-candidate" style="display: {{ session('type') > 2 && session('id') != 1 ? 'none' : 'table' }};"><a class="dropdown-item" href="{{ route('adm.candidate') }}">Cadastrar Candidato</a></li>
                  <li><a class="dropdown-item" href="{{ route('adm.candidates') }}">Editar/Excluir Candidato</a></li>
                </ul>
              </li>
              @if (session('level') == 1)
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Apuração
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @if(session('type') >= 3)
                    <li id="indicates"><a class="dropdown-item" href="{{ route('adm.couting.indicates') }}">Indicações</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('adm.couting.candidates') }}">Eleição</a></li>
                    <li><a class="dropdown-item" href="{{ route('adm.couting.voters') }}">Eleitores</a></li>
                </ul>
              </li>
              @endif
            </ul>
          </div>
          <div class="dropdown">
            <button
              type="button"
              class="btn btn-outline-secondary position-relative end-0 dropdown-toggle"
              style="font-size: 0.8em;"
              id="dropdownMenuButton"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"></path>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"></path>
              </svg>
              Perfil
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 88px;">
              <li><a class="dropdown-item" style="font-size: 0.8em;" href="/adm/logout">Sair</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
