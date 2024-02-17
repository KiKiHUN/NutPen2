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
        <a class="nav-link " href="/ertekeles">
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
        <a class="nav-link active" href="/hianyzas">
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
                <h2 class="tm-block-title">Tantárgyankénti késés</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tantárgy</th>
                            <th scope="col">Késés</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $lista = []; ?>
                        @foreach ($adat as $item)
                            @if (!empty($lista))
                                {{ $talalt = false }}

                                @foreach ($lista as $key => $listaitem)
                                    @if ($item->nev == $listaitem[0])
                                        <?php
                                        $lista[$key][1] += $item->Kesett_perc;
                                        $talalt = true;
                                        ?>
                                    @endif
                                @endforeach

                                @if (!$talalt)
                                    <?php array_push($lista, [$item->nev, $item->Kesett_perc]); ?>
                                @endif
                            @else
                                <?php array_push($lista, [$item->nev, $item->Kesett_perc]); ?>
                            @endif
                        @endforeach

                        @foreach ($lista as $tantargy)
                            @if ($tantargy[1] >= 45)
                                <tr>
                                    <td style="color: rgb(255, 85, 85)"> {{ $tantargy[0] }}</td>
                                    <td style="color: rgb(255, 85, 85)">{{ $tantargy[1] }} perc</td>
                                </tr>
                            @else
                                <tr>
                                    <td style="color: green"> {{ $tantargy[0] }}</td>
                                    <td style="color: green">{{ $tantargy[1] }} perc</td>
                                </tr>
                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                <h2 class="tm-block-title">Összes késés</h2>
                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                    <thead>
                        <tr>
                            <th class="th-sm">Tanár</th>
                            <th class="th-sm">Tantárgy</th>
                            <th class="th-sm">Késés</th>
                            <th class="th-sm">Dátum</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @foreach ($adat as $item)
                            <tr>
                                <td>{{ $item->vnev . ' ' . $item->knev }}</td>
                                <td>{{ $item->nev }}</td>
                                <td>{{ $item->Kesett_perc }}</td>
                                <td>{{ date('Y-m-d', strtotime($item->Datum)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
@endsection
