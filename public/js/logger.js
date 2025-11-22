let BPJSLogger = {
    STORAGE_KEY: 'bpjs_blockchain_logs',

    getLogs() {
        const stored = localStorage.getItem(this.STORAGE_KEY);
        return stored ? JSON.parse(stored) : [];
    },

    saveLogs(logs) {
        // Keep only last 100 logs
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(logs.slice(-100)));
    },

    addLog(type, message, data = null) {
        const logs = this.getLogs();
        logs.push({
            id: Date.now(),
            type: type,
            message: message,
            data: data,
            timestamp: new Date().toISOString(),
            page: window.location.pathname
        });
        this.saveLogs(logs);
    },

    success(message, data = null) {
        this.addLog('success', message, data);
    },

    error(message, data = null) {
        this.addLog('error', message, data);
    },

    warning(message, data = null) {
        this.addLog('warning', message, data);
    },

    info(message, data = null) {
        this.addLog('info', message, data);
    },

    clear() {
        localStorage.removeItem(this.STORAGE_KEY);
    }
};

window.BPJSLogger = BPJSLogger;
