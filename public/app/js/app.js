angular.module('Polites', ['ui.router', 'politesControllers', 'angular-timeago'])
		.config(function($stateProvider, $urlRouterProvider) {
			
			$urlRouterProvider.otherwise('/');
			$stateProvider
			.state('root', {
					url: '',
                    views: {
						'header': {
							templateUrl: 'app/views/header.html'
						},
						'main': {
							templateUrl: 'app/views/allPosts.html',
							controller: 'allPostsController'

						},
						'sidebar': {
							templateUrl: 'app/views/sidebar.html',
							controller: 'sidebarController'
						}
					}
			})
            .state('root.post',{
					url: '/post/:id/:slug',
					views:{
						'main@':{
							templateUrl: 'app/views/post.html',
							controller: 'postController'
						},
						'similarPosts@':{
							templateUrl: 'app/views/sidebar.html',
							controller: 'sidebarController'
						}
					}
			});
		});
		
		
/*angular.module('Polites', ['ui.state','ui.router'])
	    .config(function($stateProvider, $urlRouterProvider) {
	    	$urlRouterProvider.otherwise( '/' );
	    	$stateProvider
	    		.state('index',{
	    			url: '/',

	    					//controller: 'PostsController',
	    			templateUrl: 'app/views/allPosts.html'
	    		});
	    });
		.state('main': {
							templateUrl: 'app/views/allPosts.html',
							controller: 'allPostsController'
						})*/

