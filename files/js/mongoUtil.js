var mongoUtil = {
	_db: "",
	_appID:"",
	_apiKey: "",
	config: function(configuration) {

		for (var key in configuration) {
			this['_'+key] = configuration[key];
		};
	},
	url: function() {
		return 'https://www.mongolab.com/api/1/databases/'+this._appID+'/collections/'+this._db+'?apiKey='+this._apiKey;
	},
	post: function(id, data, callback) {
		var obj = {};
		obj[id] = data;
		var formattedData = JSON.stringify(obj);
		$.ajax({
			url:this.url(),
			dataType:'json',
			contentType:'application/json',
			type:'POST',
			data:formattedData,
			success:function(response){

				console.log("success",response);
				if(typeof(callback) === "function") {
					callback(response);
					console.log("The ajax request callback function has been fired.");
				}
			},
			error: function(error) {
				console.log("failure",error);
			}

		});				
	},
	getRecent: function(id, callback) {
		$.ajax({

			url:this.url(),
			dataType:'json',
			contentType:'application/json',
			type:'GET',
			success:function(response){
				console.log("recent terms: ", response);
				var terms = [];
				$.each(response, function(index, value) {
					var term = value.entry.term;
					terms.push(term);
				});
				var mostRecent = terms.length,
					lastRecent = mostRecent - 5,
					recentTerms = terms.slice(lastRecent, mostRecent);
				console.log(recentTerms);
				$.each(recentTerms, function(index, value) {
					var recentMarkup = $('<a>'+value+'</a>');
					console.log("each individual term: ", recentMarkup);
					$('#mostRecent').append(recentMarkup);
				});
			},
			error:function(error){
				console.log(error);
			}
		});
	},
	getDictionary: function(id, callback) {
		$.ajax({
			url:this.url(),
			dataType:'json',
			contentType:'application/json',
			type:'GET',
			success:function(response){
				console.log("recent terms: ", response);
				var terms = [];
				$.each(response, function(index, value) {
					var term = value.entry.term;
					terms.push(term);
				});
				$.each(terms, function(index, value) {
					var termListingMarkup = $('<a href="#" id="'+value+'"><li>'+value+'</li></a>');
					$('#list').prepend(termListingMarkup);
				});
				$('#container').trigger('clickFunctions');
			},
			error:function(error){
				console.log(error);
			}
		});
	}
};