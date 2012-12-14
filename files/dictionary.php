<?php 

	//figure out how many pages to make links for
	$json = json_decode(file_get_contents('definitions.json'));
	$numberOfPages = count((array)$json);

	//use get just the first part of the query parameter
	if(isset($_GET)&!empty($_GET)) {
		//should be a regex
		$currentPage = explode(".",$_GET['entry']);
		$currentPage = $currentPage[0];
		echo $currentPage;

		//select the current page from the json object
		$currentPageData = $json->$currentPage->entry;
		$term = $currentPageData->term;
		$images = $currentPageData->images;
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Babel: a Dictionary for Panhuman Image-Based Language</title>
		<link rel="stylesheet/less" type="text/css" href="css/babel.less" />
		<link rel="stylesheet/less" type="text/css" href="css/dictionary.less" />
		<script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>
		<script src="js/mongoUtil.js"></script>
		<script src="js/less-1.3.0.min.js" type="text/javascript"></script>
		<script src="js/jquery.animate-shadows.min.js" type="text/javascript"></script>
		<script src="js/jquery.jeditable.min.js" type="text/javascript"></script>
		<script src="js/jquery.autogrow.js" type="text/javascript"></script>
		<script src="js/jquery.jeditable.autogrow.js" type="text/javascript"></script>
		<script>
		var id;
		
		$(document).ready(function() {
			//MongoDB stuff
			mongoUtil.config({
				"db":"babeldb",
				"appID":"heroku_app7962868",
				"apiKey":"5089c368e4b0a116b09053b1"
			});
			mongoUtil.getDictionary();

			//About drawer code
			$('#about').hide();//first keep #about hidden
			var closeAbout = function(){ //then define a function to close the about panel
				$('#about').slideUp();
			};
			$('#openAbout').click(function() {
				if($('#about').is(":hidden")) {
					$('#about').slideDown("slow");
				} else {
					closeAbout();
				}
			});
			$('#closeAbout').click(function(){	closeAbout();	});
			
			$('#searchPanel').hide();
			var closeSearch = function(){
				$('#searchPanel').slideUp();
			};
			$('#openSearch').click(function() {
				if($('#searchPanel').is(":hidden")) {
					$('#searchPanel').slideDown("slow");
				} else {
					closeSearch();
				}
			});
			$('#closeSearch').click(function() { closeSearch(); });
			
			$('#definition').hide();
			
			$('#query').focus(function() {
				$('#query').animate({width: '100%'}, 500);
			}).blur(function() {
				$('#query').animate({width: '130px'}, 500);
			});	
				
			$('#container').on('clickFunctions', function(){ //If a term is selected from the grand list
				$('#list>a').each(function(index, item) {
					$item = $(item);
					$item.click(function() {
						id = $(this).attr('id');
						console.log("what's the id when i click something?", id);
						history.pushState("", "id", "dictionary.php?term="+id);
						$('#container').trigger('getDefinition');
					});
				});	
			});
			
			$('#container').on('getDefinition', function(){ //Then make an AJAX request to get all the right data
				console.log("did the ID carry over?", id);
				if($('#definition').is(':hidden')){
					console.log("What is 'this' here?", $(this));
					$('#definition').fadeIn();
				}
				$.ajax({
					url: 'https://www.mongolab.com/api/1/databases/heroku_app7962868/collections/babeldb?q=%7B"entry.term"%3A"'+id+'"%7D&s=&f=&view=json&apiKey=5089c368e4b0a116b09053b1',
					dataType: "json",
					success: function(data){
						//update the current html structure with the new content
						console.log("Got definition:", data);
						var term = data[0].entry.term,
							images = data[0].entry.images,
							context = data[0].entry.context;
						$('.term').empty().append(term);
						$('#defContainer').empty();
						$('#contextContainer').empty();
						$.each(images, function(index, value) {
							var imgUrl = value.imgUrl,
								imageMarkup = $('<li><img src="'+imgUrl+'"/></li>');
							$('#defContainer').append(imageMarkup);
						});
						$.each(context, function(index, value) {
							var text = value.text,
								url = value.url,
								contextMarkup = $('<li>'+text+'<a href="'+url+'" target="_blank">➚</a></li>');
							$('#contextContainer').append(contextMarkup);
						});
					}
				});
			});
			
			<?php if(isset($_GET['term']) && !empty($_GET['term'])) { //Or if the page was loaded with a term in the URL
				$term = $_GET['term']; ?>
				id = '<?=$term;?>';
				console.log("the page loaded with an ID. It is: ", id);
				$('#container').trigger('getDefinition');
			<?php } ?>
						
		});
		</script>
	</head>
	<body>
		<div id="navigation">
			<li><a href="#" class="active">Contribute</a></li>
			<li><a id="openSearch">Search</a></li>
			<li><a href="#">View Current Dictionary</a></li>
			<li><a id="openAbout">About</a></li>
			<form id="search">
				<input type="text" placeholder="Search the dictionary" name="search" id="query" />
			</form>
		</div>
		<div id="about">
			<h1>About Panhumanism</h1>
			<div class="text">
				<p>Appropriating non-Latin characters (eg: Japanese, Thai, Chinese characters), some tweets create images to express something. The characters are abstracted from their literal meaning and are given a new meaning based solely on imagery. Thus, a new language is formed that is understandable by all-- a sort of pan-humanist language.</p>
				<p>The language's "words" have no separation between the word and the meaning. That is to say, the words are self-referential.</p>
				<p>This project attempts to create a dictionary for this language. An interface will be created that will crowd-source the creation of this dictionary. The interface shows a new "word" [eg: (∏ ω ∏) ] and Google Image results of that word as a query. Users of the interface are instructed to delete the image results that do not match what the word means. When all of the Google images represent what the word means, the user should "approve" the word, and it will be added to the dictionary. If no images ever represent the word, the word is rejected.</p>
				<p>Later, the dictionary can be viewed.</p>
				<p>This, of course, is entirely gratuitous, as there is no need for a dictionary for a language of this sort.</p>
			</div>
			<div id="mostRecent"></div>
			<div id="closeAbout">Close ↑</div>
		</div>
		<div id="searchPanel">
			<h1>Search for existing terms:</h1>
			<form id="search"><input type="text" name="searchTerm" placeholder="Enter your search terms here." /> <input type="submit" name="submitSearch" value="Go!" /></form>
			<div id="closeSearch">Close ↑</div>
		</div>
		<div id="container">
			<header>
				<a href="index.php"><img src="images/logo.png" /></a>
				<span class="tagline">A dictionary for panhuman image-based language</span>
			</header>
			<article id="definition">
				<section id="instruction">
					<div id="termContainer">
						<div class="term"></div>
					</div>
				</section>
				<section id="entry">
					<ol id="defContainer">
						
					</ol>
					<h2 class="removeWhenError">Usage & Context:</h2>
					<ol id="contextContainer">
						
					</ol>
				</section>
				<section id="contribute">
					<a href="dictionary.html">Return to browsing the dictionary.</a>
				</section>
			</article>
			<article id="content" class="columns">
				<h1 class="pageHeader">Browse</h1>
				<section id="list">
				</section>
				<section id="contribute">
					<a href="index.html">Contribute a definition to the dictionary</a>
				</section>
			</article>
		</div>
	</body>
</html>