@extends('layout')

@section('navbar')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('userviews.student.Navbar')
    
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <p class="text-white mt-5 mb-5">Hello, <b>{{ $user->FName }}</b></p>
            <input type="hidden" id="UserID" value="{{ $user->UserID }}">
        </div>
    </div>
    <!-- row -->
   
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <div class="tm-bg-primary-dark tm-block">
                <h2 class="tm-block-title">Értesítések</h2>
                <div class="MainWarnings">
                    @if ($newwarnings)
                        @foreach ( $newwarnings as $warning)
                            <h5>Figyelmzettése van {{ $warning["whogavename"] }}({{ $warning["whogaveID"] }}) dolgozótól! : {{ $warning["name"] }}</h5>
                        @endforeach
                    @endif
                </div> 
                <div class="MainGrades">
                    @if ($newratings)
                        @foreach ( $newratings as $rating)
                            <h5>Értékelése van {{ $rating->GetLesson->GetSubject->Name }} tárgyból! : {{ $rating->GetGradeType->Name }}</h5>
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

@endsection