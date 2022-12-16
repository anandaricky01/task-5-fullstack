<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        $this->middleware('auth');
        $this->path = public_path() . "\img\\";
    }

    public function index()
    {
        return view('articles.index', [
            'articles' => Article::latest()->paginate(7)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('articles.create', [
            'categories' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'image' => 'required'
        ]);
        $file = $request->file('image');
        $this->checkImage($file);
        // $extension = $file->getClientOriginalExtension();
        // $extensions = array('png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG');

        // if(!in_array($extension, $extensions)){
        //     return redirect('/article/create')->with('danger', 'Hanya boleh menggunakan ekstensi tersedia!');
        // }

        $filename = md5($file->getClientOriginalName()) . md5(microtime(false)) . "." . $file->getClientOriginalExtension();
        // $path = public_path() . '\img\\';
        // dd($path);
        $validated['image'] = $filename;
        $validated['user_id'] = Auth::user()->id;
        $validated['category_id'] = $validated['category'];
        try{
            $file->move($this->path, $filename);
            Article::create($validated);

            return redirect('/article')->with('success', 'Tambah Success!');

        } catch(QueryException $e){
            return redirect('/article/create')->with('danger', $e->errorInfo);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('articles.edit', [
            'article' => $article,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required'
        ]);

        $file = $request->file('image');
        $old_path = $this->path . $article->image;
        if($request->file('image')){
            $this->checkImage($file);
            File::delete($old_path);
            $filename = md5($file->getClientOriginalName()) . md5(microtime(false)) . "." . $file->getClientOriginalExtension();
            $file->move($this->path, $filename);
        } else {
            $filename = $article->image;
        };
        $validated['category_id'] = $validated['category'];
        $validated['image'] = $filename;
        $article->update($validated);

        return redirect('/article/' . $article->id)->with('success', 'Edit Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try{
            $image_path = $this->path . $article->image;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $article->find($article->id)->delete();

            return redirect('/article')->with('success', 'Article berhasil dihapus!');
        } catch(QueryException $e){
            return redirect('/article')->with('danger', $e->errorInfo);
        }
    }

    public function checkImage($file){
        $extension = $file->getClientOriginalExtension();
        $extensions = array('png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG');

        if(!in_array($extension, $extensions)){
            return redirect('/article/create')->with('danger', 'Hanya boleh menggunakan ekstensi tersedia!');
        }
    }

    public function myPost(){
        $article = Article::where('user_id', Auth::user()->id)->paginate(6)->withQueryString();
        return view('articles.mypost', [
            'articles' => $article
        ]);
    }
}
