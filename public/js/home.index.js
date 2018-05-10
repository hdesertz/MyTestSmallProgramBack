let refreshVerifyCode = ()=>{
    $.getJSON("/tool/verifyCode",function (ret) {
    	if(ret.code === 0){
            $("#verifyCodeImg").attr("src",ret.data);
        }
    });
};


$(function() {
    $('[data-toggle="tooltip"]').tooltip();

    refreshVerifyCode();

	$("#loginForm").submit(function (event) {
        event.preventDefault();
        let param = $(this).serialize();
        $.ajax({
			method:"POST",
			url:"/web/login",
			data:param,
		}).done(function (ret) {
			if(ret.code !== 0){
				console.log("login1",ret);
				layer.msg(ret.tips);
                refreshVerifyCode();
				return;
			}
			window.location.href = "/web/create";

        }).fail(function (result) {
            refreshVerifyCode();
			console.log(result);
        });
    });
    $("#refreshVerifyCode").click(function () {
        refreshVerifyCode();
    });
	$("input[type='password'][data-eye]").each(function(i) {
		var $this = $(this);

		$this.wrap($("<div/>", {
			style: 'position:relative'
		}));
		$this.css({
			paddingRight: 60
		});
		$this.after($("<div/>", {
			html: 'Show',
			class: 'btn btn-primary btn-sm',
			id: 'passeye-toggle-'+i,
			style: 'position:absolute;right:10px;top:50%;transform:translate(0,-50%);-webkit-transform:translate(0,-50%);-o-transform:translate(0,-50%);padding: 2px 7px;font-size:12px;cursor:pointer;'
		}));
		$this.after($("<input/>", {
			type: 'hidden',
			id: 'passeye-' + i
		}));
		$this.on("keyup paste", function() {
			$("#passeye-"+i).val($(this).val());
		});
		$("#passeye-toggle-"+i).on("click", function() {
			if($this.hasClass("show")) {
				$this.attr('type', 'password');
				$this.removeClass("show");
				$(this).removeClass("btn-outline-primary");
			}else{
				$this.attr('type', 'text');
				$this.val($("#passeye-"+i).val());				
				$this.addClass("show");
				$(this).addClass("btn-outline-primary");
			}
		});
	});
});