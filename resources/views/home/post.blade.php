@extends("layouts/frontend")

@section("style")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">

    <link rel="stylesheet" type="text/css" href="css/home.post.css" />
@endsection

@section("content")
    <div class="container">
       <div class="content">
           <h3 class="post-title">{{$post->title}}</h3>
           <hr>
           <div class="post-intro">
               <a class="author" href="javascript:void(0);">{{$post->author_name}}</a>
               <text class="time">{{$post->created_at}}</text>
           </div>
           <div class="post-content">{!! $post->content_html !!}</div>
       </div>
    </div>
@endsection

@section("script")
    <script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
@endsection
