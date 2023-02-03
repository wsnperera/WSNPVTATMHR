<?php



 class Trade1Controller extends BaseController
 {


 	public function viewTrades()
 	{

 	






     
 		$trades = Trade1::where('Deleted',"!=","1")->get();
                



 		$v = View::make('Trade1.Trade');

 		
 		$v->trades = $trades;
 		$v->user = User::getSysUser();

                
                    


 		return $v;

        }
        
        
        



        
             public function actionSearch()
            {

                    $v = View::make('Trade1.Trade');
                 
                 
                    $searchKey = Input::get('key');
                    $sql = "select *
                    from trade 
                    where Deleted=0 
                    and TradeName like '%".$searchKey."%'";
                    $trades = DB::select(DB::raw($sql));
                    $v->trades = $trades;
                    
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
                 $trades->DateEntered = \Carbon\Carbon::now();
                 $trades->User = User::getSysUser()->userID;
                 
                 
                
                $trades->save();
                
                
                
                
                
                
                return Redirect::to('viewTrades');
                
                
                
                
                
            }
            
            public function actionCreate()
            {
                
                
                  $method = Request::getMethod();
                
                  $view = View::make('Trade1.Create');
                  $view->user = User::getSysUser();
                  //$view->holidaytypes = HolidayType::where('Deleted',"!=",1)->get();
                  $view->trades = Trade1::where('Deleted',"!=",1)->get();
                  //$view->organisations = Organisation::where('Deleted',"!=",1)->get();
                  //$view->coursestarteds =Coursestarted::where('Deleted',"!=",1)->get();
                  //$view->trades = Trade::where('Deleted','!=',1)->get();
                  //$view->EntryQualifications = EntryQualification::where('Deleted',"!=",1)->get();
                  
                
                if($method == "GET")
                {
                    
                     return $view;
                    
                    
                }
                if($method == "POST")
                {
                    
                    
                    
                    
                    
                    $validator = Trade1::validate(Input::all());
                    
                    
                    if($validator->passes())
                    {
                        
                       
                       
                        $c = new Trade1;
                        $c->fill(Input::all());
                        //$c->DateEntered = \Carbon\Carbon::now();
                        $c->User = User::getSysUser()->userID;
                        $c->save();
                         
                      return Redirect::to('viewTrades');
                        
                        
                        
                        
                    }
                    else
                    {
                       
                           return Redirect::to('createTrade1')->withErrors($validator);
                         
                    }    
                        
                  
                }  
                   
                  
                    
                    
                    
            }  
                  
        public function actionEdit()
        {
            $view = View::make('Trade1.Edit');
            
            
            switch (Request::getMethod()) 
            {
                case 'GET':

                    
                        $cdid = Request::get('cid');
                    
                    
                       
                 
                    
                    // $view->institutes = Coursestarted::where('Deleted',"!=",1)->get();
                     

                    
                     //$view -> holiday = Holiday::where('H_ID',"=",  Input::get('cid'))->first();
                     //$view->holidaytypes = HolidayType::where('Deleted',"!=",1)->get();
                      // $view->organisations = Organisation::where('Deleted',"!=",1)->get();
                     //$view->trades = Trade::where('Deleted','!=',1)->get();
                    // $view->EntryQualifications = EntryQualification::where('Deleted',"!=",1)->get();
                     $view->trades = Trade1::find(Request::get('cid'));
                     
                    //$view->institues = Institue::where('Deleted',"!=",1)->get();
                    
                     return  $view;
                    
                    break;
                
                case 'POST':

                    
         $array =  Input::all();
                    
                    $c = Trade1::find($array['TradeID']);
                    
                    
                   $c->fill(Input::all());
				   $c->Changed = 1;
                   
                   
                   
                   if($c->save())
                   {
                       
                       return Redirect::to('viewTrades');
                       
                       
                   }
                    
                    

                    break;
                
                default:
                  
                    break;
            }
            
            
           
            
            
            
            
            
            
            
        } 
  
            
            
            
            
            
            
        }
            
            
            
            
            
            
            
            
            
            
            
            
            
                    


 


