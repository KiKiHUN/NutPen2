@extends('layout')

@section('navbar')
    <li class="nav-item">
        <a class="nav-link" href="/Dashboard">
            <i class="fa-solid fa-house-chimney"></i>
            Főoldal
            <span class="sr-only">(current)</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link active" href="/ertekeles">
            <i class="fa-solid fa-cross"></i>
            Értékelések
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/ora">
            <i class="fa-solid fa-clock"></i>
            Órarend
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/hianyzas">
            <i class="fa-solid fa-person-circle-question"></i>
            Késések
        </a>
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
            <div class="tm-bg-primary-dark tm-block">
                <h2 class="tm-block-title">Performance</h2>
                <canvas id="barChart"></canvas>
                <p>ide egy menő kördiagrammot</p>
            </div>
        </div>
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                <h2 class="tm-block-title">Orders List</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tantárgy</th>
                            <th scope="col">Tanár</th>
                            <th scope="col">Jegy</th>
                            <th scope="col">Dátum</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($ertekelesek as $item)
                            <?php
                            $tanar = DB::table('ertekeles')
                                ->join('tanars', function ($join) {
                                    $join->on('tanars.azonosito', '=', 'ertekeles.Tanar_azonosito');
                                })
                                ->where('tanars.azonosito', '=', $item->Tanar_azonosito)
                                ->get()
                                ->first();

                            $tantargy = DB::table('ertekeles')
                                ->join('tantargies', function ($join) {
                                    $join->on('tantargies.ID', '=', 'ertekeles.Tantargy_ID');
                                })
                                ->where('tantargies.ID', '=', $item->Tantargy_ID)
                                ->get()
                                ->first();
                            ?>
                            <tr>
                                <td>{{ $tantargy->nev }}</td>
                                <td>{{ $tanar->vnev . ' ' . $tanar->knev }}</b></td>
                                <td>{{ $item->jegy }}</td>
                                <td>{{ $item->datum }}</td>
                            </tr>
                        @endforeach




                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
