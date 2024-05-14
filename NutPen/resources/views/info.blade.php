@extends('layout')

@section('navbar')
<link rel="stylesheet" href="/css/switch.css">
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
            <a class="dropdown-item" href="/kijelentkezes">Kilépés</a>
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
                
                <p class="text-white mt-5 mb-5" id="role" value="{{ $user->GetRole->Name  }}" >Felhasználó típus: <b>{{ $user->GetRole->Name  }}</b></p>
                <p class="text-white mt-5 mb-5">Vezetéknév: <b>{{ $user->LName }}</b></p>
                <p class="text-white mt-5 mb-5">Keresztnév: <b>{{ $user->FName }}</b></p>
                <p class="text-white mt-5 mb-5">Azonsoító: <b>{{ $user->UserID }}</b></p>
                <p class="text-white mt-5 mb-5">Születésnap: <b>{{ $user->BDay }}</b></p>
                <p class="text-white mt-5 mb-5">Üzenet engedélyezve:
                    <label id="allowswitch" class="switch">
                        <input id="allowmsg" type="checkbox"  {{ $user->AllowMessages ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
               </p>
                
                <br>
                <div id="additional-attributes" data-attributes="{{ $aditionals }}"></div>
                <p class="text-white mt-5 mb-5">Email: <b>{{ $user->Email }}</b></p>
                <p class="text-white mt-5 mb-5">Telefonszám: <b>{{ $user->Phone }}</b></p>
                <p class="text-white mt-5 mb-5">Nem: <b>{{ $user->GetSexType->Name }}</b></p>
                <p class="text-white mt-5 mb-5">Irányítószám: <b>{{ $user->PostalCode }}</b></p>
                <p class="text-white mt-5 mb-5">Cím: <b>{{ $user->FullAddress }}</b></p>
                
                <div id="additional-fields">
       
                </div>

                <form action="/jelszoVisszaallitas" method="get">
                    <input type="submit" class="btn btn-danger" value="Jelszó módosítása">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/info.js') }}" type="text/javascript" defer></script>
  
@endsection