<div class="dashboard-intro">
    <p class="eyebrow">Registrasi Rehabilitasi</p>
    <h1>Data pendaftar rehabilitasi rawat jalan</h1>
    <p>Daftar lengkap pengguna yang telah melakukan pendaftaran rehabilitasi.</p>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<div class="dashboard-panel">
    <div class="dashboard-panel-header">
        <div>
            <p class="eyebrow">Rehabilitasi</p>
            <h2>Data Pendaftaran</h2>
        </div>
        <p class="text-muted"><?= count($registrations) ?> pendaftar ditemukan</p>
    </div>

    <?php if (empty($registrations)): ?>
        <div class="dashboard-empty">
            <p>Belum ada pendaftaran rehabilitasi yang tersimpan.</p>
        </div>
    <?php else: ?>
        <div class="registration-toolbar">
            <label class="registration-search" for="registration-search">
                <span class="sr-only">Cari pendaftar</span>
                <input id="registration-search" type="search" placeholder="Cari nama, nomor HP, atau tujuan" autocomplete="off">
            </label>
            <span id="visible-registration-count" class="text-muted" aria-live="polite"><?= count($registrations) ?> pendaftar</span>
        </div>
        <div class="dashboard-table-wrap">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>HP Klien</th>
                        <th>Tujuan</th>
                        <th>Tanggal Daftar</th>
                        <th>Info</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $index => $registration): ?>
                        <tr data-registration-row data-registration-search="<?= esc(strtolower(implode(' ', [
                            (string) ($registration['client_name'] ?? ''),
                            (string) ($registration['client_phone'] ?? ''),
                            (string) ($registration['purpose'] ?? ''),
                        ])), 'attr') ?>">
                            <td><?= esc($index + 1) ?></td>
                            <td><?= esc($registration['client_name'] ?? '-') ?></td>
                            <td><?= esc($registration['client_phone'] ?? '-') ?></td>
                            <td><?= esc($registration['purpose'] ?? '-') ?></td>
                            <td><?= esc($registration['created_at'] ?? '-') ?></td>
                            <td>
                                <button
                                    type="button"
                                    class="table-detail-button"
                                    data-client-name="<?= esc($registration['client_name'] ?? '-', 'attr') ?>"
                                    data-client-nik="<?= esc($registration['client_nik'] ?? '-', 'attr') ?>"
                                    data-gender="<?= esc($registration['gender'] ?? '-', 'attr') ?>"
                                    data-birth-place="<?= esc($registration['birth_place'] ?? '-', 'attr') ?>"
                                    data-birth-date="<?= esc($registration['birth_date'] ?? '-', 'attr') ?>"
                                    data-client-age="<?= esc($registration['client_age'] ?? '-', 'attr') ?>"
                                    data-client-phone="<?= esc($registration['client_phone'] ?? '-', 'attr') ?>"
                                    data-client-address="<?= esc($registration['client_address'] ?? '-', 'attr') ?>"
                                    data-guardian-name="<?= esc($registration['guardian_name'] ?? '-', 'attr') ?>"
                                    data-guardian-nik="<?= esc($registration['guardian_nik'] ?? '-', 'attr') ?>"
                                    data-guardian-phone="<?= esc($registration['guardian_phone'] ?? '-', 'attr') ?>"
                                    data-purpose="<?= esc($registration['purpose'] ?? '-', 'attr') ?>"
                                    data-guardian-address="<?= esc($registration['guardian_address'] ?? '-', 'attr') ?>"
                                    data-created-at="<?= esc($registration['created_at'] ?? '-', 'attr') ?>"
                                    aria-label="Lihat detail pendaftaran <?= esc($registration['client_name'] ?? 'peserta', 'attr') ?>"
                                    aria-haspopup="dialog">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="registrationDetailModal" class="hidden modal-overlay" role="dialog" aria-modal="true" aria-labelledby="registrationDetailTitle" aria-hidden="true">
            <div class="modal-panel">
                <button type="button" class="modal-close" id="registrationDetailClose" aria-label="Tutup detail pendaftaran">×</button>
                <h2 id="registrationDetailTitle">Detail Pendaftaran</h2>
                <dl class="modal-detail-list">
                    <dt>Nama</dt>
                    <dd id="modalClientName"></dd>
                    <dt>NIK</dt>
                    <dd id="modalClientNik"></dd>
                    <dt>Gender</dt>
                    <dd id="modalGender"></dd>
                    <dt>TTL</dt>
                    <dd id="modalTtl"></dd>
                    <dt>Usia</dt>
                    <dd id="modalAge"></dd>
                    <dt>HP Klien</dt>
                    <dd id="modalClientPhone"></dd>
                    <dt>Alamat Klien</dt>
                    <dd id="modalClientAddress"></dd>
                    <dt>Wali</dt>
                    <dd id="modalGuardianName"></dd>
                    <dt>NIK Wali</dt>
                    <dd id="modalGuardianNik"></dd>
                    <dt>HP Wali</dt>
                    <dd id="modalGuardianPhone"></dd>
                    <dt>Tujuan</dt>
                    <dd id="modalPurpose"></dd>
                    <dt>Alamat Wali</dt>
                    <dd id="modalGuardianAddress"></dd>
                    <dt>Tanggal Daftar</dt>
                    <dd id="modalCreatedAt"></dd>
                </dl>
            </div>
        </div>

        <script>
            (function() {
                const modal = document.getElementById('registrationDetailModal');
                const closeButton = document.getElementById('registrationDetailClose');
                const detailButtons = document.querySelectorAll('.table-detail-button');
                const search = document.getElementById('registration-search');
                const rows = document.querySelectorAll('[data-registration-row]');
                const count = document.getElementById('visible-registration-count');
                let lastFocused = null;

                const fields = {
                    clientName: document.getElementById('modalClientName'),
                    clientNik: document.getElementById('modalClientNik'),
                    gender: document.getElementById('modalGender'),
                    ttl: document.getElementById('modalTtl'),
                    age: document.getElementById('modalAge'),
                    clientPhone: document.getElementById('modalClientPhone'),
                    clientAddress: document.getElementById('modalClientAddress'),
                    guardianName: document.getElementById('modalGuardianName'),
                    guardianNik: document.getElementById('modalGuardianNik'),
                    guardianPhone: document.getElementById('modalGuardianPhone'),
                    purpose: document.getElementById('modalPurpose'),
                    guardianAddress: document.getElementById('modalGuardianAddress'),
                    createdAt: document.getElementById('modalCreatedAt'),
                };

                function openModal(data) {
                    lastFocused = document.activeElement;
                    fields.clientName.textContent = data.clientName;
                    fields.clientNik.textContent = data.clientNik;
                    fields.gender.textContent = data.gender;
                    fields.ttl.textContent = data.birthPlace + ', ' + data.birthDate;
                    fields.age.textContent = data.clientAge;
                    fields.clientPhone.textContent = data.clientPhone;
                    fields.clientAddress.textContent = data.clientAddress;
                    fields.guardianName.textContent = data.guardianName;
                    fields.guardianNik.textContent = data.guardianNik;
                    fields.guardianPhone.textContent = data.guardianPhone;
                    fields.purpose.textContent = data.purpose;
                    fields.guardianAddress.textContent = data.guardianAddress;
                    fields.createdAt.textContent = data.createdAt;
                    modal.classList.remove('hidden');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('modal-open');
                    closeButton.focus();
                }

                function closeModal() {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('modal-open');
                    lastFocused?.focus();
                }

                search?.addEventListener('input', () => {
                    const term = search.value.trim().toLocaleLowerCase('id-ID');
                    let visible = 0;
                    rows.forEach((row) => {
                        const matches = row.dataset.registrationSearch.includes(term);
                        row.hidden = !matches;
                        visible += matches ? 1 : 0;
                    });
                    count.textContent = `${visible} pendaftar`;
                });

                detailButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        openModal(button.dataset);
                    });
                });

                closeButton.addEventListener('click', closeModal);
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });
            })();
        </script>
    <?php endif; ?>
</div>
