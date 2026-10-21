(function (window) {
    'use strict';

    // Shared in-memory CMI runtime used by both SCORM adapters.
    function ScormRuntime(version, storage) {
        this.version = version;
        this.storage = storage || null;
        this.state = 'Not Initialized';
        this.dirty = false;
        this.lastError = 0;
        this.data = this.defaultData();
    }

    // Creates the smallest useful CMI data model for the selected version.
    ScormRuntime.prototype.defaultData = function () {
        if (this.version === '2004') {
            return {
                'cmi.location': '',
                'cmi.completion_status': 'unknown',
                'cmi.success_status': 'unknown',
                'cmi.score.raw': '',
                'cmi.score.min': '',
                'cmi.score.max': '',
                'cmi.score.scaled': '',
                'cmi.suspend_data': '',
                'cmi.launch_data': '',
                'cmi.session_time': 'PT0S',
                'cmi.exit': '',
                'cmi.learner_id': '',
                'cmi.learner_name': ''
            };
        }

        return {
            'cmi.core.lesson_status': 'not attempted',
            'cmi.core.lesson_location': '',
            'cmi.core.score.raw': '',
            'cmi.core.score.min': '',
            'cmi.core.score.max': '',
            'cmi.core.student_id': '',
            'cmi.core.student_name': '',
            'cmi.core.session_time': '00:00:00',
            'cmi.core.exit': '',
            'cmi.suspend_data': '',
            'cmi.launch_data': ''
        };
    };

    // Sets an error and returns the SCORM failure value.
    ScormRuntime.prototype.fail = function (code) {
        this.lastError = code;
        return '';
    };

    // Initializes the runtime and starts a non-blocking restore of saved data.
    ScormRuntime.prototype.initialize = function () {
        if (this.state !== 'Not Initialized') {
            this.lastError = this.version === '2004' ? 103 : 101;
            return false;
        }

        this.state = 'Initialized';
        this.lastError = 0;
        if (this.storage && typeof this.storage.load === 'function') {
            this.storage.load().then(function (saved) {
                if (saved && !this.dirty && this.state === 'Initialized') {
                    this.data = Object.assign(this.data, saved);
                }
            }.bind(this)).catch(function () {
                // A missing or unavailable persistence endpoint must not prevent launch.
            });
        }
        return true;
    };

    // Terminates the session, committing dirty data before changing state.
    ScormRuntime.prototype.terminate = function () {
        if (this.state !== 'Initialized') {
            this.lastError = this.version === '2004' ? 132 : 301;
            return false;
        }

        if (this.dirty && !this.commit()) {
            return false;
        }
        this.state = 'Terminated';
        this.lastError = 0;
        return true;
    };

    // Reads a valid, readable CMI element.
    ScormRuntime.prototype.getValue = function (element) {
        if (this.state !== 'Initialized') {
            return this.fail(this.version === '2004' ? 132 : 301);
        }
        if (!element || (!Object.prototype.hasOwnProperty.call(this.data, element) && !this.isCmiElement(element))) {
            return this.fail(this.version === '2004' ? 401 : 201);
        }
        if (!Object.prototype.hasOwnProperty.call(this.data, element)) {
            this.data[element] = '';
        }
        if (this.isWriteOnly(element)) {
            return this.fail(this.version === '2004' ? 405 : 404);
        }
        this.lastError = 0;
        return String(this.data[element]);
    };

    // Writes a valid, writable CMI element and marks the snapshot dirty.
    ScormRuntime.prototype.setValue = function (element, value) {
        if (this.state !== 'Initialized') {
            this.lastError = this.version === '2004' ? 132 : 301;
            return false;
        }
        if (!element || !this.isCmiElement(element)) {
            this.lastError = this.version === '2004' ? 401 : 201;
            return false;
        }
        if (this.isReadOnly(element)) {
            this.lastError = this.version === '2004' ? 404 : 403;
            return false;
        }
        // SCORM values are strings, but many browser packages pass numeric scores.
        if (value === null || value === undefined) {
            this.lastError = this.version === '2004' ? 406 : 405;
            return false;
        }
        if (typeof value !== 'string') {
            if (typeof value === 'number' || typeof value === 'boolean') {
                value = String(value);
            } else {
                this.lastError = this.version === '2004' ? 406 : 405;
                return false;
            }
        }
        // Keep compatibility with package-specific CMI elements without failing the call.
        if (!Object.prototype.hasOwnProperty.call(this.data, element)) {
            this.data[element] = '';
        }
        this.data[element] = value;
        this.dirty = true;
        this.lastError = 0;
        return true;
    };

    // Persists the complete CMI snapshot when a storage helper is available.
    ScormRuntime.prototype.commit = function () {
        if (this.state !== 'Initialized') {
            this.lastError = this.version === '2004' ? 132 : 301;
            return false;
        }
        if (!this.storage || typeof this.storage.save !== 'function') {
            this.lastError = this.version === '2004' ? 391 : 391;
            return false;
        }

        var request = this.storage.save(this.data);
        if (request && typeof request.then === 'function') {
            request.then(function (ok) {
                if (ok) {
                    this.dirty = false;
                    this.lastError = 0;
                }
            }.bind(this)).catch(function () {
                this.lastError = 391;
            }.bind(this));
        }
        this.lastError = 0;
        return true;
    };

    // Defines the minimal read/write restrictions required by the runtime.
    ScormRuntime.prototype.isReadOnly = function (element) {
        return element === 'cmi.core.student_id' || element === 'cmi.core.student_name' ||
            element === 'cmi.launch_data' || element === 'cmi.learner_id' ||
            element === 'cmi.learner_name';
    };

    ScormRuntime.prototype.isWriteOnly = function () { return false; };

    // Allows the minimal runtime to accept valid CMI extensions used by packages.
    ScormRuntime.prototype.isCmiElement = function (element) {
        return typeof element === 'string' && element.indexOf('cmi.') === 0;
    };

    window.ScormRuntime = ScormRuntime;
}(window));
