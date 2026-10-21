(function (window) {
    'use strict';

    var runtime = new window.ScormRuntime('1.2', window.ScormStorage);

    // Exposes the SCORM 1.2 LMS API expected by content packages.
    window.API = {
        LMSInitialize: function () { return runtime.initialize() ? 'true' : 'false'; },
        LMSFinish: function () { return runtime.terminate() ? 'true' : 'false'; },
        LMSGetValue: function (element) { return runtime.getValue(element); },
        LMSSetValue: function (element, value) { return runtime.setValue(element, value) ? 'true' : 'false'; },
        LMSCommit: function () { return runtime.commit() ? 'true' : 'false'; },
        LMSGetLastError: function () { return String(runtime.lastError); },
        LMSGetErrorString: function (code) {
            return ({ 0: 'No Error', 101: 'General Exception', 201: 'Invalid argument', 301: 'Not initialized', 391: 'General Commit Failure', 403: 'Element is read only', 404: 'Element is write only', 405: 'Incorrect Data Type' })[code] || 'Unknown Error';
        },
        LMSGetDiagnostic: function (code) { return code ? 'SCORM 1.2 error ' + code : ''; }
    };
}(window));
