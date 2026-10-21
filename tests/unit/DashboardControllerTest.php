<?php

use App\Controllers\DashboardController;
use CodeIgniter\Test\CIUnitTestCase;

final class DashboardControllerTest extends CIUnitTestCase
{
    protected function tearDown(): void
    {
        session()->remove('auth_user');
        parent::tearDown();
    }

    public function testItRendersTheCorrectDashboardForHumasUmum(): void
    {
        session()->set('auth_user', [
            'name' => 'Humas Umum',
            'role' => 'humas_umum',
        ]);

        $controller = new DashboardController();
        $html = (string) $controller->index();

        $this->assertStringContainsString('Dashboard Humas Umum', $html);
        $this->assertStringContainsString('Selamat datang, Humas Umum.', $html);
    }

    public function testItRendersTheCorrectDashboardForHumasRehabilitasi(): void
    {
        session()->set('auth_user', [
            'name' => 'Humas Rehabilitasi',
            'role' => 'humas_rehabilitasi',
        ]);

        $controller = new DashboardController();
        $html = (string) $controller->index();

        $this->assertStringContainsString('Dashboard Humas Rehabilitasi', $html);
        $this->assertStringContainsString('Selamat datang, Humas Rehabilitasi.', $html);
    }

    public function testItFallsBackToTheGeneralDashboardWhenRoleIsMissing(): void
    {
        session()->set('auth_user', [
            'name' => 'Tanpa Role',
        ]);

        $controller = new DashboardController();
        $html = (string) $controller->index();

        $this->assertStringContainsString('Dashboard Humas Umum', $html);
    }
}
