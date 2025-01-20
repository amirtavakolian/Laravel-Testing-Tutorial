<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div style="border: red; border-width: 5px; border-style: dashed">
    <h5>{{ $post->title }}</h5>
    <p>{{ $post->content }}</p>
    <div>
        @auth()
            @can('update', $post)
                <a href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
            @endcan
        @endauth
    </div>
    <hr>
    <div>
        <h2 style="color: red">Comments:</h2>
        @foreach($post->comments as $comment)
            <div>
                <h3>{{ $comment->user->name }}:</h3>
                <p>{{ $comment->content }}</p>
            </div>
        @endforeach
        <hr>
    </div>

    @if(session()->has('comment_saved'))
        <p>{{ session()->get('comment_saved') }}</p>
    @endif

    <br>
    @auth()
        <h2>write comment: </h2>
        <form method="POST" action="{{ route('comment.store', ['post' => $post]) }}">
            @csrf
            <textarea name="content"></textarea>
            <br><br>
            <input type="submit" value="submit">
        </form>
    @else()
        <h3>
            please login for writing comment ==>
            <a href="{{ route('auth.login') }}">Login</a>
        </h3>

    @endauth

</div>
</body>
</html>
