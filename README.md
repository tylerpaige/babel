
<h2>Babel</h2>
Appropriating non-Latin characters (eg: Japanese, Thai, Chinese characters), some tweets
create images to express something. The characters are abstracted from their literal 
meaning and are given a new meaning based solely on imagery. Thus, a new language is
formed that is understandable by all-- a sort of pan-humanist language. 

The language's "words" have no separation between the word and the meaning. That is to 
say, the words are self-referential.  

This project attempts to create a dictionary for this language. An interface will be
created that will crowd-source the creation of this dictionary. The interface shows a new
"word" [eg: (∏ ω ∏) ] and Google Image results of that word as a query. Users of the
interface are instructed to delete the image results that do not match what the word
means. When all of the Google images represent what the word means, the user should
"approve" the word, and it will be added to the dictionary. If no images ever represent
the word, the word is rejected.

Later, the dictionary can be viewed.

This, of course, is entirely gratuitous, as there is no need for a dictionary for a
language of this sort. (Just realized this. Fuck.) 

<h3>Tweet Filters: Rules for what to filter out</h3>
<ul>
	<li>Strings of a-z characters (uppercase and lowercase) that are 2+ characters long</li>
	<li>Strings of 0-9 numerals that are 2+ characters long</li>
	<li>Parentheticals, quotes, & brackets that contain strings of characters/numerals as described above (ie: if the above strings are enclosed in parentheses, quotes, or brackets, remove the string and their container)</li>
	<li>Usernames: strings of a-z 0-9 characters following an "@"</li>
	<li>Retweet formats:
		<ul>
			<li>RT @___</li>
			<li>RT @___:</li>
			<li>RT @___: "</li>
			<li>"@___</li>
			<li>" @___</li>
			<li>Probably all quotes should go (not necessarily the contents of the quotes, but the quotes themselves)</li>			
		</ul>
	</li>
	<li>Links</li>
	<li>Standard emoticons:
		<ul>
			<li>:) / :-)</li>
			<li>:( / :-(</li> 
			<li>:'(</li>
			<li>:*</li>
			<li>;)</li>
			<li>;*</li>
			<li>:o / :O</li>
			<li>:D</li>
			<li>D:</li>
			<li>:p / :P</li>
		</ul>
	</li>
</ul>

<h3>Personal Notes for creating keys at school</h3>

This is just a sample project to get the students in a guest lecture at Cooper Union going with GitHub and Heroku.

//Create Keys
ssh-keygen -t rsa

heroku login
//login

//Clear your previous keys
heroku keys:clear
heroky keys:add chose the id_rsa key

//cd to the directory 
cd ~/documents/_tcp/cooper-union-class

//create new heroku instance
heroku create

//salt n peppa - push it
git push heroku master //where "master" is the branch you want to push