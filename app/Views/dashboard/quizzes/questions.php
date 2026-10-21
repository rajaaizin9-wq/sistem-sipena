<div class="min-w-0 mb-8">
    <p class="mb-1 text-xs font-bold tracking-widest uppercase text-sky-600">Manajemen Kuis</p>

    <div class="flex flex-col min-w-0 gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex-1 min-w-0">
            <h1 class="max-w-full text-2xl font-black leading-tight tracking-tight break-words line-clamp-2 text-slate-800 sm:text-3xl">
                Pertanyaan: <?= esc($quiz['title']) ?>
            </h1>
            <p class="mt-1 text-sm text-slate-500">Kelola pertanyaan untuk kuis ini.</p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="<?= base_url('dashboard/quizzes') ?>"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-700 transition-all bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50">
                Kembali
            </a>

            <a href="<?= base_url('dashboard/quizzes/' . esc($quiz['id'], 'url') . '/questions/create') ?>"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white transition-all bg-sky-600 rounded-lg shadow-sm hover:bg-sky-700">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M12 5v14M5 12h14"></path>
                </svg>
                Tambah pertanyaan
            </a>
        </div>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<div class="mt-6 overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
    <div class="flex items-center justify-between min-w-0 gap-4 px-5 py-4 border-b border-slate-200 bg-slate-50/50 sm:px-6">
        <div class="min-w-0">
            <h2 class="font-semibold text-slate-800">Daftar pertanyaan</h2>
            <p class="mt-0.5 text-sm text-slate-500">Pertanyaan yang dimiliki kuis.</p>
        </div>

        <span class="inline-flex shrink-0 items-center rounded-md bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 ring-1 ring-inset ring-sky-700/10">
            <?= count($questions ?? []) ?> pertanyaan
        </span>
    </div>

    <?php if (empty($questions)): ?>

        <div class="px-6 py-16 text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100">
                <svg class="w-8 h-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <path d="M12 17h.01"></path>
                </svg>
            </div>

            <strong class="block mb-1 text-sm font-semibold text-slate-900">
                Belum ada pertanyaan
            </strong>

            <p class="mb-6 text-sm text-slate-500">
                Tambahkan pertanyaan untuk kuis ini.
            </p>

            <a href="<?= base_url('dashboard/quizzes/' . esc($quiz['id'], 'url') . '/questions/create') ?>"
                class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-sm font-semibold transition rounded-lg min-h-10 text-sky-700 bg-slate-50 hover:bg-sky-50 hover:text-sky-800">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"></path>
                </svg>
                Tambah pertanyaan
            </a>
        </div>

    <?php else: ?>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] table-fixed divide-y divide-slate-200">
                <colgroup>
                    <col class="w-16">
                    <col class="w-[calc(100%-224px)]">
                    <col class="w-24">
                    <col class="w-32">
                </colgroup>

                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold tracking-wider text-slate-600 uppercase">
                            #
                        </th>

                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold tracking-wider text-slate-600 uppercase">
                            Pertanyaan
                        </th>

                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold tracking-wider text-slate-600 uppercase">
                            Urutan
                        </th>

                        <th scope="col" class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold tracking-wider text-slate-600 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-slate-100">
                    <?php foreach ($questions as $i => $q): ?>

                        <tr class="transition-colors group hover:bg-slate-50/75">

                            <td class="py-4 pl-6 pr-3 text-sm align-top whitespace-nowrap text-slate-500">
                                <?= $i + 1 ?>
                            </td>

                            <td class="px-3 py-4 align-top">
                                <p class="max-w-full overflow-hidden text-sm leading-6 break-words line-clamp-2 text-slate-900"
                                    title="<?= esc($q['question']) ?>">
                                    <?= esc($q['question']) ?>
                                </p>
                            </td>

                            <td class="px-3 py-4 text-sm align-top whitespace-nowrap text-slate-600">
                                <?= esc($q['sort_order']) ?>
                            </td>

                            <td class="py-4 pl-3 pr-6 text-sm font-medium text-right align-top whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">

                                    <a href="<?= base_url('dashboard/quizzes/' . esc($quiz['id'], 'url') . '/questions/edit/' . esc($q['id'], 'url')) ?>"
                                        class="transition-colors text-slate-400 hover:text-sky-600"
                                        title="Edit pertanyaan"
                                        aria-label="Edit pertanyaan">
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>

                                    <form method="post"
                                        action="<?= base_url('dashboard/quizzes/' . esc($quiz['id'], 'url') . '/questions/delete/' . esc($q['id'], 'url')) ?>"
                                        class="m-0"
                                        onsubmit="return confirmDelete(this, 'Hapus pertanyaan ini?')">
                                        <?= csrf_field() ?>

                                        <button type="submit"
                                            class="transition-colors cursor-pointer text-slate-400 hover:text-red-600"
                                            title="Hapus pertanyaan"
                                            aria-label="Hapus pertanyaan">
                                            <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18"></path>
                                                <path d="M8 6V4h8v2"></path>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                                <path d="M10 11v6M14 11v6"></path>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>