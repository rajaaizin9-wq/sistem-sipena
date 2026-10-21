<?php foreach ($comments as $c): ?>
    <div class="p-4 sm:p-5 bg-white border border-slate-200/90 rounded-xl shadow-2xs min-w-0 overflow-hidden">
        <div class="flex items-center justify-between gap-3 mb-2 min-w-0">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center border border-sky-200 shrink-0">
                    <?= esc(strtoupper(substr($c['name'] ?? 'A', 0, 1))) ?>
                </div>
                <span class="text-sm font-bold text-slate-900 truncate min-w-0"><?= esc($c['name']) ?></span>
            </div>
            <span class="text-[11px] text-slate-400 shrink-0">
                <?= esc(! empty($c['created_at']) ? date('d M Y, H:i', strtotime($c['created_at'])) : '') ?>
            </span>
        </div>
        <div class="pl-10 min-w-0">
            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed break-words [overflow-wrap:anywhere] [word-break:break-word]">
                <?= nl2br(esc($c['comment'])) ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>
