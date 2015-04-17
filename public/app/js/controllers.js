angular.module('Controllers',[])
		  .controller('AllpostsCtrl', function($scope, $state, $anchorScroll, Posts) {
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
		  .controller('PostCtrl',function($scope, $state, $timeout, $anchorScroll, Posts){
		  	    $scope.convertToDate = function(input){
		  	    	input = input.replace(/(.+) (.+)/, "$1T$2Z");
					input = new Date(input).getTime();
					return input;
		  	    };
		  		Posts.getPost($state.params.id + '/' + $state.params.slug).success(function(data) {
		  			$scope.post = data;
		  		}).error(function(data){
		  			$scope.post = {error: data};
		  		});
		  			$anchorScroll();
		  		Posts.getComments($state.params.id).success(function(data){
		  			$scope.comments = data;
		  		});

		  		$scope.getReply = function(comment){
			  		comment.imgReply = true;
				  	Posts.getReplies(comment.id).success(function(data){
				  	    comment.replies = data;
				  	    comment.replyData = true;
				  	    comment.imgReply = false;
					});
		  			this.show = true;
		  		};

				$scope.replyComment = function(comment){
					if(comment.respuestasTotal > 0){
						this.getReply(comment);
					}else{
						this.show = true
					}
				}

		  		$scope.storeComment = function(post, input){
                    Posts.storeComment(post.id, input).success(function(data){
                    	/*Posts.getComments(post.id).success(function(data){
		  				      $scope.comments = data;
		  				});*/
                    	$scope.comments.push(data);
		  				input.comment = '';
                    });
		  		};


		  		$scope.storeReply = function(comment, input){
		  			Posts.storeReply(comment.id, input).success(function(data){
		  				comment.replies = data;
		  				/*message = data;
		  				Posts.getReplies(comment.id).success(function(data){
		  					comment.replies = data;
		  					comment.replyData = true;
		  				});*/
		  				input.reply = '';
		  			});
		  		};

		  })
		  .controller('StorepostCtrl', function($scope, $anchorScroll, $timeout, $state, $filter, Posts) {
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
						maxTags: 8,
						typeahead: {
					          prefetch: './api/tags'
					    }
				};
				/***end-tags********/

				Posts.getSections().success(function(data){
					$scope.secciones = data;
				});		

				//funcion para cargar imagen al servidor y luego renderizarla en el cuadro del editor
				//function to upload the image to the server and then render it this in the editor display box 
				$scope.uploadImagemini = function(files){
					data = new FormData();
					data.append('file', files[0]);
					Posts.uploadImage(data).success(function(url){
						path = 'images/post/'+url;
						$scope.imageMini = path;
					});
					$('#image-mini-modal').modal('hide');
				};

				$scope.uploadImageminiUrl = function(file){
					if($filter('isUrl')(file)){
						$scope.imageMini = file;
						$scope.errors = {imagemini: ''};
					}else{
						$scope.errors = {imagemini: 'URL de imagen inválida'};
					}
				};

				$scope.toAllPosts = function(){
					angular.element('#storePost').modal('hide');
					$timeout(function(){
						$state.go("root");
					}, 1500);
				};

				$scope.deleteImgMini = function(imageMini){
					if(!$filter('isUrl')(imageMini)){
						Posts.deleteImage({imagemini: imageMini}).success(function(data){
							console.log('success ', data);
						})
						.error(function(data){
							console.log('error ', data);
						});
					}
					$scope.imageMini = null;
				};
		  })
		  .controller('LoginCtrl', function ($rootScope, $scope, $sanitize, $state, Authenticate) {
		  		$scope.authentication = function(login){
		  			Authenticate.login({
		  				'email': $sanitize(login.email),
		  				'password': $sanitize(login.password)
		  			}).success(function(data){
		  				angular.element('#login').modal('hide');
		  				$state.go($rootScope.pathSelected, {},{reload: true});
		  			}).error(function(data){
		  				$scope.flash = data;
		  			});
		  		}
		  })
		  .controller('SidebarCtrl',function($scope, $anchorScroll, Posts) {
		  		$anchorScroll();
		  		Posts.getSections().success(function(data){
		  			$scope.secciones =  data;
		  		});
		  		Posts.getRecentPosts().success(function(data){
		  			$scope.sidebarPosts = data;
		  		});
		  })
		  .controller('HeaderCtrl', function ($rootScope, $scope, $state, Authenticate, $cookieStore) {
		  		$scope.login = function(){
		  			angular.element('#login').modal('show');
		  		};
		  		$scope.logout = function(){
		  			Authenticate.logout();
		  			$state.go('root', {},{reload: true});
		  		};
		  		
		  })
		  .controller('AppCtrl', function ($scope, $rootScope) {
		  });
		  