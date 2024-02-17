@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')
<i class="fa-solid fa-gavel"></i>
{{ __($exception->getMessage() ?: 'Forbidden') }}
<i class="fa-solid fa-face-kiss-beam"></i>
@endsection
