<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $uploads = Upload::where('status', 'active')
        ->where('uploads.userId', Auth::id())
        ->latest()
        ->paginate(5);
        $uploadsMimeSize = DB::table('uploads')
        ->select('mime', DB::raw('sum(size) as size'), DB::raw('count(*) as countItem'))
        ->where('status', 'active')
        ->where('uploads.userId', Auth::id())
        ->groupBy('mime')->get();

        //render view with uploads
        return view('uploads.index', compact(['uploads', 'uploadsMimeSize']));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('uploads.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'title'     => 'required|min:5',
            // 'content'   => 'required|min:10'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/uploads/' . Auth::id(), $image->hashName());

        //create post
        Upload::create([
            'image'     => $image->hashName(),
            'userId'     => Auth::id(),
            'size'     => $image->getSize(),
            'mime'     => $image->getMimeType(),
            // 'content'   => $request->content
        ]);

        //redirect to index
        return redirect('/uploads')->with(['success' => 'Insert uploads successfully.']);
    }

    /**
     * edit
     *
     * @param  mixed $post
     * @return void
     */
    public function edit($id)
    {
        $upload = Upload::find($id);
        return view('uploads.edit', compact('upload'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update($id, Request $request)
    {
        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        //check if image is uploaded
        if ($request->hasFile('image')) {
            $upload = Upload::find($id);
            //upload new image
            $image = $request->file('image');
            
            $image->storeAs('public/uploads/' . Auth::id(), $image->hashName());
            //delete old image
            Storage::delete('public/uploads/' . Auth::id() . '/' . $upload->image);

            //update post with new image
            $upload->update([
                'image' => $image->hashName(),
            ]);
        }
        //redirect to index
        return redirect('/uploads')->with(['success' => 'Update uploads successfully.']);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {
        $upload = Upload::find($id);
        //delete image
        Storage::delete('public/' . Auth::id() . '/uploads/' . $upload->image);

        //delete post
        
        $upload->update([
            'status' => 'inactive',
        ]);

        //redirect to index
        return redirect('/uploads')->with(['success' => 'Delete successfully.']);
    }
}
