<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;

class AdminPhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return public_path();
        return Photo::all();
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
        $explore = explode("," ,$request->image);
        $decode = base64_decode($explore[1]);
        if(str_contains($explore[0],'jpeg')) {
            $extention = 'png';
        }else{
            $extention = 'jpg';
        }
        $filename = str_random() .'.' . $extention;
        $path = public_path() . '/images/' . $filename;
        file_put_contents($path, $decode);
        $url =(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}";
        $photo = Photo::create([
            'name' => $filename,
            'path' => $url .'/images/' . $filename,
            'size' => 0
        ]);
        return $photo;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
            $photo = Photo::find($id);
            \unlink(public_path(). '/images/'.$photo->name);
            $photo->delete();
            return response([
                'code' => '201',
                'message' => 'true',
                'data' => $photo,
                'message_client' => 'Delete Photo Error'
            ]);
        } catch (\Throwable $th) {
            return response([
                'code' => '500',
                'message' => 'false',
                'message_client' => 'Delete Photo Error'
            ]);
        }
    }
}
