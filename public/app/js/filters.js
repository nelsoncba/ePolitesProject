angular.module('Filters',[])
		
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