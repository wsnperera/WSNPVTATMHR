<?php




 class activityController extends BaseController
 {
     	
     
     
     
     public function viewActivity()
 	{

             $activities = Activity::where('Deleted','=',0)->get();
           



 		$v = View::make('activity.activity');

 		
 		$v->trades = $activities;
 		$v->user = User::getSysUser();

                
                    
                 //print_r($activities);

 		return $v;

        }               
     
     
     
     
     
     
     
     
     
     
     public function actionCreate()
            {
                
                
                  $method = Request::getMethod();
                
                  $view = View::make('activity.create');
                  $view->user = User::getSysUser();
                  //$view->holidaytypes = HolidayType::where('Deleted',"!=",1)->get();
                  $view->trades = Activity::get();
                  
                  
                
                if($method == "GET")
                {
                    
                     return $view;
                    
                    
                }
                if($method == "POST")
                {
                    
                    
                    
                    
                    
                    $validator = Activity::validate(Input::all());
                    
                    
                    if($validator->passes())
                    {
                        
                       
                       
                        $c = new Activity;
                        $c->fill(Input::all());
                       // $c->DateEntered = \Carbon\Carbon::now();
                        //$c->User = User::getSysUser()->userID;
                        $c->save();
                         
                      return Redirect::to('viewActivity');
                        
                        
                        
                        
                    }
                    else
                    {
                       
                           return Redirect::to('createActivity')->withErrors($validator);
                         
                    }    
                        
                  
                }  
                   
                  
                    
                    
                    
            }  
     
    public function actionSearch()
            {

                    $v = View::make('activity.activity');
                 
                 
                    $searchKey = Input::get('key');
                    
                  $v-> trades = Activity::where("activityname","LIKE",'%'.$searchKey.'%')->get();
                    //->where('Deleted','!=',1)
                    $v->user = User::getSysUser();
                    //$v->holiday =  $tmp;
                    $v->Issearch = true;
                    
                    
                    
                    
                    return $v;
                    
                    
                    
                    
            }
         
             


            
            public function actionDelete()
            {
                
                
                $cid = Input::get('cid');
                
                
               
                $trades = Trade1::find($cid); // if not found show 404 page
                
                
                 $trades->Deleted = 1;
				 $trades->Changed = 1;
                 //$trades->DateEntered = \Carbon\Carbon::now();
                 $trades->User = User::getSysUser()->userID;
                 
                 
                
                $trades->save();
                
                
                
                
                
                
                return Redirect::to('viewTrades');
                
                
                
                
                
            }
            

                  
        public function actionEdit()
        {
            $view = View::make('activity.Edit');
            
            
            switch (Request::getMethod()) 
            {
                case 'GET':

                    
                        $cdid = Request::get('cid');
                    
                    
                       
                 
                    
                   
                     $view->trades = Activity::find(Request::get('cid'));
                  
                    
                    
                     return  $view;
                    
                    break;
                
                case 'POST':
                    $id=Input::get('activityid');
                    
         //$array =  Input::all();
                    
                    //$c = Activity::find($array['id']);
                    $c=Activity::find($id);
                    
                   $c->fill(Input::all());
				   $c->Changed = 1;
                   
                   $c->save();
                   
                   if($c->save())
                   {
                       
                       return Redirect::to('viewActivity');
                       
                       
                   }
                    
                    

                    break;
                
                default:
                  
                    break;
            }
            
            
           
            
            
            
            
            
            
            
        } 
  
            
            
            
            
            
            
        }
            
            
            
            
            
            
            
            
            
            
            
            
            
                    


 



  




























