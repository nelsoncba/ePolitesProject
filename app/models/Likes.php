<?php

class Likes extends Eloquent{
    protected $table = 'likes';

    protected $fillabe = array('likes','unlikes','total','commentario_id','usuario_id');
    
    

}
