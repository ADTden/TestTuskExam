$('.js_report').on("click",function(){
	console.log($(".news-detail").attr('data-id_news'))

	$.ajax({
	  type: "POST",
	  url: "/local/templates/furniture-pule_red/components/bitrix/news.detail/reports/report.php",
	  data: { NEWS_ID: $(".news-detail").attr('data-id_news') }
	}).done(function( msg ) {
	 $('.js_report').html(msg);
	});

})