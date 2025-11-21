@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div>
            <h4 class="fw-bold">Connection Status</h4>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex flex-row justify-content-sm-between align-items-center p-3" style="width: 80vw; height: 60px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">API Server</p>
                    <div class="rounded-5 d-flex justify-content-center align-items-center m-0 p-0" style="width: 250px; height: 35px; background-color: #d4edda;">
                        <p class="p-0 m-0">✅ Connected</p>
                    </div>
                </div>

                <div class="d-flex flex-row justify-content-sm-between align-items-center p-3" style="width: 80vw; height: 60px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">Blockchain Network</p>
                    <div class="rounded-5 d-flex justify-content-center align-items-center m-0 p-0" style="width: 250px; height: 35px; background-color: #d4edda;">
                        <p class="p-0 m-0">✅ Running</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h4 class="fw-bold">Network Component</h4>
            <div class="d-flex flex-row justify-content-sm-between">
                <div class="d-flex flex-column justify-content-center align-items-center p-3" style="width: 23vw; height: 115px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">API Server</p>
                    <div class="d-flex justify-content-center align-items-center m-0 p-0">
                        <h3 class="p-0 m-0">6</h3>
                        <h3 class="p-0 m-0">/</h3>
                        <h3 class="p-0 m-0">10</h3>
                    </div>
                </div>

                <div class="d-flex flex-column justify-content-center align-items-center p-3" style="width: 23vw; height: 115px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">Ordering Nodes</p>
                    <div class="d-flex justify-content-center align-items-center m-0 p-0">
                        <h3 class="p-0 m-0">6</h3>
                        <h3 class="p-0 m-0">/</h3>
                        <h3 class="p-0 m-0">10</h3>
                    </div>
                </div>

                <div class="d-flex flex-column justify-content-center align-items-center p-3" style="width: 23vw; height: 115px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">Channel</p>
                    <h3 class="p-0 m-0">3</h3>
                </div>
            </div>
        </div>

        <div>
            <h4 class="fw-bold">Organization</h4>

            <div class="d-flex flex-column gap-2">
                <div class="d-flex flex-row justify-content-sm-between align-items-center p-3" style="width: 80vw; height: 85px; border: 1px solid #ccc; border-radius: 10px;">
                    <div class="d-flex flex-column gap-1">
                        <p class="m-0 p-0 fs-5 fw-semibold">🏛️ BPJS</p>
                        <div class="d-flex flex-row align-items-center gap-2">
                            <p class="m-0 p-0 fs-6">Peers:</p>
                            <p class="p-0 m-0 fs-6">2</p>
                            <p class="p-0 m-0 fs-6"> | </p>
                            <p class="m-0 p-0 fs-6">MSP: BPJSMSP</p>
                        </div>
                    </div>

                    <div class="rounded-5 d-flex justify-content-center align-items-center m-0 p-0" style="width: 250px; height: 35px; background-color: #d4edda;">
                        <p class="p-0 m-0">Active</p>
                    </div>
                </div>

                <div class="d-flex flex-row justify-content-sm-between align-items-center p-3" style="width: 80vw; height: 85px; border: 1px solid #ccc; border-radius: 10px;">
                    <div class="d-flex flex-column gap-1">
                        <p class="m-0 p-0 fs-5 fw-semibold">🏪 Puskesmas</p>
                        <div class="d-flex flex-row align-items-center gap-2">
                            <p class="m-0 p-0 fs-6">Peers:</p>
                            <p class="p-0 m-0 fs-6">2</p>
                            <p class="p-0 m-0 fs-6"> | </p>
                            <p class="m-0 p-0 fs-6">MSP: PuskesmasMSP</p>
                        </div>
                    </div>

                    <div class="rounded-5 d-flex justify-content-center align-items-center m-0 p-0" style="width: 250px; height: 35px; background-color: #d4edda;">
                        <p class="p-0 m-0">Active</p>
                    </div>
                </div>

                <div class="d-flex flex-row justify-content-sm-between align-items-center p-3" style="width: 80vw; height: 85px; border: 1px solid #ccc; border-radius: 10px;">
                    <div class="d-flex flex-column gap-1">
                        <p class="m-0 p-0 fs-5 fw-semibold">🏥 Rumah Sakit</p>
                        <div class="d-flex flex-row align-items-center gap-2">
                            <p class="m-0 p-0 fs-6">Peers:</p>
                            <p class="p-0 m-0 fs-6">2</p>
                            <p class="p-0 m-0 fs-6"> | </p>
                            <p class="m-0 p-0 fs-6">MSP: RumahSakitMSP</p>
                        </div>
                    </div>

                    <div class="rounded-5 d-flex justify-content-center align-items-center m-0 p-0" style="width: 250px; height: 35px; background-color: #d4edda;">
                        <p class="p-0 m-0">Active</p>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-success btn-refresh w-25">Refresh</button>

        <div class="border-top pt-4">
            <h4 class="fw-bold">System Information</h4>

            <pre class="bg-dark text-white p-2" style="border-radius: 10px; overflow-x: auto;">
                OS: Ubuntu 20.04.6 LTS
                OS: Ubuntu 20.04.6 LTS</pre>
        </div>
    </div>
@endsection
