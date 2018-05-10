@extends("layouts/frontend")
@section("style")
    <link rel="stylesheet" type="text/css" href="css/home.index.css">
@endsection

@section("content")
<div class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <img src="img/lg.coffee-cup-drink-loader.gif">
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">登录</h4>
                            <form id="loginForm">
                                <div class="form-group">
                                    <label for="account">账号</label>
                                    <input id="account" type="text" class="form-control" name="account" value=""
                                           required
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="password">密码</label>
                                    <input id="password" type="password" class="form-control" name="password" required
                                           data-eye>
                                </div>
                                <div class="form-group">
                                    <label for="verifyCode">验证码</label>
                                    <input id="verifyCode" style="margin-bottom:10px" type="text" class="form-control"
                                           name="verifyCode" value="" required>
                                    <a href="javascript:void(0);" id="refreshVerifyCode">
                                        <img src="img/lg.coffee-cup-drink-loader.gif" id="verifyCodeImg"
                                             data-toggle="tooltip" data-placement="right" title="刷新验证码"/>
                                    </a>
                                </div>
                                <div class="form-group no-margin">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        登录
                                    </button>
                                </div>
                                <div class="margin-top20 text-center">
                                    创建新账号？
                                    <a href="javascript:void(0);" data-toggle="tooltip" title="请在小程序上注册">
                                        注册
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; {{date("Y")}} &mdash; 自豪地使用 {{config("app.name")}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
    <script src="js/home.index.js"></script>
@endsection