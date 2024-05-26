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
                @if ($status == 0)
                    <h2 class="tm-block-title">Házifeladatok</h2>
                    <button class="NewItemButton" onclick="location.href = '/tanar/ujhazifeladat/{{ $lessonid }}';" >Hozzáadás</button>
                  
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Intervallum</th>
                                <th class="th-sm">Cím</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Engedélyezve</th>
                                <th class="th-sm">Beküldött házifeladatok</th>
                                <th class="th-sm">Módosítás</th>
                                <th class="th-sm">Törlés</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($homeworks as $item)
                                <tr>
                                    <td>{{ $item->StartDateTime }} <br> --> <br> {{ $item->EndDateTime }}</td>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->Description }}</td>
                                    <td>
                                        @if ($item->Active)
                                            Igen
                                        @else
                                            Nem
                                        @endif
                                    </td>
                                    <td> <div class="btnplacer"><button  class="DownloadButton" onclick="location.href = '/tanar/hazifeladatok/diakok/{{ $item->ID }}';" >Beadott feladatok</button>  </div></td>
                                    <td><div class="btnplacer"><button class="EditButton" onclick="location.href = '/tanar/hazifeladatmodositas/{{ $item->ID }}/{{ $lessonid }}';" >Szerkesztés</button></div></td>
                                    <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/tanar/hazifeladattorles/{{ $item->ID }}';" >Törlés</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else
                    @if ($status == 2)
                        <h2 class="tm-block-title">Új Házifeladat</h2>
                        
                            <form id="ujRang" class="formCenterContent" action="/tanar/ujhazifeladatmentes" method="post">
                                @csrf
                                <input type="hidden" id="lessonID" name="lessonID" value="{{ $lessonid }}">
                                
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
                            <h2 class="tm-block-title">Házifeladat módosítása</h2>
                            
                                <form id="ujRang" class="formCenterContent" action="/tanar/hazifeladatmodositas" method="post">
                                    @csrf
                                    <input type="hidden" id="lessonID" name="lessonID" value="{{ $lessonid }}">
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
                              @include('gradeInfoWithEdit')
                                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Diák</th>
                                            <th class="th-sm">Osztály neve</th>
                                            <th class="th-sm">Beküldési időpont</th>
                                            <th class="th-sm">Megjegyzés</th>
                                            <th class="th-sm">Fájl letöltése</th>
                                            <th class="th-sm">Törlés</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        @foreach ($homeworks as $item)
                                            <tr>
                                                <td>{{ $item["name"]." \\ ".$item["UserID"] }}</td>
                                                <td>{{ $item["classname"] }}</td>
                                                

                                                @if ($item["hw"])
                                                    <td>{{ $item["hw"]->SubmitDateTime }}</td>
                                                    @if (isset( $item["hw"]->Answer))
                                                    <td> <span class="grade-button" onclick="AskForCommentText('{{ $item['hw']->StudentID }}', '{{ $item['hw']->HomeWorkID }}','{{ $item['hw']->Answer }}')">{{ $item["hw"]->Answer }}</span></td>
                                                    @else
                                                        <td> <span class="noMissing-button" onclick="AskForCommentText('{{ $item['hw']->StudentID }}', '{{ $item['hw']->HomeWorkID }}','{{ $item['hw']->Answer }}')">Még nincs hozzászólás</span></td>
                                                    @endif
                                                    @if (isset($item["hw"]->FileName))
                                                        <td><div class="btnplacer"><p>{{$item["hw"]->FileName }}</p><button class="DownloadButton" title="{{ $item['hw']->FileName }}" onclick="location.href = '/tanar/bekuldotthazifeladat/letoltes/{{ $item['hw']->HomeWorkID }}/{{ $item['hw']->StudentID }}';" >Letöltés</button></div></td>
                                                    @else
                                                        <td>Nincs beküldött házifeladat</td>
                                                    @endif
                                                    <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/tanar/bekuldotthazifeladat/torles/{{  $item['hw']->HomeWorkID }}/{{  $item['hw']->StudentID }}';" >Törlés</button></div></td>
                                                @else
                                                    <td>Házifeladat nincs beadva</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif
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
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
