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
            <span class="input-group-text" style="width: 150px">Claim ID</span>
            <input type="text" class="form-control" id="claim_id" placeholder="ch: CLAIM1234567890" required>
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
            <span class="input-group-text" style="width: 150px">Card ID</span>
            <input type="text" class="form-control" id="card_id" placeholder="ch: 0001-2345-6789-0000" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Visit ID</span>
            <input type="text" class="form-control" id="visit_id" placeholder="ch: VISIT0978674564" required>
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
            <span class="input-group-text" style="width: 150px">Claim Type</span>
            <select class="form-select" id="claim_type" required>
                <option value="1">Inpatient [Rawat Inap]</option>
                <option value="2">Outpatient [Rawat Jalan]</option>
                <option value="3">Emergency [IGD]</option>
            </select>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Service Date</span>
            <input type="date" class="form-control" id="service_date" required>
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
            <span class="input-group-text" style="width: 150px">Total Amount</span>
            <input type="number" class="form-control" id="total_amount" placeholder="ch: 2000000" required>
        </div>

        <div class="input-group">
            <span class="input-group-text" style="width: 150px">Claim Amount</span>
            <input type="number" class="form-control" id="claim_amount" placeholder="ch: 1500000" required>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <button class="btn btn-warning" type="button" id="btnGenerateSample">🎲 Generate Sample</button>
            <button class="btn btn-secondary" type="button" id="btnGetPatientClaims">📋 Get Patient Claims</button>
            <button class="btn btn-success" type="button" id="btnProcessClaim">✅ Process Claim</button>
            <button class="btn btn-primary" type="button" id="btnSubmitClaim">📤 Submit Claim</button>
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
                claim_id: document.getElementById('claim_id').value,
                patient_id: document.getElementById('patient_id').value,
                patient_name: document.getElementById('patient_name').value,
                card_id: document.getElementById('card_id').value,
                visit_id: document.getElementById('visit_id').value,
                facility_code: document.getElementById('facility_code').value,
                facility_name: document.getElementById('facility_name').value,
                claim_type: document.getElementById('claim_type').value,
                service_date: document.getElementById('service_date').value,
                diagnosis: document.getElementById('diagnosis').value,
                treatment: document.getElementById('treatment').value,
                total_amount: parseFloat(document.getElementById('total_amount').value) || 0,
                claim_amount: parseFloat(document.getElementById('claim_amount').value) || 0,
            };
        }

        function setFormData(data) {
            Object.keys(data).forEach(key => {
                const el = document.getElementById(key);
                if (el) el.value = data[key];
            });
        }

        // Submit Claim
        document.getElementById('btnSubmitClaim').addEventListener('click', async () => {
            showLoading(true);
            const formData = getFormData();
            BPJSLogger.info('Submitting insurance claim...', formData);
            try {
                const response = await fetch('/api/claim/submit', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(formData)
                });
                const data = await response.json();
                showResult(data);
                showAlert(data.success ? 'success' : 'danger', data.message);
                if (data.success) {
                    BPJSLogger.success('Claim submitted to blockchain!', data);
                } else {
                    BPJSLogger.error('Failed to submit claim', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Submit claim error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Process Claim
        document.getElementById('btnProcessClaim').addEventListener('click', async () => {
            showLoading(true);
            const claimId = document.getElementById('claim_id').value;
            const claimAmount = parseFloat(document.getElementById('claim_amount').value) || 0;
            BPJSLogger.info(`Processing claim: ${claimId}`);
            try {
                const response = await fetch('/api/claim/process', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ claim_id: claimId, claim_amount: claimAmount })
                });
                const data = await response.json();
                showResult(data);
                const alertType = data.status === 'approved' ? 'success' : (data.status === 'rejected' ? 'warning' : 'info');
                showAlert(alertType, data.message);
                if (data.status === 'approved') {
                    BPJSLogger.success('Claim approved!', data);
                } else if (data.status === 'rejected') {
                    BPJSLogger.warning('Claim rejected', data);
                } else {
                    BPJSLogger.error('Failed to process claim', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Process claim error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Get Patient Claims
        document.getElementById('btnGetPatientClaims').addEventListener('click', async () => {
            showLoading(true);
            const patientId = document.getElementById('patient_id').value;
            BPJSLogger.info(`Fetching claims for patient: ${patientId}`);
            try {
                const response = await fetch('/api/claim/patient', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ patient_id: patientId })
                });
                const data = await response.json();
                showResult(data);
                showAlert(data.success ? 'success' : 'danger', data.success ? 'Claims retrieved!' : data.message);
                if (data.success) {
                    BPJSLogger.success('Patient claims retrieved!', data);
                } else {
                    BPJSLogger.error('Failed to get patient claims', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Get patient claims error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Generate Sample (no logging)
        document.getElementById('btnGenerateSample').addEventListener('click', async () => {
            try {
                const response = await fetch('/api/claim/sample');
                const data = await response.json();
                setFormData(data);
                showAlert('info', 'Sample data generated!');
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
            }
        });
    </script>
@endsection
