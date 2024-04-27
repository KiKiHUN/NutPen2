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
                
                @if ($status ==4)       <!--//Értékelések listázása a tanórában szereplő diákoknak osztályra szűrve-->
                    <h2 class="tm-block-title">{{ $student->LName." ".$student->FName }} értékelései</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Legutóbbi értékelés dátum</th>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Értékelések</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($combinedGrades as $oneGrade)
                            
                                <tr>
                                    <td>{{ $oneGrade["subjectName"] }}</td>
                                    <td>{{ $oneGrade["latestGrade"] }}</td>
                                    <td>{{ $oneGrade["teacherName"] }}</td>
                                    <td>
                                        @foreach ($oneGrade["grades"] as $grade)
                                        <span class="grade-button" onclick="showGradeDetails('{{ $grade['gradeName'] }}', '{{ $grade['gradeDateTime'] }}')">{{ $grade["gradeValue"] }}</span>
                                        @endforeach
                                    </td>
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
    <script>
        function showGradeDetails(gradeName, gradeDateTime) {
            alert(gradeName + " értékelést kapott ekkor:\n" + gradeDateTime);
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
