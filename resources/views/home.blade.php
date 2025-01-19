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
<h1>Welcome Dude...</h1>

@if(session()->has('post-created'))
    {{ session()->get('post-created') }}
@endif

@if(session()->has('post-updated'))
    {{ session()->get('post-updated') }}
@endif
<br><br>

@auth()
    @can('is-admin')
        <a href="#">Admin Panel</a>
    @endcan
@endauth

@foreach($posts as $post)
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
    </div>
@endforeach



</body>
</html>
