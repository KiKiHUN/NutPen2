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
                @if ($status == 0)    <!--//tanórák-->
                    <h2 class="tm-block-title">Tanórák</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Hossz</th>
                                <th class="th-sm">Napok száma</th>
                                <th class="th-sm">Naptár megnyitása</th>
                                <th class="th-sm">Osztályok listázása</th>
                                <th class="th-sm">Óra módosítása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($lessons as $item)
                                <tr>
                                    <td>{{ $item->GetTeacher->FName." ".$item->GetTeacher->LName }}</td>
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
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/fo/naptar/tanorak/{{ $item->ID }}';" >Naptár</button></div></td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/fo/osztalyok/tanora/{{ $item->ID }}';" >Osztályok listázása</button></div></td>
                                    <td><div class="btnplacer"><button class="EditButton" onclick="location.href = '/fo/tanoramodositas/{{ $item->ID }}';" >Szerkesztés</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @if ($status == 2)       <!--//új tanóra-->
                        <h2 class="tm-block-title">Új Tanóra</h2>
                        
                            <form id="ujFelh" class="formCenterContent" action="/fo/ujtanoramentes" method="post">
                                @csrf
                                <div class="NewUser">
                                    <div class="inputcolumn">
                                        <label for="teacher">Tanár: </label>
                                        <select id="teacher" class="textfield" name="teacher">
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->UserID }}">{{ $teacher->FName." ".$teacher->LName.", ID: ".$teacher->UserID }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="subject">Tantárgy: </label>
                                        <select id="subject" class="textfield" name="subject">
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->ID }}">{{ $subject->Name.", ID: ".$subject->ID }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="Minutes">Hossz (perc)</label>
                                        <input name="Minutes" type="number" class="textfield" id="Minutes"
                                            value="" required />
                                    </div>
                                    
                                    <div class="inputcolumn">
                                        <label for="startDate">Mettől:</label>
                                        <input type="date" id="startDate" min="2000-06-07" max="2500-06-14" name="startDate"/>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="endDate">Meddig:</label>
                                        <input type="date" id="endDate" min="2000-06-07" max="2500-06-14" name="endDate"/>
                                    </div>
                                

                                    <div class="inputcolumn">
                                        <label for="weektable">Meddig:</label>
                                        <div class="weektable" id="weektable",name="weektable">
                                            <table>
                                            <thead>
                                                <tr>
                                                <th></th>
                                                <th>Hétfő</th>
                                                <th>Kedd</th>
                                                <th>Szerda</th>
                                                <th>Csütrörtök</th>
                                                <th>Péntek</th>
                                                <th>Szombat</th>
                                                <th>Vasárnap</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td>Aktivál</td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Monday" data-day="Monday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Tuesday" data-day="Tuesday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Wednesday" data-day="Wednesday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Thursday" data-day="Thursday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Friday" data-day="Friday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Saturday" data-day="Saturday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Sunday" data-day="Sunday"></td>
                                                </tr>
                                                <tr>
                                                <td>Időpont</td>
                                                <td><input type="time" class="time-picker" name="TM_Monday" data-day="Monday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Tuesday" data-day="Tuesday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Wednesday" data-day="Wednesday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Thursday" data-day="Thursday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Friday" data-day="Friday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Saturday" data-day="Saturday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Sunday" data-day="Sunday" disabled></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
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
                        @if ($status ==3)        <!--//tanóra módosítás-->

                            <h2 class="tm-block-title">Tanóra módosítás</h2>
                            <form id="ujFelh" class="formCenterContent" action="/fo/tanoramodositas" method="post">
                                @csrf
                                <input type="hidden" name="lessonID" id="lessonID" value="{{ $lesson->ID }}">
                                <div class="NewUser">
                                    <div class="inputcolumn">
                                        <label for="teacher">Tanár: </label>
                                        <select id="teacher" class="textfield" name="teacher">
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->UserID }}" {{ $lesson->TeacherID == $teacher->UserID ? 'selected' : '' }}>{{ $teacher->FName." ".$teacher->LName.", ID: ".$teacher->UserID }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="subject">Tantárgy: </label>
                                        <select id="subject" class="textfield" name="subject">
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->ID }}" {{ $lesson->SubjectID == $subject->ID ? 'selected' : '' }}>{{ $subject->Name.", ID: ".$subject->ID }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="Minutes">Hossz (perc)</label>
                                        <input name="Minutes" type="number" class="textfield" id="Minutes"
                                            value="{{ $lesson->Minutes }}" required />
                                    </div>
                                    
                                    <div class="inputcolumn">
                                        <label for="startDate">Mettől:</label>
                                        <input type="date" id="startDate" min="2000-06-07" max="2500-06-14" value="{{$lesson->StartDate}}" name="startDate"/>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="endDate">Meddig:</label>
                                        <input type="date" id="endDate" min="2000-06-07" max="2500-06-14" value="{{$lesson->EndDate}}" name="endDate"/>
                                    </div>
                                
                                    <div class="inputcolumn">
                                        <label for="weektable">Meddig:</label>
                                        <div class="weektable" id="weektable",name="weektable">
                                            <table>
                                            <thead>
                                                <tr>
                                                <th></th>
                                                <th>Hétfő</th>
                                                <th>Kedd</th>
                                                <th>Szerda</th>
                                                <th>Csütrörtök</th>
                                                <th>Péntek</th>
                                                <th>Szombat</th>
                                                <th>Vasárnap</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                        $a="";
                                                        $a=$a.$lesson->WeeklyTimes;
                                                        $TimeTable=unserialize($a);
                                                    ?>
                                                    <td>Aktivál</td>
                                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                        <td><input type="checkbox" class="day-checkbox textfield" name="CHK_{{ $day }}" data-day="{{ $day }}" {{ isset($TimeTable[$day]) ? 'checked' : '' }}></td>
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>Időpont</td>
                                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                        <td><input type="time" class="time-picker" name="TM_{{ $day  }}" data-day="{{ $day }}" value="{{ isset($TimeTable[$day]) ? $TimeTable[$day] : '' }}" {{ isset($TimeTable[$day]) ? '' : 'disabled' }}></td>
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="activated">Aktiválva: </label>
                                        <td><input type="checkbox" name="activated" id="activated" class="textfield"  {{ $lesson->Active ? 'checked' : '' }}></td>
                                    </div>

                                    <div class="inputcolumn">
                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                    </div>
                            
                            </form>
                                
                            </div>
                        @else
                            @if ($status ==4)       <!-- //Tanórához kapcsolt osztályok és diákok és értékelés-->
                                <h2 class="tm-block-title">{{ $subjectName }} tantárgy osztályai Tanár:({{ $teacherName }})</h2>
                                <button class="NewItemButton" onclick="location.href = '/fo/tanorak/osztalyhozzad/{{ $lessonID }}';" >Új osztály hozzáadása a tanórához</button>
                                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Név</th>
                                            <th class="th-sm">Osztályfőnök</th>
                                            <th class="th-sm">Osztály értékelései</th>
                                            <th class="th-sm">Osztály hiányzásai</th>
                                            <th class="th-sm">Diákok listázása</th>
                                            <th class="th-sm">Osztály-Tanóra</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        @foreach ($classes as $item)
                                            <tr>
                                                <td>{{ $item->Name }}</td>
                                                <td>{{ $item->GetTeacher->FName." ".$item->GetTeacher->LName }}</td>
                                                <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/fo/ertekelesek/tanora/{{  $lessonID }}/osztaly/{{ $item->ID }}';" >Értékelések</button></div></td>
                                                <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/fo/hianyzasok/tanora/{{  $lessonID }}/osztaly/{{ $item->ID }}';" >Hiányzások</button></div></td>
                                                <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/fo/osztaly/diakok/{{ $item->ID }}';" >Diákok listázása</button></div></td>
                                                <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/fo/tanora/{{ $lessonID }}/osztalytorles/{{ $item->ID }}';" >Kapcsolat bontása</button></div></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                @if ($status ==5)        <!--//osztály tanórához felvétel-->
                                    <h2 class="tm-block-title">Osztályok felvétele a tanórára</h2>
                                                    
                                    <form id="ujFelh" class="formCenterContent" action="/fo/tanorak/osztalyhozzad/mentes" method="post">
                                        @csrf
                                        <input type="hidden" name="lessonID" id="lessonID" value="{{ $lessonID }}">
                                        <div class="NewUser">
                                            <div class="inputcolumn">
                                                <label for="classID">Osztály: </label>
                                                <select id="classID" class="textfield" name="classID">
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->ID }}">{{ $class->Name."   Osztályfőnök: ".$class->GetTeacher->FName." ".$class->GetTeacher->LName." ID:".$class->ClassMasterID }}</option>
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
@endsection

@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
