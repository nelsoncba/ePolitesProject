angular.module('politesControllers',[])
		  .controller('allPostsController', function($scope, Posts) {
				var data = Posts.getAllPosts().success(function(data){
					$scope.posts = data;
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

				//funcion para cargar imagen al servidor y luego renderizarla en el cuadro del editor
				$scope.imgs = [];
				    $('.note-image-url').on('value_changed',function(){
						$scope.imgs.push($(this).val());
						console.log('url: ', $(this).val());
					});
				
				/*$('#summernote').summernote({
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
				});  */
				
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
				var tags = new Bloodhound({
				  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('tag'),
				  queryTokenizer: Bloodhound.tokenizers.whitespace,
				  prefetch: {
				    url: './api/tags',
				    filter: function(data) {
				      return data;
				    }
				  }
				});
				tags.initialize();

				$('#tagsinput').tagsinput({
				   typeaheadjs: {
				    name: 'tags',
				    displayKey: 'tag',
				    valueKey: 'tag',
				    source: tags.ttAdapter()
				  }
				});
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
				
		  		$scope.createPost = function(input){
		  			
		  			Posts.createPost(input).success(function(data){
		  				$scope.message =  data;
		  			});
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
		  