<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class AminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all(); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            return Category::create($request->all());
        } catch (\Throwable $th) {
            return response([
                'code' => '500',
                'message_dev' => 'false',
                'message_client' => 'Create Category Error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::findOrfail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        try {
            $category = Category::findOrfail($id);
            $category->update($request->all());
            return $category;
        } catch (\Throwable $th) {
            return response([
                'code' => '500',
                'message_dev' => 'false',
                'message_client' => 'Update Category Error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Category::destroy($id);
        } catch (\Throwable $th) {
            return response([
                'code' => '500',
                'message_dev' => 'false',
                'message_client' => 'Delete Category Error'
            ]);
        }
    }
}
