<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function deletePost(POST $post) {
        if(auth() -> user() -> id == $post['user_id']){
            auth() -> delete();
        }
        return redirect('/');
    }
    public function saveEdittedPost(POST $post, Request $request) {
        if(auth() -> user() -> id != $post['user_id']){
            return redirect('/');
        }

        $incomingFields = $request -> validate([
            'title' => ['required', 'max:30', Rule::unique('posts', 'title')],
            'body' => ['required', 'min:10', 'max:100']
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post -> update($incomingFields);

        return redirect('/');
    }

    public function editPost(POST $post) {
        if(auth() -> user() -> id != $post['user_id']){
            return redirect('/');
        }
        return view('edit-post', ['post' => $post]);
    }

    public function createPost(Request $request){

        $incomingFields = $request -> validate([
            'title' => ['required', 'max:30', Rule::unique('posts', 'title')],
            'body' => ['required', 'min:10', 'max:100']
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth() -> id();

        Post::create($incomingFields);
        
        return redirect('/');
    }
}
