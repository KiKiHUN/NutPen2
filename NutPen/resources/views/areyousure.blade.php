@extends('layout')


@section('content')
    

    
    <div class="row tm-content-row">
        <input type="hidden" id="gotopage" name="gotopage" value="{{ $gotopage }}">
    </div>
@endsection

@section('script')
    <script>
        let link= $( "#gotopage" ).val();
        if ( confirm("Biztos vagy benne? Módosítások nem vonhatóak vissza.\nOK->folytatás vagy Mégsem->megszakít.") == true) {
            alert("Néhány percig is eltarthat, ne zárja be a weboldalt.");
            window.location.replace(link);
        } else {
            history.back();
        }
    </script>
@endsection