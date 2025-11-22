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

        <div>
            <h4 class="fw-bold">Function Selection</h4>
            <div class="input-group">
                <span class="input-group-text" style="width: 170px">Chaincode Function</span>
                <select class="form-select" id="selectedFunction">
                    @foreach($functions as $name => $info)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex flex-column gap-2 mt-3 p-3" style="width: 80vw; border: 1px solid #ccc; border-radius: 10px;" id="functionInfo">
                <p class="p-0 m-0 fw-bold">Function Info</p>
                <h5 class="m-0 p-0" id="funcDescription">-</h5>
                <p class="m-0 p-0 fw-semibold">Required Arguments:</p>
                <ul id="funcArgs"></ul>
            </div>
        </div>

        <div>
            <h4 class="fw-bold">Function Arguments [JSON Array]</h4>
            <textarea class="form-control bg-dark text-white font-monospace" id="argsInput" rows="6" placeholder='["arg1", "arg2", "arg3"]'></textarea>
            <button class="btn btn-warning mt-2" id="btnLoadExample">📝 Load Example Arguments</button>
        </div>

        <div>
            <h4 class="fw-bold">Actions</h4>
            <div class="d-flex flex-row justify-content-start align-items-center py-2 mb-2 gap-4">
                <button class="btn btn-success" id="btnInvoke">⚡ Invoke Function [Write]</button>
                <button class="btn btn-info" id="btnQuery">🔍 Query Response [Read]</button>
            </div>
        </div>

        <div id="resultSection" class="d-none">
            <h4 class="fw-bold">Chaincode Response</h4>
            <pre class="p-3 bg-dark text-white" style="width: 80vw; border-radius: 10px; overflow: auto;" id="resultBox"></pre>
        </div>

        <div>
            <h4 class="fw-bold">Available Functions Reference</h4>
            <div style="max-height: 300px; overflow-y: auto;">
                @foreach($functions as $name => $info)
                    <div class="p-3 mb-2" style="border: 1px solid #ccc; border-radius: 10px;">
                        <strong class="text-danger">{{ $name }}</strong>
                        <p class="text-muted mb-1">{{ $info['description'] }}</p>
                        <small class="text-primary">Args: {{ implode(', ', $info['args']) }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        const functions = @json($functions);

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

        function updateFunctionInfo() {
            const selected = document.getElementById('selectedFunction').value;
            const func = functions[selected];

            document.getElementById('funcDescription').textContent = func.description;

            const argsEl = document.getElementById('funcArgs');
            argsEl.innerHTML = '';
            func.args.forEach(arg => {
                argsEl.innerHTML += `<li>${arg}</li>`;
            });
        }

        // Update function info when selection changes
        document.getElementById('selectedFunction').addEventListener('change', updateFunctionInfo);

        // Load Example (no logging)
        document.getElementById('btnLoadExample').addEventListener('click', async () => {
            const selected = document.getElementById('selectedFunction').value;
            try {
                const response = await fetch(`/api/chaincode/example?function=${selected}`);
                const data = await response.json();
                if (data.success) {
                    document.getElementById('argsInput').value = data.example;
                    showAlert('info', 'Example arguments loaded!');
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
            }
        });

        // Invoke (Write)
        document.getElementById('btnInvoke').addEventListener('click', async () => {
            showLoading(true);
            const selectedFunction = document.getElementById('selectedFunction').value;
            const argsInput = document.getElementById('argsInput').value;

            BPJSLogger.info(`Invoking chaincode function: ${selectedFunction}`, {
                function: selectedFunction,
                args: argsInput
            });

            try {
                const response = await fetch('/api/chaincode/invoke', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({
                        function: selectedFunction,
                        args: argsInput
                    })
                });
                const data = await response.json();
                showResult(data);
                showAlert(data.success ? 'success' : 'danger', data.success ? 'Chaincode invocation successful!' : data.message);
                if (data.success) {
                    BPJSLogger.success('Chaincode invocation successful!', data);
                } else {
                    BPJSLogger.error('Chaincode invocation failed', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Chaincode invoke error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Query (Read)
        document.getElementById('btnQuery').addEventListener('click', async () => {
            showLoading(true);
            const selectedFunction = document.getElementById('selectedFunction').value;
            const argsInput = document.getElementById('argsInput').value;

            BPJSLogger.info(`Querying chaincode function: ${selectedFunction}`, {
                function: selectedFunction,
                args: argsInput
            });

            try {
                const response = await fetch('/api/chaincode/query', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({
                        function: selectedFunction,
                        args: argsInput
                    })
                });
                const data = await response.json();
                showResult(data);
                showAlert(data.success ? 'success' : 'danger', data.success ? 'Query successful!' : data.message);
                if (data.success) {
                    BPJSLogger.success('Chaincode query successful!', data);
                } else {
                    BPJSLogger.error('Chaincode query failed', data);
                }
            } catch (error) {
                showAlert('danger', 'Error: ' + error.message);
                BPJSLogger.error('Chaincode query error', { error: error.message });
            } finally {
                showLoading(false);
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', updateFunctionInfo);
    </script>
@endsection
