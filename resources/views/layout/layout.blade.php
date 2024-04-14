<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/layout.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/467cba3d21.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


</head>

<body>
    <div class="sidebar">
        <ul class="main_sidebar">
            <li id="first_list_item">
                <button class="toggleSidebar">
                    <i class="fas fa-arrow-right fa-lg"></i>
                </button>
            </li>
            <li class="list_item">
                    <span class="list_item_sidebar">{{ auth()->user()->role === 1 ? 'Super Admin' : 'Admin' }},</span>
                    <span class="list_item_sidebar">{{ auth()->user()->name }}</span>
            </li>
            <li class="list_item">
                <a href="#" class="list_item_sidebar">
                    <i class="fas fa-chart-bar"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if(auth()->user()->role == 1)
            <li class="list_item">
                <a href="{{route('users')}}" class="list_item_sidebar">
                    <i class="fas fa-user"></i>
                    <span>Manage User</span>
                </a>
            </li>
            @endif

            <li class="list_item">
            <a href="#" class="list_item_sidebar toggle_submenu">
                <i class="fas fa-walking"></i>
                <span>Trek</span>
            </a>
            <ul class="submenu submenu_trek">
            <li class="list_item">
                <a href="{{ route('adminTrek', '0') }}" class="list_item_sidebar">
                <i class="fas fa-hourglass-start"></i>
                    <span>Pending</span>
                </a>
            </li>
            <li class="list_item">
                <a href="{{ route('adminTrek', '1') }}" class="list_item_sidebar">
                <i class="fas fa-check-circle"></i>
                    <span>Approved</span>
                </a>
            </li>
            </ul>
            </li>


            <li class="list_item">
                <a href="#" class="list_item_sidebar toggle_submenu">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Place</span>
                </a>
                <ul class="submenu submenu_trek">
                <li class="list_item">
                    <a href="{{ route('adminPlace', '0') }}" class="list_item_sidebar">
                    <i class="fas fa-hourglass-start"></i>
                        <span>Pending</span>
                    </a>
                </li>
                <li class="list_item">
                    <a href="{{ route('adminPlace', '1') }}" class="list_item_sidebar">
                    <i class="fas fa-check-circle"></i>
                        <span>Approved</span>
                    </a>
                </li>
                </ul>
            </li>
            <li class="list_item">
                <a href="#" class="list_item_sidebar toggle_submenu">
                    <i class="fas fa-store"></i>
                    <span>Restaurant</span>
                </a>
                <ul class="submenu submenu_trek">
                <li class="list_item">
                    <a href="{{ route('adminRestaurant', '0') }}" class="list_item_sidebar">
                    <i class="fas fa-hourglass-start"></i>
                        <span>Pending</span>
                    </a>
                </li>
                <li class="list_item">
                    <a href="{{ route('adminRestaurant', '1') }}" class="list_item_sidebar">
                    <i class="fas fa-check-circle"></i>
                        <span>Approved</span>
                    </a>
                </li>
                </ul>
            </li>
            <li class="list_item" id="last_list_item">
                <a href="/logout" class="list_item_sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                </svg>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content">
        @yield('content')
    </div>
    <script>
        var sidebarToggle = document.querySelector(".toggleSidebar");
        var sidebar = document.querySelector(".sidebar");

        sidebarToggle.addEventListener("click", function () {
            sidebarToggle.classList.toggle("flipandmove");
            sidebar.classList.toggle("active_sidebar");

            var submenus = document.querySelectorAll(".submenu");
            submenus.forEach(function (submenu) {
                submenu.classList.remove("show");
            });
        });





        document.addEventListener('DOMContentLoaded', function() {
            const toggleSubmenu = document.querySelectorAll('.toggle_submenu');

            // Add click event listener to each toggle_submenu element
            toggleSubmenu.forEach(function(item) {
                item.addEventListener('click', function() {
                    // Toggle the visibility of the next sibling submenu
                    const submenu = item.nextElementSibling;
                    submenu.classList.toggle('show');
                });
            });
        });

    </script>
</body>

</html>
