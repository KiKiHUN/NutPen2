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
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <br>
        </div>
        @foreach ($gyerekek as $gyerek)
            <?php
                $gyerekadat = DB::table('diaks')
                    ->where('azonosito', '=', $gyerek->Diak_azonosito)
                    ->get()
                    ->first();
                $keses = DB::table('keses')
                ->selectRaw('keses.ID,diaks_tanoras.Diak_azonosito,Kesett_perc,tanars.vnev,tanars.knev,tantargies.nev,tantargies.leiras,keses.Datum,keses.igazolva')
                ->join('diaks_tanoras', function ($join) {
                    $join->on('diaks_tanoras.ID', '=', 'keses.Diak_tanora_ID');
                })
                ->join('tanoras', function ($join) {
                    $join->on('tanoras.ID', '=', 'diaks_tanoras.Tanora_ID');
                })
                ->join('tantargies', function ($join) {
                    $join->on('tantargies.ID', '=', 'tanoras.Tantargy_ID');
                })
                ->join('tanars', function ($join) {
                    $join->on('tanars.azonosito', '=', 'tanoras.Tanar_azonosito');
                })
                ->where('diaks_tanoras.Diak_azonosito', '=', $gyerek->Diak_azonosito)
                ->get();
            ?>
            <div class="col-12 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                    <h2 class="tm-block-title">{{ $gyerekadat->vnev }} {{ $gyerekadat->knev }} késései/hiányzásai</h2>
                    <p class="igazolasSzam">Fennmaradó igazolások száma: {{ $gyerekadat->elerhetoIgazolasok }}</p>
                    <table class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Késés</th>
                                <th class="th-sm">Dátum</th>
                                <th class="th-sm">Igazolás</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keses as $item)
                                @if (!$item->igazolva)
                                    @if ($gyerekadat->elerhetoIgazolasok > 0)
                                        <tr class="hianyzik">
                                            <form id="bekuld_{{ $item->ID }}" action="/hianyzas/igazol" method="post">
                                                @csrf
                                                <input type="hidden" id="id" name="id"
                                                    value="{{ $item->ID }}">
                                                <td>{{ $item->vnev . ' ' . $item->knev }}</td>
                                                <td>{{ $item->nev }}</td>
                                                <td>{{ $item->Kesett_perc }} perc</td>
                                                <td>{{ date('Y-m-d', strtotime($item->Datum)) }}</td>
                                                <td><a
                                                        href="javascript:{}"onclick="document.getElementById('bekuld_{{ $item->ID }}').submit();"><i
                                                            class="fa-solid fa-check fa-2x"></i></a></td>

                                            </form>
                                        </tr>
                                    @else
                                        <tr class="hianyzik">
                                            <td>{{ $item->vnev . ' ' . $item->knev }}</td>
                                            <td>{{ $item->nev }}</td>
                                            <td>{{ $item->Kesett_perc }}</td>
                                            <td>{{ date('Y-m-d', strtotime($item->Datum)) }}</td>
                                            <td>igazolatlan</td>
                                        </tr>
                                    @endif
                                @else
                                    <tr class="igazolva">
                                        <td>{{ $item->vnev . ' ' . $item->knev }}</td>
                                        <td>{{ $item->nev }}</td>
                                        <td>{{ $item->Kesett_perc }}</td>
                                        <td>{{ date('Y-m-d', strtotime($item->Datum)) }}</td>
                                        <td>igazolva</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
@endsection
