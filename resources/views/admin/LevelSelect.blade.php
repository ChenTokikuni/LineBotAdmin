<ul class="nav nav-pills" id="select-ul-test" role="tablist">
	<?php $activeNum = 1; ?>
	@foreach($data as $v)
	<li role="presentation" class="active"><a href="/admin/main_content?title_id={{$v['title_id']}}&activeNum={{$activeNum}}">{{$v['name']}} <span class="badge"> {{$v['level_count']}}</span></a></li>
	<?php $activeNum = $activeNum+1; ?>
	@endforeach
</ul>
<script>
	$(function(){
		var anum = parseQueryString(location.search).activeNum || '1';
		$('#select-ul-test li').removeClass('active');
		$('#select-ul-test li:nth-child('+anum+')').addClass('active');
		
		//$('.pull-right').css({'margin-top':'20px'});
	});
	//Getting URL Parameters
	function parseQueryString(url) {
		var urlParams = {};
		url.replace(
			new RegExp("([^?=&]+)(=([^&]*))?", "g"),
			function($0, $1, $2, $3) {
				urlParams[$1] = $3;
			}
		);
		return urlParams;
	}

</script>