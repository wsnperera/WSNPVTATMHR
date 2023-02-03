<?php
use SimpleExcel\SimpleExcel;

class CourseController extends BaseController{
	
	  public function DeletedCourseCatogory() {


        $cid = Input::get('cid');


        $course = CourseCategory::findOrFail($cid); // if not found show 404 page


        $course->Deleted = 1;
		
        $course->User = User::getSysUser()->userID;



        $course->save();

  return Redirect::to('viewCourseCatogory');
    }
	
	  public function EditCourseCatogory() {
        $view = View::make('CourseCategory.Edit');


        switch (Request::getMethod()) {
            case 'GET':
                    $view->course = CourseCategory::where('id', "=", Input::get('cid'))->first();
                

                return $view;

                break;

            case 'POST':


               
                $Category = Input::get('Category');
                $i=0;

                $c = CourseCategory::find(Input::get('CD_ID'));


                //$c->fill(Input::all());
                $c->Category= $Category;
                
                $c->User = User::getSysUser()->userID;
                
                $c->save();
              

               
                return Redirect::to('viewCourseCatogory');

                // do your edit here


            
        }
    }
	
	 public function CreateCourseCatogory() {


        $method = Request::getMethod();

        $view = View::make('CourseCategory.Create');
        $view->user = User::getSysUser();
		


        if ($method == "GET") {


            return $view;
        }
        if ($method == "POST") {

                $Category = Input::get('Category');
                
                $c = new CourseCategory;
               // $c->fill(Input::all());
                $c->Category= $Category;
                $c->User = User::getSysUser()->userID;
                $c->save();



                return $view->with("done", true);
            
        }
    }

	
	  public function viewCourseCatogory() {

     $courses = CourseCategory::where('Deleted','=','0')->orderBy('Category')->get();

        $v = View::make('CourseCategory.course');
        $v->courses = $courses;
        $v->user = User::getSysUser();
        return $v;
    }

    public function DeleteQPackageModules()
    {
       $PackageID = Input::get('id');
       $delete = MOQualificationPackageModule::where('packageid','=',$PackageID)->update(array('Deleted' => 1));
       return Redirect::to('AssignQPackageModules');

    }

    public function ViewListQPackageModules()
    {
        $method = Request::getMethod();
        $PackageID = Input::get('id');
        $view = View::make('MOQPackageModule.ViewI');
        $getCScode = NVQQualificationPackage::where('id','=',$PackageID)->pluck('cscode');
        $tradeid = NVQcompetencystandard::where('code','=',$getCScode)->pluck('tradeid');
        $view->trades = Trade::where('TradeId','=',$tradeid)->pluck('TradeName');
        $view->coms = $getCScode;
        $view->Packcode = NVQQualificationPackage::where('id','=',$PackageID)->pluck('packagecode');
        $sql = "select module.ModuleCode,module.ModuleName
                  from moqualificationpackagemodule
                  left join module
                  on moqualificationpackagemodule.moduleid=module.ModuleId
                  where moqualificationpackagemodule.packageid='".$PackageID."'
                  and moqualificationpackagemodule.Deleted='0'
                  and moqualificationpackagemodule.Active='1'";
        $Module = DB::select(DB::raw($sql));
        $view->Module = $Module;
        $view->Pckid = $PackageID;
        return $view;
    }

    public function EditQPackageModules()
    {
        $method = Request::getMethod();
        $PackageID = Input::get('id');
        $view = View::make('MOQPackageModule.Edit');
        $getCScode = NVQQualificationPackage::where('id','=',$PackageID)->pluck('cscode');
        $tradeid = NVQcompetencystandard::where('code','=',$getCScode)->pluck('tradeid');
        $view->trades = Trade::where('TradeId','=',$tradeid)->pluck('TradeName');
        $view->coms = $getCScode;
        $view->Packcode = NVQQualificationPackage::where('id','=',$PackageID)->pluck('packagecode');
         $sql = "select ModuleId,ModuleName,ModuleCode
                          from module
                          where module.Deleted=0
                          and module.Active=1
                          order by module.ModuleCode";
        $Module = DB::select(DB::raw($sql));
        $view->Module = $Module;
        $view->Pckid = $PackageID;
        if($method == "GET") 
        {
            return $view;
        }
        if($method == "POST") 
        {
             $PackageID = Input::get('PckID');
            $ModuleList = [];
             $ModuleList = Input::get('ModuleId');
            $countM = Count($ModuleList);
            $updateActiveZERO = MOQualificationPackageModule::where('packageid','=',$PackageID)->update(array('Active' => 0));
            for($i=0;$i<$countM;$i++)
            {
                $available = MOQualificationPackageModule::where('packageid','=',$PackageID)->where('moduleid','=',$ModuleList[$i])->get();
                $Acount = count($available);

                if($Acount == 0)
                {
                  $c = new MOQualificationPackageModule();
                  $c->packageid = $PackageID;
                  $c->moduleid = $ModuleList[$i];
                  $c->Active = 1;
                  $c->User = User::getSysUser()->userID; 
                  $c->save();
                }
                else
                {
                    $update = MOQualificationPackageModule::where('packageid','=',$PackageID)
                    ->where('moduleid','=',$ModuleList[$i])
					->where('Active','=',0)
                    ->update(array('Active' => 1,'Deleted' => 0));
                }
                  
            }
            
            return Redirect::to('AssignQPackageModules');
            }
        
    }

