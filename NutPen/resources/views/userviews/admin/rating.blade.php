@extends('layout')

@section('navbar')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('userviews.admin.Navbar')
    
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
                @if ($status == 0)     <!--//értékeléstípusok-->
                    <h2 class="tm-block-title">Értékelés típusok</h2>
                    <button class="NewItemButton" onclick="location.href = '/admin/ujertekelestipus';" >Új értékelés típus</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Érték</th>
                                <th class="th-sm">Értékelés módosítása</th>
                                <th class="th-sm">Értékelés törlése</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            
                            @foreach ($ratings as $item)
                                <tr>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->Value}}</td>
                                    <td><div class="btnplacer"><button  class="EditButton" onclick="location.href = '/admin/ertekelestipusmodositas/{{ $item->ID }}';" >Módosítás</button> </div></td>
                                    <td><div class="btnplacer"><button  class="RemoveButton" onclick="location.href = '/admin/ertekelestipustorles/{{ $item->ID }}';" >Törlés</button> </div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @if ($status == 2)      <!--//új értékeléstípus-->
                        <h2 class="tm-block-title">Új Értékelés típus</h2>
                        
                            <form id="ujFelh" class="formCenterContent" action="/admin/ujertekelestipusmentes" method="post">
                                @csrf
                                <div class="NewUser">
                                    <div class="inputcolumn">
                                        <label for="name">Név: </label>
                                        <input type="text" class="textfield" id="name" name="name" value="" required>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="value">Érték: </label>
                                        <input type="text" class="textfield" id="value" name="value" value="" required >
                                    </div>
                                    <div class="inputcolumn">
                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                    </div>
                                <div class="NewUser">
                            </form>
                        </div>
                    @else
                        @if ($status ==3)       <!--//értékeléstípus módosítás-->

                            <h2 class="tm-block-title">Értékelés típus módosítás</h2>
                            <form id="ujFelh" class="formCenterContent" action="/admin/ertekelestipusmodositas" method="post">
                                @csrf
                                <input type="hidden" name="ratingID" id="ratingID" value="{{ $rating->ID }}">
                                <div class="NewUser">
                                    <div class="NewUser">
                                        <div class="inputcolumn">
                                            <label for="name">Név: </label>
                                            <input type="text" class="textfield" id="name" name="name" value="{{ $rating->Name }}" required>
                                        </div>
                                        <div class="inputcolumn">
                                            <label for="value">Érték: </label>
                                            <input type="text" class="textfield" id="value" name="value" value="{{ $rating->Value }}" required >
                                        </div>
                                        <div class="inputcolumn">
                                            <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                        </div>
                                    <div class="NewUser">
                                </div>
                            </form>
                                
                            </div>
                        @else
                            @if ($status ==4)       <!--//Értékelések listázása a tanórában szereplő diákoknak osztályra szűrve-->
                                <h2 class="tm-block-title"><b>{{ $classname }}</b> osztály diákjainak értékelései <b>{{ $subjectName }}</b> tárgyból</h2>
                                <button class="NewItemButton" onclick="location.href = '/admin/tanorak/ujertekeles/{{ $lessonID }}/osztaly/{{ $classID }}';" >Új értékelés</button>
                                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Azonosító</th>
                                            <th class="th-sm">Név</th>
                                            <th class="th-sm">Értékelések</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        @foreach ($gradesByStudent as $item)
                                        
                                            <tr>
                                                <td>{{ $item["UserID"] }}</td>
                                                <td>{{ $item["name"] }}</td>
                                                <td>
                                                    @foreach ($item["grades"] as $grade)
                                                        {{ $grade->GetGradeType->Value }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                @if ($status ==5)       <!--//osztály tanórához felvétel-->
                                    <h2 class="tm-block-title">{{ $classname }} osztályhoz új értékelések</h2>
                                    <form id="ujFelh" class="formCenterContent" action="/admin/tanorak/ertekelesekmentes" method="post">
                                        @csrf
                                        <input type="hidden" name="lessonID" id="lessonID" value="{{ $lessonID }}">
                                        <input type="hidden" name="classID" id="classID" value="{{ $classID }}">
                                        <div class="NewUser">
                                            <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                                <thead>
                                                    <tr>
                                                        <th class="th-sm">Azonosító</th>
                                                        <th class="th-sm">Név</th>
                                                        <th class="th-sm">Értékelések</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">
                                                    @foreach ($students as $item)
                                                        <tr>
                                                            <td>{{ $item->UserID }}</td>
                                                            <td>{{ $item->LName." ".$item->FName }}</td>
                                                            <td>
                                                                <select id="gradeID_{{ $item['UserID'] }}" class="textfield" name="gradeID_{{ $item['UserID'] }}">
                                                                    <option value="-1">-</option>
                                                                    @foreach ($grades as $grade)
                                                                        <option value="{{ $grade->ID }}">{{ $grade->Name."  ".$grade->Value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="inputcolumn">
                                                <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                            </div>
                                        </div>
                                    </form>
                                    
                                @else
                                    @if ($status ==6)   <!--//top X értékelés--> 
                                        <h2 class="tm-block-title">Legutóbbi értékelések</h2>
                                        <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                            <thead>
                                                <tr>
                                                    <th class="th-sm">Diák Azonosító</th>
                                                    <th class="th-sm">Diák Neve</th>
                                                    <th class="th-sm">Tanár neve</th>
                                                    <th class="th-sm">Tantárgy</th>
                                                    <th class="th-sm">Értékelés</th>
                                                    <th class="th-sm">Értékelés módosítása</th>
                                                    <th class="th-sm">Értékelés törlése</th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                @foreach ($ratings as $item)
                                                    <tr>
                                                        <td>{{ $item->GetStudent->UserID }}</td>
                                                        <td>{{ $item->GetStudent->FName." ".$item->GetStudent->LName }}</td>
                                                        <td>{{ $item->GetLesson->GetTeacher->FName." ".$item->GetLesson->GetTeacher->LName }}</td>
                                                        <td>{{ $item->GetLesson->GetSubject->Name }}</td>
                                                        <td>{{ $item->GetGradeType->Name." // ".$item->GetGradeType->Value}}</td>
                                                        <td><div class="btnplacer"><button class="EditButton" onclick="location.href = '/admin/ertekelesmodositas/{{ $item->ID }}';" >Módosítás</button></div></td>
                                                        <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/admin/ertekelestorles/{{ $item->ID }}';" >Törlés</button></div></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        @if($status==7)      <!--//Diák jegyének módosítása-->
                                            <h2 class="tm-block-title">{{ $rating->GetStudent->LName." ".$rating->GetStudent->FName }} jegyének módosítása</h2>
                                            <form id="ujFelh" class="formCenterContent" action="/admin/ertekelesmodositas" method="post">
                                                @csrf
                                                <input type="hidden" name="ratingID" id="ratingID" value="{{ $rating->ID }}">
                                                <div class="NewUser">
                                                    <div class="NewUser">
                                                        <div class="inputcolumn">
                                                            <label for="value">Érték: </label>
                                                            <select id="gradeTypeID" class="textfield" name="gradeTypeID">
                                                                @foreach ($grades as $grade)
                                                                    <option value="{{ $grade->ID }}" {{ $rating->GradeTypeID == $grade->ID ? 'selected' : '' }}>{{ $grade->Name."  ".$grade->Value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="inputcolumn">
                                                            <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                                        </div>
                                                    <div class="NewUser">
                                                </div>
                                            </form>
                                                
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif
                @endif

               
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
