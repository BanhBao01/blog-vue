<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Post;
use App\Tag;
use App\PostTags;
use Validator;
use App\Http\Resources\Posts as PostsResource;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::with('posttags','category','photo')->get();
        return PostsResource::collection($post);
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
        $validator = Validator::make($request->all(), [
                    'title' => 'required|max:255',
                    'image' => 'required',
                    'category_id' => 'required',
                    'tags' => 'required',
                    'content' => 'required',
                    'sub_title' => 'required'
                ]);
        if ($validator->fails()) {
            return response([
                'code' => '500',
                'message' => 'false',
                'message_client' => 'Not Required '
                ]);
        }else{
            try {
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
                $post = Post::create([
                    'title' => $request->title,
                    'slug_title' => str_slug($request->title),
                    'photo_id' => $photo->id,
                    'category_id' => $request->category_id,
                    'content' => $request->content,
                    'sub_title' => $request->sub_title,
                    'status' => $request->status
                ]);
                $tags = Tag::whereIn('id',$request->tags)->get();
                foreach ($tags as $tag) {
                    PostTags::create([
                        'post_id' => $post->id,
                        'tag_id' => $tag->id,
                        'tag' => $tag->name
                    ]);
                }
                return response([
                    'code' => '201',
                    'message' => 'true',
                    'message_client' => 'Create Post Success'
                ]);
            } catch (\Throwable $th) {
            //throw $th;
                return response([
                    'code' => '404',
                    'message' => 'false',
                    'message_client' => $th
                ]);
            }
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
        $post = Post::findOrfail($id);
        return new PostsResource($post);
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
        $validator = Validator::make($request->all(), [
                    'title' => 'required|max:255',
                    'category_id' => 'required',
                    'tags' => 'required',
                    'content' => 'required',
                    'sub_title' => 'required'
                ]);
        if ($validator->fails()) {
            return response([
                'code' => '500',
                'message' => 'false',
                'message_client' => 'Not Required '
                ]);
        }else{
            try {
                $post = Post::find($id);
                if($request->image != null){
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
                    $post->update([
                        'title' => $request->title,
                        'slug_title' => str_slug($request->title),
                        'photo_id' => $photo->id,
                        'category_id' => $request->category_id,
                        'content' => $request->content,
                        'sub_title' => $request->sub_title,
                        'status' => $request->status
                    ]);
                }else{
                    $post->update([
                        'title' => $request->title,
                        'slug_title' => str_slug($request->title),
                        'category_id' => $request->category_id,
                        'content' => $request->content,
                        'sub_title' => $request->sub_title,
                        'status' => $request->status
                    ]);
                }
                $tags = Tag::whereIn('id',$request->tags)->get();
                $id_tags = $post->posttags->pluck('id');
                PostTags::destroy($id_tags);
                foreach ($tags as $tag) {
                    PostTags::create([
                        'post_id' => $post->id,
                        'tag_id' => $tag->id,
                        'tag' => $tag->name
                    ]);
                }
                return response([
                    'code' => '201',
                    'message' => 'true',
                    'message_client' => 'Update Post Success'
                ]);
            } catch (\Throwable $th) {
            //throw $th;
                return response([
                    'code' => '404',
                    'message' => 'false',
                    'message_client' => $th
                ]);
            }
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
            $post = Post::findOrfail($id);
            $id_tags = $post->posttags->pluck('id');
            PostTags::destroy($id_tags);
            $post->delete();
            return response([
                'code' => '201',
                'message' => 'true',
                'message_client' => 'Delete Post Success'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                'code' => '500',
                'message' => 'false',
                'message_client' => 'Delete Post Error'
            ]);
        }
    }
}
