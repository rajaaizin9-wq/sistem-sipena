<?php
$total = count($answers);
$correct = count(array_filter($answers, static fn($answer) => (int) $answer['is_correct'] === 1));
$scorePct = $total > 0 ? (int) round(($correct / $total) * 100) : 0;
$participantName = $answers[0]['participant_name'] ?? '';
$participantAge  = $answers[0]['participant_age'] ?? null;
$subId = $submissionId ?? ($answers[0]['submission_id'] ?? '');
$resultUrl = base_url('quiz/' . $quiz['id'] . '/hasil/' . $subId);

$headingFeedback = 'Luar Biasa!';
if ($scorePct < 60) {
    $headingFeedback = 'Tingkatkan lagi pemahaman Anda!';
} elseif ($scorePct < 80) {
    $headingFeedback = 'Hasil Cukup Baik!';
}
?>

<section class="bg-slate-50 py-8 sm:py-12 min-h-[calc(100vh-140px)]">
    <div class="w-full max-w-2xl px-4 mx-auto space-y-6 sm:px-6">

        <!-- Navigation -->
        <div class="flex items-center justify-between">
            <a href="<?= base_url('quiz') ?>" class="inline-flex items-center gap-2 text-sm font-semibold transition-colors text-slate-600 hover:text-sky-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                <span>Kembali ke Daftar Kuis</span>
            </a>
            <span class="px-3 py-1 text-xs font-semibold border rounded-full bg-sky-50 text-sky-700 border-sky-200/60">
                SIPENA • Hasil Kuis
            </span>
        </div>

        <!-- Result Summary Card -->
        <div class="overflow-hidden bg-white border shadow-xl rounded-2xl shadow-slate-200/60 border-slate-200/80">

            <div class="flex flex-col justify-between gap-6 p-6 border-b sm:p-8 border-slate-100 bg-slate-50/50 sm:flex-row sm:items-center">
                <div class="space-y-1.5 min-w-0 flex-1">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-semibold rounded-full bg-sky-50 text-sky-700 border border-sky-200/60">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-sky-600">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Selesai Dikerjakan</span>
                    </span>
                    <h1 class="text-xl font-bold leading-tight break-words sm:text-2xl text-slate-900"><?= esc($quiz['title']) ?></h1>
                    
                    <?php if ($participantName !== ''): ?>
                        <p class="text-xs text-slate-600 font-medium flex items-center gap-1.5 pt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 shrink-0">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span>Peserta: <strong class="font-semibold text-slate-800"><?= esc($participantName) ?></strong><?= $participantAge ? ' (' . esc($participantAge) . ' tahun)' : '' ?></span>
                        </p>
                    <?php endif; ?>

                    <p class="text-sm font-medium text-slate-500 pt-0.5"><?= $headingFeedback ?></p>
                </div>

                <div class="shrink-0 bg-white rounded-xl p-4 border border-slate-200 shadow-sm text-center min-w-[130px]">
                    <span class="block text-3xl font-black text-sky-600"><?= $scorePct ?>%</span>
                    <span class="block text-xs font-semibold text-slate-500 mt-0.5"><?= $correct ?> dari <?= $total ?> Benar</span>
                </div>
            </div>

            <!-- Breakdown Questions -->
            <div class="p-6 space-y-5 bg-white sm:p-8">
                <h2 class="flex items-center justify-between pb-2 text-base font-bold border-b text-slate-900 border-slate-100">
                    <span>Rincian Jawabanmu</span>
                    <span class="text-xs font-semibold text-slate-500"><?= $total ?> Pertanyaan</span>
                </h2>

                <div class="space-y-4">
                    <?php foreach ($answers as $index => $answer): ?>
                        <?php
                        $chosen = ['a', 'b', 'c', 'd'][(int) $answer['answer'] - 1];
                        $correctOption = ['a', 'b', 'c', 'd'][(int) $answer['correct_option'] - 1];
                        $isCorrect = (int) $answer['is_correct'] === 1;
                        ?>
                        <div class="p-5 rounded-xl border <?= $isCorrect ? 'border-green-200 bg-green-50/40' : 'border-red-200 bg-red-50/40' ?> space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-xs font-bold tracking-wider uppercase text-slate-500">Pertanyaan <?= $index + 1 ?></span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-bold rounded-full border <?= $isCorrect ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' ?>">
                                    <?= $isCorrect ? '✓ Benar' : '✕ Salah' ?>
                                </span>
                            </div>

                            <h3 class="text-sm font-bold leading-snug text-slate-900"><?= esc($answer['question']) ?></h3>

                            <div class="pt-1 space-y-2 text-xs sm:text-sm">
                                <div class="p-2.5 rounded-lg flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-2 <?= $isCorrect ? 'bg-green-100/60 text-green-900' : 'bg-red-100/60 text-red-900' ?>">
                                    <span class="font-semibold text-slate-600 shrink-0 w-28">Jawaban Anda:</span>
                                    <strong class="font-bold"><?= strtoupper($chosen) ?>. <?= esc($answer['option_' . $chosen]) ?></strong>
                                </div>
                                <?php if (! $isCorrect): ?>
                                    <div class="p-2.5 rounded-lg flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-2 bg-white border border-slate-200 text-slate-900">
                                        <span class="font-semibold text-slate-600 shrink-0 w-28">Jawaban Benar:</span>
                                        <strong class="font-bold text-green-700"><?= strtoupper($correctOption) ?>. <?= esc($answer['option_' . $correctOption]) ?></strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex flex-col items-center gap-3 pt-6 border-t border-slate-100">
                    <span class="text-xs font-bold tracking-wider uppercase text-slate-400">Bagikan Hasil Kuis Ini</span>
                    
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text=<?= urlencode(($participantName !== '' ? $participantName . ' telah' : 'Saya telah') . ' menyelesaikan kuis "' . $quiz['title'] . '" dengan skor ' . $scorePct . '%! Lihat hasil pengerjaannya di: ' . $resultUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white transition-colors shadow-sm rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800" title="Bagikan ke WhatsApp">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>WhatsApp</span>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($resultUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white transition-colors bg-blue-600 shadow-sm rounded-xl hover:bg-blue-700 active:bg-blue-800" title="Bagikan ke Facebook">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            <span>Facebook</span>
                        </a>

                        <!-- X (Twitter) -->
                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode(($participantName !== '' ? $participantName . ' telah' : 'Saya telah') . ' menyelesaikan kuis "' . $quiz['title'] . '" dengan skor ' . $scorePct . '%!') ?>&url=<?= urlencode($resultUrl) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white transition-colors shadow-sm rounded-xl bg-slate-900 hover:bg-slate-800 active:bg-black" title="Bagikan ke X / Twitter">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            <span>X</span>
                        </a>

                        <!-- Salin Link -->
                        <button type="button" onclick="copyShareLink(this, '<?= esc($resultUrl, 'js') ?>')" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold transition-colors border shadow-sm cursor-pointer rounded-xl bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 border-slate-300" title="Salin Tautan Hasil Kuis">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span class="btn-copy-label">Salin Link Hasil</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
function copyShareLink(btn, url) {
    function showSuccess() {
        const label = btn.querySelector('.btn-copy-label');
        if (label) label.textContent = 'Tersalin!';
        btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
        setTimeout(() => {
            if (label) label.textContent = 'Salin Link';
            btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
        }, 2000);
    }

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(showSuccess).catch(function() {
            fallbackCopyText(url, showSuccess);
        });
    } else {
        fallbackCopyText(url, showSuccess);
    }
}

function fallbackCopyText(text, callback) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        if (callback) callback();
    } catch (err) {
        alert('Tautan kuis: ' + text);
    }
    document.body.removeChild(textArea);
}
</script>