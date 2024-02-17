@extends('layout')

@section('navbar')

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
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clock"></i>
            <span>
                Felhasználó <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/felhasznalok">Listázás</a>
            <a class="dropdown-item" href="/ujfelhasznalo">Új</a>
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


   
@endsection

@section('content')

    <!-- row -->
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                @if ($status!=1)
                    <button type="submit" class="filterbtn" value="a">Admin</button>
                    <button type="submit" class="filterbtn" value="t">Tanár</button>
                    <button type="submit" class="filterbtn" value="s">Diák</button>
                    <button type="submit" class="filterbtn" value="p">Szülő</button>
                    <button type="submit" class="filterbtn" value="h">Fő emberek</button>
                @endif
               
                @if ($status == 0)
                    <h2 class="tm-block-title">Felhasználók</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Vnév</th>
                                <th class="th-sm">Knév</th>
                                <th class="th-sm">Típus</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $item->USerID }}</td>
                                    <td>{{ $item->fname }}</td>
                                    <td>{{ $item->lname }}</td>
                                    <td>{{ $item->role }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 1)
                    <h2 class="tm-block-title">Új felhasználó</h2>
                    <div>
                        <form id="ujFelh" action="/felhasznalok/ujFelh" method="post">
                            @csrf
                            <label for="vnev">Vezetéknév: </label>
                            <input type="text" id="vnev" name="vnev" value="" required>
                            <label for="knev">Keresztnév: </label>
                            <input type="text" id="knev" name="knev" value="" required>
                            <label for="tipus">Típus: </label>
                            <select id="tipus" name="tipus">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->ID }}">{{ $role->Name }}</option>
                                @endforeach
                            </select>
                            <label for="knev">Jelszó: </label>
                            <input type="password" id="pw" name="pw" value="" required>
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
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
