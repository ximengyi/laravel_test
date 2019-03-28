<?php

namespace App\Http\Controllers;
use App\Http\Requests\ArticleFormRequest;
use App\Http\Requests\ArticleStoreRequest;
use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Validator;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        // $validator = Validator::make($request->all(), [
        //     'id' => 'required|integer',
        //     'page' => 'required|integer',
        // ],[]);
        // if ($validator->fails()) {
        //
        //     return $this->failed(155001, $validator->errors()->all(),$validator->errors()->all());
        //
        // }
        // // if ($validator->fails()) {
        // //
        // //     return $this->failed(155001, $validator->errors()->first(),$validator->errors()->first());
        // //
        // // }
        $count = isset($request->count) ? (int)$request->count : 5;
        $datas = Article::orderBy('id', 'desc')->paginate($count);
      // $data = Article::all();


        return $this->success($datas);
    }

    public function show(Article $article)
    {
        return $article;
    }

    public function store(ArticleStoreRequest $request)
    {



        $article = Article::create($request->all());

        return response()->json($article, 201);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Article $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }

}
