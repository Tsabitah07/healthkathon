<div class="d-flex flex-column m-0" style="width: 17vw; height: 100vh; border-right: #1a202c solid 1px; background: forestgreen; position: fixed;">
    <div style="height: 80vh">
        <div class="d-flex align-items-center pt-3 pb-2 mb-3 border-bottom">
            <img src="{{ asset('image/HealthLink.png') }}" alt="Healthkathon Logo" style="margin-left: 10px; height: 40px; width: 40px; padding: 0; object-fit: cover;">
            <a href="{{ route('home-after') }}" class="d-flex align-items-center text-decoration-none">
                <h5 class="fw-semibold ps-2 text-white">HEALTHKATHON</h5>
            </a>
        </div>

        <nav class="nav flex-column gap-1">
            <a class="nav-link fw-bold fs-5 text-white" href="{{ route('network-status') }}">Network Status</a>
            <a class="nav-link fw-bold fs-5 text-white" href="{{ route('card') }}">BPJS Card Test</a>
            <a class="nav-link fw-bold fs-5 text-white" href="{{ route('visit') }}">Visit</a>
            <a class="nav-link fw-bold fs-5 text-white" href="{{ route('claim') }}">Claim</a>
            <a class="nav-link fw-bold fs-5 text-white" href="{{ route('chaincode') }}">Chaincode</a>
            <a class="nav-link fw-bold fs-5 text-white" href="{{ route('debug-console') }}">Debug Console</a>
        </nav>
    </div>
    <div class="d-flex bg-transparent" style="height: 20%; justify-content: left; align-items: end">
        <form action="/logout" method="post" class="d-inline bg-transparent">
            @csrf
            @method('post')
            <button type="submit" onclick="return confirm('Are you sure you want to Logout')" class="bg-transparent border-0 text-white fw-bold fs-5 p-3">Logout</button>        </form>
    </div>
</div>

<style>
    .text-tosca { color: #20c997 !important; } /* adjust hex if you prefer a different tosca shade */
</style>
