angular.module('politesControllers',[])
		  .controller('allPostsController', function($scope, Posts) {
				var data = Posts.getAllPosts().success(function(data){
					$scope.posts = data;
				});
				$scope.algo = '<b><s>esto es texto</s></b>';
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
		  		$scope.options = {
		  			height: 300,
		  			focus: true,
		  			toolbar: [
		  				['edit',['undo','redo']],
		  				['headline', ['style']],
			            ['style', ['bold', 'italic', 'underline']],
			            ['fontface', ['fontname']],
			            ['textsize', ['fontsize']],
			            //['fontclr', ['color']],
			            ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
			            //['height', ['height']],
			            ['table', ['table']],
			            ['insert', ['link','picture','video']],
			            ['view', ['codeview']],
		  			]
		  		};
		  		$scope.imageUpload = function(files, editor) {
		  			/*Posts.loadImage(files).success(function(){

		  			});*/
				    console.log('image upload:', files, editor);
				    console.log('image upload\'s editable:', $scope.editable);
				    editor.insertImage($scope.editable, 'images/adolfybenito.jpg');
				  };
		  		$scope.createPost = function(input){
		  			
		  			/*Posts.createPost(input).success(function(data){
		  				$scope.message =  data;
		  			});*/
		  		};
		  })
		  .controller('sidebarController',function($scope, Posts) {
		  		Posts.getSections().success(function(data){
		  			$scope.secciones =  data;
		  		});
		  		Posts.getRecentPosts().success(function(data){
		  			$scope.sidebarPosts = data;
		  		});
		  });
		  