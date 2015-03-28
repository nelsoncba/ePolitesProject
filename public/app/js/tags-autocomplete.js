
angular.module('tags-autocomplete', [])
		.directive('tagsAutocomplete', function ($http) {
			return {
				restrict: 'AE',
				scope:{
					selectedTags: '=model'
				},
				templateUrl: 'app/views/tags-autocomplete.html',
				link: function (scope, element, attrs) {
					scope.suggestions = [];
					scope.selectedTags = [];
					scope.selectedIndex = -1;

					scope.removeTag=function(index){
		                scope.selectedTags.splice(index,1);
		            }

		            scope.search=function(){
		                $http.get(attrs.url+'?term='+scope.searchText).success(function(data){
		                    if(data.indexOf(scope.searchText)===-1){
		                        data.unshift(scope.searchText);
		                    }
		                    scope.suggestions=data;
		                    scope.selectedIndex=-1;
		                });
		            }

		            scope.addToSelectedTags=function(index){
		                if(scope.selectedTags.indexOf(scope.suggestions[index])===-1){
		                    scope.selectedTags.push(scope.suggestions[index]);
		                    scope.searchText='';
		                    scope.suggestions=[];
		                }
		            }

		            scope.checkKeyDown=function(event){
		                if(event.keyCode===40){
		                    event.preventDefault();
		                    if(scope.selectedIndex+1 !== scope.suggestions.length){
		                        scope.selectedIndex++;
		                    }
		                }
		                else if(event.keyCode===38){
		                    event.preventDefault();
		                    if(scope.selectedIndex-1 !== -1){
		                        scope.selectedIndex--;
		                    }
		                }
		                else if(event.keyCode===13){
		                    scope.addToSelectedTags(scope.selectedIndex);
		                }
		            }

		            scope.$watch('selectedIndex',function(val){
		                if(val!==-1) {
		                    scope.searchText = scope.suggestions[scope.selectedIndex];
		                }
		            });
				}
			};
		});