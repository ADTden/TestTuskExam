$(document).ready(function(){
$('.js_report').on("click",function(){
	console.log($(".news-detail").attr('data-id_news'))

	$.ajax({
	  type: "POST",
	  url: "",
	  data: { NEWS_ID: $(".news-detail").attr('data-id_news') }
	}).done(function( msg ) {
		var from =  msg.search('учтено №'); 
		var to =  msg.search('<p><a href="/news/">');
		$newstr =  msg.substring(from,to);
		$('.js_report').html("Ваше мнение "+$newstr);
	});

})
});
