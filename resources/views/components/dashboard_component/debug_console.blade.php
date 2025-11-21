@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div class="d-flex flex-row justify-content-sm-between align-items-center gap-3">
            <div class="input-group has-validation w-75">
                <span class="input-group-text" style="width: 120px">Filter by Type</span>
                <select class="form-select claim_type" aria-label="Claim Type" id="claim_type" required>
                    <option value="0">All</option>
                    <option value="1">Success</option>
                    <option value="2">Errors</option>
                    <option value="3">Warning</option>
                    <option value="4">Info</option>
                </select>
            </div>

            <div class="d-flex flex-row gap-2 w-25">
                <button class="btn btn-primary w-50">Clear Console</button>
                <button class="btn btn-success w-50">Download Logs</button>
            </div>
        </div>

        <div class="d-flex flex-row justify-content-sm-between w-100">
            <div class="d-flex flex-column justify-content-center align-items-center" style="background: #20c997; width: 17vw; height: 110px; border-radius: 10px;">
                <h1 class="p-0 m-0">5</h1>
                <p class="p-0 m-0">Success</p>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center" style="background: #20c997; width: 17vw; height: 110px; border-radius: 10px;">
                <h1 class="p-0 m-0">5</h1>
                <p class="p-0 m-0">Success</p>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center" style="background: #20c997; width: 17vw; height: 110px; border-radius: 10px;">
                <h1 class="p-0 m-0">5</h1>
                <p class="p-0 m-0">Success</p>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center" style="background: #20c997; width: 17vw; height: 110px; border-radius: 10px;">
                <h1 class="p-0 m-0">5</h1>
                <p class="p-0 m-0">Success</p>
            </div>
        </div>

        <div class="d-flex flex-column gap-3 bg-dark" style="width: 100%; height: 400px; border: 1px solid #ccc; border-radius: 10px; padding: 10px;">
            <div class="d-flex flex-row justify-content-sm-between align-items-center p-2" style="width: 100%; border-bottom: 1px solid #ccc;">
                <div class="d-flex flex-row gap-2 align-items-center">
                    <div style="width: 20px; height: 20px; background-color: #28a745; border-radius: 50%;"></div>
                    <p class="p-0 m-0 fw-bold text-white">2024-01-01 12:00:00</p>
                </div>
            </div>
            <div class="d-flex flex-column overflow-y-scroll gap-3" style="width: 100%; height: 340px;">
                @foreach(range(1,10) as $i)
                    <div class="d-flex flex-row bg-light justify-content-sm-between p-2" style="width: 98%; border-radius: 10px">
                        <div class="w-50 d-flex flex-column justify-content-center align-items-start me-3">
                            <h5 class="p-0 m-0">Title</h5>
                            <p class="p-0 m-0">Description line 1</p>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center" style="background: #20c997; width: 150px; height: 35px; border-radius: 10px;">
                            <p class="p-0 m-0">Status</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
