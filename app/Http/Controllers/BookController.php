<?php

// use Auth;
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Validator;             //この行追加！
use Illuminate\View\View;  //この行追加！
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::orderBy('created_at', 'asc')->paginate(3);
        // $books = Book::where('user_id',Auth::user()->id)->orderBy('created_at', 'asc')->paginate(3);
        return view('books', [
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //バリデーション
    $validator = Validator::make($request->all(), [
         'item_name' => 'required|min:3|max:255',
         'item_number' => 'required | min:1 | max:3',
         'item_amount' => 'required | max:6',
         'published'   => 'required',
    ]);

        //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    
        //以下に登録処理を記述（Eloquentモデル）
    
      // Eloquentモデル
      $books = new Book;
      $books->user_id     = Auth::user()->id; //追加のコード
      $books->item_name   = $request->item_name;
      $books->item_number = $request->item_number;
      $books->item_amount = $request->item_amount;
      $books->published   = $request->published;
      $books->imge        = $request->imge;
    
      
     // 画像投稿機能
      // 画像フォームでリクエストした画像情報を取得
      $imge = $request->file('imge');
      // storage > public > img配下に画像が保存される
    //   $path = $img->store('img','public');
    //   $img_path = Storage::putFileAs('', $img, $img->getClientOriginalName(), '');
    
    // 画像がアップロードされていれば、storageに保存
        if($request->hasFile('imag')){
            $path = \Storage::put('/public', $imge);
            $path = explode('/', $path);
        }else{
            $path = null;
        }
    
    
      
      $books->save(); 
      return redirect('/');
      
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }
   
        //更新画面
    public function edit($book_id): View
    {
        $books = Book::where('user_id',Auth::user()->id)->find($book_id);
        //{books}id 値を取得 => Book $books id 値の1レコード取得
        return view('booksedit', ['book' => $books]);
    }
        

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //バリデーション
         $validator = Validator::make($request->all(), [
             'id' => 'required',
             'item_name' => 'required|min:3|max:255',
             'item_number' => 'required|min:1|max:3',
             'item_amount' => 'required|max:6',
             'published' => 'required',
        ]);
        //バリデーション:エラー
         if ($validator->fails()) {
             return redirect('/booksedit/'.$request->id)
                 ->withInput()
                 ->withErrors($validator);
        }
        
        //データ更新
        $books = Book::where('user_id',Auth::user()->id)->find($request->id);
        // $books = Book::find($request->id);
        $books->item_name   = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published   = $request->published;
        $books->save();
        return redirect('/');
        
        
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
         $book->delete();       //追加
         return redirect('/');  //追加
    }

}