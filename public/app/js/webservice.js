angular.module('Polites')
	.factory('WebService', function($http){
		var request = function(method, path, data){
			return $http({
					method: method,
					url: './api/' +  path,
					data: data
			}).success(function(data){
				return data;
			}).error(function(data){
				return data;
			});
		}
		return {
			get: function(path, data)
			{
				/*return $http.get('./api/' + path, data).success(function(data){
					return data;
				}).error(function(data){
					return data;
				});*/
				return request('GET', path, data);
			},
			post: function(path, data)
			{	
				/*return $http.post('./api/' + path, data).success(function(data){
					return data;
				}).error(function(data){
					return data;
				});*/
				return request('POST', path, data);
			},
			put: function(path, data)
			{
				/*return $http.put('./api/' + path, data).success(function(data){
					return data;
				}).error(function(data){
					return data;
				});*/
				return request('PUT', path, data);
			},
			delete: function(path, data)
			{
				/*return $http.del('./api/' + path, data).success(function(data){
					return data;
				}).error(function(data){
					return data;
				});*/
				return request('DELETE', path, data);
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