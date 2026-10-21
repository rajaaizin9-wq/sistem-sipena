(function (window) {
    'use strict';

    var key = 'scorm-runtime-cmi';

    // Loads the last local snapshot; the server endpoint is probed when available.
    function load() {
        var local = null;
        try {
            local = JSON.parse(window.localStorage.getItem(key) || 'null');
        } catch (e) {}

        return fetch('/scorm/save', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (response) {
                if (!response.ok) { return local; }
                return response.json().then(function (body) {
                    return body && body.data && typeof body.data === 'object' ? body.data : local;
                }).catch(function () { return local; });
            })
            .catch(function () { return local; });
    }

    // Sends the complete CMI object and keeps a local fallback for the next launch.
    function save(data) {
        try { window.localStorage.setItem(key, JSON.stringify(data)); } catch (e) {}

        return fetch('/scorm/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        }).then(function (response) { return response.ok; }).catch(function () { return true; });
    }

    window.ScormStorage = { load: load, save: save };
}(window));
