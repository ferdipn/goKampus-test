<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Services\ArticleService;
use App\Services\FileService;

class ArticleController extends Controller
{
    function __construct() {
        $this->fileService = new FileService;
        $this->articleService = new ArticleService;
    }

    public function index(Request $request) {
        try {
            $articles = $this->articleService->getArticles($request);

            return response()->json([
                'data' => $articles,
                'code' => 200,
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id) {

        try {
            $article = $this->articleService->getArticleByID($id);

            return response()->json([
                'data' => $article,
                'code' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'creator' => 'required|exists:users,id',
            'title' => 'required|unique:articles,title,NULL,id,deleted_at,NULL',
            'image' => 'required|file|max:5000', // max 5MB
            'content' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $request['image_url'] = $this->fileService->upload($request->file('image'));

        try {
            $article = $this->articleService->storeArticle($request);

            return response()->json([
                'message' => 'Article created successfully',
                'code' => 201,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function put(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'creator' => 'required|exists:users,id',
            'title' => 'required|unique:articles,title,NULL,id,deleted_at,NULL',
            'image' => 'required|file|max:5000', // max 5MB
            'content' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $request['image_url'] = $this->fileService->upload($request->file('image'));

        try {
            $article = $this->articleService->updateArticleByID($id, $request);

            return response()->json([
                'message' => 'Article updated successfully',
                'code' => 201,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete($id) {
        try {
            $article = $this->articleService->deleteArticleByID($id);

            return response()->json([
                'message' => 'Article deleted successfully',
                'code' => 200,
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
