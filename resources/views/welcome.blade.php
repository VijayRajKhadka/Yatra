<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yatra</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assests/css/welcome.css') }}" />
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="backimage">
        <img src="{{ asset('assests/images/mountain.jpg') }}" class="backimage" alt="Background Image"/>
    </div>
    <div class="nav-container">
        <div class="header">
            <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-transparent">
                <div class="container-fluid justify-content-center">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/">_-Home-_</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">_-About-_</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">_-Blog-_</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">_-Contact-_</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="content-container">
        <div class="image-contaiter">
            <h1>YATRA</h1>
        </div>
        <div class="intro-content">
            <p>Your Ultimate Travel Partner to Nepal</p>
            <br/>
            <a href="/login" style="text-decoration:none; color:white;"><button class="login-btn">Login</button></a>&nbsp;&nbsp;
            <a href="/signup" style="text-decoration:none; color:white;"><button class="login-btn">Register</button></a>
            <br/>
            <br/>
            <br/>
            <br/>
            <p><-Explore-></p>
        </div>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <div class="container-one-container">
            <div class="container-one">
                <h1>What is Yatra ?</h1>
                <p>|</p>
                <p>Yatra is your friend to your new journey.<br/>
                    Yatra enables you to plan your trips and share your journey with other travellers.<br/>
                    It enables user to add Treks, Places and Restaurants.<br/>
                    Start growing your community by sharing.<br/>
                    Lets Start by adding your first journey!, <a href='/userDashboard' style="font-family:cursive; text-decoration:none;">Add Here</a>  </p>
                <p>|</p>
                <hr style="margin-left:100px; margin-right:100px;"/>
                <h1>What does Yatra Provide ?</h1>
            </div>  
        </div>
        <br/>
        <br/>
        <div class="container-two">
            <div class="container-two-image" style="margin-right:20px;">
            <img src="{{ asset('assests/images/trek.jpg') }}" width=550px, height=330px/>
            </div>
            <div class="container-two-text">
                <h1>Trek</h1>
                <br/>
                <p >Treking has been a best part for exploring Nepal. Yatra 
                    Trek provides you withall information for planning your next trip. Yatra is provides
                    mobile application for viewing all the information for the journey. Yatra also allows user
                    to add theirnew finding i.e. new trek routes to hidden green treasure of Nepal.</p>
            </div>
        </div>
        <br/>
        <br/>
        <hr style="margin-left:100px; margin-right:100px;"/>
        <br/>
        <div class="container-two">
            <div class="container-two-text" style="margin-right:20px;">
                <h1>Place</h1>
                <br/>
                <p style="margin-right:20px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
            <div class="container-three-image">
           <img src="{{ asset('assests/images/reflec.jpg') }}" width=550px, height=330px/>
            </div>
        </div>
        <br/>
        <br/>
        <hr style="margin-left:100px; margin-right:100px;"/>
        <br/>
    </div>
</body>
</html>
