@extends('layout')

@section('navbar')
    <li class="nav-item">
        <a class="nav-link " href="/Dashboard">
            <i class="fa-solid fa-house-chimney"></i>
            Főoldal
            <span class="sr-only">(current)</span>
        </a>
    </li>


    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clock"></i>
            <span>
                Óra <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/ora">Listázás</a>
            <a class="dropdown-item" href="/ora/uj">Új</a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-pen-ruler"></i>
            <span>
                Tantárgy <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/targy">Listázás</a>
            <a class="dropdown-item" href="/targy/uj">Új</a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clock"></i>
            <span>
                Felhasználó <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/felhasznalok">Listázás</a>
            <a class="dropdown-item" href="/felhasznalok/uj">Új</a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-link"></i>
            <span>
                Diák-Szülő Kapcsolat <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/kapcsolat/szulo ">Listázás</a>
            <a class="dropdown-item" href="/kapcsolat/szulo/uj">Új</a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-link"></i>
            <span>
                Diák-Tanóra Kapcsolat <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/kapcsolat/ora ">Listázás</a>
            <a class="dropdown-item" href="/kapcsolat/ora/uj">Új</a>
        </div>
    </li>


    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i>
            <span>
                Beállítások <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/fiok">Fiók</a>
            <a class="dropdown-item" href="/logout">Kilépés</a>
        </div>
    </li>
@endsection

@section('content')
    <!-- row -->
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
        </div>
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">

                @if ($status == 0)
                    <h2 class="tm-block-title">Összes diák-szülő kapcsolat</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Szülő azonosító</th>
                                <th class="th-sm">Szülő név</th>
                                <th class="th-sm">Diák azonosító</th>
                                <th class="th-sm">Diák név</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($kapcsolatok as $item)
                                <tr>
                                    <td>{{ $item->szulo_azon }}</td>
                                    <td>{{ $item->szulo_vnev . ' ' . $item->szulo_knev }}</td>
                                    <td>{{ $item->diak_azon }}</td>
                                    <td>{{ $item->diak_vnev . ' ' . $item->diak_knev }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 1)
                    <h2 class="tm-block-title">Új diák-szülő kapcsolat</h2>
                    <div>
                        <form id="ujFelh" action="/kapcsolat/szulo/ujkapcs" method="post">
                            @csrf

                            <label for="diak">Diák: </label>
                            <select id="diak" name="diak">
                                @foreach ($diakok as $diak)
                                    <option value="{{ $diak->azonosito }}">
                                        {{ $diak->azonosito . '  //  ' . $diak->vnev . ' ' . $diak->knev }}</option>
                                @endforeach
                            </select>
                            <label for="szulo">Szülő: </label>
                            <select id="szulo" name="szulo">
                                @foreach ($szulok as $szulo)
                                    <option value="{{ $szulo->azonosito }}">
                                        {{ $szulo->azonosito . '  //  ' . $szulo->vnev . ' ' . $szulo->knev }}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="Mentés" class=" btn-success">
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
@endsection
