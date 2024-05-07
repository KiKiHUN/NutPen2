@extends('layout')

@section('navbar')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('userviews.headuser.Navbar')
    
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
                    <h2 class="tm-block-title">Figyelmeztetések</h2>
                    <button class="NewItemButton" onclick="location.href = '/fo/ujfigyelmeztetes';" >Hozzáadás</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Diák</th>
                                <th class="th-sm">Dátum</th>
                                <th class="th-sm">Módosítás</th>
                                <th class="th-sm">Törlés</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($warnings as $item)
                                <tr>
                                    <td>{{ $item["name"] }}</td>
                                    <td>{{ $item["description"] }}</td>
                                    <td>{{ $item["whogavename"]." / ".$item["whogaveID"] }}</td>
                                    <td>{{ $item["studentname"]." / ".$item["studentID"] }}</td>
                                    <td>{{ $item["datetime"] }}</td>
                                    <td><div class="btnplacer"><button class="EditButton" onclick="location.href = '/fo/figyelmeztetesmodositas/{{ $item['ID'] }}';" >Szerkesztés</button></div></td>
                                    <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/fo/figyelmeztetestorles/{{ $item['ID'] }}';" >Törlés</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 2)
                    <h2 class="tm-block-title">Új Figyelmeztetés</h2>
                    
                        <form id="ujRang" class="formCenterContent" action="/fo/ujfigyelmeztetesmentes" method="post">
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
                @if ($status ==3)
                    <h2 class="tm-block-title">Figyelmeztetés módosítása</h2>
                    
                        <form id="ujRang" class="formCenterContent" action="/fo/figyelmeztetesmodositas" method="post">
                            @csrf
                            <input type="hidden" name="warningID" id="warningID" value="{{ $warning->ID }}">
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="{{ $warning->Name }}" required>
                                </div>
                                <div class="inputcolumn">
                                    <label for="description">Leírás: </label>
                                    <input type="text" class="textfield" id="description" name="description" value="{{ $warning->Description }}" required>
                                </div>
                                <div class="inputcolumn">
                                    <label for="studentID">Diák: </label>
                                    <select id="studentID" class="textfield" name="studentID">
                                        @foreach ($students as $student)
                                            <option value="{{ $student->UserID }}" {{ $warning->StudentID == $student->UserID ? 'selected' : '' }}>{{ $student->FName." ".$student->LName.", ID: ".$student->UserID }}</option>
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
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
