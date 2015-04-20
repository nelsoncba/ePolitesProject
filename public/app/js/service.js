angular.module('Service',[])
		.factory('Posts', function(webservice) {
			return {
				getRecentPosts: function(){
					return webservice.request('GET','recentPosts').success(function(data){
						return data;
					}).error(function(data){
			       		return data;
					});
				},
			    getAllPosts: function(params){
			       return  webservice.request('GET','allPosts/' + params).success(function(data){
			       		return data;
			       }).error(function(data){
			       		return data;
			       });
			    },
			    getBySection: function(params){
			    	return webservice.request('GET', 'bySection/' + params).success(function(data){
			    		return data;
			    	}).error(function(data){
			       		return data;
					});
			    },
			    getPost: function(params){
			    	return webservice.request('GET','post/' + params).success(function(data){
			    		return data;
			    	}).error(function(data){
			       		return data;
					});
			    },
			    storePost: function(input){
			    	return webservice.request('POST','storePost', input).success(function(data){
			    		return data;
			    	}).error(function(data){
						return data;
					});
			    },
			    getComments: function(postId){
			    	return webservice.request('GET', 'comments/' + postId).success(function(data){
			    		return data;
			    	}).error(function(data){
			    		return data;
			    	});
			    },
			    storeComment: function(postId, input){
			    	return webservice.request('POST', 'storeComment/' + postId, input).success(function(data){
			    		return data;
			    	}).error(function(data){
			       		return data;
					});
			    },
			    getReplies: function(commentId){
			    	return webservice.request('GET', 'replies/' + commentId).success(function(data){
			    		return data;
			    	}).error(function(data){
			       		return data;
					});
			    },
			    storeReply: function(commentId, input){
			    	return webservice.request('POST', 'storeReply/' + commentId, input).success(function(data){
			    		return data;
			    	}).error(function(data){
			       		return data;
					});
			    },
			    getSections: function(){
			       return  webservice.request('GET','allSections').success(function(data){
			       		return data;
			       }).error(function(data){
			       		return data;
			       });
			    },
			    uploadImage: function(data){
			    	return $.ajax({
							method: 'POST',
				    		url: './api/uploadImage',
				    		data: data,
				    		cache: false,
			                contentType: false,
			                processData: false,
				    		success: function(data){
				    			return data;
				    		}
					});
			    },
			    deleteImage: function(image){
			    	return webservice.request('POST', 'deleteImage', image).success(function(data){
			    		return data;
			    	}).error(function(data){
			       		return data;
					});
			    }
			};
		})
		.factory('Authenticate', function(webservice, sessionService, $rootScope) {

			return {

				login: function(data){
					return webservice.request('POST', 'authenticate', data).success(function(data){
						sessionService.set('user', data.user);
						$rootScope.currentUser = data.user
						return data;
					}).error(function(data){
						return data;
					});
				},
				logout: function(){
					webservice.request('GET', 'logout').success(function(){
						sessionService.remove('user');
						$rootScope.currentUser = null;
					});
				},
				isLoggedIn: function(){
					return sessionService.get('user');
				}
			};
		})
		.service('sessionService', function($cookieStore) {
			    
		  		this.set = function(key, value){
		  			return $cookieStore.put(key, value);
		  		},
		  		this.get = function(key){
		  			return $cookieStore.get(key);
		  		},
		  		this.remove = function(key){
		  			return $cookieStore.remove(key);
		  		}
		})
		.service('webservice', function ($http) {
			this.request = function(method, path, data){
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
		});