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
                @if ($status == 0)
                    <h2 class="tm-block-title">Házi feladatok</h2>
                    <button class="NewItemButton" onclick="location.href = '/admin/ujhazifeladat';" >Hozzáadás</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Cím</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Intervallum</th>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Osztályok</th>
                                <th class="th-sm">Engedélyezve</th>
                                <th class="th-sm">Beküldött házifeladatok</th>
                                <th class="th-sm">Módosítás</th>
                                <th class="th-sm">Törlés</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($homeworks as $item)
                                <tr>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->Description }}</td>
                                    <td>{{ $item->StartDateTime }} <br> --> <br> {{ $item->EndDateTime }}</td>
                                    <td>{{ $item->GetLesson->GetTeacher->FName." ".$item->GetLesson->GetTeacher->LName  }}</td>
                                    <td>{{ $item->GetLesson->GetSubject->Name }}</td>
                                  
                                    <td>  <div class="btnplacer"> <button class="OtherFunctionButton" onclick="location.href = '/admin/hazifeladat/osztalyok/{{ $item->ID }}';" >Osztályok</button> </div> </td>
                                    <td>
                                        @if ($item->Active)
                                            Igen
                                        @else
                                            Nem
                                        @endif
                                    </td>
                                    <td> <div class="btnplacer"><button  class="DownloadButton" onclick="location.href = '/admin/hazifeladatok/diakok/{{ $item->ID }}';" >Beadott feladatok</button>  </div></td>
                                    <td><div class="btnplacer"><button class="EditButton" onclick="location.href = '/admin/hazifeladatmodositas/{{ $item->ID }}';" >Szerkesztés</button></div></td>
                                    <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/admin/hazifeladattorles/{{ $item->ID }}';" >Törlés</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else
                    @if ($status == 2)
                        <h2 class="tm-block-title">Új Házi feladat</h2>
                        
                            <form id="ujRang" class="formCenterContent" action="/admin/ujhazifeladatmentes" method="post">
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
                                        <label for="startDate">Kezdet:</label>
                                        <input type="datetime-local" id="startDate" min="2000-06-07T00:00" max="2500-06-14T00:00" name="startDate"/>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="endDate">Vég:</label>
                                        <input type="datetime-local" id="endDate" min="2000-06-07T00:00" max="2500-06-14T00:00" name="endDate"/>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="lessonID">Tanóra: </label>
                                        <select id="lessonID" class="textfield" name="lessonID">
                                        
                                            @foreach ($lessons as $lesson)
                                                <option value="{{ $lesson->ID }}">{{ 
                                                    $lesson->GetSubject->Name." -- ".
                                                    $lesson->GetTeacher->FName." ".$lesson->GetTeacher->LName." -- ".
                                                    " Osztákyok: " }}
                                                    @foreach ($lesson->GetClasses as $schoolclass)
                                                        {{ $schoolclass->Name.", " }}
                                                    @endforeach
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="activated">Aktiválva: </label>
                                        <td><input type="checkbox" name="activated" id="activated" class="textfield" value="1"></td>
                                    </div>

                                    <div class="inputcolumn">
                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                    </div>
                                <div class="NewUser">
                            </form>
                        </div>
                    @else
                        @if ($status ==3)
                            <h2 class="tm-block-title">Házi feladat módosítása</h2>
                            
                                <form id="ujRang" class="formCenterContent" action="/admin/hazifeladatmodositas" method="post">
                                    @csrf
                                    <input type="hidden" name="homeworkID" id="homeworkID" value="{{ $homework->ID }}">
                                    <div class="NewUser">
                                        <div class="inputcolumn">
                                            <label for="name">Név: </label>
                                            <input type="text" class="textfield" id="name" name="name" value="{{ $homework->Name }}" required>
                                        </div>
                                        <div class="inputcolumn">
                                            <label for="description">Leírás: </label>
                                            <input type="text" class="textfield" id="description" name="description" value="{{ $homework->Description }}" required>
                                        </div>
                                        <div class="inputcolumn">
                                            <label for="startDate">Kezdet:</label>
                                            <input type="datetime-local" id="startDate" min="2000-06-07T00:00" max="2500-06-14T00:00" value="{{$homework->StartDateTime}}" name="startDate"/>
                                        </div>
                                        <div class="inputcolumn">
                                            <label for="endDate">Vég:</label>
                                            <input type="datetime-local" id="endDate" min="2000-06-07T00:00" max="2500-06-14T00:00" value="{{$homework->EndDateTime}}" name="endDate"/>
                                        </div>
                                        <div class="inputcolumn">
                                            <label for="lessonID">Tanóra: </label>
                                            <select id="lessonID" class="textfield" name="lessonID">
                                            
                                                @foreach ($lessons as $lesson)
                                                    <option value="{{ $lesson->ID }}" {{ $lesson->ID == $homework->LessonID ? 'selected' : '' }}>{{ 
                                                        $lesson->GetSubject->Name." -- ".
                                                        $lesson->GetTeacher->FName." ".$lesson->GetTeacher->LName." -- ".
                                                        " Osztákyok: " }}
                                                        @foreach ($lesson->GetClasses as $schoolclass)
                                                            {{ $schoolclass->Name.", " }}
                                                        @endforeach
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="inputcolumn">
                                            <label for="activated">Aktiválva: </label>
                                            <td><input type="checkbox" name="activated" id="activated" class="textfield" {{ $homework->Active ? 'checked' : '' }}></td>
                                        </div>

                                        <div class="inputcolumn">
                                            <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                        </div>
                                    <div class="NewUser">
                                </form>
                            </div>
                        @else
                            @if ($status ==4)
                                <h2 class="tm-block-title">Diákok beadott feladatai</h2>
                                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Házifeladat Cím</th>
                                            <th class="th-sm">Leírás</th>
                                            <th class="th-sm">Diák</th>
                                            <th class="th-sm">Beküldési időpont</th>
                                            <th class="th-sm">Megjegyzés</th>
                                            <th class="th-sm">Fájl letöltése</th>
                                            <th class="th-sm">Törlés</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        @foreach ($homeworks as $item)
                                            <tr>
                                                <td>{{ $item->GetHomework->Name }}</td>
                                                <td>{{ $item->GetHomework->Description }}</td>
                                                
                                                <td>{{$item->GetStudent->UserID }} <br> {{ $item->GetStudent->LName." ".$item->GetStudent->FName }}</td>
                                                <td>{{ $item->SubmitDateTime }}</td>
                                                <td>{{ $item->Answer }}</td>
                                                
                                                @if (isset($item->FileName))
                                                    <td><div class="btnplacer"><button class="DownloadButton" title="{{ $item->FileName }}" onclick="location.href = '/admin/bekuldotthazifeladat/letoltes/{{ $item->HomeWorkID }}/{{ $item->StudentID }}';" >Letöltés</button></div></td>
                                                @else
                                                    <td>Nincs beküldött házifeladat</td>
                                                @endif
                                               
                                                <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/admin/bekuldotthazifeladat/torles/{{ $item->HomeWorkID }}/{{ $item->StudentID }}';" >Törlés</button></div></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
