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
                    <h2 class="tm-block-title">Igazolás típusok</h2>
                    <button class="NewItemButton" onclick="location.href = '/admin/ujigazolastipus';" >Új igazolás típus</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Igazolás típus módosítása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            
                            @foreach ($veriftypes as $item)
                                <tr>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->Description}}</td>
                                    <td><div class="btnplacer"><button  class="EditButton" onclick="location.href = '/admin/igazolastipusmodositas/{{ $item->ID }}';" >Módosítás</button> </div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @if ($status == 2)      <!--//új értékeléstípus-->
                        <h2 class="tm-block-title">Új Igazolás típus</h2>
                        
                            <form id="ujFelh" class="formCenterContent" action="/admin/ujigazolastipusmentes" method="post">
                                @csrf
                                <div class="NewUser">
                                    <div class="inputcolumn">
                                        <label for="name">Név: </label>
                                        <input type="text" class="textfield" id="name" name="name" value="" required>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="description">Leírás: </label>
                                        <input type="text" class="textfield" id="description" name="description" value="" required >
                                    </div>
                                    <div class="inputcolumn">
                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                    </div>
                                <div class="NewUser">
                            </form>
                        </div>
                    @else
                        @if ($status ==3)       <!--//értékeléstípus módosítás-->

                            <h2 class="tm-block-title">Igazolás típus módosítás</h2>
                            <form id="ujFelh" class="formCenterContent" action="/admin/igazolastipusmodositas" method="post">
                                @csrf
                                <input type="hidden" name="verificationID" id="verificationID" value="{{ $verif->ID }}">
                                <div class="NewUser">
                                    <div class="NewUser">
                                        <div class="inputcolumn">
                                            <label for="name">Név: </label>
                                            <input type="text" class="textfield" id="name" name="name" value="{{ $verif->Name }}" required>
                                        </div>
                                        <div class="inputcolumn">
                                            <label for="description">Leírás: </label>
                                            <input type="text" class="textfield" id="description" name="description" value="{{ $verif->Description }}" required >
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
                                <h2 class="tm-block-title"><b>{{ $classname }}</b> osztály diákjainak késései/hiányzásai <b>{{ $subjectName }}</b> tárgyból</h2>
                                <button class="NewItemButton" onclick="location.href = '/admin/tanorak/ujhianyzas/{{ $lessonID }}/osztaly/{{ $classID }}';" >Új hiányzás</button>
                               @include('gradeInfo')
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
                                                                <span class="grade-button" onclick="showMissingDetails('{{ $missing->GetVerificationType->Name }}', '{{ $missing->DateTime }}')">{{ $missing->MissedMinute }}</span>
                                                            
                                                            @else
                                                                {{ $missing->MissedMinute }}
                                                            @endif
                                                    
                                                         @endforeach
                                                    @endif
                                                   
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                @if ($status ==5)    
                                    <h2 class="tm-block-title">{{ $classname }} osztályhoz új hiányzás felvétele</h2>
                                    <form id="ujFelh" class="formCenterContent" action="/admin/tanorak/hianyzasmentes" method="post">
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
                                                              
                                                                <select id="missingID_{{ $item['UserID'] }}" class="textfield" name="missingID_{{ $item['UserID'] }}">
                                                                    <option value="-1">Nincs igazolva</option>
                                                                    @foreach ($verifTypes as $verif)
                                                                        <option value="{{ $verif->ID }}">{{ $verif->Name."  ".$verif->Description }}</option>
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
                                    @if ($status ==6)   
                                        <h2 class="tm-block-title">Legutóbbi értékelések</h2>
                                        <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                            <thead>
                                                <tr>
                                                    <th class="th-sm">Dátum</th>
                                                    <th class="th-sm">Diák Azonosító</th>
                                                    <th class="th-sm">Diák Neve</th>
                                                    <th class="th-sm">Tanár neve</th>
                                                    <th class="th-sm">Tantárgy</th>
                                                    <th class="th-sm">Késett perc</th>
                                                    <th class="th-sm">Igazolva</th>
                                                    <th class="th-sm">Értékelés módosítása</th>
                                                    <th class="th-sm">Értékelés törlése</th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                @foreach ($missings as $item)
                                              
                                                    <tr>
                                                        <td>{{  $item->DateTime }}</td>
                                                        <td>{{ $item->GetStudent->UserID }}</td>
                                                        <td>{{ $item->GetStudent->FName." ".$item->GetStudent->LName }}</td>
                                                        <td>{{ $item->GetLesson->GetTeacher->FName." ".$item->GetLesson->GetTeacher->LName }}</td>
                                                        <td>{{ $item->GetLesson->GetSubject->Name }}</td>
                                                        <td>{{  $item->MissedMinute }} perc </td>
                                                        <td>
                                                          
                                                            @if ($item->GetVerificationType)
                                                                {{ $item->GetVerificationType->Name}}
                                                            @else
                                                                nincs még igazolva!
                                                            @endif
                                                        </td>
                                                        
                                                        <td><div class="btnplacer"><button class="EditButton" onclick="location.href = '/admin/hianyzasmodositas/{{ $item->ID }}';" >Módosítás</button></div></td>
                                                        <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/admin/hianyzastorles/{{ $item->ID }}';" >Törlés</button></div></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        @if($status==7)     
                                            <h2 class="tm-block-title">{{ $missing->GetStudent->LName." ".$missing->GetStudent->FName }} hiányzásának módosítása</h2>
                                            <form id="ujFelh" class="formCenterContent" action="/admin/hianyzasmodositas" method="post">
                                                @csrf
                                                <input type="hidden" name="missID" id="missID" value="{{ $missing->ID }}">
                                                <div class="NewUser">
                                                    <div class="NewUser">
                                                        <div class="inputcolumn">
                                                            <label for="minutes">Késett perc: </label>
                                                            <input type="number" id="minutes" name="minutes" value="{{ $missing->MissedMinute }}">
                                                        </div>
                                                        <div class="inputcolumn">
                                                            <label for="verifID">Hiányzás igazolása: </label>
                                                            <select id="verifID" class="textfield" name="verifID">
                                                                <option value="{{ null }}" {{ $missing->VerificationTypeID == null ? 'selected' : '' }}>Nincs igazolva</option>
                                                                @foreach ($VerifTypes as $verif)
                                                                    <option value="{{ $verif->ID }}" {{ $missing->VerificationTypeID == $verif->ID ? 'selected' : '' }}>{{ $verif->Name.":  ".$verif->Description }}</option>
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
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
