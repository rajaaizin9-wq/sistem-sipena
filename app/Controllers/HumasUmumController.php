<?php

namespace App\Controllers;

use App\Models\LandingPageSettingsModel;
use App\Models\DrugFactModel;
use App\Models\AboutSectionModel;

class HumasUmumController extends BaseController
{
    public function __construct(
        private readonly LandingPageSettingsModel $settingsModel = new LandingPageSettingsModel(),
        private readonly DrugFactModel $drugFactModel = new DrugFactModel(),
        private readonly AboutSectionModel $aboutSectionModel = new AboutSectionModel(),
    ) {}

    public function landingPage(): string
    {
        $user = session()->get('auth_user');

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/humas_umum/landing_page', [
                'user' => $user,
                'facts' => $this->drugFactModel->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll(4),
                'aboutSection' => $this->aboutSectionModel->orderBy('id', 'DESC')->first(),
            ]),
        ]);
    }

    public function saveLandingPage(): \CodeIgniter\HTTP\RedirectResponse
    {
        $user = session()->get('auth_user');

        if ($user === null || ($user['role'] ?? '') !== 'humas_umum') {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'hero_title'        => 'required|string|max_length[120]',
            'hero_subtitle'     => 'required|string|max_length[260]',
            'hero_cta_label'    => 'required|string|max_length[80]',
            'hero_cta_url'      => 'required|string|max_length[160]',
            'secondary_cta_label' => 'permit_empty|string|max_length[80]',
            'secondary_cta_url' => 'permit_empty|string|max_length[160]',
            'about_title'       => 'required|string|max_length[120]',
            'about_body'        => 'required|string|max_length[500]',
            'services_title'    => 'required|string|max_length[120]',
            'services_body'     => 'required|string|max_length[300]',
            'quick_links_title' => 'required|string|max_length[120]',
            'quick_links_body'  => 'required|string|max_length[300]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Beberapa field belum valid.');
        }

        $facts = $this->drugFactModel->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll(4);
        $postedFacts = (array) $this->request->getPost('facts');
        foreach ($facts as $fact) {
            $input = $postedFacts[$fact['id']] ?? [];
            $title = trim((string) ($input['title'] ?? ''));
            $value = trim((string) ($input['value'] ?? ''));
            if ($title === '' || $value === '' || mb_strlen($title) > 100 || mb_strlen($value) > 30) {
                return redirect()->back()->withInput()->with('error', 'Data fakta tidak valid.');
            }
            $this->drugFactModel->update($fact['id'], ['title' => $title, 'value' => $value, 'description' => $title]);
        }

        $saved = $this->settingsModel->saveSettings($this->request->getPost());

        if ($saved) {
            return redirect()->to('/dashboard/landing-page')->with('success', 'Konten landing page berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan perubahan.');
    }
}
