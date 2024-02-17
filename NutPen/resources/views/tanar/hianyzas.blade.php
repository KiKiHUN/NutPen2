@extends('layout')

@section('navbar')
    <li class="nav-item">
        <a class="nav-link" href="/Dashboard">
            <i class="fa-solid fa-house-chimney"></i>
            Főoldal
            <span class="sr-only">(current)</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-circle-check"></i>
            <span>
                Értékelés <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/ertekeles">Listázás</a>
            <a class="dropdown-item" href="/ertekeles/tantargyvalaszt">Új</a>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/ora">
            <i class="fa-solid fa-clock"></i>
            Órarend
            <span class="sr-only">(current)</span>
        </a>
    </li>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clipboard-question"></i>
            <span>
                Hiányzás/késés <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/hianyzas">Listázás</a>
            <a class="dropdown-item" href="/hianyzas/tantargyvalaszt">Új</a>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/diakok/tantargyvalaszt">
            <i class="fa-solid fa-users-between-lines"></i>
            Diákok
            <span class="sr-only">(current)</span>
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
            <br>
        </div>
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller">
                @if ($status == 0)
                    <h2 class="tm-block-title">Értékelések listája</h2>
                @endif
                @if ($status == 1)
                    <h2 class="tm-block-title">Tantárgy kiválasztása</h2>
                @endif
                @if ($status == 2)
                    <h2 class="tm-block-title">Diák és jegy kiválasztása</h2>
                @endif
                <br>
                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                    @if ($status == 0)
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Perc</th>
                                <th class="th-sm">Igazolva</th>
                                <th class="th-sm">dátum</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">

                            @foreach ($adatok as $item)
                                <tr>
                                    <td>{{ $item->vnev . ' ' . $item->knev }}</td>
                                    <td>{{ $item->azonosito }}</td>
                                    <td>{{ $item->nev }}</td>
                                    <td>{{ $item->Kesett_perc }}</td>
                                    <td>{{ $item->igazolva }}</td>
                                    <td>{{ $item->Datum }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                    @if ($status == 1)
                        <thead>
                            <tr>
                                <th>Név</th>
                                <th>ID</th>
                                <th>Kiválaszt</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($adatok as $item)
                                <tr>
                                    <form id="bekuld_{{ $item->ID }}" action="/hianyzas/diakvalaszt" method="post">
                                        @csrf
                                        <input type="hidden" id="id" name="id" value="{{ $item->ID }}">
                                        <td>{{ $item->nev }}</td>
                                        <td>{{ $item->ID }}</td>
                                        <td><a href="javascript:{}"
                                                onclick="document.getElementById('bekuld_{{ $item->ID }}').submit();"><i
                                                    class="fa-solid fa-check fa-2x"></i></a></td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                    @if ($status == 2)
                        <thead>
                            <tr>
                                <th>Azonosító</th>
                                <th>Vnév</th>
                                <th>Knév</th>
                                <th>Késés</th>
                                <th>Hiányzás</th>
                                <th>Rögzít</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <form id="bekuld" action="/hianyzas/tarolas" method="post">
                                <meta name="csrf-token" content="{{ Session::token() }}">
                                @foreach ($adatok as $item)
                                    <tr>
                                        <input type="hidden" id="id_{{ $item->azonosito }}" name="id"
                                            value="{{ $item->tanoraid }}">
                                        <input type="hidden" id="azonosito" name="azonosito"
                                            value="{{ $item->azonosito }}">
                                        <td>{{ $item->azonosito }}</td>
                                        <td>{{ $item->vnev }}</td>
                                        <td>{{ $item->knev }}</td>
                                        <td>
                                            <?php
                                            $kezdet = $item->kezdet;
                                            $veg = $item->veg;
                                            $kezdet = strtotime($kezdet);
                                            $veg = strtotime($veg);
                                            ?>
                                            <input type="number" placeholder="X perc" id="nmb_{{ $item->azonosito }}"
                                                min="0" max="{{ ($veg - $kezdet) / 60 }}" onfocus="this.value=''">

                                        </td>
                                        <td>
                                            <input type="checkbox" id="chk_{{ $item->azonosito }}"
                                                onchange="disableBTN('{{ $item->azonosito }}','{{ ($veg - $kezdet) / 60 }}')">
                                        </td>
                                        <td>
                                            <button type="button" onclick="listahozad('{{ $item->azonosito }}')">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            <button type="button" onclick="listatorol('{{ $item->azonosito }}')">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </form>
                        </tbody>
                    @endif
                </table>

                <button type="button" onclick="kuldes()">
                    Küldés
                </button>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/checkboxdisable.js') }}" type="text/javascript" defer></script>
@endsection
