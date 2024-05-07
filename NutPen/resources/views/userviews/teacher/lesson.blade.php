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
                @if ($status == 0)    <!--//tanórák-->
                    <h2 class="tm-block-title">Tanórák</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                               
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Hossz</th>
                                <th class="th-sm">Napok száma</th>
                                <th class="th-sm">Naptár megnyitása</th>
                                <th class="th-sm">Osztályok listázása</th>
                                <th class="th-sm">Házifeladatok</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($lessons as $item)
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
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/naptar/tanorak/{{ $item->ID }}';" >Naptár</button></div></td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/osztalyok/tanora/{{ $item->ID }}';" >Osztályok listázása</button></div></td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/hazifeladatok/tanora/{{ $item->ID }}';" >Házifeladatok listázása</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @if ($status ==4)       <!-- //Tanórához kapcsolt osztályok és diákok és értékelés-->
                        <h2 class="tm-block-title">{{ $subjectName }} tantárgy osztályai </h2>
                        <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                            <thead>
                                <tr>
                                    <th class="th-sm">Név</th>
                                    <th class="th-sm">Osztály értékelései</th>
                                    <th class="th-sm">Osztály hiányzásai</th>
                                    <th class="th-sm">Diákok listázása</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @foreach ($classes as $item)
                                    <tr>
                                        <td>{{ $item->Name }}</td>
                                        <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/ertekelesek/tanora/{{  $lessonID }}/osztaly/{{ $item->ID }}';" >Értékelések</button></div></td>
                                        <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/hianyzasok/tanora/{{  $lessonID }}/osztaly/{{ $item->ID }}';" >Hiányzások</button></div></td>
                                        <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/tanar/osztaly/diakok/{{ $item->ID }}';" >Diákok listázása</button></div></td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
