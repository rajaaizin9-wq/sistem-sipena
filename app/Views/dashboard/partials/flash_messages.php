<?php
$flashSuccess = session()->getFlashdata('success');
$flashError   = session()->getFlashdata('error');
$flashWarning = session()->getFlashdata('warning');
$flashInfo    = session()->getFlashdata('info');
?>

<script>
(function() {
    function triggerFlashToasts() {
        if (typeof window.showToast === 'function') {
            const pending = sessionStorage.getItem('pending_toast');
            if (pending) {
                sessionStorage.removeItem('pending_toast');
                try {
                    const data = JSON.parse(pending);
                    if (data && data.type && data.message) {
                        window.showToast(data.type, data.message);
                    }
                } catch (e) {}
            }
            <?php if ($flashSuccess): ?>
                window.showToast('success', <?= json_encode($flashSuccess) ?>);
            <?php endif; ?>
            <?php if ($flashError): ?>
                window.showToast('error', <?= json_encode($flashError) ?>);
            <?php endif; ?>
            <?php if ($flashWarning): ?>
                window.showToast('warning', <?= json_encode($flashWarning) ?>);
            <?php endif; ?>
            <?php if ($flashInfo): ?>
                window.showToast('info', <?= json_encode($flashInfo) ?>);
            <?php endif; ?>
        } else {
            setTimeout(triggerFlashToasts, 50);
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', triggerFlashToasts);
    } else {
        triggerFlashToasts();
    }
})();
</script>