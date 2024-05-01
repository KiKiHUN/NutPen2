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
                @if ($status ==4)       <!--//Értékelések listázása a tanórában szereplő diákoknak osztályra szűrve-->
                    <h2 class="tm-block-title"><b>{{ $classname }}</b> osztály diákjainak értékelései <b>{{ $subjectName }}</b> tárgyból</h2>
                    <button class="NewItemButton" onclick="location.href = '/tanar/tanorak/ujertekeles/{{ $lessonID }}/osztaly/{{ $classID }}';" >Új értékelés</button>
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
                                        @if (count($item["grades"])==0)
                                            Nincs még értékelés
                                        @else
                                            @foreach ($item["grades"] as $grade)
                                                    <span class="grade-button" onclick="showGradeDetailsAndAskToEdit('{{  $grade->GetGradeType->Name }}', '{{  $grade->DateTime }}','{{ '/tanar/ertekelesmodositas/'.$grade->ID }}')">{{ $grade->GetGradeType->Value }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @if ($status ==5)       <!--//osztály tanórához felvétel-->
                        <h2 class="tm-block-title">{{ $classname }} osztályhoz új értékelések</h2>
                        <form id="ujFelh" class="formCenterContent" action="/tanar/tanorak/ertekelesekmentes" method="post">
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
                        
                        @if($status==7)      <!--//Diák jegyének módosítása-->
                            <h2 class="tm-block-title">{{ $rating->GetStudent->LName." ".$rating->GetStudent->FName }} jegyének módosítása</h2>
                            <form id="ujFelh" class="formCenterContent" action="/tanar/ertekelesmodositas" method="post">
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
            </div>
        </div>
    </div>
@endsection

@section('script')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/tanarJS.js') }}" type="text/javascript" defer></script>
@endsection
