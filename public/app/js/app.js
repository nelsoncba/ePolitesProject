angular.module('Polites', ['ui.router','ngRoute', 'ngSanitize', 'ngCookies', 'Controllers', 'Service', 'Filters', 'angular-timeago','summernote', 'bsTagsInput'])
		.run(function($rootScope, $state, Authenticate, sessionService, Registration){
			'use strict';

			//init. var. 
			$rootScope.pathSelected = 'root';
			$rootScope.message = null;
			$rootScope.labelBtn = null;
			$rootScope.toTemplate = null;
			$rootScope.errors = null;


			//add current user to global var. 
			$rootScope.currentUser = sessionService.get('user');

			//auth. routes
			$rootScope.$on("$stateChangeStart", function(event, toState, toParams, fromState, fromParams) {

				//user registration confirmation or registration error
				if(toState.name == 'root.confirmRegister'){
					angular.element('#modalMsg').modal('show');
					Registration.verify(toParams.confirmToken).success(function(data){
						$rootScope.message = {success:data};
						$rootScope.labelBtn = 'Cerrar';
						$rootScope.toTemplate = function(){
							angular.element('#modalMsg').modal('hide');
							$rootScope.currentUser = sessionService.get('user');
							$state.transitionTo('root',{},{reload: true});
						}
					}).error(function(data){
		  				$rootScope.message = {error: data};
		  				$rootScope.labelBtn = 'Reenvío de email';
		  				$rootScope.toTemplate = function(){
		  					$state.go('root.register');
		  					angular.element('#modalMsg').modal('hide');
		  				}
		  			});
				}
				//add route selected to redirect after login 
	        	if(toState.name != 'root.login'){
	        		$rootScope.pathSelected = toState.name;
	        		$rootScope.paramUrl = toParams;
	        		
	        	}
	        	//
	            if (toState.authenticate && !Authenticate.isLoggedIn()) {
	            		$state.go('root.login');
                        event.preventDefault();
	            }

	        });
		})
		.config(function($stateProvider, $urlRouterProvider,$locationProvider){
			$stateProvider
			.state('root', {
					url: '/',
                    views: {
                    	'container':{templateUrl: 'app/views/container.html'},
						'header': {
							templateUrl: 'app/views/header.html',
							controller:  'HeaderCtrl'
						},
						'main@root': {
							templateUrl: 'app/views/allPosts.html',
							controller: 'AllpostsCtrl'

						},
						'sidebar@root': {
							templateUrl: 'app/views/sidebar.html',
							controller: 'SidebarCtrl'
						}
					},
					authenticate: false
			})
			.state('root.postsBySection',{
					url: 'seccion::slug',
					views:{
						'main@root':{
							templateUrl: 'app/views/allPosts.html',
							controller: 'AllpostsCtrl'
						}
					},
					authenticate: false
			})
            .state('root.post',{
					url: 'post/:id/:slug',
					views:{
						'main@root':{
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
			.state('root.create-post',{
					url: 'crear-articulo',
					views:{
						'main@root':{
							templateUrl: 'app/views/crear-post.html',
							controller: 'StorepostCtrl'
						}
					},
					authenticate: true
			})
			.state('root.register',{
					url: 'registro',
					views:{
						'container@':{
							templateUrl: 'app/views/register.html',
							controller: 'RegisterCtrl'
						}
					},
					authenticate: false
			})
			.state('root.login',{
					url: 'login',
					views:{
						'container@':{
							templateUrl: 'app/views/login.html',
							controller: 'LoginCtrl'
						}
					},
					authenticate: false
			})
			.state('root.confirmRegister',{
				url: 'register-verify/:confirmToken',
				authenticate: false		
			})
			.state('root.sendMail',{
					url:'send-email',
					views:{
						'container@':{
							templateUrl: 'app/views/send-email.html'
						}
					},
					authenticate: false
			});
			$urlRouterProvider.otherwise('/');
			//$locationProvider.html5Mode(true);
		})
		.config(function($httpProvider) {
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
		});
		