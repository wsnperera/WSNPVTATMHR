<?php



 class HolidayController extends BaseController
 {


 	public function viewHoliday()
 	{
     
 		$holidays = DB::select(DB::raw("select holiday.H_ID,holiday.HolidayYear,holiday.Holidaydate,holidaytype.HTName,holiday.Active
  from holiday
  left join holidaytype
  on holiday.HTId=holidaytype.HTId
  where holiday.Deleted=0
  order by holiday.Holidaydate ASC"));
                



 		$v = View::make('Holiday.Holiday');

 		
 		$v->holidays = $holidays;
 		$v->user = User::getSysUser();

                
                    


 		return $v;

        }
        
        
        
/*

 	public function registerHoliday()
 	{

 			$user = User::where('userID', '=', Session::get('currentUser')->userID)->first();
 		$holidays = Course::all();

 		$view = View::make('Holiday.registerholiday');

 		$view->holidays= $holidays;
 		$view->user = $user;

 		return $view;


 	}
*/

/*
 	public function regHoliday()
 	{
 		$response = array();



 		$user = User::where('userID', '=', Session::get('currentUser')->userID)->first();

 		$cid = Input::get("HID");


 		$check = studentCourse::where('userID','=',$user->userID)->where('courseID','=',$cid)->first();

 		if(is_null($check))
 		{


	 		$studentCourse = new studentCourse;

	 		$studentCourse->userID = $user->userID;

	 		$studentCourse->courseID = $cid;

	 		$studentCourse->save();

 		
 			$response["done"] = 1;
 			$response["message"] = "Sucsesfully Registered";



 		}
 		else
 		{

 			$response["done"] = 0;
 			$response["message"] = "You are already Registered on this course";
 		}


 		echo json_encode($response);

 		




 	}
      
         
     */   
        
             public function actionSearch()
            {

                    $v = View::make('Holiday.Holiday');
                 
                 
                    $searchKey = Input::get('key');
                    
                  $v-> holidays = Holiday::where("HolidayYear","=",$searchKey)->where('Deleted','!=',1)->get();
                    
                    $v->user = User::getSysUser();
                    //$v->holiday =  $tmp;
                    $v->Issearch = true;
                    
                    
                    
                    
                    return $v;
                    
                    
                    
                    
            }
         
             


            
            public function actionDelete()
            {
                
                
                $cid = Input::get('cid');
                
                
               
                $holiday = Holiday::find($cid); // if not found show 404 page
                
                
                 $holiday->Deleted = 1;
				 $holiday->Changed = 1;
                 $holiday->DateEntered = \Carbon\Carbon::now();
                 $holiday->User = User::getSysUser()->userID;
                 
                 
                
                $holiday->save();
                
                
                
                
                
                
                return Redirect::to('holiday');
                
                
                
                
                
            }
            
         
    public function actionCreate()
            {
                
                
                  $method = Request::getMethod();
                
                  $view = View::make('Holiday.Create');
                  $view->user = User::getSysUser();
                  $view->holidaytypes = HolidayType::where('Deleted',"!=",1)->get();
                  //$view->trades = Trade::where('Deleted','!=',1)->get();
                  //$view->EntryQualifications = EntryQualification::where('Deleted',"!=",1)->get();
                  
                
                if($method == "GET")
                {
                    
                    $fullDate=Input::get('HolidayYear');
                    $year=substr($fullDate,0,4);
                    echo $year;
                     return $view;
                    
                    
                }
                if($method == "POST")
                {
                    $fullDate=Input::get('HolidayYear');
                    $year=substr($fullDate,0,4);
                    $month=substr($fullDate,5,2);
                    $day=substr($fullDate,8,2);
                    
                    
                  
                     $c = new Holiday;
              
                   $validator = Holiday::validate(Input::all());
                     
                    if($validator->passes())
                    {
                     $c->HolidayYear=$year;
                     $c->HolidayMonth=$month;
                     $c->HolidayDay=$day;
                     $c->HTId=Input::get('HTId');
                     $c->PublicIn=Input::get('PublicIn');
                     $c->HTId=Input::get('HTId');
                    $c->FullTime=Input::get('FullTime');
                     $c->PartTime=Input::get('PartTime');
                     $c->Holidaydate = $fullDate;
                     //$c->DateEntered = \Carbon\Carbon::now();
                     $c->User = User::getSysUser()->userID;
                     $c->save();
                              return Redirect::to('holiday');
                     
                    }
                    else{
                        
                       return Redirect::to('createHoliday')->withErrors($validator); 
                        
                    }
          
                    //$validator = Holiday::validate(Input::all());
                    
                    
//                    if($validator->passes())
//                    {
//                        
//                       
//                       
//                        $c = new Holiday;
//                        $c->fill(Input::all());
//                        $c->DateEntered = \Carbon\Carbon::now();
//                        $c->User = User::getSysUser()->userID;
//                        $c->save();
//                         
//                        //return $view->with("done",true);
//                        
//                        
//                        
//                        
//                    }
//                    else
//                    {
//                       
//                           //return Redirect::to('createHoliday')->withErrors($validator);/
                        
//                    }    
                        
                  
                }  
                   
                  
                    
                    
                    
            }

    public function actionEdit()
        {
            $view = View::make('Holiday.Edit');
            
            
            switch (Request::getMethod()) 
            {
                case 'GET':

                    
                    
                    
                    // $view->institutes = Institue::where('Deleted',"!=",1)->get();
                    $htid = Holiday::where('H_ID',"=",  Input::get('cid'))->pluck('HTId');
                     $view ->holiday = Holiday::where('H_ID',"=",  Input::get('cid'))->first();
                     $view->holidaytypes = HolidayType::where('Deleted',"!=",1)->get();
                     $view->h_day = HolidayType::where('HTId',"=",$htid)->pluck('HTName');

                     //$view->trades = Trade::where('Deleted','!=',1)->get();
                    // $view->EntryQualifications = EntryQualification::where('Deleted',"!=",1)->get();
                    
                     return  $view;
                    
                    break;
                
                case 'POST':

                    
                    $array =  Input::all();
                    
                    $c = Holiday::find($array['H_ID']);
                    
                    
                   //$c->fill(Input::all());
                   
                    $fullDate=Input::get('HolidayYear');
                    $year=substr($fullDate,0,4);
                    $month=substr($fullDate,5,2);
                    $day=substr($fullDate,8,2);
                     $c->HolidayYear=$year;
                     $c->HolidayMonth=$month;
                     $c->HolidayDay=$day;
                     $c->HTId=Input::get('HTId');
                     $c->PublicIn=Input::get('PublicIn');
                     $c->HTId=Input::get('HTId');
                   $c->Active=Input::get('Active');
                     $c->Holidaydate = $fullDate;
                     //$c->DateEntered = \Carbon\Carbon::now();
                     $c->User = User::getSysUser()->userID;
					 $c->Changed = 1;
                     $c->save();
                   
                   if($c->save())
                   {
                       
                       return Redirect::to('holiday');
                       
                       
                   }
                    
                    // do your edit here
                    

                    break;
                
                default:
                  
                    break;
            }
            
            
           
            
            
            
            
            
            
            
        }
            
            
            
            
            
            
            
            
            
            
            
            
            
                    }


 

