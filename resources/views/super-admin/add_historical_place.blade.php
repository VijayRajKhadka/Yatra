@extends('layout/layout')

@section('content')

    <h2 class="mb-4">ADD A HISTORICAL PLACE</h2>
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{route('submitHistPlaceForm')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
               
                <div class="mb-3">
                    <label for="description" class="form-label">Description:<span style="color: red;">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>

                <div class="mb-3">
                    <label for="open_time" class="form-label">Open Time:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="open_time" name="open_time" required>
                </div>

                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="latitude" name="latitude" required>
                </div>

                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="longitude" name="longitude" required>
                </div>

                <div class="mb-3">
                    <label for="get_there" class="form-label">Get There:<span style="color: red;">*</span></label>
                    <textarea class="form-control" id="get_there" name="get_there" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="ticket_price" class="form-label">Ticket Price (for tourist):<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="ticket_price" name="ticket_price" required>
                </div>
                <div class="mb-3">
                    <label for="contact_no" class="form-label">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                </div>


                <button type="submit" class="btn btn-primary" style="width:540px; height:70px;">Submit</button>

            </div>
            <div class="col-md-6">

            <div class="mb-3">
                <label for="map_url" class="form-label">Map of Place :<span style="color: red;">*</span></label>
                <input type="file" class="form-control" id="map_url" name="map_url" accept=".jpg, .jpeg, .png" onchange="previewImage(event, 'mapPreview')" required> 
                <img id="mapPreview" src="#" alt="Map Preview" style="display: none; max-width: 50%; height: auto;">
            </div>


            <div class="mb-3">
                <label for="images" class="form-label">Choose Images of Place :<span style="color: red;">*</span></label>
                <input type="file" class="form-control" id="images" name="images[]" accept=".jpg, .jpeg, .png" multiple onchange="previewImages(event)" required> 
            </div>

            <div id="imagesPreview" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;"></div>




            </div>
        </div>
    </form>
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
    function previewImages(event) {
        const input = event.target;
        const container = document.getElementById('imagesPreview');

        container.innerHTML = '';

        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const image = document.createElement('img');
                    image.src = e.target.result;
                    image.style.width = '100%';
                    image.style.height = 'auto';
                    container.appendChild(image);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
    
    }


</script>

@endsection
