(function (window) {
    'use strict';

    var runtime = new window.ScormRuntime('2004', window.ScormStorage);

    // Exposes the SCORM 2004 API expected by content packages.
    window.API_1484_11 = {
        Initialize: function () { return runtime.initialize() ? 'true' : 'false'; },
        Terminate: function () { return runtime.terminate() ? 'true' : 'false'; },
        GetValue: function (element) { return runtime.getValue(element); },
        SetValue: function (element, value) { return runtime.setValue(element, value) ? 'true' : 'false'; },
        Commit: function () { return runtime.commit() ? 'true' : 'false'; },
        GetLastError: function () { return String(runtime.lastError); },
        GetErrorString: function (code) {
            return ({ 0: 'No Error', 101: 'General Exception', 201: 'Invalid argument', 301: 'Not initialized', 391: 'General Commit Failure', 403: 'Element is read only', 404: 'Element is write only', 405: 'Incorrect Data Type', 132: 'Not initialized', 401: 'Invalid argument', 406: 'Incorrect Data Type' })[code] || 'Unknown Error';
        },
        GetDiagnostic: function (code) { return code ? 'SCORM 2004 error ' + code : ''; }
    };
}(window));
