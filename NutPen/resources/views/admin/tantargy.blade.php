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
                    <h2 class="tm-block-title">Összes Tárgy</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">ID</th>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Leírás</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($tantargyak as $item)
                                <tr>
                                    <td>{{ $item->ID }}</td>
                                    <td>{{ $item->nev }}</td>
                                    <td>{{ $item->leiras }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 1)
                    <h2 class="tm-block-title">Tárgy hozzáadás</h2>
                    <div>
                        <form id="ujTargy" action="/targy/ujtargy" method="post">
                            @csrf
                            <label for="nev">Név: </label>
                            <input type="text" id="nev" name="nev" value="" required>
                            <label for="leiras">Leírás: </label>
                            <input type="text" id="leiras" name="leiras" value="" required>
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
