<div class="position-relative">
    <img src="{{ asset('image/Daftar-BPJS-Kesehatan.jpg') }}"
         class="img-fluid"
         alt="Banner"
         style="height:100vh; width: 100vw; object-fit: cover">

    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="z-index: 2; background: rgba(0, 0, 0, 0.65);">
        <p class="text-center mb-0 text-white">Welcome to</p>
        <h1 class="text-center m-0 text-9xl text-white fw-bold">{{ $appName }}</h1>
        <p class="m-0 text-center text-white mb-3" style="width: 60vw">
            HealthLink adalah platform yang memanfaatkan teknologi blockchain untuk merevolusi layanan kesehatan. Misi kami adalah menyediakan akses data dan layanan kesehatan yang aman, transparan, dan efisien bagi semua orang. Dengan HealthLink, pasien, penyedia layanan, dan perusahaan asuransi dapat terhubung dan berbagi informasi secara mulus, sehingga koordinasi perawatan lebih baik dan hasil kesehatan meningkat.
        </p>
        <a href="{{ route('login') }}" class="btn btn-success me-3" style="width: 170px">Go To Dashboard</a>
    </div>
</div>
