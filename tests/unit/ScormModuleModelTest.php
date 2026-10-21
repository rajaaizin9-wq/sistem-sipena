<?php

use App\Models\ScormModuleModel;
use CodeIgniter\Test\CIUnitTestCase;

final class ScormModuleModelTest extends CIUnitTestCase
{
    public function testCanPersistAndToggleScormModules(): void
    {
        $path = WRITEPATH . 'scorm_modules.json';
        if (is_file($path)) {
            unlink($path);
        }

        $model = new ScormModuleModel();
        $id = $model->saveModule([
            'title' => 'Modul Uji',
            'description' => 'Deskripsi uji',
            'version' => '1.0',
            'folder_name' => 'modul-uji',
            'launch_file' => 'index.html',
            'thumbnail' => 'thumb.jpg',
            'published' => 0,
        ]);

        $this->assertNotEmpty($id);

        $modules = $model->getModules();
        $this->assertCount(1, $modules);

        $module = $model->getModuleById($id);
        $this->assertSame('Modul Uji', $module['title']);
        $this->assertSame('1.0', $module['version']);

        $this->assertTrue($model->togglePublished($id, 1));
        $this->assertSame(1, (int) $model->getModuleById($id)['published']);

        $this->assertTrue($model->deleteModule($id));
        $this->assertCount(0, $model->getModules());
    }
}
