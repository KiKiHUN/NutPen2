@extends('layout')

@section('navbar')
   
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
                @if ($status == 0)    <!--//tanórák-->
                    <h2 class="tm-block-title">Diákjaim</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Értékelések</th>
                                <th class="th-sm">Figyelmeztetések</th>
                                <th class="th-sm">Késések/hiányzások</th>
                                <th class="th-sm">Tanórák</th>
                                <th class="th-sm">Házifeladatok</th>
                                <th class="th-sm">Naptár</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                           
                            @foreach ($students as $item)
                                <tr>
                                    <td>{{ $item->GetStudent->FName." ".$item->GetStudent->LName }}</td>
                                    <td>{{ $item->StudentID}}</td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/szulo/ertekelesek/{{ $item->StudentID }}';" >Értékelések</button></div></td>
                                    <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/szulo/figyelmeztetesek/{{ $item->StudentID }}';" >Figyelmeztetések</button></div></td>
                                    <td><div class="btnplacer"><button class="DownloadButton" onclick="location.href = '/szulo/kesesek/{{ $item->StudentID }}';" >Késések</button></div></td>
                                    <td><div class="btnplacer"><button class="EditButton" onclick="location.href = '/szulo/tanorak/{{ $item->StudentID }}';" >Tanórák</button></div></td>
                                    <td><div class="btnplacer"><button class="EditButton" onclick="location.href = '/szulo/hazifeladatok/{{ $item->StudentID }}';" >Házifeladatok</button></div></td>
                                    <td><div class="btnplacer"><button class="OtherFunctionButton calendarStudFiltbutton" value="{{ $item->StudentID }}" >Saját naptár</button></div></td>
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
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
 
@endsection
