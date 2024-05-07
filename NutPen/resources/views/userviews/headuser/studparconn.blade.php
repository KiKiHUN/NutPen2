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
                @if ($status == 0)
                    <h2 class="tm-block-title">Diák-szülő kapcsolatok</h2>
                    <button class="NewItemButton" onclick="location.href = '/fo/kapcsolat/ujszulodiak';" >Hozzáadás</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Diák azonosító</th>
                                <th class="th-sm">Diák név</th>
                                <th class="th-sm">Szülő azonosító</th>
                                <th class="th-sm">Szülő név</th>
                                <th class="th-sm">kapcsolat törlése</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($conns as $item)
                                <tr>
                                    <td>{{ $item->StudentID }}</td>
                                    <td>{{ $item->GetStudent->FName." ".$item->GetStudent->LName }}</td>
                                    <td>{{ $item->ParentID }}</td>
                                    <td>{{ $item->GetParent->FName." ".$item->GetParent->LName }}</td>
                                    <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/fo/kapcsolat/szulodiaktorles/{{ $item->StudentID }}/{{ $item->ParentID }}';" >Törlés</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 2)
                    <h2 class="tm-block-title">Új diák-szülő kapcsolat</h2>
                    
                        <form id="ujRang" class="formCenterContent" action="/fo/kapcsolat/ujszulodiakmentes" method="post">
                            @csrf
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="studentID">Diák: </label>
                                    <select id="studentID" class="textfield" name="studentID">
                                        @foreach ($students as $student)
                                            <option value="{{ $student->UserID }}">{{ $student->FName." ".$student->LName.", ID: ".$student->UserID }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="inputcolumn">
                                    <label for="parentID">Szülő: </label>
                                    <select id="parentID" class="textfield" name="parentID">
                                        @foreach ($parents as $student)
                                            <option value="{{ $student->UserID }}">{{ $student->FName." ".$student->LName.", ID: ".$student->UserID }}</option>
                                        @endforeach
                                    </select>
                                    <div class="inputcolumn">
                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                    </div>
                                </div>
                            <div class="NewUser">
                        </form>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
@endsection