    public function LoadModuleTableQPack()
    {
        $html=' 
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                    <th class="center">#</th>
                    <th>Module Code</th>                          
                    <th>Module Name</th>
                    <th><label><input type="checkbox"/><span class="lbl">Select All</span></label></th>  
                    </tr>
                    </thead>
                    <tbody>';

                    $sql = "select ModuleId,ModuleName,ModuleCode
                          from module
                          where module.Deleted=0
                          and module.Active in(1,'Yes')
                          order by module.ModuleCode";
                          $Module = DB::select(DB::raw($sql));

$i=1;
            foreach ($Module as $e) {


                
                  $html .='<tr>
                              <td class="center" >' . $i++ . '</td>
                              <td>' . $e->ModuleCode. '</td>
                              <td>' . $e->ModuleName. '</td>
                              <td><input type="hidden" value="' . $e->ModuleId . '" name="myid[]" id="myid"/>
                                    <input type="checkbox"   name="ModuleId[]" value="' . $e->ModuleId . '"/>
                                        <span class="lbl"></span>
                                    </center>
                                </label>
                                </td>
                            </tr>';

                
               
              }

              $html.='</tbody></table>';
              return $html;
    }
public function LoadNVQCourseComPackageQQQ()
    {
        $ComStand=Input::get('ComStand');
    $sql = "select nvqqualificationpackage.id,nvqqualificationpackage.packagecode
              from nvqqualificationpackage
              where nvqqualificationpackage.Deleted=0
              and nvqqualificationpackage.cscode='".$ComStand."'
              order by nvqqualificationpackage.packagecode";
            
    $Ins=DB::select(DB::raw($sql));

    return json_encode($Ins);
    }
    public function LoadNVQCourseComPackageQQ()
    {
        $ComStand=Input::get('ComStand');
    $sql = "select nvqqualificationpackage.id,nvqqualificationpackage.packagecode
              from nvqqualificationpackage
              where nvqqualificationpackage.id NOT IN (select distinct moqualificationpackagemodule.packageid
                                  from moqualificationpackagemodule
                                  where moqualificationpackagemodule.Active='1'
                                  and moqualificationpackagemodule.Deleted='0')
              and nvqqualificationpackage.Deleted=0
              and nvqqualificationpackage.cscode='".$ComStand."'
              order by nvqqualificationpackage.packagecode";
            
    $Ins=DB::select(DB::raw($sql));

    return json_encode($Ins);
    }

    public function CreateQPackageModules()
    {
        $method = Request::getMethod();
        $view = View::make('MOQPackageModule.Create');
        $view->trades = Trade::where('Active','=','Yes')->orderBy('TradeName')->get();
        
        if ($method == "GET") 
        {
            return $view;
        }
        if($method == 'POST')
        {
            $PackageID = Input::get('Qpackage');
            $ModuleList = [];
            $ModuleList = Input::get('ModuleId');
            $countM = Count($ModuleList);

            for($i=0;$i<$countM;$i++)
            {
              $c = new MOQualificationPackageModule();
              $c->packageid = $PackageID;
              $c->moduleid = $ModuleList[$i];
              $c->Active = 1;
              $c->User = User::getSysUser()->userID; 
              $c->save();
            }
            
            return $view->with("done", true);
        }
    }


