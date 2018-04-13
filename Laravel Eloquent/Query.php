<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table_A;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function query(){

        // Create
        $Create = Table::create([
            'message' => 'A new comment.',
        ]);

        // Create Multiple
        $Create = Table::createMany([
            [
                'message' => 'A new comment.',
            ]
        ]);

        // Create Sync
        $CreateSync = $user->roles()->sync([1]);

        // Update
        $update = Table::where('active', 1)
                       ->update([
                            'delayed' => 1
                       ]);

        // Update Multiple
        $update = Table::whereIn('id', [1])
                       ->update([
                         ['column' => 'value']
                       ]);

        // Delete
        $delete = Table::where('active', 1)->delete();

        // Delete Multiple
        $delete = Table::whereIn('id', [1])->delete();

        // One To One
        $phone = User::find(1)->phone;

        // One To Many
        $comments = App\Post::find(1)->comments;
        $comments = App\Post::find(1)->comments()->where('title', 'foo')->first();

        // Many To Many
        $roles = App\User::find(1)->roles()->orderBy('name')->get();

        #Eager Loading
        $books = App\Book::with('author')->get();
        $books = App\Book::with(['author', 'publisher'])->get();
        $books = App\Book::with('author.contacts')->get();
        $users = App\Book::with('author:id,name')->get();
        
        $users = App\User::with(['posts' => function ($query) use ($param){
            $query->where('title', 'like', '%first%');
        }])->get();

        $users = App\User::with(['posts' => function ($query) use ($param){
            $query->orderBy('created_at', 'desc');
        }])->get();

        // Collection
        where('price', '=', 100);
        whereIn('price', [150, 200]);
        whereNotIn('price', [150, 200]);
        push(5);
        random();
        pluck('name');
        first();
        except(['price', 'discount']);
        get('foo', 'default-value');
        has('product');
        implode('product', ', ');
        isEmpty();
        isNotEmpty();
        all();
        slice(4, 2);
    }
}
