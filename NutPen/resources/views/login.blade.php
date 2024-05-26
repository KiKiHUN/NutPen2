@extends('layout')

@section('navbar')

@endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-warning" style="text-align:center">
        {{ session()->get('message') }}
    </div>
@endif
    <div class="Internal">
       
        <div class="Banner">

        </div>
        <div class="row">
            <div class="col-12 mx-auto tm-login-col">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="tm-block-title mb-4">Üdvözöljük a NutPen naplóban</h2>
                            <h2 class="tm-block-title mb-4">Kérem jelentkezzen be</h2>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <form action="/loginCheck" method="post" class="tm-login-form">
                                @csrf
                                <div class="form-group">
                                    <label for="username">Azonosító</label>
                                    <input name="ID" type="text" class="form-control validate" id="ID"
                                        value="" required />
                                </div>
                                <div class="form-group mt-3">
                                    <label for="password">Jelszó</label>
                                    <input name="password" type="password" class="form-control validate" id="password"
                                        value="" required />
                                </div>
                                <div class="form-group mt-4">

                                    @if ($enabledToLogin == false)
                                        <br>
                                        <h2 style="color: red">Bejelentkezés letiltva</h2>
                                    @else
                                        <button type="submit" class="btn btn-primary btn-block text-uppercase">
                                            Bejelentkez
                                        </button>
                                    @endif
                                    @if ($voltProba == true)
                                        <br>
                                        <h2 style="color: red">Sikertelen bejelentkezés</h2>
                                    @endif

                                </div>
                            </form>
                        </div>
                        admin: a00000 alma12345<br>
                        szülő: p1b4j8u2 alma12345<br>
                        tanár: t5v5l8g6 alma12345<br>
                        osztályfőnök tanár: t8d3n2t0 alma12345<br>
                        fő felhasználó: h2h5c6q3 alma12345<br>
                        diák: s2m9u0f7 alma12345
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        switch (screen.orientation.type) {
            case "landscape-primary":
            break;
            case "landscape-secondary":
            break;
            case "portrait-secondary":
            case "portrait-primary":
            alert("A jobb használhatóság érdekében fordítsa el az eszközét.")
            break;
            default:
            console.log("The orientation API isn't supported in this browser :(");
        }

        
    </script>
    <script src="/js/bannerLoad.js"></script>
@endsection
