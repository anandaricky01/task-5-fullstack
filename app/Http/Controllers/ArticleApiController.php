<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ArticleApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                'image' => 'nullable',
                'category_id' => 'required|numeric'
            ]);

            if($validated->fails()){
                return response()->json(['message' => $validated->errors()], 422);
            }

            // insert the user_id into the $request array
            $request['user_id'] = Auth::user()->id;

            try {
                $article = Article::create($request->all());
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
            'image' => 'nullable',
            'category_id' => 'required|numeric'
        ]);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 422);
        }

        try {
            $article->update($request->all());
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
