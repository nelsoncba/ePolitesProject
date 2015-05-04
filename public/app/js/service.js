angular.module('Service',[])
		.factory('Posts', function(webservice, $rootScope) {
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
			    updatePost: function(id, input){
			    	return webservice.request('PUT', 'updatePost/' + id, input).success(function(data){
			    		return data;
			    	}).error(function(data){
			    		return data;
			    	});
			    },
			    deletePost: function(id){
			    	return webservice.request('DELETE','deletePost/' + id).success(function(data){
			    		return data;
			    	}).error(function(data){
						return data;
					});
			    },
			    editPost: function(id){

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
			    selectTags: function(){
			    	return webservice.request('GET', 'tags').success(function(data){
			    		return data;
			    	});
			    },
			    uploadImage: function(data, id){
			    	return $.ajax({
							method: 'POST',
				    		url: './api/v1/uploadImage/' + id,
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
		.factory('Likes', function(webservice) {
		
			return {
				setlikes: function(id, likes){
					return webservice.request('GET', 'likes/' + id + '/' + 1 + '/' + 0).success(function(data){
						return data;
					});
				},
				setUnlikes: function(id, unlikes){
					return webservice.request('GET', 'likes/' + id + '/' + 0 + '/' + 1).success(function(data){
						return data;
					});
				}
		
			};
		})
		.factory('Registration', function(webservice,sessionService) {
			
			return {
				storeUser: function(data){
					return webservice.request('POST', 'register', data).success(function(data){
						return data;
					}).error(function(data){
						return data;
					});

				},
				verify: function(token){
					return webservice.request('GET', 'register/verify/' + token).success(function(data){
						sessionService.set('user', data.user);
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
				},
				sendMail: function(input){
					return webservice.request('POST', 'sendMail/'+'resetPassword', input).success(function(data){
						return data;
					}).error(function(data){
						return	data;
					});
				},
				verifyResetPass: function(token){
					return webservice.request('GET', 'verifyResetPass/'+ token).success(function(data){
						sessionService.set('resetPassInfo', data);
						return data;
					}).error(function(data){
						return	data;
					});
				},
				resetPassword: function(data){
					return webservice.request('POST', 'resetPassword', data).success(function(data){
						sessionService.remove('resetPassInfo');
						return data;
					}).error(function(data){
						return	data;
					});
				}
			};
		})
		.factory('Account', function (webservice) {
		
			return {
				myPosts: function(id){
					return webservice.request('GET', 'account/myPosts/' + id).success(function(data){
						return data;
					}).error(function(data){
						return	data;
					});
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
						url: './api/v1/' +  path,
						data: data
						}).success(function(data){
							return data;
						}).error(function(data){
							return data;
						});
			}
		});