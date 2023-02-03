<?php


 class HolidayTypeController extends BaseController
 {


 	public function viewHolidayTypes()
 	{

 	

 		

 		$courses = HolidayType::where('Deleted',"!=","1")->get();
                



 		$v = View::make('HolidayType');

 		
 		$v->HolidayTypes = $courses;
 		$v->user = User::getSysUser();

                
                    


 		return $v;


 	}
        
          public function actionDelete()
            {
                
                
                $cid = Input::get('HTId');
                
               
                $course = HolidayType::findOrFail($cid); // if not found show 404 page
                
                
                 $course->Deleted = 1;
                 $course->DateEntered = \Carbon\Carbon::now();
                 $course->User = User::getSysUser()->userID;
                 
                 
                
                $course->save();
                
                
                
                
                
                
                return Redirect::to('HolidayType');
                
                
                
                
                
            }
            
            
              public function actionSearch()
            {

                    $v = View::make('HolidayType');
                 
                 
                    $searchKey = Input::get('serachkey');
                    
                    $course = HolidayType::where("HTName","LIKE", "%".$searchKey."%" )->where('Deleted','!=',1)->get();
                    
                    
                   
                   
                 
                    
                    $v->user = User::getSysUser();
                    $v->HolidayTypes =  $course;
                    $v->Issearch = true;
                    
                    
                    
                    
                    return $v;
                    
                    
                    
                    
            }

         public function actionEdit()
                 
    {
        $view = View::make('EditHolidayType');
        
        
        switch (Request::getMethod()) 
        {
            
                case 'GET':
                    
                    $x = HolidayType::where('HTId',"=",Input::get('cid'))->first();
                  
                     $view -> batch = $x;
                     $view->user = User::getSysUser();
                     return  $view;
                     
                    break;
                
                case 'POST':
                    $b=new HolidayType;
                    $b = HolidayType::find(Input::get('HTId'));
                    $b->HTName=Input::get('HTName');
					$b->Changed = 1;
                    
                   
                    $b->DateEntered = \Carbon\Carbon::now();
                    $b->User = User::getSysUser();
                    $b->save();
                 
                   if($b->save())
                   {
                       
                       return Redirect::to('HolidayType');
                       
                   }
                    
                
                    break;
                
                default:
                  
                    break;
            }
            
          
            
        }
            
        
          public function actionCreate()
          { 
              
                    $view=View::make('CreateHolidayType');
                    $HDT=new HolidayType;
                    $view->user = User::getSysUser();
                    $method= Request::getMethod();
                    
                    
                    if($method=='POST')
                    {
                        $HDT= new HolidayType();
                        
                        $HDT->HTName = Input::get('HTName');
						            $HDT->DateEntered = date('y-m-d');
						            $HDT->User = User::getSysUser()->userID;
                        
                        $validator = HolidayType::validate(Input::all());
                        
                        if($validator->passes())
                        {
                           
                            $HDT->save();
                            return Redirect::to('HolidayType');
                        }
                        else
                        {
                              return Redirect::to('createHolidayType')->withErrors($validator);
                        }
                        
                        
                     
                      
                       
                       
                        
                        return $view;
                    }
                     if($method=='GET')
                    {
                         return $view;
                     }
                    
                    
                    
                    
                    
                
            }
        
 }
 
 