angular.module('politesControllers',['ui.router'])
		  .controller('allPostsCtrl', function($scope,$state, $anchorScroll, Posts) {
		  		$anchorScroll();
		  		//date.setDate(date.getDate()-1);
		  		if($state.params.slug == null){
				var data = Posts.getAllPosts().success(function(data){
					/*angular.forEach(posts, function(post, key){
						var maxCommnts = 0;
						var p = new Date(post.created_at);
						p.setDate(p.getDate()+1);
						if(date > p && post.count > maxComment){
							maxComment = post.count
							$scope.fecha = p;
						}else{

						}
					});*/
					$scope.posts = data;
				});
				}else{
				Posts.getBySection($state.params.slug).success(function(data) {
		  			$scope.posts = data;
		  		});
				}
		  })
		  .controller('postCtrl',function($scope, $state, $anchorScroll, Posts){
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

		  		$scope.getReply = function(index, comment){
		  			if(comment.respuestasTotal > 0){
		  					comment.imgReply = true;
			  		   Posts.getReplies(comment.id).success(function(data){
			  		    	 comment.replies =  data;
			  		    	 comment.imgReply = false;
			  		    	 comment.replyData = true;
				  			});
		  			}
		  			this.show = true;
		  		};

		  		$scope.storeComment = function(post, input){
                    Posts.storeComment(post.id, input).success(function(data){
                    	message = data;
                    	Posts.getComments(post.id).success(function(data){
		  				      $scope.comments = data;
		  				});
		  				input.comment = '';
                    });
		  		};


		  		$scope.storeReply = function(comment, input){
		  			Posts.storeReply(comment.id, input).success(function(data){
		  				message = data;
		  				Posts.getReplies(comment.id).success(function(data){
		  					comment.replies = data;
		  				});
		  				input.reply = '';
		  			});
		  		};		
		  })
		  .controller('storePostCtrl', function($scope, $anchorScroll, $timeout, $state, Posts) {
		  		$anchorScroll();
		  		$scope.storePost = function(input){
		  			angular.element('#storePost').modal('show');
		  			Posts.storePost(input).success(function(data){
		  				$scope.input = '';
		  				$scope.input = {tags: ''};
		  				$scope.errors= '';
		  				$scope.message = data;
		  			}).error(function(data){
		  				if(data.error){
		  					$scope.message = data;
		  				}
		  				 angular.element('#storePost').modal('hide');
						 $scope.errors = data;
					});
		  		};
		  		//funcion para cargar imagen al servidor y luego renderizarla en el cuadro del editor
				//function to upload the image to the server and then render it this in the editor display box 
				$scope.imgs = [];
				    $('.note-image-url').on('value_changed',function(){
						$scope.imgs.push($(this).val());
						console.log('url: ', $(this).val());
					});
				
				$scope.options = {
					height: 500,
					focus: true,
					onImageUpload: function(files, editor, welEditable){
						sendFiles(files[0], editor, welEditable);
					},
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
				/*$scope.imageUpload = function(files, editor){
					data = new FormData();
		            data.append("file", files[0]);
					Posts.uploadImage(data).success(function(url){
						editor.insertImage($scope.editable, 'images/temp/' + url);
						path = 'images/temp/'+url;
						$scope.imgs.push(path);
					});
				};*/

				function sendFiles(files, editor, welEditable){
		            data = new FormData();
		            data.append("file", files);
					Posts.uploadImage(data).success(function(url){
						editor.insertImage(welEditable, 'images/post/' + url);
						path = 'images/post/'+url;
						$scope.imgs.push(path);
					});
				};

				/*****tags***********/
				$scope.tagsOptions = {
						maxTags: 4,
						typeahead: {
					          prefetch: './api/tags'
					    }
				};
				/***end-tags********/

				Posts.getSections().success(function(data){
					$scope.secciones = data;
				});		

				$scope.uploadImagemini = function(files){
					data = new FormData();
					data.append('file', files[0]);
					Posts.uploadImage(data).success(function(url){
						path = 'images/post/'+url;
						$scope.imagemini = path;
						$scope.input = {image:path};
					});
					console.log('url: ', files);
					$('#image-mini-modal').modal('hide');
				};

				$scope.uploadImageminiUrl = function(file){
				//	$('#image-mini').val(file);
					$scope.input = {image: file};
					$scope.imagemini = file;
				};

				$scope.toAllPosts = function(){
					angular.element('#storePost').modal('hide');
					$timeout(function(){
						$state.go("root");
					}, 1500);
				};
		  })
		  .controller('sidebarCtrl',function($scope, $anchorScroll, Posts) {
		  		$anchorScroll();
		  		Posts.getSections().success(function(data){
		  			$scope.secciones =  data;
		  		});
		  		Posts.getRecentPosts().success(function(data){
		  			$scope.sidebarPosts = data;
		  		});
		  });
		  