@extends('layout')

@section('header')
<link rel="stylesheet" href="/bootstrap-datetimepicker-4.17.47/css/bootstrap-datetimepicker.css">
@endsection

@section('navbar')

@endsection

@section('content')
<div class="container">
    <div class="row">
       <div class='col-sm-6'>
          <div class="form-group">
             <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
                </span>
             </div>
          </div>
       </div>
       <script type="text/javascript">
          $(function () {
              $('#datetimepicker2').datetimepicker({
                  locale: 'ru'
              });
          });
       </script>
    </div>
 </div>
                                      

@endsection


@section('script')
<script type="text/javascript" src="/bootstrap-datetimepicker-4.17.47/js/bootstrap-datetimepicker.min.js"></script>
@endsection