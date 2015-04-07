angular.module('Polites')
		.factory('Posts', function(WebService) {
			return {
				getRecentPosts: function(){
					return WebService.get('recentPosts').success(function(data){
						return data;
					});
				},
				setPosts: function(posts){
					this.allPosts = posts;
				},
			    getAllPosts: function(){
			       return  WebService.get('allPosts').success(function(data){
			       		posts = data;
			       		return data;
			       });
			    },
			    getBySection: function(params){
			    	return WebService.get('bySection/' + params).success(function(data){
			    		return data;
			    	});
			    },
			    getPost: function(params){
			    	return WebService.get('post/' + params).success(function(data){
			    		return data;
			    	});
			    },
			    storePost: function(input){
			    	return WebService.post('storePost', input).success(function(data){
			    		return data;
			    	}).error(function(data){
						return data;
					});
			    },
			    getComments: function(postId){
			    	return WebService.get('comments/' + postId).success(function(data){
			    		return data;
			    	});
			    },
			    storeComment: function(postId, input){
			    	return WebService.post('storeComment/' + postId, input).success(function(data){
			    		return data;
			    	});
			    },
			    getReplies: function(commentId){
			    	return WebService.get('replies/' + commentId).success(function(data){
			    		return data;
			    	});
			    },
			    storeReply: function(commentId, input){
			    	return WebService.post('storeReply/' + commentId, input).success(function(data){
			    		return data;
			    	});
			    },
			    getSections: function(){
			       return  WebService.get('allSections').success(function(data){
			       		return data;
			       });
			    },
			    uploadImage: function(image){
			    	return WebService.sendFile('uploadImage', image).success(function(data){
			    		return data;
			    	});
			    },
			    deleteImage: function(image){
			    	return WebService.post('deleteImage', image).success(function(data){
			    		return data;
			    	});
			    }
			};
		});