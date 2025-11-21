@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Visit ID</span>
            <input type="text" class="form-control visit_id" id="visit_id" placeholder="ch: VISIT0978674564" aria-label="Visit ID" aria-describedby="visible-addon" required>
        </div>

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
            <span class="input-group-text" style="width: 150px">Facility Code</span>
            <input type="text" class="form-control facility_code" id="facility_code" placeholder="ch: RS0082" aria-label="Facility Code" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Facility Name</span>
            <input type="text" class="form-control facility_name" id="facility_name" placeholder="ch: RS Siloam" aria-label="Facility Name" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Facility Type</span>
            <select class="form-select facility_type" aria-label="Facility Type" id="facility_type" required>
                <option value="1">RS [Rumah Sakit]</option>
                <option value="2">Puskesmas</option>
            </select>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Visit Date</span>
            <input type="date" class="form-control visit_date" id="visit_date" placeholder="ch: 1990-01-01" aria-label="Visit Date" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Visit Type</span>
            <select class="form-select visit_type" aria-label="Visit Type" id="visit_type" required>
                <option value="1">Inpatient [Rawat Inap]</option>
                <option value="2">Outpatient [Rawat Jalan]</option>
                <option value="3">Emergency [IGD]</option>
            </select>
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
            <span class="input-group-text" style="width: 150px">Doctor ID</span>
            <input type="text" class="form-control doctor_id" id="doctor_id" placeholder="ch: DR123456" aria-label="Doctor ID" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Doctor Name</span>
            <input type="text" class="form-control doctor_name" id="doctor_name" placeholder="ch: Dr. Smith" aria-label="Doctor Name" aria-describedby="visible-addon" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px; display: flex; flex-direction: column; justify-content: start; align-items: start">Notes</span>
            <textarea class="form-control notes" id="notes" placeholder="ch: Patient is recovering well." aria-label="Notes" aria-describedby="visible-addon" required></textarea>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <button class="btn btn-primary btn-record-visit" type="button">Record Visit</button>
            <button class="btn btn-secondary btn-patient-history" type="button">Patient History</button>
        </div>
    </div>
@endsection
