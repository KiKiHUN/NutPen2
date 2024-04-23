@extends('layout')

@section('navbar')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

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
                @if ($status == 0)         <!--//osztályok-->
                    <h2 class="tm-block-title">Osztályaim</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Osztályfőnök</th>
                                <th class="th-sm">Osztálytársak listázása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($classes as $item)
                                <tr>
                                    <td>{{ $item->GetClass->Name }}</td>
                                    <td>{{ $item->GetClass->GetTeacher->FName." ".$item->GetClass->GetTeacher->LName }}</td>
                                    <td><button onclick="location.href = '/diak/osztaly/osztalytarsak/{{ $item->ClassID }}';" >Osztálytársak</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @if ($status ==4)       <!-- //osztályban diákok és törlése és hozzáadása gomb-->
                        <h2 class="tm-block-title">Osztálytársak</h2>
                        <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                            <thead>
                                <tr>
                                    <th class="th-sm">Azonosító</th>
                                    <th class="th-sm">Vezetéknév</th>
                                    <th class="th-sm">Keresztnév</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @foreach ($class->GetStudents as $student)
                                    <tr>
                                        <td>{{ $student->UserID }}</td>
                                        <td>{{ $student->LName }}</td>
                                        <td>{{ $student->FName }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
@endsection
