<?php

class CourseCategory extends Eloquent {

    protected $table = 'coursecategory';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

   
   
}
