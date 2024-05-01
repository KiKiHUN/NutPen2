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
                    <h2 class="tm-block-title"><b>{{ $classname }}</b> osztály diákjainak késései/hiányzásai <b>{{ $subjectName }}</b> tárgyból</h2>
                    <button class="NewItemButton" onclick="location.href = '/tanar/tanorak/ujhianyzas/{{ $lessonID }}/osztaly/{{ $classID }}';" >Új hiányzás</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Késések</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($missingsByStudent as $item)
                            
                                <tr>
                                    <td>{{ $item["UserID"] }}</td>
                                    <td>{{ $item["name"] }}</td>
                                    <td>
                                        
                                        @if (count($item["missings"])==0)
                                            Nincs még hiányzás
                                        @else
                                            @foreach ($item["missings"] as $missing)
                                                @if ($missing->Verified==1)
                                                    <span class="grade-button" onclick="showGradeDetails('{{ $missing->GetVerificationType->Name }}', '{{ $missing->DateTime }}','{{ '/tanar/hianyzasmodositas/'.$missing->ID }}')">{{ $missing->MissedMinute }} perc, </span>
                                                
                                                @else
                                                <span class="noMissing-button" onclick="showMissingDetailsAndAskToEdit('{{ '/tanar/hianyzasmodositas/'.$missing->ID }}')">{{ $missing->MissedMinute }} perc, </span>
                                                   
                                                @endif
                                        
                                                @endforeach
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @if ($status ==5)       <!--//osztály tanórához felvétel-->
                        <h2 class="tm-block-title">{{ $classname }} osztályhoz új hiányzás felvétele</h2>
                        <form id="ujFelh" class="formCenterContent" action="/tanar/tanorak/hianyzasmentes" method="post">
                            @csrf
                            <input type="hidden" name="lessonID" id="lessonID" value="{{ $lessonID }}">
                            <input type="hidden" name="classID" id="classID" value="{{ $classID }}">
                            <div class="NewUser">
                                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Azonosító</th>
                                            <th class="th-sm">Név</th>
                                            <th class="th-sm">Késett perc</th>
                                            <th class="th-sm">Igazolás</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        @foreach ($students as $item)
                                            <tr>
                                                <td>{{ $item->UserID }}</td>
                                                <td>{{ $item->LName." ".$item->FName }}</td>
                                                <td>  
                                                    <div class="inputcolumn">
                                                        <label for="minutes_{{ $item['UserID'] }}">Késett perc: </label>
                                                        <input type="number" id="minutes_{{ $item['UserID'] }}" name="minutes_{{ $item['UserID'] }}" value=0>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select id="missingID_{{ $item['UserID'] }}" class="textfield" name="missingID_{{ $item['UserID'] }}" disabled>
                                                        <option value="-1">Nincs igazolva</option>
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
                            <h2 class="tm-block-title">{{ $missing->GetStudent->LName." ".$missing->GetStudent->FName }} hiányzásának módosítása</h2>
                            <form id="ujFelh" class="formCenterContent" action="/tanar/hianyzasmodositas" method="post">
                                @csrf
                                <input type="hidden" name="missID" id="missID" value="{{ $missing->ID }}">
                                <div class="NewUser">
                                    <div class="NewUser">
                                        <div class="inputcolumn">
                                            <label for="minutes">Késett perc: </label>
                                            <input type="number" id="minutes" name="minutes" value="{{ $missing->MissedMinute }}">
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
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