    public function AssignQPackageModules()
    {
        $method = Request::getMethod();
        $view = View::make('MOQPackageModule.View');
        $view->trades = $trades = Trade::where('Active','=','Yes')->orderBy('TradeName')->get();
        $data = DB::select(DB::raw("select distinct moqualificationpackagemodule.packageid,
  nvqqualificationpackage.packagecode,
  nvqcompetencystandard.code,
  nvqcompetencystandard.name,
  trade.TradeName
  from moqualificationpackagemodule
  left join nvqqualificationpackage
  on moqualificationpackagemodule.packageid=nvqqualificationpackage.id
  left join nvqcompetencystandard
  on nvqqualificationpackage.cscode=nvqcompetencystandard.code
  left join trade
  on nvqcompetencystandard.tradeid=trade.TradeId
  where moqualificationpackagemodule.Active='1'
  and moqualificationpackagemodule.Deleted='0'
  order By trade.TradeName"));
        $view->Packages = $data;
    
        if ($method == "GET") 
        {
            return $view;
        }
    }

    public function LoadNVQCourseComPackage()
    {
         $ComStand=Input::get('ComStand');
    $sql = "select nvqqualificationpackage.id,nvqqualificationpackage.packagecode
  from nvqqualificationpackage
  where nvqqualificationpackage.Deleted=0
  and nvqqualificationpackage.cscode='".$ComStand."'
  order by nvqqualificationpackage.packagecode";
            
    $Ins=DB::select(DB::raw($sql));
    //
    $html='';
        foreach($Ins As $i){
            $html.='<option value="'.$i->id.'">'.$i->packagecode.'</option>';
        }
        $html.='';
    return $html;
    //
    }

    public function LoadCompetencyCourseCreate()
    {
         $TradeID = Input::get('TradeId');

        $sql = "select nvqcompetencystandard.code,nvqcompetencystandard.name
  from nvqcompetencystandard
  where nvqcompetencystandard.Deleted='0'
  and nvqcompetencystandard.tradeid='".$TradeID."'
  order by nvqcompetencystandard.code";
        $res = DB::select(DB::raw($sql));

        return json_encode($res);
    }

    public function viewCourses() {



        $sql = "SELECT cd.*,t.TradeName,inst.InstituteName,q.qualification,coursecategory.Category
                FROM coursedetails cd
                LEFT JOIN qualification q ON
                cd.Qualification_ID = q.Qualification_ID
                LEFT JOIN institution inst ON
                cd.InstituteId = inst.InstituteId
                LEFT JOIN trade t ON
                cd.TradeId = t.TradeId
				LEFT JOIN coursecategory
				ON cd.CourseCategoryId=coursecategory.id
				AND coursecategory.Deleted=0
                WHERE cd.Deleted != 1
				/*AND cd.Active='Yes'*/
				AND cd.CourseType IN ('Full','Part')
				AND cd.Nvq='NVQ'
				
                ORDER BY cd.CourseListCode,cd.CourseType";

//        $courses = Course::where('Deleted', "!=", "1")->OrderBy('CourseListCode')->get();

        $courses = DB::select(DB::raw($sql));
        $trades = Trade::where('Active','=','Yes')->orderBy('TradeName')->get();

        $v = View::make('Course.course');

$v->Trade = $trades;
        $v->courses = $courses;
        $v->user = User::getSysUser();





        return $v;
    }

    public function actionSearch() {

        $v = View::make('Course.course');

        $Trade = Input::get('order_by');
        $CourseType = Input::get('CourseType');

        $sql = "SELECT cd.*,t.TradeName,inst.InstituteName,q.qualification,coursecategory.Category
                FROM coursedetails cd
                LEFT JOIN qualification q ON
                cd.Qualification_ID = q.Qualification_ID
                LEFT JOIN institution inst ON
                cd.InstituteId = inst.InstituteId
                LEFT JOIN trade t ON
                cd.TradeId = t.TradeId
				LEFT JOIN coursecategory
				ON cd.CourseCategoryId=coursecategory.id
				AND coursecategory.Deleted=0
                WHERE cd.Deleted != 1 
				/*AND cd.Active='Yes'*/
				AND cd.CourseType IN('Full','Part')
				AND cd.Nvq='NVQ'
                AND cd.TradeId ='" . $Trade . "'  
				
				AND CourseType = '".$CourseType."'
                ORDER BY cd.CourseName";

        $course = DB::select(DB::raw($sql));
        $trades = Trade::where('Active','=','Yes')->orderBy('TradeName')->get();


//        $course = Course::where("courseName", "LIKE", "%" . $searchKey . "%")->where('Deleted', '!=', 1)->get();



$v->Trade = $trades;
        $v->user = User::getSysUser();
        $v->courses = $course;
        $v->Issearch = true;




        return $v;
    }

    public function actionDelete() {


        $cid = Input::get('cid');


        $course = Course::findOrFail($cid); // if not found show 404 page


        $course->Deleted = 1;
		$course->Changed = 1;
        $course->DateEntered = \Carbon\Carbon::now();
		
        $course->User = User::getSysUser()->userID;



        $course->save();






        return Redirect::to('courses');
    }

    public function actionCreate() {


        $method = Request::getMethod();

        $view = View::make('Course.Create');
        $view->user = User::getSysUser();
		 $ins = User::getSysUser()->instituteId;
		 $view->institutes = Institue::where('InstituteId', '=', $ins)->pluck('InstituteName');
        //$view->institutes = Institue::where('Deleted', "!=", 1)->get();
        $view->trades = Trade::where('Deleted', '!=', 1)->get();
        $view->EntryQualifications = EntryQualification::where('Deleted', "!=", 1)->get();
		$view->CategoryL = CourseCategory::where('Deleted','=',0)->orderBy('Category')->get();


        if ($method == "GET") {


            return $view;
        }
        if ($method == "POST") {





            $validator = Course::validate(Input::all());


            if ($validator->passes()) {

                $Packages = [];
                $Packages = Input::get('NVQPackage');
                $countP = count($Packages); 
                $CourseListCode = Input::get('CourseListCode');
                $i=0;
                $c = new Course;
               // $c->fill(Input::all());
                $c->CourseName= Input::get('CourseName');
                $c->CourseListCode = Input::get('CourseListCode');
                $c->InstituteId = Input::get('InstituteId');
                $c->coursenamesinhala = Input::get('coursenamesinhala');
                $c->coursenametamil = Input::get('coursenametamil');
                $c->CourseType = Input::get('CourseType');
                $c->Duration = Input::get('Duration');
                $c->DurationHours = Input::get('DurationHours');
                $c->TradeId = Input::get('TradeId');
                $c->ComStand = Input::get('ComStand');
                $c->Nvq = Input::get('Nvq');
                $c->CourseLevel = Input::get('CourseLevel');
                $c->courseLevelStatus = Input::get('courseLevelStatus');
                $c->ProgramType = Input::get('ProgramType');
                $c->ProgramType = Input::get('ProgramType');
                //$c->DateEntered = \Carbon\Carbon::now();
                $c->User = User::getSysUser()->userID;
                $c->InstituteId = User::getSysUser()->instituteId;
				$c->Active =Input::get('Active');
				$c->CourseCategoryId = Input::get('CourseCategoryID');
                $c->save();

                $CD_ID = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('CD_ID');

                for($i=0;$i<$countP;$i++)
                {
                    $r = new CourseDetailQualificationPackages();
                    $r->CourseListCode = $CourseListCode;
                    $r->CD_ID = $CD_ID;
                    $r->NVQualificationPackageID = $Packages[$i];
                    $r->User = User::getSysUser()->userID;
                    $r->save();

                }


                return $view->with("done", true);
            } else {

                return Redirect::to('createCourse')->withErrors($validator);
            }
        }
    }

    public function actionEdit() {
        $view = View::make('Course.Edit');


        switch (Request::getMethod()) {
            case 'GET':




                $view->institutes = Institue::where('Deleted', "!=", 1)->get();
                $view->course = Course::where('CD_ID', "=", Input::get('cid'))->first();
                $tadeid = Trade::where('TradeId', "=", $view->course->TradeId)->first();
				$view->tradesel = Trade::where('TradeId', "=", $view->course->TradeId)->first();
                $view->trades = Trade::where('Deleted', '!=', 1)->get();
                $view->EntryQualifications = EntryQualification::where('Deleted', "!=", 1)->get();
                $view->CompyS = NVQcompetencystandard::where('Deleted','=',0)->where('tradeid','=',$tadeid->TradeId)->orderBy('code')->get();
				$view->CategoryL = CourseCategory::where('Deleted','=',0)->orderBy('Category')->get();
                $compty = Course::where('CD_ID', "=", Input::get('cid'))->pluck('ComStand');
                $pp = DB::select(DB::raw("select nvqqualificationpackage.id,nvqqualificationpackage.packagecode
                                          from coursedetailpackages
                                          left join nvqqualificationpackage
                                          on coursedetailpackages.NVQualificationPackageID=nvqqualificationpackage.id
                                          where coursedetailpackages.CD_ID='".Input::get('cid')."'
                                          and nvqqualificationpackage.Deleted=0"));
                $view->packages = $pp;

                return $view;

                break;

            case 'POST':


                $array = Input::all();
                $Packages = [];
                $Packages = Input::get('NVQPackage');
                $countP = count($Packages); 
                $CourseListCode = Input::get('CourseListCode');
                $i=0;

                $c = Course::find($array['CD_ID']);


                //$c->fill(Input::all());
                $c->CourseName= Input::get('CourseName');
                $c->CourseListCode = Input::get('CourseListCode');
                $c->InstituteId = Input::get('InstituteId');
                $c->coursenamesinhala = Input::get('coursenamesinhala');
                $c->coursenametamil = Input::get('coursenametamil');
                $c->CourseType = Input::get('CourseType');
                $c->Duration = Input::get('Duration');
                $c->DurationHours = Input::get('DurationHours');
                $c->TradeId = Input::get('TradeId');
                $c->ComStand = Input::get('ComStand');
                $c->Nvq = Input::get('Nvq');
                $c->CourseLevel = Input::get('CourseLevel');
                $c->courseLevelStatus = Input::get('courseLevelStatus');
                $c->ProgramType = Input::get('ProgramType');
                $c->ProgramType = Input::get('ProgramType');
                //$c->DateEntered = \Carbon\Carbon::now();
                $c->User = User::getSysUser()->userID;
                $c->InstituteId = User::getSysUser()->instituteId;
				$c->Changed = 1;
				$c->Active=Input::get('Active');
				$c->CourseCategoryId = Input::get('CourseCategoryID');
                $c->save();
                $delete = CourseDetailQualificationPackages::where('CD_ID','=',$array['CD_ID'])->delete();

                for($i=0;$i<$countP;$i++)
                {
                    $r = new CourseDetailQualificationPackages();
                    $r->CourseListCode = $CourseListCode;
                    $r->CD_ID = $array['CD_ID'];
                    $r->NVQualificationPackageID = $Packages[$i];
                    $r->User = User::getSysUser()->userID;
                    $r->save();

                }
               
                return Redirect::to('courses');

                // do your edit here


            
        }
    }

     public function downloadExcel(){

        
       
        $sql = "SELECT cd.*,t.TradeName,inst.InstituteName,q.qualification,coursecategory.Category
                FROM coursedetails cd
                LEFT JOIN qualification q ON
                cd.Qualification_ID = q.Qualification_ID
                LEFT JOIN institution inst ON
                cd.InstituteId = inst.InstituteId
                LEFT JOIN trade t ON
                cd.TradeId = t.TradeId
				LEFT JOIN coursecategory
				ON cd.CourseCategoryId=coursecategory.id
				AND coursecategory.Deleted=0
                WHERE cd.Deleted != 1
                ORDER BY cd.CourseName";

        $courses=DB::select($sql);
        //$courses= json_decode(json_encode(DB::select($sql)),true);
        //return json_encode($courses);
    
    $excel = new SimpleExcel('csv');      // make the output as CCSV

        $printablearray = array();  // prepare Main array 

        $headerArray = array('Institute', 'CourseName', 'CourseType','Course_List_Code', 'Trade', 'NVQ', 'Course_Level', 'Duration In Month','Duration In Hours', 'Program_Type', 'Qualification','Category','Active'); // prepare headers array

        array_push($printablearray, $headerArray);  // put header array inside the printable array

        foreach ($courses as $applicant) {  array_push($printablearray, array(CourseController::getInstitute($applicant->InstituteId), $applicant->CourseName, $applicant->CourseType,
               $applicant->CourseListCode, CourseController::getTrade($applicant->TradeId), 
              $applicant->Nvq, $applicant->CourseLevel, 
                $applicant->Duration,$applicant->DurationHours,
                $applicant->ProgramType, CourseController::getQualification($applicant->Qualification_ID),$applicant->CourseCategoryId,$applicant->Active));
        }
        $excel->writer->setData($printablearray); // now all your data should be in printableArray
        $excel->writer->saveFile('D:\example'); // save it


}
public static function getTrade($id){

    return Trade::where('TradeId','=',$id)->pluck('TradeName');

  }

   public static function getQualification($id){

    return EntryQualification::where('Qualification_ID','=',$id)->pluck('Qualification');

  }
  public static function getInstitute($id){

    return Institute::where('InstituteId','=',$id)->pluck('InstituteName');

  }

}

?>
