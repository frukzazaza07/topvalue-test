<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        // $categorys = Category::where('status', 'active')->latest()->paginate(5);
        $categorys = DB::table(DB::raw('categorys'))
        ->select(DB::raw('categorys.id, categorys.categoryName, SUM(uploads.size) AS sumSizeAll, COUNT(*) AS countItemAll, categorys.created_at'))
        ->join('categoryrelation','categorys.id',  '=' ,'categoryrelation.categoryId')
        ->join('uploads','uploads.id',  '=' ,'categoryrelation.uploadId')
        ->where('categoryrelation.status', 'active')
        ->where('uploads.status', 'active')
        ->where('categorys.status', 'active')
        ->where('categoryrelation.status', 'active')
        ->where('categorys.userId', Auth::id())
        ->groupBy('categorys.id')
        ->get();

        //render view with uploads
        return view('categorys.index', compact(['categorys']));
    }
    // SELECT c.categoryName, SUM(u.size), COUNT(*) FROM categoryrelation cr JOIN categorys c ON c.id = cr.categoryId JOIN uploads u ON u.id = cr.uploadId GROUP BY cr.categoryId;
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('categorys.create');
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
            'categoryName' => 'required',
        ]);


        //create post
        Category::create([
            'categoryName' => $request->Auth::id(),
            'userId' => Auth::id(),
            // 'content'   => $request->content
        ]);

        //redirect to index
        return redirect('/categorys')->with(['success' => 'Insert category successfully.']);
    }

    /**
     * edit
     *
     * @param  mixed $post
     * @return void
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categorys.edit', compact('category', 'id'));
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
        $category = Category::find($id);
        $this->validate($request, [
            'categoryName' => 'required',
        ]);

            $category->update([
                'categoryName' => $request->categoryName,
            ]);

        //redirect to index
        return redirect('/categorys')->with(['success' => 'Update category successfully.']);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->update([
            'status' => 'inactive',
        ]);

        //redirect to index
        return redirect('/categorys')->with(['success' => 'Delete successfully.']);
    }
}
