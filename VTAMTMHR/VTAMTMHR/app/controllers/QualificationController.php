<?php


class QualificationController extends BaseController 
{
    public function viewQualification()
 	{
 		$Qualification = Qualification::where('Deleted',"!=","1")->get();
 		$v = View::make('Qualification.qualification');
 		$v->courses = $Qualification;
 		$v->user = User::getSysUser();
 		return $v;
 	}
        public function actionSearch()
        {

                    $v = View::make('Qualification.qualification');
                    $searchKey = Input::get('serachkey');
                    $qualification = Qualification::where("Qualification","LIKE", "%".$searchKey."%" )->where('Deleted','!=',1)->get();
                    
                    $v->user = User::getSysUser();
                    $v->courses =  $qualification;
                    $v->Issearch = true;
                    
                    return $v; 
        }
        
        public function actionCreate()
    {
                  $method = Request::getMethod();
                
                  $view = View::make('Qualification.QCreate');
                  $view->user = User::getSysUser();
                  $view->institutes = Institue::where('Deleted',"!=",1)->get();
                  $view->trades = Organization::where('Deleted','!=',1)->get();
                  //$view->EntryQualifications = EntryQualification::where('Deleted',"!=",1)->get();
                  
                if($method == "GET")
                {
                     return $view;
                    
                }
                if($method == "POST")
                {
                    $validator = Qualification::validate(Input::all());
                    
                    
                    if($validator->passes())
                    {
                        $c = new Qualification;
                        $c->fill(Input::all());
                        //$c->DateEntered = \Carbon\Carbon::now();
                        $c->User = User::getSysUser()->userID;
                        $c->save();
                         
                        return $view->with("done",true);
                        
                        
                        
                        
                    }
                    else
                    {
                       
                           return Redirect::to('createQualification')->withErrors($validator);
                         
                    }    
                        
                  
                   
                   
                  
                    
                    
                    
              }
                
                  
                
                
        }
        public function actionDelete()
    {
                
                
                $En_Id= Input::get('En_Id');
                
               
                $course = Qualification::findOrFail($En_Id); // if not found show 404 page
                
                
                 $course->Deleted = 1;
				 $course->Changed = 1;
                 $course->DateEntered = \Carbon\Carbon::now();
                 $course->User = User::getSysUser()->userID;
                 
                 
                
                $course->save();
                
                
                
                
                
                
                return Redirect::to('searchQualification');
                
                
                
                
                
   }
   
   public function actionEdit()
        {
            $view = View::make('Qualification.Edit');
            
            
            switch (Request::getMethod()) 
            {
                case 'GET':

                    
                    
                    
                     $view->institutes = Institue::where('Deleted',"!=",1)->get();
                     $view -> course = Qualification::where('En_Id',"=",  Input::get('En_Id'))->first();
                     $view->trades = Organization::where('Deleted','!=',1)->get();
                     //$view->EntryQualifications = EntryQualification::where('Deleted',"!=",1)->get();
                    
                     return  $view;
                    
                    break;
                
                case 'POST':

                    
                    $array =  Input::all();
                    
                    $c = Qualification::find($array['En_Id']);
                    
                    
                   $c->fill(Input::all());
                   $c->Uploaded=0;
                   $c->Changed=1;
                   
                   
                   if($c->save())
                   {
                       
                       return Redirect::to('searchQualification');
                       
                       
                   }
                    
                    // do your edit here
                    

                    break;
                
                default:
                  
                    break;
            }
            
            
           
            
            
            
            
            
            
            
        }
            

            
        
    
}
