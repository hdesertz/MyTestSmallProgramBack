@extends("layouts/frontend")

@section("style")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.create.css" />
@endsection

@section("content")
    <div class="container">
        <h2  class="alert alert-info" role="alert" style="text-align: center">文章创作</h2>
        <form id="createPost-form" >
            <div class="form-group">
                <label for="title">标题</label>
                <input type="text" class="form-control" id="title"  name="title" required autofocus>
            </div>
            <div class="form-group">
                <label for="content">正文（仅支持 Markdown 语法）</label>
                <textarea class="form-control" id="content" name="content" ></textarea>
            </div>
            <div class="form-group">
                <label for="category">分类</label>
                <select class="form-control" id="category" name="category">
                    @foreach($categoryList as $cate)
                        <option value="{{$cate['en_name']}}">{{$cate['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="summary">摘要</label>
                <textarea class="form-control" id="summary"  name="summary" rows="2"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">提交</button>
            </div>
        </form>
    </div>

@endsection

@section("script")
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
    <script>
        var simplemde = new SimpleMDE({
            element: $("#content")[0],
            showIcons: ["code", "table"],
            renderingConfig: {
                singleLineBreaks: false,
                codeSyntaxHighlighting: true,
            },
        });
        $(function(){
            $("#createPost-form").submit(function(event){
                event.preventDefault();
                let postData = $(this).serialize();
                postData.content = simplemde.value();

                $.ajax({
                    method:"post",
                    url:"web/createPost",
                    dataType:"json",
                    data:$(this).serialize()
                }).done(function(ret){
                    if(ret.code !== 0 && ret.data){
                        layer.msg(ret.tips);
                        console.log("createPost1",ret);
                        return;
                    }
                    console.log(ret.data);
                    location.href = "web/post/"+ret.data;
                }).fail(function(result){
                    console.log("createPost2",result);
                });
            });
        });
    </script>
@endsection
