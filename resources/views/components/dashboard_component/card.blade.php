@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Card ID</span>
            <input type="text" class="form-control card_id" id="card_id" placeholder="ch: 0001-2345-6789-0000" aria-label="Card ID" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Patient ID</span>
            <input type="text" class="form-control patient_id" id="patient_id" placeholder="ch: P7486738" aria-label="Patient ID" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Patient Name</span>
            <input type="text" class="form-control patient_name" id="patient_name" placeholder="ch: John Doe" aria-label="Patient Name" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">NIK [National ID]</span>
            <input type="text" class="form-control nik" id="nik" placeholder="ch: 1234567890123456" aria-label="NIK" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Birth Date</span>
            <input type="date" class="form-control birth_date" id="birth_date" placeholder="ch: 1990-01-01" aria-label="Birth Date" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Gender</span>
            <select class="form-select gender" aria-label="Gender" id="gender" required>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px; display: flex; flex-direction: column; justify-content: start; align-items: start">Address</span>
            <textarea class="form-control address" id="address" placeholder="ch: 123 Main St, City, Country" aria-label="Address" aria-describedby="visible-addon" required></textarea>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Card Type</span>
            <select class="form-select card_type" aria-label="Card Type" id="card_type" required>
                <option value="1">PBI [Penerima Bantuan Iuran]</option>
                <option value="2">Non-PBI</option>
            </select>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Issue Date</span>
            <input type="date" class="form-control issue_date" id="issue_date" placeholder="ch: 2025-12-31" aria-label="Issue Date" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Expiry Date</span>
            <input type="date" class="form-control expiry_date" id="expiry_date" placeholder="ch: 2026-12-31" aria-label="Expiry Date" aria-describedby="visible-addon" required>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <button class="btn btn-danger btn-issue-card" type="button">Issue Card</button>
            <button class="btn btn-primary btn-verify-card" type="button">Verify Card</button>
        </div>
    </div>
@endsection
