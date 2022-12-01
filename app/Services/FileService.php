<?php

namespace App\Services;

use Exception;

use Illuminate\Support\Facades\Storage;

const AVAILABLE_PROVIDER = ['local', 'public'];
const DEFAULT_PATH = 'assets/';
class FileService
{
    private $storage;

    function __construct($diskProvider = 'public') {
        if (!in_array($diskProvider, AVAILABLE_PROVIDER)) {
            throw new Exception('Invalid disk provider in file service: '.$diskProvider);
        }

        $this->storage = Storage::disk($diskProvider);

    }

    public function upload($file, $path = '')
    {
        $filename = $this->generateFileName($file);
        $upload = $this->storage->put(DEFAULT_PATH.$path.$filename, file_get_contents($file->getRealPath()));

        if ($upload) {
            return $this->storage->url(DEFAULT_PATH.$path.$filename);
        } else {
            throw new Exception('Failed on uploading file');
        }
    }

    private function generateFileName($file)
    {
        $today = date('Y_m_d_h_i_s');

        $filename = $today.'.'.$file->getClientOriginalExtension();
        return $filename;
    }

    public function getFile($path)
    {
        return $this->storage->get($path);
    }
}
