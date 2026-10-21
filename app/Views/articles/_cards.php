<?php foreach ($articles as $article): ?>
<a href="<?= base_url('artikel/' . $article['id']) ?>" class="flex flex-col overflow-hidden transition-all duration-200 bg-white border shadow-sm group rounded-xl border-slate-200 hover:border-bnn-300 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-bnn-600 focus-visible:ring-offset-2">
    <div class="relative overflow-hidden bg-slate-100 aspect-[16/9]">
        <?php if (! empty($article['image'])): ?>
            <img src="<?= base_url($article['image']) ?>" alt="<?= esc($article['title']) ?>" class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-[1.02]" loading="lazy">
        <?php else: ?>
            <div class="flex flex-col items-center justify-center w-full h-full p-4 bg-gradient-to-br from-sky-50 via-slate-50 to-blue-100/60">
                <div class="p-3 bg-white/90 rounded-2xl shadow-xs border border-sky-100 mb-1.5 transition-transform duration-300 group-hover:scale-110">
                    <svg class="w-8 h-8 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5" />
                    </svg>
                </div>
                <span class="text-xs font-semibold tracking-wide text-sky-900/60">Artikel BNN</span>
            </div>
        <?php endif; ?>
    </div>
    <div class="flex flex-col flex-1 p-5">
        <?php $articleDate = (! empty($article['created_at']) && strtotime($article['created_at']) > 0) ? strtotime($article['created_at']) : time(); ?>
        <time class="text-xs font-medium text-slate-500" datetime="<?= esc(date('Y-m-d', $articleDate)) ?>"><?= esc(date('d F Y', $articleDate)) ?></time>
        <h2 class="mt-2 text-lg font-semibold leading-7 text-sky-950 line-clamp-2 break-words [overflow-wrap:anywhere]"><?= esc($article['title']) ?></h2>
        <p class="mt-2 text-sm leading-6 text-slate-600 line-clamp-3 break-words [overflow-wrap:anywhere]"><?= esc(mb_strimwidth($article['description'] ?: strip_tags($article['content']), 0, 150, '...')) ?></p>
        <div class="flex items-center gap-1.5 pt-4 mt-auto text-sm font-semibold text-sky-700"><span>Baca selengkapnya</span><svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5" /></svg></div>
    </div>
</a>
<?php endforeach; ?>
