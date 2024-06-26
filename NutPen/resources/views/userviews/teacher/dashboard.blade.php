@extends('layout')

@section('navbar')
   
    @include('userviews.teacher.Navbar')
    
@endsection

@section('content')
   
    <div class="row">
        <div class="col">
            <p class="text-white mt-5 mb-5">Hello, <b>{{ $user->LName }}</b></p>
            <input type="hidden" id="UserID" value="{{ $user->UserID }}">
        </div>
    </div>
    <!-- row -->
   
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <div class="tm-bg-primary-dark tm-block">
                <h2 class="tm-block-title">Értesítések</h2>
                <div class="MainGrades">
                    @if ($newhomeworks)
                        @foreach ( $newhomeworks as $newhomework)
                            @if ($newhomework->get_submitted_home_works_count>0)
                                <h5>{{  $newhomework->Name }} házifeladatot {{ $newhomework->get_submitted_home_works_count }} diák adta be a héten!</h5>
                            @endif
                           
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        
        @include('message')

      
    </div>
    </div>
@endsection

@section("script")
   
    <script src="/js/msgModal.js"></script>

    <script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>

@endsection