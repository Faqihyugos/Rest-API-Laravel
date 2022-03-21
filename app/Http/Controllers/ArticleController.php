<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseFormatter;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(5);

        return ResponseFormatter::success(
            $articles,
            'Articles retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:1000',
            'image' => 'required',
            'user_id' => 'required|integer',
            'category_id' => 'required|integer'
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error($validate->errors(), 400);
        }

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            // 'image' => $request->image->store(
            //     'assets/img_article', 'public'
            // ),
            'user_id' => $request->user_id,
            'category_id' => $request->category_id
        ]);
        return ResponseFormatter::success($article, 'Article created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);

        return ResponseFormatter::success($article, 'Article retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:1000',
            'image' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'category_id' => 'required|integer'
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error($validate->errors(), 400);
        }

        $article = Article::find($id);
        if(empty($article)) {
            return;
        }
        $article->title = $request->title;
        $article->content = $request->content;
        $article->image = $request->image;
        $article->user_id = $request->user_id;
        $article->category_id = $request->category_id;
        $article->save();

        return ResponseFormatter::success($article, 'Article updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if(empty($article)) {
            return;
        }
        $article->delete();
        return ResponseFormatter::success(null, 'Article deleted successfully');
    }
}
