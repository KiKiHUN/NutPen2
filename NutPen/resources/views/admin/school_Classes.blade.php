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

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                @if ($status == 0)
                    <h2 class="tm-block-title">Felhasználók</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Osztályfőnök</th>
                                <th class="th-sm">Osztály módosítása</th>
                                <th class="th-sm">Diákok listázása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($classes as $item)
                                <tr>
                                    <td>{{ $item->ID }}</td>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->GetTeacher->FName." ".$item->GetTeacher->LName }}</td>
                                    <td><button onclick="location.href = '/osztalymodositas/{{ $item->ID }}';" >Szerkesztés</button></td>
                                    <td><button onclick="location.href = '/osztaly/diakok/{{ $item->ID }}';" >Diákok listázása</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 2)
                    <h2 class="tm-block-title">Új osztály</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/ujosztalymentes" method="post">
                            @csrf
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="" required>
                                </div>
                                <div class="inputcolumn">
                                    <label for="teacher">Osztályfőnök: </label>
                                    <select id="teacher" class="textfield" name="teacher">
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->UserID }}">{{ $teacher->FName." ".$teacher->LName.", ID: ".$teacher->UserID }}</option>
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
                    <h2 class="tm-block-title">Új osztály</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/osztalymodositas" method="post">
                            @csrf
                            <input type="hidden" name="classID" id="classID" value="{{ $class->ID }}">
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="{{ $class->Name }}" required>
                                </div>
                                <div class="inputcolumn">
                                    <label for="teacher">Osztályfőnök: </label>
                                    <select id="teacher" class="textfield" name="teacher">
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->UserID }}" {{ $class->ClassMasterID == $teacher->ID ? 'selected' : '' }}>{{ $teacher->FName." ".$teacher->LName.", ID: ".$teacher->UserID }}</option>
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
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
