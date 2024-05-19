@extends('layout')

@section('navbar')
   

    <link rel="stylesheet" href="/css/jquery-calendar.min.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <link rel="stylesheet" href="/css/solid.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('userviews.admin.Navbar')
    
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
                    @include('calendar')
                    <h2 class="tm-block-title">Események</h2>
                    <button class="NewItemButton"  onclick="location.href = '/admin/ujesemeny';" >Új Esemény</button>
                    <button class="OtherFunctionButton rightspacer" id="alleventCalendar" >Összes a naptárba</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Intervallum</th>
                                <th class="th-sm">Rangoknak megjelenítve:</th>
                                <th class="th-sm">Szerkesztés</th>
                                <th class="th-sm">Törlés</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                          
                            @foreach ($events as $item)
                                <tr>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->Description }}</td>
                                    <td>{{ $item->StartDateTime." -> ".$item->EndDateTime }}</td>
                                    <td>
                                        @foreach (  $item->GetRoleTypes as $role)
                                            {{ $role->Name.", " }}
                                        @endforeach
                                    </td>
                                    <td> <div class="btnplacer"><button class="EditButton" onclick="location.href = '/admin/esemenymodositas/{{ $item->ID }}';" >Szerkesztés</button></div></td>
                                    <td><div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/admin/esemenytorles/{{ $item->ID }}';" >Törlés</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 2)
                    <h2 class="tm-block-title">Új esemény</h2>
                    <form id="ujFelh" class="formCenterContent" action="/admin/ujesemeny/" method="post">
                        @csrf
                        <div class="NewUser">
                            <div class="inputcolumn">
                                <label for="name">Név: </label>
                                <input type="text" class="textfield" id="name" name="name" value="" required>
                            </div>
                            <div class="inputcolumn">
                                <label for="desc">Leírás: </label>
                                <input type="text" class="textfield" id="desc" name="desc" value="" required>
                            </div> 
                            <div class="inputcolumn">
                                <label for="startDate">Kezdet:</label>
                                <input type="datetime-local" id="startDate" min="2000-06-07T00:00" max="2500-06-14T00:00" name="startDate" required/>
                            </div>
                            <div class="inputcolumn">
                                <label for="endDate">Vég:</label>
                                <input type="datetime-local" id="endDate" min="2000-06-07T00:00" max="2500-06-14T00:00" name="endDate" required/>
                            </div>
                            <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                <thead>
                                    <tr>
                                        <th class="th-sm">Rang neve</th>
                                        <th class="th-sm">Engedélyezés</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->Name }}</td>
                                            <td>
                                                <input type="checkbox" name="roleID_{{ $role->ID }}" id="roleID_{{ $role->ID }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="inputcolumn">
                                <label for="activated">Aktiválva: </label>
                                <td><input type="checkbox" name="activated" id="activated" class="textfield"></td>
                            </div>
                            <div class="inputcolumn">
                                <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                            </div>
                        </div>
                    </form>
                
                @endif

                @if ($status ==3)
                
                    <h2 class="tm-block-title">Esemény módosítása</h2>
                    <form id="ujFelh" class="formCenterContent" action="/admin/esemenymodositas/" method="post">
                        @csrf
                        <input type="hidden" name="eventID" id="eventID" value="{{ $event->ID }}">
                        <div class="NewUser">
                            <div class="inputcolumn">
                                <label for="name">Név: </label>
                                <input type="text" class="textfield" id="name" name="name" value="{{ $event->Name }}" required>
                            </div>
                            <div class="inputcolumn">
                                <label for="desc">Leírás: </label>
                                <input type="text" class="textfield" id="desc" name="desc" value="{{ $event->Description }}" required>
                            </div> 
                            <div class="inputcolumn">
                                <label for="startDate">Kezdet:</label>
                                <input type="datetime-local" id="startDate" min="2000-06-07T00:00" max="2500-06-14T00:00" name="startDate" value="{{ $event->StartDateTime }}" required/>
                            </div>
                            <div class="inputcolumn">
                                <label for="endDate">Vég:</label>
                                <input type="datetime-local" id="endDate" min="2000-06-07T00:00" max="2500-06-14T00:00" name="endDate" value="{{ $event->EndDateTime }}" required/>
                            </div>
                            <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                <thead>
                                    <tr>
                                        <th class="th-sm">Rang neve</th>
                                        <th class="th-sm">Engedélyezés</th>
                                    </tr>
                                </thead>
                                @php
                                    $selectedRoleIds = $event->GetRoleTypes->pluck('ID')->toArray();
                                   
                                @endphp
                                <tbody id="myTable">
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->Name }}</td>
                                            <td>
                                             
                                                <input type="checkbox" name="roleID_{{ $role->ID }}" id="roleID_{{ $role->ID }}" 
                                                        {{ in_array($role->ID, $selectedRoleIds) ? 'checked' : '' }}
                                                >
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="inputcolumn">
                                <label for="activated">Aktiválva: </label>
                                <td><input type="checkbox" name="activated" id="activated" class="textfield" {{ $event->Enabled ? 'checked' : '' }}></td>
                            </div>
                            <div class="inputcolumn">
                                <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/gorgeto.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/adminJS.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
    <script src="/js/jquery-calendar.min.js"></script>
    <script src="/js/jquery.touchSwipe.min.js"></script>
    <script src="/js/moment.withlocales.js"></script>
@endsection
