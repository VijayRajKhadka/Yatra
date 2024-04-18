@extends('layout/layout')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div>
        @if(session('success'))
        <div id="successAlert" class="alert alert-success" role="alert">
        {{ session('success') }}
        </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <h2>{{ $hists->name }}</h2>
            
            <form action="{{ route('updateHistoricalPlace', $hists->historical_place_id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <strong>Historical Place ID: </strong>
                    <input type="text" name="histsorical_place_id" value="{{ $hists->historical_place_id }}" readonly class="form-control">
                </div>

                <div class="col-md-6">
                    <strong>Historical Place Name: </strong>
                    <input type="text" name="name" value="{{ $hists->name }}" class="form-control">
                </div>
               
                <div class="col-md-6">
                    <strong>Description: </strong>
                    <textarea name="description" class="form-control">{{ $hists->description }}</textarea>
                </div>
                <div class="col-md-6">
                    <strong>Location:</strong>
                    <input type="text" name="location" value="{{ $hists->location }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Latitude: </strong>
                    <input type="text" name="latitude" value="{{ $hists->latitude }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Longitude: </strong>
                    <input type="text" name="longitude" value="{{ $hists->longitude }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Open Time: </strong>
                    <input type="text" name="open_time" value="{{ $hists->open_time }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Get There: </strong>
                    <input type="text" name="get_there" value="{{ $hists->get_there }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Ticket Price: </strong>
                    <input type="text" name="ticket_price" value="{{ $hists->ticket_price }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Contact No: </strong>
                    <input type="text" name="contact_no" value="{{ $hists->contact_no }}" class="form-control">
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-lg">Edit Changes</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <p>Created At: {{ $hists->created_at }}</p>
        <div id="imageSlider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($histsImages->first()->historical_place_image as $key => $image)
                <li data-target="#imageSlider" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($histsImages->first()->historical_place_image as $key => $image)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <img class="d-block w-100" src="{{ $image->historical_place_image_path }}" alt="Image {{ $key }}">
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#imageSlider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#imageSlider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="row">
    <div class="col-md-6">
    <form action="{{ route('addMonument') }}" method="POST" enctype="multipart/form-data" style="margin-top: 50px;">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Monument Name:</label>
                <input type="text" name="name"  class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="monument_imageUrl" class="form-label">Image of Monument:<span style="color: red;">*</span></label>
                <input type="file" class="form-control" id="monument_imageUrl" name="monument_imageUrl" onchange="previewImage(event, 'mapPreview')" required> 
            </div>
            <div class="mb-3">
                <input type="hidden" name="historical_place_id" value="{{ $hists->historical_place_id }}" class="form-control">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success btn-lg">ADD THIS MONUMENT</button>
            </div>
        </form>
    </div>

    <div class="col-md-6">
        <div class="mb-3", style="margin-top: 50px;">
            <label for="mapPreview" class="form-label">Preview:</label>
            <br/>
            <img id="mapPreview" src="#" alt="Map Preview" style="max-width: 50%; height: auto;">
        </div>
    </div>
</div>


@foreach($monu as $monument)

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
        <form id="updateForm" action="{{ route('updateMonument', $monument->monuments_id) }}" method="POST">

            <tr>
                <td>{{ $monument->monuments_id }}</td>
                <td><img src="{{$monument->monument_imageUrl}}" alt="Image" width="100" height="100"></td>
                <td>
                    <input class="form-control" type="text" name="name" value="{{ $monument->name }}">
                </td>
                <td>
                    <textarea class="form-control" name="description" rows="5">{{ $monument->description }}</textarea>
                </td>
                <td>{{ $monument->created_at->format('d M Y') }}</td>
                <td>{{ $monument->updated_at->format('d M Y') }}</td>
                <td>
                    @csrf
                    @method('PUT')
                    <button class="btn btn-outline-success" onclick="confirmEdit('{{ $monument->name }}', '{{ $monument->monuments_id}}')" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>Edit</button>
                    </form>
                    </td>
                    <td>
                    <form id='deleteMonu' action="{{ route( 'deleteMonument' , $monument->monuments_id) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('{{ $monument->name }}', '{{ $monument->monuments_id}}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            
        </tbody>
    </table>

@endforeach

</div>
<script>
    function previewImage(event, imageId) {
        const input = event.target;
        const image = document.getElementById(imageId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                image.src = e.target.result;
                image.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            image.src = "#";
            image.style.display = 'none';
        }
    }

    function confirmEdit(name, id) {
        if (window.confirm("Are you sure you want to edit " + name + " with ID " + id + "?")) {
            var form = document.getElementById('updateForm'); 
            form.submit(); 
        }
    }

    function confirmDelete(username, id) {
    if (window.confirm(username + " with id " + id + " will be deleted. ARE YOU SURE??")) {
        var form = document.getElementById('deleteMonu');
        form.submit();
    } 
}



    </script>
@endsection
