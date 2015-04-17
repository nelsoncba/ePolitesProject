angular.module('Polites', ['ui.router', 'ngSanitize', 'ngCookies', 'Controllers', 'Service', 'Filters', 'angular-timeago','summernote', 'bsTagsInput'])
		.run(function($rootScope, $state, Authenticate, sessionService){
			'use strict';
			$rootScope.currentUser = sessionService.get('user');
			$rootScope.$on("$stateChangeStart",
	        function(event, toState, toParams, fromState, fromParams) {
	            if (toState.authenticate && !Authenticate.isLoggedIn()) {
	            	$rootScope.pathSelected = toState.name;
	                angular.element('#login').modal('show');
	                event.preventDefault();
	            }
	        });
		})
		.config(function($stateProvider, $urlRouterProvider) {
			$stateProvider
			.state('root', {
					url: '/',
					controller: 'AppCtrl',
                    views: {
						'header': {
							templateUrl: 'app/views/header.html',
							controller:  'HeaderCtrl'
						},
						'main': {
							templateUrl: 'app/views/allPosts.html',
							controller: 'AllpostsCtrl'

						},
						'sidebar': {
							templateUrl: 'app/views/sidebar.html',
							controller: 'SidebarCtrl'
						}
					},
					authenticate: false
			})
			.state('root.postsBySection',{
					url: ':slug',
					views:{
						'main@':{
							templateUrl: 'app/views/allPosts.html',
							controller: 'AllpostsCtrl'
						}
					},
					authenticate: false
			})
            .state('root.post',{
					url: 'post/:id/:slug',
					views:{
						'main@':{
							templateUrl: 'app/views/post.html',
							controller: 'PostCtrl'
						},
						'similarPosts@':{
							templateUrl: 'app/views/sidebar.html',
							controller: 'SidebarCtrl'
						}
					},
					authenticate: false
			})
			.state('root.crear-post',{
					url: 'articulo/crear',
					views:{
						'main@':{
							templateUrl: 'app/views/crear-post.html',
							controller: 'StorepostCtrl'
						}
					},
					authenticate: true
			});
			$urlRouterProvider.otherwise('/');
		});
		/*.config(function($httpProvider) {
			var interceptor = function($injector,$q,$rootScope){
	        var success = function(response){
	            return response
	        }
	        var error = function(response){
	            if (response.status == 401){
	                delete sessionStorage.authenticated
	                var state = $injector.get('$state');
	                angular.element('#login').modal('show');
	                $rootScope.flash(response.data);
	            }
	            return $q.reject(response);
	        }
	            return function(promise){
	                return promise.then(success, error);
	            }
	        }
	        $httpProvider.interceptors.push(interceptor);
		});*/
		