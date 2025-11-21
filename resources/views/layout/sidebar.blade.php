<div class="d-flex flex-column m-0" style="width: 17vw; height: 100vh; border-right: #1a202c solid 1px; background: forestgreen; position: fixed;">
    <div style="height: 80vh">
        <div class="d-flex align-items-center pt-3 pb-2 mb-3 border-bottom">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                <h3 class="fw-semibold ps-3 text-white">HEALTHKATHON</h3>
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
    <div style="display: flex; height: 20%; justify-content: left; align-items: end">
{{--        <form action="/auth/logout" method="post" class="d-inline">--}}
{{--            @csrf--}}
{{--            @method('post')--}}
{{--            <button onclick="return confirm('Are you sure you want to Logout')" style="text-decoration: none; font-size: large; font-weight: bold; margin-bottom: 7px; color: #ef4444; border: none; background: white">Logout</button>--}}
{{--        </form>--}}
    </div>
</div>

<style>
    .text-tosca { color: #20c997 !important; } /* adjust hex if you prefer a different tosca shade */
</style>
