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
	get: function(id, callback) {
		$.ajax({

			url:this.url(),
			dataType:'json',
			contentType:'application/json',
			type:'GET',
			success:function(response){

				console.log("success",response);
				$("<h2>"+response.length+"</h2>").appendTo("h1");
			},
			error: function(error) {
				console.log("failure",error);
			}

		});
	}
};