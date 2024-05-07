@extends('layout')

@section('navbar')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('userviews.parent.Navbar')
    
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
                    <h2 class="tm-block-title">{{ $student->LName." ".$student->FName }} Házifeladatai</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Cím</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Intervallum</th>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Megjegyzés</th>
                                <th class="th-sm">Beküldött házifeladatok</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($combinedHomeWorks as $class)
                            
                                  @foreach ($class->get_class->get_lessons as $lesson)
                                      @foreach ($lesson->get_homeworks as $homework)
                                     
                                        <tr>
                                            <td>{{ $lesson->get_subject->Name }}</td>
                                            <td>{{ $homework->Name }}</td>
                                            <td>{{ $homework->Description }}</td>
                                            <td>{{ $homework->StartDateTime }} <br> --> <br> {{ $homework->EndDateTime }}</td>
                                            <td>{{ $lesson->get_teacher->FName." ".$lesson->get_teacher->LName  }}</td>
                                           
                                            @if ($homework->get_submitted_home_works)
                                            <td>{{ $homework->get_submitted_home_works[0]->Answer? $homework->get_submitted_home_works[0]->Answer:" " }}</td>
                                                @if (isset($homework->get_submitted_home_works[0]->FileName))
                                                    <td><div class="btnplacer"><p>{{ $homework->get_submitted_home_works[0]->FileName }}</p><button class="DownloadButton" title="{{ $homework->get_submitted_home_works[0]->FileName }}" onclick="location.href = '/diak/hazifeladat/letoltes/{{ $homework->ID }}';" >Letöltés</button></div></td>
                                                @else
                                                    <td>Beadva, nincs beküldött házifeladat</td>
                                                @endif
                                            @else
                                                <td></td>
                                                <td>
                                                   Még nincs megoldva
                                                </td>
                                            @endif
                                        </tr>
                                         
                                      @endforeach
                                 
                                @endforeach
                           
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
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
