<?php

namespace App\Http\Controllers\API;

use App\Models\Blogs;
use Illuminate\Http\Request;
use App\Http\Requests\BlogsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blogs::all();
        return $this->returnJson(1,__('messages.success'),$blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogsRequest $request)
    {
        $newBlog = $request->user()->blogs()->create($request->only(['title','content']));
        return $this->returnJson(1,__('messages.success'),$newBlog);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blogs::find($id);
        if(!$blog)
           return $this->returnJson(0,__('messages.attr_not_found',['attr'=>__('messages.blog')]));
        return $this->returnJson(1,__('messages.success'),$blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogsRequest $request, string $id)
    {
        $blog = Blogs::find($id);
        if(!$blog)
           return $this->returnJson(0,__('messages.attr_not_found',['attr'=>__('messages.blog')]));

        $blog->update($request->only(['title','content']));
        return $this->returnJson(1,__('messages.success'),$blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blogs::find($id);
        if(!$blog)
           return $this->returnJson(0,__('messages.attr_not_found',['attr'=>__('messages.blog')]));

        $blog->delete();
        return $this->returnJson(0,__('messages.attr_deleted',['attr'=>__('messages.blog')]));
    }
}
