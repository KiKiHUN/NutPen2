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
                                <th class="th-sm">Felhasználók listázása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($roles as $item)
                                <tr>
                                    <td>{{ $item->Name }}</td>
                                    <?php
                                        $out="";
                                        switch(strtolower(mb_substr($item->Name, 0, 1)))
                                        {
                                            case("d"):
                                                $out="s";
                                                break;
                                            case("s"):
                                                $out="p";
                                                break;
                                            case("f"):
                                                $out="h";
                                                break;
                                            case("t"):
                                                $out="t";
                                                break;
                                            case("a"):
                                                $out="a";
                                                break;
                                         
                                        }
                                       
                                                
                                    ?>
                                    <td> <div class="btnplacer"><button class="OtherFunctionButton" onclick="location.href = '/fo/felhasznalok/{{  $out }}'" >Felhasználók listázása</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
