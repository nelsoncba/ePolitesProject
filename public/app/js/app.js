angular.module('Polites', ['ui.router', 'politesControllers', 'angular-timeago','summernote', 'bsTagsInput'])
		.config(function($stateProvider, $urlRouterProvider) {
			
			$urlRouterProvider.otherwise('/');
			$stateProvider
			.state('root', {
					url: '/',
                    views: {
						'header': {
							templateUrl: 'app/views/header.html'
						},
						'main': {
							templateUrl: 'app/views/allPosts.html',
							controller: 'allPostsCtrl'

						},
						'sidebar': {
							templateUrl: 'app/views/sidebar.html',
							controller: 'sidebarCtrl'
						}
					}
			})
			.state('root.postsBySection',{
					url: ':slug',
					views:{
						'main@':{
							templateUrl: 'app/views/allPosts.html',
							controller: 'allPostsCtrl'
						}
					}
			})
            .state('root.post',{
					url: 'post/:id/:slug',
					views:{
						'main@':{
							templateUrl: 'app/views/post.html',
							controller: 'postCtrl'
						},
						'similarPosts@':{
							templateUrl: 'app/views/sidebar.html',
							controller: 'sidebarCtrl'
						}
					}
			})
			.state('root.crear-post',{
					url: 'articulo/crear',
					views:{
						'main@':{
							templateUrl: 'app/views/crear-post.html',
							controller: 'storePostCtrl'
						}
					}
			});
		})
		.filter('unsafe',function($sce){
			return function(text){
				return $sce.trustAsHtml(text);
			}
		})
		.filter('htmlToText',function(){
			return function(text){
				var newText = angular.element(text).text();
				return newText;
			}
		})
		.filter('strLimit',  function($filter) {
		   return function(input, limit) {
		      if (input.length <= limit) {
		          return input;
		      }
		    
		      return $filter('limitTo')(input, limit) + '...';
		   };
		})
		.filter('dateTime', function($filter){
			 return function(input){
			  input = input.replace(/(.+) (.+)/, "$1T$2Z");
			  input = new Date(input).getTime();
			  return input;
			 };
		})
		.filter('isUrl', function($filter){
			return function(input){
				var isUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w!:.?+=&%@!\-\/]))?/;
				if(isUrl.test(input)){
					return true;
				}else{
					return false;
				}
			};
		});
