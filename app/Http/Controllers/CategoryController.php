<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseFormatter;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(5);

        return ResponseFormatter::success(
            $categories,
            'Categories retrieved successfully'
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
          'name' => 'required|string|max:100',
          'user_id' => 'required|integer',
      ]);   

        if ($validate->fails()) {
            return ResponseFormatter::error($validate->errors(), 400);
        }

        $category = Category::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return ResponseFormatter::success($category, 'Category created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ResponseFormatter::error('Category not found', 404);
        }

        return ResponseFormatter::success($category, 'Show detail Category');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'user_id' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error($validate->errors(), 400);
        }

        $category = Category::find($id);

        if (!$category) {
            return ResponseFormatter::error('Category not found', 404);
        }

        $category->update([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return ResponseFormatter::success($category, 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return ResponseFormatter::success('Category deleted successfully');
    }
}
