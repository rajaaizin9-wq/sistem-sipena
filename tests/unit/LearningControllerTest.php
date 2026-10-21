<?php

use App\Controllers\Learning;
use App\Models\ScormModuleModel;
use CodeIgniter\Test\CIUnitTestCase;

final class LearningControllerTest extends CIUnitTestCase
{
    protected function tearDown(): void
    {
        $path = WRITEPATH . 'scorm_modules.json';
        if (is_file($path)) {
            unlink($path);
        }

        parent::tearDown();
    }

    public function testItShowsPublishedScormModulesOnTheLearningPage(): void
    {
        $model = new ScormModuleModel();
        $model->saveModule([
            'id' => 'scorm-published',
            'title' => 'Modul Publik Uji',
            'description' => 'Modul yang bisa dibuka pengguna.',
            'version' => '1.0',
            'folder_name' => 'scorm-published',
            'launch_file' => 'index.html',
            'thumbnail' => '',
            'published' => 1,
        ]);

        $controller = new Learning();
        $html = (string) $controller->index();

        $this->assertStringContainsString('Modul Publik Uji', $html);
        $this->assertStringContainsString('scorm/launch/scorm-published', $html);
    }

    public function testItHidesUnpublishedScormModulesOnTheLearningPage(): void
    {
        $model = new ScormModuleModel();
        $model->saveModule([
            'id' => 'scorm-hidden',
            'title' => 'Modul Tersembunyi',
            'description' => 'Modul yang belum dipublikasikan.',
            'version' => '1.0',
            'folder_name' => 'scorm-hidden',
            'launch_file' => 'index.html',
            'thumbnail' => '',
            'published' => 0,
        ]);

        $controller = new Learning();
        $html = (string) $controller->index();

        $this->assertStringNotContainsString('Modul Tersembunyi', $html);
    }
}
