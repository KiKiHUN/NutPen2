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
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll ">
                @if ($status==1)
                <h2 class="tm-block-title">Felhasználó típus választása</h2>
                    <div class="filderdiv">
                   
                    <button type="submit" class="adminfilterbtn" value="a">Admin</button>
                    <button type="submit" class="adminfilterbtn" value="t">Tanár</button>
                    <button type="submit" class="adminfilterbtn" value="s">Diák</button>
                    <button type="submit" class="adminfilterbtn" value="p">Szülő</button>
                    <button type="submit" class="adminfilterbtn" value="h">Fő emberek</button>
                    </div>
                @endif
               
                @if ($status == 0)
                    <h2 class="tm-block-title">Felhasználók</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Vnév</th>
                                <th class="th-sm">Knév</th>
                                <th class="th-sm">Módosítás</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $item->UserID }}</td>
                                    <td>{{ $item->fname }}</td>
                                    <td>{{ $item->lname }}</td>
                                    <td> <div class="btnplacer"><button class="EditButton" onclick="location.href = '/admin/felhasznalomodositas/{{ $item->UserID }}';" >Szerkesztés</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($status == 2)
                    <h2 class="tm-block-title">Új felhasználó</h2>
                    <p id="hiba" style="color: red"></p>
                        <form id="ujFelh" class="formCenterContent" action="/admin/ujfelhasznalomentes" method="post">
                            @csrf
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="fname">Vezetéknév: </label>
                                    <input type="text" class="textfield" id="fname" name="fname" value="" required>
                                </div>
                              
                                <div class="inputcolumn">
                                    <label for="lname">Keresztnév: </label>
                                    <input type="text" class="textfield" id="lname" name="lname" value="" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="role">Típus: </label>
                                    <select id="role" class="textfield" name="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->Name }}">{{ $role->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <label for="sextype">Nem: </label>
                                    <select id="sextype" class="textfield" name="sextype">
                                        @foreach ($sextypes as $sextype)
                                            <option value="{{ $sextype->ID }}">{{ $sextype->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <label for="email">Email: </label>
                                    <input type="email" class="textfield" id="email" name="email" value="" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="phone">Telefonszám: </label>
                                    <input type="text" class="textfield" id="phone" name="phone" value="" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="postalcode">Irányítószám</label>
                                    <input name="postalcode" type="number" class="textfield" id="postalcode"
                                        value="" required />
                                </div>

                                <div class="inputcolumn">
                                    <label for="fulladdress">Cím</label>
                                    <input name="fulladdress" type="text" class="textfield" id="fulladdress"
                                        value="" required />
                                </div>

                                <div class="inputcolumn">
                                    <label for="bday">Születési dátum</label>
                                    <input type="date" id="bday" class="textfield" value="2017-06-01" name="bday"/>
                                </div>

                                <div class="inputcolumn">
                                    <label for="pw">Jelszó: </label>
                                    <input type="password" class="textfield" id="pw" name="pw" value="" required>
                                </div>

                                <div id="additional-fields">


                                </div>

                                <div class="inputcolumn">
                                    <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                </div>
                            <div class="NewUser">
                        </form>
                    </div>
                @endif
                @if ($status == 3)
                    <h2 class="tm-block-title">Felhasználó módisítás</h2>
                    <div id="additional-attributes" data-attributes="{{ $aditionals }}"></div>
                        <form id="ujFelh" class="formCenterContent" action="/admin/felhasznalomodositas/mentes" method="post">
                            @csrf
                            <input type="hidden" name="UserID" id="UserID" value="{{ $user->UserID }}">
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="fname">Vezetéknév: </label>
                                    <input type="text" class="textfield" id="fname" name="fname" value="{{ $user->FName }}" required>
                                </div>
                              
                                <div class="inputcolumn">
                                    <label for="lname">Keresztnév: </label>
                                    <input type="text" class="textfield" id="lname" name="lname" value="{{ $user->LName }}" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="role">Típus: </label>
                                    <select id="role" class="textfield" name="role" disabled>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->ID }}" {{ $user->RoleTypeID == $role->ID ? 'selected' : '' }}>{{ $role->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <label for="sextype">Nem: </label>
                                    <select id="sextype" class="textfield" name="sextype">
                                        @foreach ($sextypes as $sextype)
                                            <option value="{{ $sextype->ID }}" {{ $user->SexTypeID == $sextype->ID ? 'selected' : '' }}>{{ $sextype->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <label for="email">Email: </label>
                                    <input type="email" class="textfield" id="email" name="email" value="{{ $user->Email }}" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="phone">Telefonszám: </label>
                                    <input type="text" class="textfield" id="phone" name="phone" value="{{ $user->Phone }}" required>
                                </div>


                                <div class="inputcolumn">
                                    <label for="pw">Jelszó: (üresen hagyva nem módosul)</label>
                                    <input type="password" class="textfield" id="pw" name="pw" value="">
                                </div>
                                
                                <div id="additional-fields">
                                    
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
    <script>
        document.getElementById('ujFelh').onsubmit = function() {
            if (document.getElementById('pw').value.length < 8) {
                document.getElementById('hiba').innerText = "A jelszónak legalább 8 karaktenek kell lennie";
                return false;
            } else {
                return true;
            }
            return false;
        };
    </script>
@endsection
