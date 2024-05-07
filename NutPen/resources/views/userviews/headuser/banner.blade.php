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
                    <h2 class="tm-block-title">Összes Bejelentkezés banner</h2>
                    <button class="NewItemButton"  onclick="location.href = '/fo/ujbanner';" >Új Banner</button>
                    
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">ID</th>
                                <th class="th-sm">Cím</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Aktiválva</th>
                                <th class="th-sm">Szerkesztés</th>
                                <th class="th-sm">Törlés</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                           
                            <tr>
                                <td>99999</td>
                                <td><strong>Kikapcsolva</strong></td>
                                <td></td>
                                <td><input type="radio" banningid=-1 class="CHK_bannerEN" name="banner_rad" checked></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach ($banners as $item)
                                <tr>
                                    <td>{{ $item->ID }}</td>
                                    <td>{{ $item->Header }}</td>
                                    <td>{{ $item->Description }}</td>
                                    <td><input type="radio" banningid="{{ $item->ID }}" class="CHK_bannerEN" name="banner_rad"
                                        @if ( $item->Enabled==1)
                                            checked
                                            value=1
                                        @else
                                            value=0
                                        @endif
                                    ></td>
                                    <td><div class="btnplacer"><button  class="EditButton" onclick="location.href = '/fo/bannermodositas/{{ $item->ID }}';" >Módosítás</button> </div></td>
                                    <td> <div class="btnplacer"><button class="RemoveButton" onclick="location.href = '/fo/bannertorles/{{ $item->ID }}';" >Törlés</button> </div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button id="SaveBannerHeadUserBTN" class=" btn-success margined-send-btn">Mentés</button>
                @endif

                @if ($status == 2)
                    <h2 class="tm-block-title">Új banner üzenet</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/fo/ujbannermentes" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="header">Cím </label>
                                    <input type="text" class="textfield" id="header" name="header" value="">
                                </div>

                                <div class="inputcolumn">
                                    <label for="desc">Leírás </label>
                                    <td><input type="text" name="desc" id="desc" class="textfield"></td>
                                </div>
                                <div class="inputcolumn">
                                    <label for="file_upload">Kép</label>
                                    <td><input type="file" name="file_upload" id="file_upload" accept="image/png, image/gif, image/jpeg"></td>
                                </div>
                                
                                <div class="inputcolumn">
                                    <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                </div>
                            <div class="NewUser">
                        </form>
                    </div>
                @endif
                @if ($status ==3)
                    <h2 class="tm-block-title">Banner üzenet módosítása</h2>
                    
                        <form id="ujRang" class="formCenterContent" action="/fo/bannermodositas" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="bannerID" id="bannerID" value="{{ $banner->ID }}">
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="header">Cím </label>
                                    <input type="text" class="textfield" id="header" name="header" value="{{ $banner->Header }}" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="desc">Leírás </label>
                                    <td><input type="text" name="desc" id="desc" class="textfield" value="{{ $banner->Description }}"></td>
                                </div>
                                <div class="inputcolumn">
                                    <label for="oriimg">Eredeti kép: </label>
                                    <img class='BannerIMG' src='{{ $file }}' id="oriimg", name="oriimg"></img>
                                </div>
                                <div class="inputcolumn">
                                    <label for="file_upload">Kép módosítása</label>
                                    <td><input type="file" name="file_upload" id="file_upload" accept="image/png, image/gif, image/jpeg"></td>
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
