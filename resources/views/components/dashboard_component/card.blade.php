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

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Card ID</span>
            <input type="text" class="form-control" id="card_id" placeholder="ch: 0001-2345-6789-0000" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Patient ID</span>
            <input type="text" class="form-control" id="patient_id" placeholder="ch: P7486738" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Patient Name</span>
            <input type="text" class="form-control" id="patient_name" placeholder="ch: John Doe" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">NIK [National ID]</span>
            <input type="text" class="form-control" id="nik" placeholder="ch: 1234567890123456" maxlength="16" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Birth Date</span>
            <input type="date" class="form-control" id="birth_date" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Gender</span>
            <select class="form-select" id="gender" required>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Address</span>
            <textarea class="form-control" id="address" placeholder="ch: 123 Main St, City, Country" required></textarea>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Card Type</span>
            <select class="form-select" id="card_type" required>
                <option value="1">PBI [Penerima Bantuan Iuran]</option>
                <option value="2">Non-PBI</option>
            </select>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Issue Date</span>
            <input type="date" class="form-control" id="issue_date" required>
        </div>

        <div class="input-group has-validation">
            <span class="input-group-text" style="width: 150px">Expiry Date</span>
            <input type="date" class="form-control" id="expiry_date" required>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <button class="btn btn-warning" type="button" id="btnGenerateSample">🎲 Generate Sample</button>
            <button class="btn btn-danger" type="button" id="btnIssueCard">✅ Issue Card</button>
            <button class="btn btn-primary" type="button" id="btnVerifyCard">🔍 Verify Card</button>
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
                card_id: document.getElementById('card_id').value,
                patient_id: document.getElementById('patient_id').value,
                patient_name: document.getElementById('patient_name').value,
                nik: document.getElementById('nik').value,
                birth_date: document.getElementById('birth_date').value,
                gender: document.getElementById('gender').value,
                address: document.getElementById('address').value,
                card_type: document.getElementById('card_type').value,
                issue_date: document.getElementById('issue_date').value,
                expiry_date: document.getElementById('expiry_date').value,
            };
        }

        function setFormData(data) {
            Object.keys(data).forEach(key => {
                const el = document.getElementById(key);
                if (el) el.value = data[key];
            });
        }

        // Issue Card
        document.getElementById('btnIssueCard').addEventListener('click', async () => {
            showLoading(true);
            const formData = getFormData();
            BPJSLogger.info('Issuing BPJS card...', formData);
            try {
                const response = await fetch('/api/card/issue', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(formData)
                });
                const data = await response.json();
                showResult(data);
                showAlert(data.success ? 'success' : 'danger', data.message);
                if (data.success) {
                    BPJSLogger.success('Card issued successfully!', data);
                } else {
                    BPJSLogger.error('Failed to issue card', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Card issue error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Verify Card
        document.getElementById('btnVerifyCard').addEventListener('click', async () => {
            showLoading(true);
            const cardId = document.getElementById('card_id').value;
            BPJSLogger.info(`Verifying card: ${cardId}`);
            try {
                const response = await fetch('/api/card/verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ card_id: cardId })
                });
                const data = await response.json();
                showResult(data);
                showAlert(data.success ? 'success' : 'danger', data.message);
                if (data.success) {
                    BPJSLogger.success('Card verified successfully!', data);
                } else {
                    BPJSLogger.error('Failed to verify card', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Card verify error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Generate Sample Data (no logging)
        document.getElementById('btnGenerateSample').addEventListener('click', async () => {
            try {
                const response = await fetch('/api/card/sample');
                const data = await response.json();
                setFormData(data);
                showAlert('info', 'Sample data generated!');
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
            }
        });
    </script>
@endsection
