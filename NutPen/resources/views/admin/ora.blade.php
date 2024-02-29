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
