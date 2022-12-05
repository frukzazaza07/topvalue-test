<?php

namespace App\Http\Controllers;

use App\Models\CategoryRelation;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryRelationController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index($categoryId)
    {
        //get posts
        $categoryRelation = DB::table(DB::raw('categoryrelation'))
            ->select(DB::raw('categoryrelation.id, categorys.categoryName, categoryrelation.orderShow, uploads.userId, uploads.image, uploads.size, uploads.mime, categoryrelation.created_at'))
            ->join('categorys', 'categorys.id',  '=', 'categoryrelation.categoryId')
            ->join('uploads', 'uploads.id',  '=', 'categoryrelation.uploadId')
            ->where('categoryrelation.status', 'active')
            ->where('uploads.status', 'active')
            ->where('categorys.status', 'active')
            ->where('categoryrelation.status', 'active')
            ->where('categoryrelation.categoryId', $categoryId)
            ->where('categorys.userId', Auth::id())
            ->orderBy('categoryrelation.orderShow')
            ->get();

        if(count($categoryRelation) == 0){
            return redirect('/categorys')->with(['error' => 'Add category first.']);
        }    

        $uploads = Upload::where('status', 'active')
            ->where('uploads.userId', Auth::id())
            ->latest()
            ->paginate(5);

        //render view with uploads
        return view('categoryRelation.index', compact(['categoryRelation', 'uploads', 'categoryId']));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('categoryRelation.create');
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
            'categoryId' => 'required',
            'uploadId' => 'required',
        ]);


        //create post
        CategoryRelation::create([
            'categoryId' => $request->categoryId,
            'uploadId' => $request->uploadId,
            'userId' => Auth::id(),
            // 'content'   => $request->content
        ]);

        //redirect to index
        return redirect('/category-relation/view/' . $request->categoryId)->with(['success' => 'Add image to category successfully.']);
    }

    /**
     * edit
     *
     * @param  mixed $post
     * @return void
     */
    public function edit($id)
    {
        $category = CategoryRelation::find($id);
        return view('categoryRelation.edit', compact('category', 'id'));
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
        $categoryRelation = CategoryRelation::find($id);
        $this->validate($request, [
            'orderShow' => 'required',
        ]);

        $categoryRelation->update([
            'orderShow' => $request->orderShow,
        ]);

        //redirect to index
        return redirect('/category-relation/view/' . $categoryRelation->categoryId)->with(['success' => 'Change image order successfully.']);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {
        $category = CategoryRelation::find($id);
        $category->update([
            'status' => 'inactive',
        ]);

        //redirect to index
        return redirect('/category-relation/view/' . $category->categoryId)->with(['success' => 'Delete successfully.']);
    }
}
