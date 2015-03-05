angular.module('politesControllers',[])
		  .controller('allPostsController', function($scope, Posts) {
				var data = Posts.getAllPosts().success(function(data){
					$scope.posts = data.key;
					Posts.setPosts(data.key);
				});
		  })
		  .controller('postController',function($scope, $state, $anchorScroll, Posts){
		  	    $scope.convertToDate = function(stringDate){
		  	    	var dateOut = new Date(stringDate);
		  	    	dateOut.setDate(dateOut.getDate()+1);
		  	    	return dateOut;
		  	    }
		  		Posts.getPost($state.params.id + '/' + $state.params.slug).success(function(data) {
		  			$scope.post = data;
		  		});
		  			$anchorScroll();
		  		Posts.getComments($state.params.id).success(function(data){
		  			$scope.comments = data;
		  		});

		  		$scope.saveComment = function(post, input){
                    Posts.saveComment(post.id, input).success(function(data){
                    	message = data;
                    	Posts.getComments(post.id).success(function(data){
		  				      $scope.comments = data;
		  				});
		  				input.comment = '';
                    });
		  		};

		  		$scope.getReply = function(comment){
		  			if(comment.respuestasTotal > 0){
			  		    Posts.getReplies(comment.id).success(function(data){
			  		    	 comment.replies =  data;
			  			});
		  			}
		  			this.show = true;
		  		};

		  		$scope.saveReply = function(comment, input){
		  			Posts.saveReply(comment.id, input).success(function(data){
		  				message = data;
		  				Posts.getReplies(comment.id).success(function(data){
		  					comment.replies = data;
		  				});
		  				input.reply = '';
		  			});
		  		};
		  		
		  })
		  .controller('sidebarController',function($scope, Posts) {
		  		Posts.getSections().success(function(data){
		  			$scope.secciones =  data;
		  		});
		  		data = Posts.getPosts();
		  		$scope.sidebarPosts = data;
					
		  });