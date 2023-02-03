<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

 Validator::extend('alpha_dale', function($attribute, $value)
{
    return preg_match('/^[ A-Za-z.]*$/', $value);
});


require app_path().'/filters.php';

Validator::extend('alpha_spaces', function($attribute, $value)
{
return preg_match('/^[\pL\s]+$/u', $value);
});
 
 
// use it as usual:
$rules = array('name' => 'required|alpha_spaces');


require app_path().'/filters.php';
Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s]+$/u', $value);
});

 Validator::extend('nic_val', function($attribute, $value)
{
    return preg_match('/^[0-9]{9}[v|V|X|M]$/', $value);
});
 
// use it as usual:
$rules = array('OrgaName' => 'required|alpha_spaces');

require app_path().'/filters.php';
Validator::extend('alpha_spaces', function($attribute, $value)
{
return preg_match('/^[\pL-\s]+$/u', $value);
});
 Validator::extend('custom', function($attribute, $value, $parameters)
{
  
        $year = $parameters[0];
        $course=$parameters[1];
        
    //echo $value;
      $sql = DB::table('applicant')
      ->where('NIC',$value)
      ->where('Year',$year)
      ->where('CourseCode',$course)
      ->count();
   
var_dump($sql);
      
    if($sql>=1)
    {
        return false; 
    }
    
 else{
        return true; 
 }
    
    
    
    
});
 Validator::extend('employee', function($attribute, $value, $parameters)
{
  
        $empid = $parameters[0];
     
        
    //echo $value;
      $sql = DB::table('employee')
      ->where('EPFNo',$empid)
     
      ->count();
   
var_dump($sql);
      
    if($sql>=1)
    {
        return true; 
    }
    
 else{
        return false; 
 }
    
    
    
    
});
 Validator::extend('student_id', function($attribute, $value,$parameters)
{
  
        $student_id = $parameters[0];
     
        
    //echo $value;
      $sql = DB::table('trainee')
      ->where('Training_No',$student_id)
     
      ->count();
   
var_dump($sql);
      
    if($sql>=1)
    {
        return true; 
    }
    
 else{
        return false; 
 }
    
    
    
    
});
Validator::extend('ExamAnswer', function($attribute, $value, $parameters)
{
    $RA = $parameters[0];
    $WA=$parameters[1];
    if($RA==$WA)
    {
        return false; 
    }
    else
    {
        return true; 
    }
 });
// use it as usual:
$rules = array('SubjectName' => 'required|alpha_spaces');
Validator::extend('alpha_spaces_and', function($attribute, $value) {
    return preg_match('/^[\pL\s&]+$/u', $value);
});
