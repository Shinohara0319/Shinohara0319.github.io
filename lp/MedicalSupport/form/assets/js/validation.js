$(function () {
	$(window).on('load', function(){
		//エラー表示エリアを非表示にする
		$('.is-valid-company').css('display', 'none');
		// $('.is-valid-busyo').css('display', 'none');
		$('.is-valid-name').css('display', 'none');
		$('.is-valid-name').css('display', 'none');
		$('.is-valid-email').css('display', 'none');
		$('.is-valid-tel').css('display', 'none');
	});

	//会社名入力チェック
	$("#your-company").blur(function () {
		checkCompany();
	});
	//部署入力チェック
	// $("#your-busyo").blur(function () {
	// 	checkBusyo();
	// });
	//名前チェック
	$("#your-sei").blur(function () {
		checkSei();
	});
	$("#your-mei").blur(function () {
		checkMei();
	});
	//メールアドレス入力チェック
	$("#your-email").blur(function () {
		checkEmail();
	});
	//電話番号入力チェック
	$("#your-tel").blur(function () {
		checkTel();
	});
	//個人情報の同意のチェック時にエラーを消す
	$("#agree1").change(function () {
		if ($("#agree1").prop("checked")) {
			$(".is-valid-agree1").text("");
		}else{
			$(".is-valid-agree1").text("「同意する」にチェックしてください。");
		}
	});
	//個人情報の同意のチェック時にエラーを消す
	$("#agree2").change(function () {
		if ($("#agree2").prop("checked")) {
			$(".is-valid-agree2").text("");
		}else{
			$(".is-valid-agree2").text("「同意する」にチェックしてください。");
		}
	});

	//送信時の必須項目入力チェック
	$("#confirm").on('click', function () {
		var err_cnt = 0,
			err_point = "";

		if ($("#agree1").prop("checked")) {
			$(".is-valid-agree1").text("");
		}else{
			$(".is-valid-agree1").text("「同意する」にチェックしてください。");
			err_cnt += 1;
			err_point = "privacy_check_box";
		}
		if ($("#agree2").prop("checked")) {
			$(".is-valid-agree2").text("");
		}else{
			$(".is-valid-agree2").text("「同意する」にチェックしてください。");
			err_cnt += 1;
			err_point = "privacy_check_box";
		}
		if(checkTel()){
			err_cnt += 1;
			err_point = "your-tel";
		}
		if(checkEmail()){
			err_cnt += 1;
			err_point = "your-email";
		}
		if(checkSei()){
			err_cnt += 1;
			err_point = "your-sei";
		}
		if(checkMei()){
			err_cnt += 1;
			err_point = "your-mei";
		}
		// if(checBusyo()){
		// 	err_cnt += 1;
		// 	err_point = "your-busyo";
		// }
		if(checkCompany()){
			err_cnt += 1;
			err_point = "your-company";
		}

		if ( Number(err_cnt) > 0) {
			$('html,body').animate({
				scrollTop : $('#' + err_point).offset().top
			}, 'fast');
			return false;
		}else{
			//XSS対策
			$('#your-company').val(escapeHTML($('#your-company').val()));
			// $('#your-busyo').val(escapeHTML($('#your-busyo').val()));
			return true;
		}
		return false;
	});

	function checkCompany() {
		if ($('#your-company').val() == "") {
			$('.is-valid-company').text("会社名が入力されていません。");
			$('.is-valid-company').css('display', 'block');
			return 1;
		} else {
			$('.is-valid-company').text("");
			$('.is-valid-company').css('display', 'none');
			return 0;
		}
	}
	// function checkBusyo() {
	// 	if ($('#your-busyo').val() == "") {
	// 		$('.is-valid-busyo').text("部署名が入力されていません。");
	// 		$('.is-valid-busyo').css('display', 'block');
	// 		return 1;
	// 	} else {
	// 		$('.is-valid-busyo').text("");
	// 		$('.is-valid-busyo').css('display', 'none');
	// 		return 0;
	// 	}
	// }
	function checkSei() {
		if ($('#your-sei').val() == "") {
			$('.is-valid-name').text("姓が入力されていません。");
			$('.is-valid-name').css('display', 'block');
			return 1;
		} else {
			$('.is-valid-name').text("");
			$('.is-valid-name').css('display', 'none');
			return 0;
		}
	}
	function checkMei() {
		if ($('#your-mei').val() == "") {
			$('.is-valid-name').text("名が入力されていません。");
			$('.is-valid-name').css('display', 'block');
			return 1;
		} else {
			$('.is-valid-name').text("");
			$('.is-valid-name').css('display', 'none');
			return 0;
		}
	}
	function checkEmail() {
		if ($('#your-email').val() == "") {
			$('.is-valid-email').text("メールアドレスが入力されていません。");
			$('.is-valid-email').css('display', 'block');
			return 1;
		}else if(!$('#your-email').val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)) {
			$('.is-valid-email').text("有効なメールアドレス形式で入力してください。");
			$('.is-valid-email').css('display', 'block');
			return 1;
		}else{
			$('.is-valid-email').text("");
			$('.is-valid-email').css('display', 'none');
			return 0;
		}
	}
	function checkTel() {
		if ($('#your-tel').val() == "") {
			$('.is-valid-tel').text("電話番号が入力されていません。");
			$('.is-valid-tel').css('display', 'block');
			return 1;
		}else if(!$('#your-tel').val().match(/\d{10,11}$/)) {
			$('.is-valid-tel').text("有効な電話番号で入力してください。");
			$('.is-valid-tel').css('display', 'block');
			return 1;
		}else{
			$('.is-valid-tel').text("");
			$('.is-valid-tel').css('display', 'none');
			return 0;
		}
	}

	//エスケープ処理
	function escapeHTML(str) {
		str = str.replace(/&/g, '&amp;');
		str = str.replace(/</g, '&lt;');
		str = str.replace(/>/g, '&gt;');
		str = str.replace(/"/g, '&quot;');
		str = str.replace(/'/g, '&#39;');
		return str;
	}
});
