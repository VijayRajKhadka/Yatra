@extends('layout/layout')

@section('content')

    <h2 class="mb-4">Events</h2>

    @if(session('success'))
    <div id="successAlert" class="alert alert-success" role="alert">
    {{ session('success') }}
    </div>
    @endif
    <script>
        setTimeout(function(){
            $('#successAlert').fadeOut('slow');
        }, 3000);

    

</script>
    <form method="post" action="{{ route('send.notification') }}">
        @csrf
        <div class="form-group">
        <input type="text" class="form-control" name="title" placeholder="Title for Notification" style="width:600px">
        </div>

        <input name="body" class="form-control" placeholder="Body for Notification" style="width:600px"></input>
        <br/>
        <button type="submit" class="btn btn-outline-success">Send Notification</button>
    </form>

@endsection
