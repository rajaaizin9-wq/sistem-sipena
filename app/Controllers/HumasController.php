<?php

namespace App\Controllers;

use App\Models\AboutSectionModel;
use App\Models\DrugFactModel;
use App\Models\LandingPageSettingsModel;
use App\Models\MonthlyStatisticModel;
use App\Models\RehabilitasiRawatJalanRegistrationModel;

class HumasController extends BaseController
{
    public function __construct(
        private readonly LandingPageSettingsModel $settingsModel = new LandingPageSettingsModel(),
        private readonly DrugFactModel $drugFactModel = new DrugFactModel(),
        private readonly AboutSectionModel $aboutSectionModel = new AboutSectionModel(),
        private readonly RehabilitasiRawatJalanRegistrationModel $registrations = new RehabilitasiRawatJalanRegistrationModel(),
        private readonly MonthlyStatisticModel $monthlyStatsModel = new MonthlyStatisticModel(),
    ) {}

    public function landingPage(): string
    {
        $user = session()->get('auth_user');
        $selectedYear = (int) ($this->request->getGet('year') ?: date('Y'));
        if ($selectedYear < 2000 || $selectedYear > 2100) {
            $selectedYear = (int) date('Y');
        }
        $availableYears = array_values(array_unique(array_map('intval', $this->monthlyStatsModel->getAvailableYears())));
        if (! in_array($selectedYear, $availableYears, true)) {
            $availableYears[] = $selectedYear;
        }
        rsort($availableYears);
        $availableYears = array_values(array_unique($availableYears));

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/humas/landing_page', [
                'user'           => $user,
                'settings'       => $this->settingsModel->getSettings(),
                'facts'          => $this->drugFactModel->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll(4),
                'aboutSection'   => $this->aboutSectionModel->orderBy('id', 'DESC')->first(),
                'monthlyData'    => $this->monthlyStatsModel->getYearData($selectedYear),
                'availableYears' => $availableYears,
                'selectedYear'   => $selectedYear,
            ]),
        ]);
    }

    public function saveLandingPage(): \CodeIgniter\HTTP\RedirectResponse
    {
        $facts = $this->drugFactModel->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll(4);
        foreach ($facts as $fact) {
            $input = ((array) $this->request->getPost('facts'))[$fact['id']] ?? [];
            $title = trim((string) ($input['title'] ?? ''));
            $value = trim((string) ($input['value'] ?? ''));
            if ($title === '' || $value === '' || mb_strlen($title) > 100 || mb_strlen($value) > 30) {
                return redirect()->back()->withInput()->with('error', 'Data fakta tidak valid.');
            }
            $this->drugFactModel->update($fact['id'], ['title' => $title, 'value' => $value, 'description' => $title]);
        }

        return $this->settingsModel->saveSettings($this->request->getPost())
            ? redirect()->to('/dashboard/landing-page')->with('success', 'Konten landing page berhasil diperbarui.')
            : redirect()->back()->withInput()->with('error', 'Gagal menyimpan perubahan.');
    }

    public function saveMonthlyStats(): \CodeIgniter\HTTP\RedirectResponse
    {
        $year = (int) $this->request->getPost('year');
        if ($year < 2000 || $year > 2100) {
            return redirect()->back()->withInput()->with('error', 'Tahun tidak valid.');
        }

        $monthsInput = (array) $this->request->getPost('months');
        $this->monthlyStatsModel->saveYearData($year, $monthsInput);

        return redirect()->to('/dashboard/landing-page?year=' . $year)->with('success', "Data grafik bulanan tahun {$year} berhasil diperbarui.");
    }
}
