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
                    <h2 class="tm-block-title">{{ $student->FName." ".$student->LName }} tantárgyai</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Leírás</th>
                                <!--<th class="th-sm">Tanórák listázása</th>-->
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($lessonclassconecttions as $item)
                                @foreach ($item->GetClass->GetLessons as $lesson)
                                    <tr>
                                        <td>{{ $lesson->GetSubject->Name }}</td>
                                        <td>{{ $lesson->GetSubject->Description }}</td>
                                        <!--<td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/diak/tantargy/orak/{{ $lesson->GetSubject->ID }}';" >Tanórák listázása</button></div></td>-->
                                    </tr>
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
