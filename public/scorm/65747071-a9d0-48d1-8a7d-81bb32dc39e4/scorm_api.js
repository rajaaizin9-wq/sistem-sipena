/**
 * Simple client-side SCORM API wrapper
 */
class ScormAPIAdapter {
  constructor(version) {
    this.version = version;
    this.api = null;
  }

  // Find the SCORM API starting from current window upwards
  findAPI(win) {
    let findAttempts = 0;
    const findAttemptsLimit = 500;
    const apiName = this.version === '1.2' ? 'API' : 'API_1484_11';

    while (win[apiName] === null || win[apiName] === undefined) {
      findAttempts++;
      if (findAttempts > findAttemptsLimit) {
        return null;
      }
      if (win.parent && win.parent !== win) {
        win = win.parent;
      } else {
        break;
      }
    }
    return win[apiName] || null;
  }

  initialize() {
    this.api = this.findAPI(window);
    if (!this.api && window.opener) {
      this.api = this.findAPI(window.opener);
    }

    if (this.api) {
      if (this.version === '1.2') {
        const result = this.api.LMSInitialize("");
        return result === "true";
      } else {
        const result = this.api.Initialize("");
        return result === "true";
      }
    }
    console.warn("[SCORM] API wrapper initialized, but no LMS API discovered.");
    return false;
  }

  getValue(element) {
    if (this.api) {
      if (this.version === '1.2') {
        return this.api.LMSGetValue(element);
      } else {
        return this.api.GetValue(element);
      }
    }
    return "";
  }

  setValue(element, value) {
    if (this.api) {
      if (this.version === '1.2') {
        const result = this.api.LMSSetValue(element, value);
        return result === "true";
      } else {
        const result = this.api.SetValue(element, value);
        return result === "true";
      }
    }
    return false;
  }

  commit() {
    if (this.api) {
      if (this.version === '1.2') {
        const result = this.api.LMSCommit("");
        return result === "true";
      } else {
        const result = this.api.Commit("");
        return result === "true";
      }
    }
    return false;
  }

  terminate() {
    if (this.api) {
      if (this.version === '1.2') {
        const result = this.api.LMSFinish("");
        return result === "true";
      } else {
        const result = this.api.Terminate("");
        return result === "true";
      }
    }
    return false;
  }
}
