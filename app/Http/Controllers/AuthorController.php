<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $items = Author::simplePaginate(4);
        return view("index",["items" => $items]);
    }
    
    public function find()
    {
        return view("find",["input"=>""]);
    }
    public function search(Request $request)
    {
        $item = Author::where("name", $request->input)->first();
        $param = [
            "item" => $item,
            "input" => $request->input
        ];
        return view("find", $param);
    }
    public function bind(Author $author)
    {
        $data = [
            "item" => $author,
        ];
        return view("author.binds", $data);
    }
    public function add()
    {
        return view("add");
    }
    public function create(Request $request)
    {
        $this->validate($request,Author::$rules);
        $form = $request->all();
        Author::create($form);
        return redirect("/");
    }
    public function edit(Request $request)
    {
        $author = Author::find($request->id);
        return view("edit",["form" => $author]);
    }
    public function update(Request $request)
    {
        $this->validate($request,Author::$rules);
        $form = $request->all();
        unset($form["_token"]);
        Author::where("id",$request->id)->update($form);
        return redirect("/");
    }
    public function delete(Request $request)
    {
        $author = Author::find($request->id);
        return view("delete",["form"=>$author]);
    }
    public function remove(Request $request)
    {
        Author::find($request->id)->delete();
        return redirect("/");
    }
    public function relate(Request $request)
    {
        $hasItems = Author::has("book")->get();
        $noItems = Author::doesntHave("book")->get();
        $param = ["hasItems" =>$hasItems,"noItems"=>"noItems"];
        return view("author.index",$param);
    }

}
