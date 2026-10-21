<?php

use App\Controllers\Scorm;
use App\Models\ScormModuleModel;
use CodeIgniter\Test\CIUnitTestCase;

final class ScormControllerTest extends CIUnitTestCase
{
    protected function tearDown(): void
    {
        $path = WRITEPATH . 'scorm_modules.json';
        if (is_file($path)) {
            unlink($path);
        }

        $folder = FCPATH . 'scorm/scorm-test';
        if (is_dir($folder)) {
            @unlink($folder . '/index.html');
            @rmdir($folder);
        }

        parent::tearDown();
    }

    public function testItBuildsAContentRouteForLaunchFiles(): void
    {
        $folder = FCPATH . 'scorm/scorm-test';
        if (! is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        file_put_contents($folder . '/index.html', '<html><body>ok</body></html>');

        $model = new ScormModuleModel();
        $model->saveModule([
            'id' => 'scorm-test',
            'title' => 'Modul Uji',
            'description' => 'Deskripsi',
            'version' => '1.0',
            'folder_name' => 'scorm-test',
            'launch_file' => 'index.html',
            'thumbnail' => '',
            'published' => 1,
        ]);

        $controller = new Scorm();
        $html = (string) $controller->launch('scorm-test');

        $this->assertStringContainsString('scorm&#x2F;content', $html);
        $this->assertStringContainsString('scorm-test', $html);
    }
}
