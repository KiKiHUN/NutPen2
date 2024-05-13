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
                @if ($status ==0)   <!--//top X értékelés--> 
                    <h2 class="tm-block-title">Késéseim</h2>
                    <h2 class="tm-block-title">{{ $student->RemainedParentVerification }}db. szülői igazolása maradt</h2>
                    @include('gradeInfo')
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Dátum</th>
                                <th class="th-sm">Tanár neve</th>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Késett perc</th>
                                <th class="th-sm">Igazolva</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($missings as $item)
                            
                                <tr>
                                    <td>{{  $item->DateTime }}</td>
                                    <td>{{ $item->GetLesson->GetTeacher->FName." ".$item->GetLesson->GetTeacher->LName }}</td>
                                    <td>{{ $item->GetLesson->GetSubject->Name }}</td>
                                    <td>{{  $item->MissedMinute }} perc </td>
                                    
                                        
                                        @if ($item->GetVerificationType)
                                            <td>
                                                {{ $item->GetVerificationType->Name}}
                                            </td>
                                           
                                        @else
                                            <td>
                                                nincs még igazolva!
                                            </td>
                                        @endif
                                </tr>
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
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
