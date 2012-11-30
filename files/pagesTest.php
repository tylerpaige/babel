<?php 

	//figure out how many pages to make links for
	$json = json_decode(file_get_contents('https://www.mongolab.com/api/1/databases/heroku_app7962868/collections/babeldb?apiKey=5089c368e4b0a116b09053b1'));
	$numberOfPages = count((array)$json);

	//use get just the first part of the query parameter
	if(isset($_GET)) {
		//should be a regex
		$currentPage = explode(".",$_GET['page']);
		$currentPage = $currentPage[0];
		echo $currentPage;

		//select the current page from the json object
		$currentPageData = $json->$currentPage;
		$title = $currentPageData->title;
		$content = $currentPageData->content;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Single page application example</title>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script>
			$(document).ready(function(){
		
				//find each list item
				$("#pages>li").each(function(index, item){
					$item = $(item);
					
					//the dynamically created id originally came from the json object
					var id = $item.attr("id");
					
					$item.click(function(item){
					
						//when clicked, update the url
						history.pushState("", "id", id + ".html");
						
						//get the new content
						$.ajax({
						  url: "pages.json",
						  dataType: 'json',
						  success: function(data){
						  
						  	//update the current html structure with the new content
							$("#title").html(data[id].title);
							$("#content").html(data[id].content);
						  }
						});	
					});
				});
			});
		</script>
	</head>
	<body>
		<ul id="pages">
			<?php foreach($json as $pageID => $page) { ?>
			<li id="<?php echo $pageID;?>"><?php echo $page->title;?></li>
			<?php } ?>
		</ul>
		<?php if($title); {?>
		<h1 id="title"><?php echo $title;?></h1>
		<p id="content"><?php echo $content;?></p>
		<?php } ?>
	</body>
</html>