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
			    getPost: function(params){
			    	return WebService.get('post/' + params).success(function(data){
			    		return data;
			    	});
			    },
			    createPost: function(input){
			    	return WebService.post('createPost', input).success(function(data){
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
			    saveComment: function(postId, input){
			    	return WebService.post('saveComment/' + postId, input).success(function(data){
			    		return data;
			    	});
			    },
			    getReplies: function(commentId){
			    	return WebService.get('replies/' + commentId).success(function(data){
			    		return data;
			    	});
			    },
			    saveReply: function(commentId, input){
			    	return WebService.post('saveReply/' + commentId, input).success(function(data){
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
			    }
			};
		});