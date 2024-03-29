@extends('layouts.app')
@push("footer-scripts")
    <script>
        let reloadMinutes = 5;
        let reloadMS = reloadMinutes * 60 * 1000;
        $(document).ready(function () {
            setInterval(function () {
                location.reload();
            }, reloadMS);
        });
    </script>
@endpush
@section('title', 'Status Page')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <a href="{{ setting("url") }}" style="margin: auto; width: 80%; max-width: 200px; height: 80%; max-height: 200px">
                    <img src="{{ image_url(setting('logo')) }}" />
                </a>
            </div>
            <h1 class="text-center">Status Page</h1>
            <div class="mb-3">
                <h3 class="text-center">Current Network Status</h3>
            </div>
            <div class="row">
                @empty($checks)
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> There are no status checks yet.
                    </div>
                @else
                    @foreach($checks as $check)
                        @if ($check->is_enabled)
                            <div class="col-sm-6 col-lg-4">
                            @if ($check->status == 1)
                                <h2 style="border-radius: 0.3rem;" class="text-center bg-success">{{ $check->name }}</h2>
                                <p class="text-center">Status: Online</p>
                            @else
                                <h2 style="border-radius: 0.3rem;"  class="text-center bg-danger">{{ $check->name }}</h2>
                                <p class="text-center">Status: Offline</p>
                            @endif
                            </div>
                        @endif
                    @endforeach
                @endempty
            </div>
        </div>
    </div>
@endsection
