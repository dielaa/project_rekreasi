@extends('templates.app')

@section('content')

    <div id="intro-example" class="p-5 text-center bg-image"
        style=" height: 80vh ; background-image: url('https://i.pinimg.com/1200x/83/8e/0a/838e0a376ba4993e4bb04793df05b1c9.jpg');">
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="d-flex justify-content-end align-items-center h-100">
                <div class="text-white text-start ms-5" style="padding-top: 150px; max-width: 800px;">
                    <h1 class="mb-3">Where Land Ends, the Wonder Begins</h1>
                    <p>
                        Step into Sea World Ancol and leave the surface behind.
                        Here, tunnels curve beneath swimming giants, pools invite your hands to meet the sea, and every
                        corner whispers stories from the deep.
                    </p>
                    <h5 class="mb-4"></h5>
                </div>
            </div>
        </div>
    </div>
        <div class="container mt-5">
        <h2 class="fw-bold">Facility</h2>
        <p class="text-muted">
            Discover our world class facilities and attractions beneath the sea. Dive into interactive experiences, meet fascinating marine life, and explore a magical underwater adventure.
        </p>
    </div>

    <div class="container my-5">
        <div class="row">
            @foreach($facilities as $facility)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $facility->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $facility->category ?? 'Facility' }}</h6>
                            <p class="card-text">{{ $facility->description }}</p>
                            @if($facility->link)
                                <a href="{{ $facility->link }}" class="card-link" target="_blank">Learn More</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


