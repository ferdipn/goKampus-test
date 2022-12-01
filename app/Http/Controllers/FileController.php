<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use App\Services\FileService;

class FileController extends Controller
{
    function __construct() {
        $this->fileService = new FileService;
    }

    public function uploadFile(Request $request) {

        $validator = Validator::make($request->all(), [
            'file' => 'required|file',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $fileURL = $this->fileService->upload($request->file('file'));

            return response()->json([
                'url' => $fileURL,
                'code' => 201
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function downloadFile($fileName)
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);


        $contentType = [
            'jpg' => 'image/jpg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/jpg'
        ];

        return Storage::download('public/assets/'.$fileName);
    }
}
