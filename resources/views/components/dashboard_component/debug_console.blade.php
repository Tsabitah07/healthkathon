@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div class="d-flex flex-row justify-content-between align-items-center gap-3">
            <div class="input-group w-50">
                <span class="input-group-text" style="width: 120px">Filter by Type</span>
                <select class="form-select" id="filterType">
                    <option value="all">All</option>
                    <option value="success">Success</option>
                    <option value="error">Error</option>
                    <option value="warning">Warning</option>
                    <option value="info">Info</option>
                </select>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="autoScroll" checked>
                <label class="form-check-label" for="autoScroll">Auto Scroll</label>
            </div>

            <div class="d-flex flex-row gap-2">
                <button class="btn btn-danger" id="btnClearLogs">🗑️ Clear Logs</button>
                <button class="btn btn-success" id="btnDownloadLogs">💾 Download Logs</button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="d-flex flex-row justify-content-between w-100">
            <div class="d-flex flex-column justify-content-center align-items-center" id="statSuccess" style="background: #20c997; width: 17vw; height: 110px; border-radius: 10px;">
                <h1 class="p-0 m-0" id="countSuccess">0</h1>
                <p class="p-0 m-0">Success</p>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center" id="statError" style="background: #dc3545; color: white; width: 17vw; height: 110px; border-radius: 10px;">
                <h1 class="p-0 m-0" id="countError">0</h1>
                <p class="p-0 m-0">Errors</p>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center" id="statWarning" style="background: #ffc107; width: 17vw; height: 110px; border-radius: 10px;">
                <h1 class="p-0 m-0" id="countWarning">0</h1>
                <p class="p-0 m-0">Warnings</p>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center" id="statInfo" style="background: #0dcaf0; width: 17vw; height: 110px; border-radius: 10px;">
                <h1 class="p-0 m-0" id="countInfo">0</h1>
                <p class="p-0 m-0">Info</p>
            </div>
        </div>

        <!-- Log Container -->
        <div class="d-flex flex-column gap-3 bg-dark p-3" style="width: 100%; min-height: 400px; max-height: 500px; border-radius: 10px; overflow-y: auto;" id="logContainer">
            <div class="text-center text-muted py-5" id="emptyState">
                <p class="text-white">📝 No logs to display. Logs from other pages will appear here.</p>
            </div>
        </div>

        <!-- Info -->
        <div class="alert alert-info">
            <h5>Debug Console Info</h5>
            <ul class="mb-0">
                <li>Logs are stored in browser's localStorage</li>
                <li>Use filters to view specific log types</li>
                <li>Click on a log to see full details</li>
                <li>Auto-scroll keeps the latest logs visible</li>
                <li>Download logs for offline analysis</li>
            </ul>
        </div>
    </div>

    <script>
        // Global log storage using localStorage
        const STORAGE_KEY = 'bpjs_blockchain_logs';

        function getLogs() {
            const stored = localStorage.getItem(STORAGE_KEY);
            return stored ? JSON.parse(stored) : [];
        }

        function saveLogs(logs) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(logs.slice(-100))); // Keep last 100
        }

        function addLog(type, message, data = null) {
            const logs = getLogs();
            logs.push({
                id: Date.now(),
                type,
                message,
                data,
                timestamp: new Date().toISOString()
            });
            saveLogs(logs);
            renderLogs();
        }

        // Make addLog available globally
        window.addLog = addLog;

        function getLogColor(type) {
            const colors = {
                success: '#20c997',
                error: '#dc3545',
                warning: '#ffc107',
                info: '#0dcaf0'
            };
            return colors[type] || '#6c757d';
        }

        function getLogIcon(type) {
            const icons = {
                success: '✅',
                error: '❌',
                warning: '⚠️',
                info: 'ℹ️'
            };
            return icons[type] || '📝';
        }

        function renderLogs() {
            const logs = getLogs();
            const filter = document.getElementById('filterType').value;
            const container = document.getElementById('logContainer');
            const emptyState = document.getElementById('emptyState');

            const filteredLogs = filter === 'all'
                ? logs
                : logs.filter(l => l.type === filter);

            document.getElementById('countSuccess').textContent = logs.filter(l => l.type === 'success').length;
            document.getElementById('countError').textContent = logs.filter(l => l.type === 'error').length;
            document.getElementById('countWarning').textContent = logs.filter(l => l.type === 'warning').length;
            document.getElementById('countInfo').textContent = logs.filter(l => l.type === 'info').length;

            container.innerHTML = [...filteredLogs].reverse().map(log => `
                <div class="d-flex flex-row bg-light justify-content-between p-3"
                     style="border-radius: 10px; border-left: 4px solid ${getLogColor(log.type)};">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span>${getLogIcon(log.type)}</span>
                            <span class="badge" style="background-color: ${getLogColor(log.type)}">
                                ${log.type.toUpperCase()}
                            </span>
                            <small class="text-muted">${new Date(log.timestamp).toLocaleString()}</small>
                        </div>
                        <p class="mb-0">${log.message}</p>
                        ${log.data ? `
                            <details class="mt-2">
                                <summary class="text-primary" style="cursor: pointer;">Show Data</summary>
                                <pre class="bg-dark text-white p-2 mt-2" style="border-radius: 5px; font-size: 0.85rem; max-height: 200px; overflow: auto;">
                                    ${JSON.stringify(log.data, null, 2)}
                                </pre>
                            </details>
                        ` : ''}
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" onclick="copyLog(${log.id})">📋</button>
                </div>
            `).join('');

        }

        function copyLog(logId) {
            const logs = getLogs();
            const log = logs.find(l => l.id === logId);
            if (log) {
                navigator.clipboard.writeText(JSON.stringify(log, null, 2));
                alert('Log copied to clipboard!');
            }
        }

        // Clear Logs
        document.getElementById('btnClearLogs').addEventListener('click', () => {
            if (confirm('Are you sure you want to clear all logs?')) {
                localStorage.removeItem(STORAGE_KEY);
                renderLogs();
            }
        });

        // Download Logs
        document.getElementById('btnDownloadLogs').addEventListener('click', () => {
            const logs = getLogs();
            const blob = new Blob([JSON.stringify(logs, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `bpjs-blockchain-logs-${new Date().toISOString().slice(0, 19).replace(/:/g, '-')}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });

        // Filter change
        document.getElementById('filterType').addEventListener('change', renderLogs);

        // Initialize
        document.addEventListener('DOMContentLoaded', renderLogs);

        // Listen for storage changes from other tabs/pages
        window.addEventListener('storage', (e) => {
            if (e.key === STORAGE_KEY) {
                renderLogs();
            }
        });

        // Refresh logs periodically
        setInterval(renderLogs, 2000);
    </script>
@endsection
