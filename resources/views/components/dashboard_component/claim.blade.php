@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Claim ID</span>
            <input type="text" class="form-control claim_id" id="claim_id" placeholder="ch: CLAIM1234567890" aria-label="Claim ID" aria-describedby="visible-addon" required>
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
            <span class="input-group-text" style="width: 150px">Card ID</span>
            <input type="text" class="form-control card_id" id="card_id" placeholder="ch: 0001-2345-6789-0000" aria-label="Card ID" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Visit ID</span>
            <input type="text" class="form-control visit_id" id="visit_id" placeholder="ch: VISIT0978674564" aria-label="Visit ID" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Facility Code</span>
            <input type="text" class="form-control facility_code" id="facility_code" placeholder="ch: RS0082" aria-label="Facility Code" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Facility Name</span>
            <input type="text" class="form-control facility_name" id="facility_name" placeholder="ch: RS Siloam" aria-label="Facility Name" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Claim Type</span>
            <select class="form-select claim_type" aria-label="Claim Type" id="claim_type" required>
                <option value="1">Inpatient [Rawat Inap]</option>
                <option value="2">Outpatient [Rawat Jalan]</option>
                <option value="3">Emergency [IGD]</option>
            </select>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Service Date</span>
            <input type="date" class="form-control service_date" id="service_date" placeholder="ch: 1990-01-01" aria-label="Service Date" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Diagnosis</span>
            <input type="text" class="form-control diagnosis" id="diagnosis" placeholder="ch: A00 Cholera" aria-label="Diagnosis" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px; display: flex; flex-direction: column; justify-content: start; align-items: start">Treatment</span>
            <textarea class="form-control treatment" id="treatment" placeholder="ch: Paracetamol" aria-label="Treatment" aria-describedby="visible-addon" required></textarea>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Total Amount</span>
            <input type="number" class="form-control total_amount" id="total_amount" placeholder="ch: 2000000" aria-label="Total Amount" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Claim Amount</span>
            <input type="number" class="form-control claim_amount" id="claim_amount" placeholder="ch: 1500000" aria-label="Claim Amount" aria-describedby="visible-addon" required>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <button class="btn btn-secondary btn-get-patient-claims" type="button">Get Patient Claims</button>
            <button class="btn btn-success btn-process-claim" type="button">Process Claim</button>
            <button class="btn btn-primary btn-submit-claim" type="button">Submit Claim</button>
        </div>
    </div>
@endsection
