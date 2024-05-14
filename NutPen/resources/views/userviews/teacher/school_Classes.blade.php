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
                @if ($status == 0)         <!--//osztályok-->
                    <h2 class="tm-block-title">Osztályok</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Osztályfőnök</th>
                                <th class="th-sm">Diákok listázása</th>
                                <th class="th-sm">Tantárgyak listázása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($classes as $item)
                                <tr>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->GetTeacher->FName." ".$item->GetTeacher->LName }}</td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/osztaly/diakok/{{ $item->ID }}';" >Diákok listázása</button></div></td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/osztaly/tanorak/{{ $item->ID }}';" >Tanórák listázása</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($status ==4)     
                    <h2 class="tm-block-title">{{ $className }} osztály diákjai</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Vnév</th>
                                <th class="th-sm">Knév</th>
                                <th class="th-sm">Figyelmeztetései</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $item->UserID }}</td>
                                    <td>{{ $item->lname }}</td>
                                    <td>{{ $item->fname }}</td>
                                    <td> <div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/diak/figyelmeztetesek/{{ $item->UserID }}';" >Figyelmeztetések</button> </div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($status ==5)       <!-- //osztályban diákok és törlése és hozzáadása gomb-->
                    <h2 class="tm-block-title">{{ $className }} osztály tanórái</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                               
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Hossz</th>
                                <th class="th-sm">Napok száma</th>
                                <th class="th-sm">Osztály értékelései</th>
                                <th class="th-sm">Osztály hiányzásai</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($class->GetLessons as $item)
                                <tr>
                                    <td>{{ $item->GetSubject->Name}}</td>
                                    <td>{{ $item->Minutes}} perc</td>
                                    <td>
                                        <?php 
                                        $notNullCount = 0;
                                        $dayTimes=[];
                                        foreach (unserialize($item->WeeklyTimes) as $day => $time) {
                                            // Check if the time is not null
                                            if ($time !== null) {
                                                $dayTimes[] = [
                                                    'Day' => $day,
                                                    'Time' => $time,
                                                    'Lenght'=>$item->Minutes
                                                ];
                                                
                                                $notNullCount++;
                                            }
                                        }
                                        $dayTimesJson = json_encode($dayTimes);
                                        echo("<span class='grade-button' onclick='showDetails($dayTimesJson)'> $notNullCount </span>");
                                        
                                    ?>
                                    </td>                                                                                                      
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/ertekelesek/Osztalytanorak/{{ $item->ID }}/osztaly/{{ $class->ID }}';" >Értékelések</button></div></td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/Osztalyhianyzasok/tanora/{{ $item->ID }}/osztaly/{{ $class->ID }}';" >Hiányzások</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($status ==6)
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
                                                   {{ $grade->GetGradeType->Value }},
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($status ==7)  
                @include('gradeInfoWithEdit')   
                 @include('gradeInfo')
                    <h2 class="tm-block-title"><b>{{ $classname }}</b> osztály diákjainak késései/hiányzásai <b>{{ $subjectName }}</b> tárgyból</h2>
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
                                                    <span class="grade-button" onclick="showMissingDetails('{{ $missing->GetVerificationType->Name }}', '{{ $missing->DateTime }}','{{ '/tanar/hianyzasmodositas/'.$missing->ID }}')">{{ $missing->MissedMinute }} perc, </span>
                                                
                                                @else
                                                <span class="noMissing-button" onclick="showMissingDetailsAndAskToEdit('{{ '/tanar/osztalyhianyzasmodositas/'.$missing->ID }}')">{{ $missing->MissedMinute }} perc, </span>
                                                
                                                @endif
                                        
                                                @endforeach
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($status ==8)     

                    <h2 class="tm-block-title">{{ $missing->GetStudent->LName." ".$missing->GetStudent->FName }} hiányzásának módosítása</h2>
                    <form id="ujFelh" class="formCenterContent" action="/tanar/osztalyhianyzasmodositas" method="post">
                        @csrf
                        <input type="hidden" name="missID" id="missID" value="{{ $missing->ID }}">
                        <div class="NewUser">
                            <div class="NewUser">
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
                @if ($status == 9)
                    <h2 class="tm-block-title">Figyelmeztetések</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Diák</th>
                                <th class="th-sm">Dátum</th>
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
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
