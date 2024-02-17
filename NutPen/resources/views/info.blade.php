@extends('layout')

@section('navbar')
    <li class="nav-item">
        <a class="nav-link" href="/vezerlopult">
            <i class="fa-solid fa-house-chimney"></i>
            Főoldal
            <span class="sr-only">(current)</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
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
    <div class="row">
        <div class="col">
            <br>
        </div>
    </div>
    <!-- row -->
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <div class="tm-bg-primary-dark tm-block">
                <p class="text-white mt-5 mb-5">Felhasználó típus: <b>{{ $user->Name }}</b></p>
                <p class="text-white mt-5 mb-5">Vezetéknév: <b>{{ $user->LName }}</b></p>
                <p class="text-white mt-5 mb-5">Keresztnév: <b>{{ $user->FName }}</b></p>
                <p class="text-white mt-5 mb-5">Azonsoító: <b>{{ $user->ID }}</b></p>
                <form action="/jelszoVisszaallitas" method="get">
                    <input type="submit" class="btn btn-danger" value="Jelszó módosítása">
                </form>
            </div>
        </div>
    </div>
@endsection
