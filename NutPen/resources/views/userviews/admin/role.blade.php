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
                    <h2 class="tm-block-title">Rangok</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Rang módosítása</th>
                                <th class="th-sm">Felhasználók listázása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($roles as $item)
                                <tr>
                                    <td>{{ $item->Name }}</td>
                                    <?php
                                    ?>
                                    <td> <div class="btnplacer"><button class="EditButton" onclick="location.href = '/admin/rangmodositas/{{ $item->ID }}';" >Szerkesztés</button></div></td>
                                    <td> <div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/admin/felhasznalok/{{ strtolower(mb_substr($item->Name, 0, 1)) }}'" >Felhasználók listázása</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 2)
                    <h2 class="tm-block-title">Új Rang</h2>
                    
                        <form id="ujRang" class="formCenterContent" action="/admin/ujrangmentes" method="post">
                            @csrf
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="" required>
                                </div>

                                <div class="inputcolumn">
                                    <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                </div>
                            <div class="NewUser">
                        </form>
                    </div>
                @endif
                @if ($status ==3)
                    <h2 class="tm-block-title">Rang módosítása</h2>
                    
                        <form id="ujRang" class="formCenterContent" action="/admin/rangmodositas" method="post">
                            @csrf
                            <input type="hidden" name="classID" id="classID" value="{{ $role->ID }}">
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="{{ $role->Name }}" required>
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
