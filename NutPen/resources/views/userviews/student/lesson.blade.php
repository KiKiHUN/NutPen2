@extends('layout')

@section('navbar')

    @include('userviews.student.Navbar')
    
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
                    @include('classInfo')

                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Hossz</th>
                                <th class="th-sm">Napok száma</th>
                                <th class="th-sm">Naptár megnyitása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($lessonclassconecttions as $item)

                                @foreach ($item->GetClass->GetLessons as $lesson)
                                <tr>
                                    <td>{{ $lesson->GetTeacher->FName." ".$lesson->GetTeacher->LName }}</td>
                                    <td>{{ $lesson->GetSubject->Name}}</td>
                                    <td>{{ $lesson->Minutes}} perc</td>
                                    <td>
                                    <?php 
                                            $notNullCount = 0;
                                            $dayTimes=[];
                                            foreach (unserialize($lesson->WeeklyTimes) as $day => $time) {
                                                // Check if the time is not null
                                                if ($time !== null) {
                                                    $dayTimes[] = [
                                                        'Day' => $day,
                                                        'Time' => $time,
                                                        'Lenght'=>$lesson->Minutes
                                                    ];
                                                    
                                                    $notNullCount++;
                                                }
                                            }
                                            
                                            $dayTimesJson = json_encode($dayTimes);
                                            echo("<span class='grade-button' onclick='showDetails($dayTimesJson)'> $notNullCount </span>");
                                            
                                        ?>
                                    </td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton calendarLesFiltbutton" value="{{ $lesson->ID }}" >Naptár</button></div></td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
              
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
