angular.module('Controllers',[])
		  .controller('AllpostsCtrl', function($rootScope,$scope, $state, $anchorScroll, Posts) {
		  		//initialize variables 
		  		//to paginate in server
		  		$scope.page = 1;
		  		$scope.perPage = 3;
		  		//loaders & link show more
				$scope.more = $scope.more_posts = false;
				$scope.has_posts = null;
				$scope.posts = [];

				$anchorScroll();

				//check if there is a section 
			  	if($state.params.slug == null){
					Posts.getAllPosts($scope.page + '/' + $scope.perPage).success(function(data){
						//concatenates paged articles
					    $scope.posts = $scope.posts.concat(data.data);
					    $scope.has_posts = true;
					    //check for more paged posts
						$scope.more = $scope.page < (data.total / $scope.perPage);
				    });
				}else if($state.params.slug){
					Posts.getBySection($state.params.slug + '/' + $scope.page + '/' + $scope.perPage).success(function(data) {
				  		$scope.posts = $scope.posts.concat(data.data);
				  		$scope.has_posts = true;
						$scope.more = $scope.page < (data.total / $scope.perPage);
				  	});
				}

				$scope.has_more = function(){
					return $scope.more;
				};

				//link to show more posts
				$scope.show_more = function(){
					$scope.more_posts = true;
					$scope.page = $scope.page + 1;
					if($state.params.slug == null){
						Posts.getAllPosts($scope.page + '/' + $scope.perPage).success(function(data){
						    $scope.posts = $scope.posts.concat(data.data);
						    $scope.more_posts = false
							$scope.more = $scope.page < (data.total / $scope.perPage);
					    });
					}else{
						Posts.getBySection($state.params.slug + '/' + $scope.page + '/' + $scope.perPage).success(function(data) {
					  		$scope.posts = $scope.posts.concat(data.data);
					  		$scope.more_posts = false;
							$scope.more = $scope.page < (data.total / $scope.perPage);
					  	});
					}
				};

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
					          prefetch: './api/v1/tags'
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
						$state.go('root', {},{reload: true})
					}, 1500);
				};

				$scope.deleteImgMini = function(imageMini){
					if(!$filter('isUrl')(imageMini)){
						Posts.deleteImage({imagemini: imageMini}).success(function(data){
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
			  			$state.go($rootScope.pathSelected, $rootScope.paramUrl, {reload: true});
			  		}).error(function(data){
			  			login.password = '';
			  			$scope.flash = data.flash;
			  		});
			  	};
			  	$scope.tplLogin = function(){
		  			if(Authenticate.isLoggedIn()){
		  				$state.go('root');
		  				return false;
		  			}else{
		  				return  true;
		  			}
		  		};
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
		  .controller('HeaderCtrl', function ($rootScope, $scope, $state, Authenticate, Registration) {
		  
		  		$scope.login = function(){
		  			if(!$rootScope.currentUser)
		  				$state.go('root.login');
		  			else
		  				$state.go('root');
		  		};
		  		$scope.logout = function(){
		  			Authenticate.logout();
		  			$state.go('root', {},{reload: true});
		  		};

		  })
		  .controller('RegisterCtrl',  function($rootScope, $scope, $state, Registration) {
		  		
		  		$scope.registration = function(input){
		  			$rootScope.errors = null;
		  			$rootScope.message = null;
		  			angular.element('#modalMsg').modal('show');
		  			Registration.storeUser(input).success(function(data){
		  				$rootScope.message = {success: data};
		  				$rootScope.labelBtn = 'Ir a login';
		  				$scope.input = '';
		  				$rootScope.toTemplate = function(){
		  					angular.element('#modalMsg').modal('hide');
		  				}
		  			}).error(function(data){
		  				if(data.message){
			  				$rootScope.message = {error: data};
			  				$rootScope.labelBtn = 'Cerrar';
			  				$rootScope.toTemplate = function(){
			  					angular.element('#modalMsg').modal('hide');
			  				}		  					
		  				}else{
		  					$rootScope.errors = data;
		  					angular.element('#modalMsg').modal('hide');
			  			}	
		  			});
		  		}

		  });
		  