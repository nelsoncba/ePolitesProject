angular.module('Polites')
	.factory('WebService', function($http){
		return {
			get: function(path, data)
			{
				return $http.get('./api/' + path, data).success(function(data){
					return data;
				});
			},
			post: function(path, data)
			{	
				return $http.post('./api/' + path, data).success(function(data){
					return data;
				});
			},
			put: function(path, data)
			{
				return $http.put('./api/' + path, data).success(function(data){
					return data;
				});
			},
			delete: function(path, data)
			{
				return $http.delete('./api/' + path, data).success(function(data){
					return data;
				});
			},
			sendFile: function(path, data){
				return $.ajax({
						method: 'POST',
			    		url: './api/' + path,
			    		data: data,
			    		cache: false,
		                contentType: false,
		                processData: false,
			    		success: function(data){
			    			return data;
			    		}
				});
			}
		}
	});