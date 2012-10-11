<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>This is It</title>
		<link rel="stylesheet/less" type="text/css" href="css/babel.less">
		<script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>
		<script src="js/less-1.3.0.min.js" type="text/javascript" />
		<script> // Getting tweets
			if(localStorage.twitterSearch) {//twitterSearch is a property of localStorage; can be named anything
				var twitterData = JSON.parse(localStorage.twitterSearch),
					formattedData = [];
				console.log(twitterData);
				$.each(twitterData.results, function(index, tweet) {
					var id = tweet.id;
					var text = tweet.text;
					var author = tweet.from_username;
					var url = "http://twitter.com/"+author+"/status/"+id;
					if(tweet.entities && tweet.entities.urls){
						$.each(tweet.entities.urls, function(i, url){
							text = text.replace(url.url, '<a href="' + url.expanded_url + ' ">' + url.display_url + '</a>');
						});
					}
					formattedData.push({ //save only the data you want
						id: id,
						text: text,
						author: author,
						url: url
					});
				});
				console.log('saved array: ', formattedData);
				localStorage.formattedData = JSON.stringify(formattedData);
			} else { //if the information does not exist in the cache, do this (add it, which is defined in the success property function)
				var data;
				$.ajax({
					url: 'http://search.twitter.com/search.json?q=%E3%82%B7%20OR%20%E3%81%A3%20OR%20%E3%83%8F%20OR%20%E3%81%A1%20OR%20(%E0%AB%80%20OR%20%E3%81%93%20OR%20%E0%B1%AA%20OR%20%E2%97%9E%E0%B8%B4%20OR%20%E2%97%9F%E0%B8%B4%20OR%20%E2%9A%97%E0%B8%B1%20lang%3Aen&rpp=1',
					dataType:'jsonp',
					success:function(response) {//has to be called "response"
						localStorage.twitterSearch = JSON.stringify(response); //response has to be wrapped in this to convert the object to a string
						console.log(response);
						var results = response.results;
						console.log(results);
						$.each(results, function(index, value) {
							var tweet = value.text;
							window.originalID = value.id;
							var author = value.from_user;
							var avatar = value.profile_image_url;
							var tweetblock = "<section class='tweetContainer'><div class='tweet'><h1 class='startQuote'>&quot;</h1>" + tweet + "</div><div class='author'><a href='http://twitter.com/" + author + "'>" + author + "</a><br/><img src='" + avatar + "' /></section>";
							$('#container').append(tweetblock);
						});	
					},
					error: function(error){//should pass the actual error that was encountered
						console.log(error);
					}
	// 				complete:function(){//what to do when done
	// 					console.log('done');
	// 				})
				});	
	</head>
	<body>
		<navigation>
			<li><a href="#" class="active">Contribute</a></li>
			<li><a href="#">Search</a></li>
			<li><a href="#">View Current Dictionary</a></li>
		</navigation>
		<div id="container">
			<header>
				<a href="index.php"><img src="images/logo.png" /></a>
			</header>
			<article id="content">
				<section id="instruction">
					Help define this symbol:
					<h1 class="symbol">(∏ ω ∏)</h1>
				</section>
				<ol>
					<li class="definition">
						<img src="#" class="defImg" />
					</li>
				</ol>
			</article>
		</div>
	</body>
</html>