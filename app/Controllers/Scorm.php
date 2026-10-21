<?php

namespace App\Controllers;

use App\Models\ScormModuleModel;
use CodeIgniter\Controller;

class Scorm extends Controller
{
    public function index()
    {
        return redirect()->to('/belajar');
    }

    public function launch($packageId = null)
    {
        if (! $packageId) {
            return redirect()->back()->with('error', 'Package ID required');
        }

        $model = new ScormModuleModel();
        $module = $model->getModuleById($packageId);

        if ($module === null) {
            return redirect()->to('/belajar')->with('error', 'Modul tidak ditemukan.');
        }

        if ((int) ($module['published'] ?? 0) !== 1) {
            return redirect()->to('/belajar')->with('error', 'Modul ini belum dipublikasikan.');
        }

        $folderName = trim((string) ($module['folder_name'] ?? $packageId));
        $launchFile = trim((string) ($module['launch_file'] ?? 'index.html'));
        $launchFile = str_replace('\\', '/', $launchFile);
        $launchFile = ltrim($launchFile, '/');

        $filePath = FCPATH . 'scorm/' . $folderName . '/' . $launchFile;
        if (! is_file($filePath) || ! is_readable($filePath)) {
            return redirect()->to('/belajar')->with('error', 'File modul tidak ditemukan.');
        }

        $contentUrl = base_url('scorm/content/' . rawurlencode($folderName) . '/' . ltrim($launchFile, '/'));

        $publishedModules = $model->getPublishedModules();
        $prevModule = null;
        $nextModule = null;
        if (is_array($publishedModules)) {
            foreach ($publishedModules as $index => $item) {
                if (($item['id'] ?? '') === ($module['id'] ?? '')) {
                    $nextModule = $publishedModules[$index - 1] ?? null;
                    $prevModule = $publishedModules[$index + 1] ?? null;
                    break;
                }
            }
        }

        // Render the player inside the public site layout so navigation and
        // footer remain available while a learner is viewing the module.
        return view('layouts/public', [
            'title'   => ($module['title'] ?? 'SCORM') . ' | BNN Kota Tanjungpinang',
            'content' => view('scorm/launch', [
                'module'     => $module,
                'launchUrl'  => $contentUrl,
                'prevModule' => $prevModule,
                'nextModule' => $nextModule,
            ]),
        ]);
    }

    public function content($folderName = null, $path = null)
    {
        if (! $folderName || ! $path) {
            return $this->response->setStatusCode(404)->setBody('File not found');
        }

        $decodedFolder = rawurldecode($folderName);
        $decodedPath = rawurldecode($path);
        $decodedPath = str_replace('\\', '/', $decodedPath);
        $decodedPath = ltrim($decodedPath, '/');

        $safePath = FCPATH . 'scorm/' . $decodedFolder . '/' . $decodedPath;
        $baseDir = FCPATH . 'scorm/' . $decodedFolder;


        if (! is_file($safePath) || ! is_readable($safePath)) {
            return $this->response->setStatusCode(404)->setBody('File not found');
        }

        if (str_contains($decodedPath, '..') || str_starts_with($decodedPath, '/')) {
            return $this->response->setStatusCode(403)->setBody('Forbidden');
        }

        $realBase = realpath($baseDir);
        $realFile = realpath($safePath);
        if ($realBase === false || $realFile === false || strpos($realFile, $realBase) !== 0) {
            return $this->response->setStatusCode(403)->setBody('Forbidden');
        }

        $extension = strtolower(pathinfo($safePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'html' => 'text/html; charset=utf-8',
            'htm' => 'text/html; charset=utf-8',
            'js' => 'application/javascript; charset=utf-8',
            'css' => 'text/css; charset=utf-8',
            'xml' => 'application/xml; charset=utf-8',
            'json' => 'application/json; charset=utf-8',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'pdf' => 'application/pdf',
            'mp3' => 'audio/mpeg',
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'ogg' => 'audio/ogg',
            'wav' => 'audio/wav',
            'txt' => 'text/plain; charset=utf-8',
            'xsd' => 'application/xml; charset=utf-8',
        ];

        $mime = $mimeTypes[$extension] ?? 'application/octet-stream';

        return $this->response->setHeader('Content-Type', $mime)->setBody(file_get_contents($safePath));
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getPost();

            return $this->response->setJSON(['status' => 'success', 'data' => $data]);
        }

        return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
    }

    public function getManifest($packageId = null)
    {
        if (! $packageId) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Package not found']);
        }

        $model = new ScormModuleModel();
        $module = $model->getModuleById($packageId);

        if ($module === null) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Package not found']);
        }

        return $this->response->setJSON([
            'id' => $module['id'] ?? $packageId,
            'title' => $module['title'] ?? '',
            'launch_file' => $module['launch_file'] ?? 'index.html',
        ]);
    }
}
