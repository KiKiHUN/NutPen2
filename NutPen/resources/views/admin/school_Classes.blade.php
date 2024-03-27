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
                @if ($status == 0)         <!--//osztályok-->
                    <h2 class="tm-block-title">Osztályok</h2>
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
                @else
                    @if ($status == 2)         <!-- //új osztály-->
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
                    @else
                        @if ($status ==3)       <!--//osztály módosítás-->
                            <h2 class="tm-block-title">Osztály módosítás</h2>
                            
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
                        @else
                            @if ($status ==4)       <!-- //osztályban diákok és törlése és hozzáadása gomb-->
                                <h2 class="tm-block-title">Diákok</h2>
                                <button onclick="location.href = '/osztalyok/diakhozzad/{{ $classID }}';" >Hozzáadás</button>
                                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Azonosító</th>
                                            <th class="th-sm">Vnév</th>
                                            <th class="th-sm">Knév</th>
                                            <th class="th-sm">Törlés</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ $item->UserID }}</td>
                                                <td>{{ $item->fname }}</td>
                                                <td>{{ $item->lname }}</td>
                                                <td> <button onclick="location.href = '/osztaly/{{ $classID }}/diaktorles/{{ $item->UserID }}';" >Törlés</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                @if ($status ==5)     <!--//diák felvétele osztályba-->
                                        <h2 class="tm-block-title">Diák felvétele az osztályba</h2>
                                
                                        <form id="ujFelh" class="formCenterContent" action="/osztalyok/diakhozzad/mentes" method="post">
                                            @csrf
                                            <input type="hidden" name="classID" id="classID" value="{{ $classID }}">
                                            <div class="NewUser">
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
                            @endif
                        @endif
                    @endif
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
