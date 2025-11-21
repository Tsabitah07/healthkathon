<div class="position-relative">
    <img src="image/Daftar-BPJS-Kesehatan.jpg"
         class="img-fluid"
         alt="Banner"
         style="height:100vh; width: 100vw; object-fit: cover">

    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="z-index: 2; background: rgba(0, 0, 0, 0.55);">
        <p class="text-center mb-0 text-white">Welcome to</p>
        <h1 class="text-center m-0 text-white fw-bold">{{ $appName }}</h1>
        <p class="m-0 text-center text-white mb-3" style="width: 60vw">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <a href="{{ route('network-status') }}" class="btn btn-success me-3" style="width: 170px">Go To Dashboard</a>
    </div>
</div>
