

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Login</title>
    
</head>
<body>
<div className="container" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <div>
            <img src="{{ asset('asset/images/logo.png') }}" className="login-logo-img" width="300px"/>
            <div className="login-header">
                @if($errors->any())
                @foreach($errors->all() as $error)
                    <p style="color:red;">{{ $error }}</p>
                @endforeach
                @endif

                @if(Session::has('error'))
                    <p style="color:red;">{{ Session::get('error') }}</p>
                @endif
            </div>
            
            <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group mb-3" style="width:300px;">
                <div class="input-group-prepend" >
                    <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                </svg></span>
                </div>
                <input type="email" class="form-control" name="email" placeholder="email" aria-describedby="basic-addon1" >
            </div>
            <div class="input-group mb-3" style="width:300px;">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                </svg></span>
                </div>
                <input type="password" class="form-control" name="password" placeholder="password" aria-describedby="basic-addon1">
            </div>

            <div class="d-grid gap-2 col-12 mx-auto">
            </div>
            <input class="btn btn-primary" type="submit" value="Login" style="width:300px;height:45px;">

            </div>
            </form>
        </div>
</body>
</html>