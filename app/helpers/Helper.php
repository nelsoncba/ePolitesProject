<?php

class Helper{

	public static strIsUrl(str){
		var isUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w!:.?+=&%@!\-\/]))?/;
        return isUrl.test(str);
	}
}