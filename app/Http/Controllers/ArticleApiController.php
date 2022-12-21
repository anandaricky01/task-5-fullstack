<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ArticleApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->path = public_path() . "\img\\";
    }

    public function index()
    {
        try {
            return response()->json([
                'data' => Article::latest()->paginate(7)->withQueryString()
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'category_id' => 'required|numeric'
        ]);

        $file = $request->file('image');

        $filename = md5($file->getClientOriginalName()) . md5(microtime(false)) . "." . $file->getClientOriginalExtension();

        if ($validated->fails()) {
            return response()->json(['message' => $validated->errors()], 422);
        }

        try {
            $file->move($this->path, $filename);
            $article = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $filename,
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id
            ]);

            $response = [
                'data' => $article,
                'message' => 'Data has been created!',
                'status' => true,
                'code' => 201
            ];

            return response()->json($response, $response['code']);
        } catch (QueryException $e) {
            return response()->json(['message' => $e->errorInfo]);
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
        try {
            $response = [
                'message' => 'Single data show',
                'data' => $article,
                'status' => true,
                'code' => 200
            ];

            return response()->json($response, $response['code']);
        } catch (QueryException $e) {
            return response()->json(['message' => $e->errorInfo]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'category_id' => 'required|numeric'
        ]);

        if ($validated->fails()) {
            return response()->json(['message' => $validated->errors()], 422);
        }
        $file = $request->file('image');
        $old_path = $this->path . $article->image;

        if($request->file('image')){
            File::delete($old_path);
            $filename = md5($file->getClientOriginalName()) . md5(microtime(false)) . "." . $file->getClientOriginalExtension();
            $file->move($this->path, $filename);
        } else {
            $filename = $article->image;
        };

        try {
            $article->update([
                'title' => $request->title,
            'content' => $request->content,
            'image' => $filename,
            'category_id' => $request->category_id
            ]);
            $response = [
                'message' => 'transaction update',
                'data' => $article,
                'status' => true,
                'code' => 200
            ];

            return response()->json($response, $response['code']);
        } catch (QueryException $e) {
            return response()->json(['message' => $e->errorInfo]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            $article->delete($article->id);
            $response = [
                'message' => 'Article Deleted!'
            ];

            return response()->json($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed ' . $e->errorInfo
            ]);
        }
    }
}
