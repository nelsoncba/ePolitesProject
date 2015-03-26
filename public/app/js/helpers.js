angular.module('Polites')
		.factory('Helpers', function () {
			
			return {
				isUrl: function(text){
					var isUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                    return isUrl.test(text);
				}
			};
		});