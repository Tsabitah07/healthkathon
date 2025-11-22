@extends('layout.base')
@section('container')
    <div class="d-flex flex-column gap-4 p-4" style="width: 80vw; margin-left: 17vw; margin-top: 70px">
        <div id="loading" class="d-none">
            <div class="d-flex align-items-center gap-2">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span>Checking network status...</span>
            </div>
        </div>

        <div>
            <h4 class="fw-bold">Connection Status</h4>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex flex-row justify-content-between align-items-center p-3" style="width: 80vw; height: 60px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">API Server</p>
                    <div id="apiStatus" class="rounded-5 d-flex justify-content-center align-items-center m-0 p-0" style="width: 250px; height: 35px; background-color: #f8d7da;">
                        <p class="p-0 m-0">⏳ Checking...</p>
                    </div>
                </div>

                <div class="d-flex flex-row justify-content-between align-items-center p-3" style="width: 80vw; height: 60px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">Blockchain Network</p>
                    <div id="blockchainStatus" class="rounded-5 d-flex justify-content-center align-items-center m-0 p-0" style="width: 250px; height: 35px; background-color: #f8d7da;">
                        <p class="p-0 m-0">⏳ Checking...</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h4 class="fw-bold">Network Component</h4>
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column justify-content-center align-items-center p-3" style="width: 23vw; height: 115px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">Active Peers</p>
                    <div class="d-flex justify-content-center align-items-center m-0 p-0">
                        <h3 class="p-0 m-0" id="peersCount">-</h3>
                        <h3 class="p-0 m-0">/</h3>
                        <h3 class="p-0 m-0">6</h3>
                    </div>
                </div>

                <div class="d-flex flex-column justify-content-center align-items-center p-3" style="width: 23vw; height: 115px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">Ordering Nodes</p>
                    <div class="d-flex justify-content-center align-items-center m-0 p-0">
                        <h3 class="p-0 m-0" id="orderersCount">-</h3>
                        <h3 class="p-0 m-0">/</h3>
                        <h3 class="p-0 m-0">5</h3>
                    </div>
                </div>

                <div class="d-flex flex-column justify-content-center align-items-center p-3" style="width: 23vw; height: 115px; border: 1px solid #ccc; border-radius: 10px;">
                    <p class="m-0 p-0">Channels</p>
                    <h3 class="p-0 m-0" id="channelsCount">-</h3>
                </div>
            </div>
        </div>

        <div>
            <h4 class="fw-bold">Organizations</h4>
            <div class="d-flex flex-column gap-2" id="organizationsContainer">
                <!-- Organizations will be loaded here -->
            </div>
        </div>

        <button class="btn btn-success w-25" id="btnRefresh">🔄 Refresh Status</button>

        <div class="border-top pt-4">
            <h4 class="fw-bold">System Information</h4>
            <pre class="bg-dark text-white p-3" id="systemInfo" style="border-radius: 10px; overflow-x: auto;">Loading...</pre>
        </div>
    </div>

    <script>
        async function checkNetworkStatus() {
            document.getElementById('loading').classList.remove('d-none');
            BPJSLogger.info('Checking network status...');

            try {
                const response = await fetch('/api/network/status');
                const data = await response.json();

                // Update API Status
                const apiStatus = document.getElementById('apiStatus');
                apiStatus.innerHTML = data.apiConnected
                    ? '<p class="p-0 m-0">✅ Connected</p>'
                    : '<p class="p-0 m-0">❌ Offline</p>';
                apiStatus.style.backgroundColor = data.apiConnected ? '#d4edda' : '#f8d7da';

                // Update Blockchain Status
                const blockchainStatus = document.getElementById('blockchainStatus');
                blockchainStatus.innerHTML = data.blockchainRunning
                    ? '<p class="p-0 m-0">✅ Running</p>'
                    : '<p class="p-0 m-0">❌ Stopped</p>';
                blockchainStatus.style.backgroundColor = data.blockchainRunning ? '#d4edda' : '#f8d7da';

                // Update Counts
                document.getElementById('peersCount').textContent = data.peers || 0;
                document.getElementById('orderersCount').textContent = data.orderers || 0;
                document.getElementById('channelsCount').textContent = data.channels || 0;

                // Update Organizations
                const orgsContainer = document.getElementById('organizationsContainer');
                orgsContainer.innerHTML = '';

                if (data.organizations) {
                    const icons = { 'BPJS': '🏛️', 'Rumah Sakit': '🏥', 'Puskesmas': '🏪' };
                    data.organizations.forEach(org => {
                        const icon = icons[org.name] || '🏢';
                        orgsContainer.innerHTML += `
                            <div class="d-flex flex-row justify-content-between align-items-center p-3" style="width: 80vw; height: 85px; border: 1px solid #ccc; border-radius: 10px;">
                                <div class="d-flex flex-column gap-1">
                                    <p class="m-0 p-0 fs-5 fw-semibold">${icon} ${org.name}</p>
                                    <div class="d-flex flex-row align-items-center gap-2">
                                        <p class="m-0 p-0 fs-6">Peers: ${org.peers}</p>
                                        <p class="p-0 m-0 fs-6"> | </p>
                                        <p class="m-0 p-0 fs-6">MSP: ${org.msp}</p>
                                    </div>
                                </div>
                                <div class="rounded-5 d-flex justify-content-center align-items-center m-0 p-0" style="width: 250px; height: 35px; background-color: ${org.status === 'active' ? '#d4edda' : '#f8d7da'};">
                                    <p class="p-0 m-0">${org.status === 'active' ? 'Active' : 'Inactive'}</p>
                                </div>
                            </div>
                        `;
                    });
                }

                // Update System Info
                if (data.systemInfo) {
                    document.getElementById('systemInfo').textContent = JSON.stringify(data.systemInfo, null, 2);
                }

                // Log success based on connection status
                if (data.apiConnected && data.blockchainRunning) {
                    BPJSLogger.success('Network status retrieved successfully', {
                        apiConnected: data.apiConnected,
                        blockchainRunning: data.blockchainRunning,
                        peers: data.peers,
                        orderers: data.orderers,
                        channels: data.channels
                    });
                } else if (data.apiConnected && !data.blockchainRunning) {
                    BPJSLogger.warning('API connected but blockchain is not running', data);
                } else {
                    BPJSLogger.error('Network connection failed', data);
                }

            } catch (error) {
                console.error('Error checking network status:', error);
                document.getElementById('apiStatus').innerHTML = '<p class="p-0 m-0">❌ Error</p>';
                document.getElementById('apiStatus').style.backgroundColor = '#f8d7da';
                BPJSLogger.error('Failed to check network status', { error: error.message });
            } finally {
                document.getElementById('loading').classList.add('d-none');
            }
        }

        document.getElementById('btnRefresh').addEventListener('click', () => {
            BPJSLogger.info('Manually refreshing network status...');
            checkNetworkStatus();
        });

        // Check status on page load
        document.addEventListener('DOMContentLoaded', checkNetworkStatus);
    </script>
@endsection
