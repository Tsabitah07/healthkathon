@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div id="loading" class="d-none">
            <div class="d-flex align-items-center gap-2">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span>Processing...</span>
            </div>
        </div>

        <div id="alertContainer"></div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Visit ID</span>
            <input type="text" class="form-control" id="visit_id" placeholder="ch: VISIT0978674564" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Card ID</span>
            <input type="text" class="form-control" id="card_id" placeholder="ch: 0001-2345-6789-0000" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Patient ID</span>
            <input type="text" class="form-control" id="patient_id" placeholder="ch: P7486738" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Patient Name</span>
            <input type="text" class="form-control" id="patient_name" placeholder="ch: John Doe" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Facility Code</span>
            <input type="text" class="form-control" id="facility_code" placeholder="ch: RS0082" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Facility Name</span>
            <input type="text" class="form-control" id="facility_name" placeholder="ch: RS Siloam" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Facility Type</span>
            <select class="form-select" id="facility_type" required>
                <option value="1">RS [Rumah Sakit]</option>
                <option value="2">Puskesmas</option>
            </select>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Visit Date</span>
            <input type="date" class="form-control" id="visit_date" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Visit Type</span>
            <select class="form-select" id="visit_type" required>
                <option value="1">Inpatient [Rawat Inap]</option>
                <option value="2">Outpatient [Rawat Jalan]</option>
                <option value="3">Emergency [IGD]</option>
            </select>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Diagnosis</span>
            <input type="text" class="form-control" id="diagnosis" placeholder="ch: A00 Cholera" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Treatment</span>
            <textarea class="form-control" id="treatment" placeholder="ch: Paracetamol" required></textarea>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Doctor ID</span>
            <input type="text" class="form-control" id="doctor_id" placeholder="ch: DR123456" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Doctor Name</span>
            <input type="text" class="form-control" id="doctor_name" placeholder="ch: Dr. Smith" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Notes</span>
            <textarea class="form-control" id="notes" placeholder="ch: Patient is recovering well."></textarea>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <button class="btn btn-warning" type="button" id="btnGenerateSample">🎲 Generate Sample</button>
            <button class="btn btn-primary" type="button" id="btnRecordVisit">📝 Record Visit</button>
            <button class="btn btn-secondary" type="button" id="btnPatientHistory">📋 Patient History</button>
        </div>

        <div id="resultSection" class="d-none">
            <h5 class="fw-bold">Result</h5>
            <pre class="bg-dark text-white p-3" style="border-radius: 10px; overflow: auto;" id="resultBox"></pre>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        function showLoading(show) {
            document.getElementById('loading').classList.toggle('d-none', !show);
        }

        function showAlert(type, message) {
            const container = document.getElementById('alertContainer');
            container.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }

        function showResult(data) {
            document.getElementById('resultSection').classList.remove('d-none');
            document.getElementById('resultBox').textContent = JSON.stringify(data, null, 2);
        }

        function getFormData() {
            return {
                visit_id: document.getElementById('visit_id').value,
                card_id: document.getElementById('card_id').value,
                patient_id: document.getElementById('patient_id').value,
                patient_name: document.getElementById('patient_name').value,
                facility_code: document.getElementById('facility_code').value,
                facility_name: document.getElementById('facility_name').value,
                facility_type: document.getElementById('facility_type').value,
                visit_date: document.getElementById('visit_date').value,
                visit_type: document.getElementById('visit_type').value,
                diagnosis: document.getElementById('diagnosis').value,
                treatment: document.getElementById('treatment').value,
                doctor_id: document.getElementById('doctor_id').value,
                doctor_name: document.getElementById('doctor_name').value,
                notes: document.getElementById('notes').value,
            };
        }

        function setFormData(data) {
            Object.keys(data).forEach(key => {
                const el = document.getElementById(key);
                if (el) el.value = data[key];
            });
        }

        // Record Visit
        document.getElementById('btnRecordVisit').addEventListener('click', async () => {
            showLoading(true);
            const formData = getFormData();
            BPJSLogger.info('Recording patient visit...', formData);
            try {
                const response = await fetch('/api/visit/record', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(formData)
                });
                const data = await response.json();
                showResult(data);
                showAlert(data.success ? 'success' : 'danger', data.message);
                if (data.success) {
                    BPJSLogger.success('Visit recorded on blockchain!', data);
                } else {
                    BPJSLogger.error('Failed to record visit', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Record visit error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Patient History
        document.getElementById('btnPatientHistory').addEventListener('click', async () => {
            showLoading(true);
            const patientId = document.getElementById('patient_id').value;
            BPJSLogger.info(`Fetching visit history for patient: ${patientId}`);
            try {
                const response = await fetch('/api/visit/history', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ patient_id: patientId })
                });
                const data = await response.json();
                showResult(data);
                showAlert(data.success ? 'success' : 'danger', data.success ? 'History retrieved!' : data.message);
                if (data.success) {
                    BPJSLogger.success('Patient history retrieved!', data);
                } else {
                    BPJSLogger.error('Failed to get patient history', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Get patient history error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Generate Sample (no logging)
        document.getElementById('btnGenerateSample').addEventListener('click', async () => {
            try {
                const response = await fetch('/api/visit/sample');
                const data = await response.json();
                setFormData(data);
                showAlert('info', 'Sample data generated!');
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
            }
        });
    </script>
@endsection
