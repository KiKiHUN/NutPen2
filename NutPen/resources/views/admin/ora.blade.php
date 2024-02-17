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
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
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
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
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
                    <h2 class="tm-block-title">Összes óra</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">ID</th>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Kezdet</th>
                                <th class="th-sm">Vég</th>
                                <th class="th-sm">Tanár, azonosíto</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($targyak as $item)
                                <tr>
                                    <td>{{ $item->ID }}</td>
                                    <td>{{ $item->nev }}</td>
                                    <td>{{ $item->kezdet }}</td>
                                    <td>{{ $item->veg }}</td>
                                    <td>{{ $item->vnev . ' ' . $item->knev . ', ' . $item->azonosito }}</b></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 1)
                    <h2 class="tm-block-title">Óra hozzáadás</h2>
                    <div>
                        <form id="ujOra" action="/ora/ujOra" method="post">
                            @csrf
                            <label for="kezdet">Kezdet: </label>
                            <input type="datetime-local" id="kezdet" name="kezdet" value=""
                                min="2000-06-07T00:00" max="2500-06-14T00:00" required>
                            <label for="veg">Veg: </label>
                            <input type="datetime-local" id="veg" name="veg" value=""
                                min="2000-06-07T00:00" max="2500-06-14T00:00" required>
                            <label for="tanarok">Tanár: </label>
                            <select id="tanarok" name="tanarok">
                                @foreach ($tanarok as $tanar)
                                    <option value="{{ $tanar->azonosito }}">
                                        {{ $tanar->azonosito . ' //// ' . $tanar->vnev . ' ' . $tanar->knev }}</option>
                                @endforeach
                            </select>
                            <select id="tantargyak" name="tantargyak">
                                @foreach ($tantargyak as $tantargy)
                                    <option value="{{ $tantargy->ID }}">{{ $tantargy->nev }}</option>
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
