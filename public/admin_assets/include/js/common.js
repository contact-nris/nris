var xhr;
function ajaxsend(u,d){
	_('.err-span span,.success-span span').text('');
    _('.err-span , .success-span').hide();
	return _.ajax({url:u,dataType:'json',type:'post',data:d,
		success:function(j){
			if(j && typeof(j.redirect) != 'undefined') window.location.href = j.redirect;
			else if(j && typeof(j.errors) != 'undefined'){_('.err-span span').text(j.errors);_('.err-span').show();}
		},complete:function(){}
	});
}
_(document).ready(function(){
	_('#btn-login').click(function(){
		var u = http + 'data/account/login';
		xhr = ajaxsend(u,_('#form-login').serialize());
		return false;
	});
	_('#logout').click(function(){
		var u = http + 'data/account/logout';
		xhr = ajaxsend(u,{logout:1});
		return false;
	});
	_('#btn-add-tran').click(function(){
		var u = http + 'data/account/add-transaction';
		xhr = ajaxsend(u,_('#form-add-tran').serialize());
		return false;
	});
	_('#btn-add-part').click(function(){
		var u = http + 'data/account/partner';
		xhr = ajaxsend(u,_('#form-add-part').serialize());
		return false;
	});
	_('#btn-add-with').click(function(){
		var u = http + 'data/account/withdraw';
		xhr = ajaxsend(u,_('#form-add-with').serialize());
		return false;
	});
	_('#btn-add-bank').click(function(){
		var u = http + 'data/account/bank';
		xhr = ajaxsend(u,_('#form-add-bank').serialize());
		return false;
	});
	_('#btn-add-vyaj').click(function(){
		var u = http + 'data/account/vyaj';
		xhr = ajaxsend(u,_('#form-add-vyaj').serialize());
		return false;
	});
	_('#btn-add-furniture').click(function(){
		var u = http + 'data/account/furniture';
		xhr = ajaxsend(u,_('#form-add-furniture').serialize());
		return false;
	});
	_('#btn-add-interest').click(function(){
		var u = http + 'data/account/interest';
		xhr = ajaxsend(u,_('#form-add-interest').serialize());
		return false;
	});
	_('.vyaj-jama').click(function(){
		var u = http + 'data/account/vyaj';
		d = new Date();
		date = prompt('Please Add Jama Date..!',d.toJSON().slice(0,10));
		xhr = ajaxsend(u,{id:_(this).attr('data-id'),vyaj_jama:1,date:date});
		return false;
	});
	_('.form_datetime').datetimepicker({
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 4,
		forceParse: 0,
		showMeridian: 0
	});
});
/*xhr.success(function(j){if(j && typeof(j.succsess) != 'undefined'){}});*/