@extends('layout')

@section('navbar')
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
                    <h2 class="tm-block-title">Összes bannolt ID és IP</h2>
                    <button class="NewItemButton"  onclick="location.href = '/admin/ujkitiltas';" >Új kitiltás</button>
                    
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Kliens ID</th>
                                <th class="th-sm">Kliens IP</th>
                                <th class="th-sm">ID bannolva</th>
                                <th class="th-sm">IP bannolva</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $item['clientID'] }}</td>
                                    <td>{{ $item['clientIP'] }}</td>
                                    <td><input type="checkbox" banningid="{{ $item['ID'] }}" class="CHK_IDbanning"
                                        @if ( $item['UUIDBanned']==1)
                                            checked
                                            value=1
                                        @else
                                            value=0
                                        @endif
                                    ></td>
                                    <td><input type="checkbox" banningid="{{ $item['ID'] }}" class="CHK_IPbanning"
                                        @if ( $item['IPBanned']==1)
                                            checked
                                            value=1
                                        @else
                                            value=0
                                        @endif
                                    ></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button id="SaveBannBTN" class=" btn-success margined-send-btn">Mentés</button>
                @endif

                @if ($status == 2)
                    <h2 class="tm-block-title">Új kitiltás</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/admin/ujkitiltasmentes" method="post">
                            @csrf
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="UUIDtext">UUID: </label>
                                    <input type="text" class="textfield" id="UUIDtext" name="UUIDtext" placeholder="6c742b69-b4a3-42ab-8793-737f0b3e62ba" value="">
                                </div>

                                <div class="inputcolumn">
                                    <label for="UUIDchk">UUID bannnolva: </label>
                                    <td><input type="checkbox" name="UUIDchk" id="UUIDchk" class="textfield"></td>
                                </div>
                                <br>
                              
                                <div class="inputcolumn">
                                    <label for="IPtext">IP: </label>
                                    <input type="text" class="textfield" id="IPtext" name="IPtext" value="" placeholder="192.168.1.1">
                                </div>

                                <div class="inputcolumn">
                                    <label for="IPchk">UUID bannnolva: </label>
                                    <td><input type="checkbox" name="IPchk" id="IPchk" class="textfield"></td>
                                </div>

                                
                                <div class="inputcolumn">
                                    <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
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
