@extends('layout')

@section('navbar')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('admin.Navbar')
    
@endsection

@section('content')
    <!-- row -->
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
        </div>
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">

                    @if($status==0)
                    <h2 class="tm-block-title">Összes diák-óra kapcsolat</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Tárgy név</th>
                                <th class="th-sm">Kezdet</th>
                                <th class="th-sm">Vég</th>
                                <th class="th-sm">Diák név</th>
                                <th class="th-sm">Diák azonosító</th>
                                <th class="th-sm">Tanár név</th>
                                <th class="th-sm">Tanár azonosító</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($kapcsolatok as $item)
                                <tr>
                                    <td>{{ $item->nev }}</td>
                                    <td>{{ $item->kezdet }}</td>
                                    <td>{{ $item->veg }}</td>
                                    <td>{{ $item->diak_vnev." ". $item->diak_knev}}</td>
                                    <td>{{ $item->diak_azon }}</td>
                                    <td>{{ $item->tanar_vnev." ". $item->tanar_knev }}</td>
                                    <td>{{ $item->tanar_azon }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @if($status==1)
                    <h2 class="tm-block-title">Új diák-óra kapcsolat</h2>
                        <div>
                            <form  id="ujDiakOra" action="/kapcsolat/ora/ujkapcs" method="post">
                                @csrf
                                <label for="diak">Diák: </label>
                                <select id="diak" name="diak" >
                                    @foreach ($diakok as $diak)
                                        <option value="{{ $diak->azonosito }}">{{ $diak->azonosito."  //  ". $diak->vnev." ". $diak->knev}}</option>
                                    @endforeach
                                </select>
                                <label for="tanora">Órák: </label>
                                <select id="tanora" name="tanora" >

                                    @foreach ($tanorak as $tanora)
                                        <option value="{{ $tanora->id }}">{{ $tanora->nev."  //  ".$tanora->kezdet." -- ".$tanora->veg." // " .$tanora->vnev." ". $tanora->knev." - ".$tanora->azonosito}}</option>
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
