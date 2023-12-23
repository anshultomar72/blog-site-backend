<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Site</title>
</head>
<body>
    @auth
        <p>Congrats you are logged in.</p> 
        <form action="/logout" method="POST">
            @csrf
            <button>Log out</button>            
        </form>    
        <div style="border: 3px solid black; padding: 30px">
            <h2>Create a New Post</h2>  
            <form action="/create-post" method="post">
                @csrf
                <input name="title" type="text" placeholder="Post Title">
                <textarea name="body" placeholder="Content of your post"></textarea>
                <button>Save Post</button>
            </form>
        </div>
        
        <div style="border: 3px solid black; padding: 30px">
            <h2>All Posts</h2>
            @foreach ($posts as $post)
                <div style="background-color: gray; padding: 10px; margin: 10px;">
                    <h3>{{$post['title']}} by {{$post -> user -> name}}</h3>
                    {{$post['body']}}
                    <p><a href="/edit-post/{{$post->id}}">Edit Post</a></p>
                    <form action="/delete-post/{{$post -> id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </div>
            @endforeach
        </div>

    @else
    <div style="border: 3px solid black; padding: 30px">
        <h2>Register</h2>
        <form action="/register" method="post">
            @csrf
            <input name="name" type="text" placeholder="name">
            <input name="email" type="text" placeholder="email">
            <input name="password" type="password" placeholder="password">
            <button>Register</button>
        </form>
    </div>
    <div style="border: 3px solid black; padding: 30px">
        <h2>Login</h2>
        <form action="/login" method="post">
            @csrf
            <input name="loginemail" type="text" placeholder="email">
            <input name="loginpassword" type="password" placeholder="password">
            <button>Log in</button>
        </form>
    </div>
    @endauth
</body>
</html>