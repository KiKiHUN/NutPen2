@extends('layout')

@section('navbar')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('userviews.teacher.Navbar')
    
@endsection

@section('content')
    

    <!-- row -->
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                @if ($status == 0)
                    <h2 class="tm-block-title">Figyelmeztetéseim</h2>
                    <button class="NewItemButton" onclick="location.href = '/tanar/ujfigyelmeztetes';" >Hozzáadás</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Diák</th>
                                <th class="th-sm">Dátum</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($warnings as $item)
                                <tr>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->Description }}</td>
                                    <td>{{ $item->GetStudent->FName." ".$item->GetStudent->LName." \\\ ".$item->StudentID }}</td>
                                    <td>{{ $item->DateTime }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($status == 2)
                <h2 class="tm-block-title">Új Figyelmeztetés</h2>
                
                    <form id="ujRang" class="formCenterContent" action="/tanar/ujfigyelmeztetesmentes" method="post">
                        @csrf
                        <div class="NewUser">
                            <div class="inputcolumn">
                                <label for="name">Név: </label>
                                <input type="text" class="textfield" id="name" name="name" value="" required>
                            </div>
                            <div class="inputcolumn">
                                <label for="description">Leírás: </label>
                                <input type="text" class="textfield" id="description" name="description" value="" required>
                            </div>
                            <div class="inputcolumn">
                                <label for="studentID">Diák: </label>
                                <select id="studentID" class="textfield" name="studentID">
                                    @foreach ($students as $student)
                                        <option value="{{ $student->UserID }}">{{ $student->FName." ".$student->LName.", ID: ".$student->UserID }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="inputcolumn">
                                <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                            </div>
                        <div class="NewUser">
                    </form>
                </div>
            @endif
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
@endsection
