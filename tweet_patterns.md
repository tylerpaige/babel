## FILTER PATTERNS!!!!!!!!!

// charactes
/([\"\'\(\[])*[a-zA-Z0-9:\,\.\']{2,}[\"\'\)\]]*\s$?/g
// username
/(RT:?)?["\s]{1,2}?@[a-zA-Z\d_]+(\s?:)?/g
			//what does the "{1,2}" do?
		// What does the "?" do? ---> says "select this (this beings what before) if it's there, but still selects if it's not"
							//the + is what makes it select only strings that have text after @
					//Couldn't @[a-zA-Z\d_] be changed to @\w ??
// all quotes
/["']/g
// LtR emoticons
/[:;][\-']?[\)\(\[\]\{\}\*oO0DpP]/g
// RtL emoticons
/D:/g
//URLS
/(?i)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))/g



//My attempts

A better retweet filter:
/(RT:?)?["\s]?(@[\w]+)?[\s"]?(\s?:)?[\s"]
	- RT @username:
	- RT @username: "
	- RT @username
	- RT: @username
	- RT:@username
	- RT: 
	- RT: "
	- RT "

## USAGE!!!!!!!!!!

```
var emoticon_pattern = /[:;][\-']?[\)\(\*oODpP]/g,
	tweet = 'today I went to the park. :-)';

tweet = tweet.replace(emoticon_pattern, '');

```

OR !!!!!!!!!!!!!!

```
var filter_tweet = function(tweet) {
	var filter_patterns = [
			// charactes
			/([\"\'\(\[])*[a-zA-Z0-9:\,\.\']{2,}[\"\'\)\]]*\s?/g,
			// username
			/(RT:?)?["\s]{1,2}?@[a-zA-Z_]+(\s?:)?/g,
			// all quotes
			/["']/g,
			// LtR emoticons
			/[:;][\-']?[\)\(\*oODpP]/g,
			// RtL emoticons
			/D:/g,
			//URLS
			/((http|https)(:\/\/))?([a-zA-Z0-9]+[.]{1}){2}[a-zA-z0-9]+(\/{1}[a-zA-Z0-9]+)*\/?/g
		];

	for(var i=0; i<filter_patterns.length; i++) {
		tweet=tweet.replace(filter_patterns[i], '');
	}

	return tweet;
}

```