<?php

class GNDivisionController extends BaseController {

    public function viewGNDivision() {
        $v = View::make('GNDivision.GNDivision');
        $GNDivision = GNDivision::where('Deleted', '!=', 1)->get();
        $v->GNDivision = $GNDivision;
        $v->user = User::getSysUser();
        return $v;
    }

    public function actionDelete() {
        $cid = Input::get('id');
        $GNDivision = GNDivision::findOrFail($cid); // if not found show 404 page
        //$GNDivision->Deleted = 1;
        $GNDivision->delete();
        return Redirect::to('viewGNDivisionVTA');
    }

    public function actionSearch() {
        $v = View::make('GNDivision.SearchGNDivision');
        $searchKey_split = Input::get('SearchKey');
        $searchKey = explode(' ',$searchKey_split);
        //$DistrictCode = District::where("DistrictName", "=", $searchKey)->pluck('DistrictCode');
        $DSDivisionCode = DSDivision::where("ElectorateName", "=", $searchKey[0])->pluck('ElectorateCode');
        $GNDivision = GNDivision::where("GNDivisionName", "=", $searchKey[0])->orWhere('DSDivisionCode','=',$DSDivisionCode)->get();
        $v->user = User::getSysUser();
        $v->GNDivision = $GNDivision;
        $v->Issearch = true;
        return $v;
    }

    public function actionCreate() {
        $view = View::make('GNDivision.CreateGNDivision');
        $method = Request::getMethod();
        $view->user = User::getSysUser();

        if ($method == 'GET') {
            $view->Electorate = DSDivision::orderBy('ElectorateName')->get();
            $view->District = District::orderBy('DistrictName')->get();
            return $view;
        }
        if ($method == 'POST') {
            $validator = GNDivision::validate(Input::all());
            if ($validator->passes()) {
                $GND = new GNDivision();
                $GND->GNDivisionName = Input::get('GNDivisionName');
                $GND->DSDivisionCode = Input::get('DSDivisionCode');
                $GNDivisionName = Input::get('GNDivisionName');
                    $DSDivisionCode = Input::get('DSDivisionCode');
                    $Count_che_Unique_DsDivi = GNDivision::where('Deleted', '!=', 1)->where('DSDivisionCode', '=', $DSDivisionCode)->where('GNDivisionName', '=', $GNDivisionName)->count();
                    $Count_DsDivi = GNDivision::where('Deleted', '!=', 1)->where('DSDivisionCode', '=', $DSDivisionCode)->count();
                   
                        for($i = 1;$i<$Count_DsDivi+2; $i++){
                            
                    if ($Count_che_Unique_DsDivi < 1) {
                        if($i<10){
                        $NewGNDivisionCode = $DSDivisionCode . '0' . $i;
                        
                        }else{
                        $NewGNDivisionCode = $DSDivisionCode.$i;
                        }
                        $che_Unique_GNDivisionCode = GNDivision::where('Deleted', '!=', 1)->where('DSDivisionCode', '=', $DSDivisionCode)->where('GNDivisionCode', '=', $NewGNDivisionCode)->count();
                        }
                        if ($che_Unique_GNDivisionCode < 1) {
                            $GND->GNDivisionCode = $NewGNDivisionCode;
                        } 
//                        else {
//                         
//                            $new_GNDivisionCode_max = GNDivision::where('Deleted', '!=', 1)->where('DSDivisionCode', '=', $DSDivisionCode)->where('GNDivisionCode', 'LIKE', $DSDivisionCode . '%')->max('GNDivisionCode');
//                            $GND->GNDivisionCode = $new_GNDivisionCode_max + 1;
//                        }
                    
                    }
                $GND->save();

                return Redirect::to('viewGNDivisionVTA');
            } else {
                return Redirect::to('createGNDivisionVTA')->withErrors($validator);
            }
            return $view;
        }
    }

    public function actionEdit() {
        switch (Request::getMethod()) {
            case 'GET':
                $view = View::make('GNDivision.EditGNDivision');
                $id = Input::get('id');
                $view->GNDivision = GNDivision::where('GNDivisionCode', '=', $id)->first();
                $DSDivisionCode = GNDivision::where('GNDivisionCode', '=', $id)->pluck('DSDivisionCode');
                $DistrictCode = DSDivision::where('ElectorateCode', '=', $DSDivisionCode)->pluck('DistrictCode');
                $view->DistrictCodevalue = $DistrictCode;
                $view->District = District::get();
                $view->Electorate = DSDivision::where('DistrictCode','=',$DistrictCode)->orderBy('ElectorateName')->get();
                return $view;
                break;

            case 'POST':
                $validator = GNDivision::validateEdit(Input::all());
                if ($validator->passes()) {
                    $id = Input::get('GNDivisionCode');
                    $gnd = GNDivision::find($id);
                    $gnd->fill(Input::all());
                    $gnd->Changed = 1;
                    $GNDivisionName = GNDivision::where('GNDivisionCode', '=', $id)->pluck('GNDivisionName');
                    $DSDivisionCode = GNDivision::where('GNDivisionCode', '=', $id)->pluck('DSDivisionCode');
                    $Count_che_Unique_DsDivi = GNDivision::where('Deleted', '!=', 1)->where('DSDivisionCode', '=', $DSDivisionCode)->where('GNDivisionName', '=', $GNDivisionName)->count();
                    $Count_DsDivi = GNDivision::where('Deleted', '!=', 1)->where('DSDivisionCode', '=', $DSDivisionCode)->where('GNDivisionCode', 'LIKE', $DSDivisionCode.'%')->count();
                   if((strstr($id,$DSDivisionCode) ? 'Yes' : 'No') === 'No'){   
                        for($i = 1;$i<$Count_DsDivi+2; $i++){
                    if ($Count_che_Unique_DsDivi > 0) {
                        if($i<10){
                        $NewGNDivisionCode = $DSDivisionCode . '0' . $i;
                        }else{
                        $NewGNDivisionCode = $DSDivisionCode.$i;
                        }
                        $che_Unique_GNDivisionCode = GNDivision::where('Deleted', '!=', 1)->where('DSDivisionCode', '=', $DSDivisionCode)->where('GNDivisionCode', '=', $NewGNDivisionCode)->count();
                        if ($che_Unique_GNDivisionCode < 1) {
                            $gnd->GNDivisionCode = $NewGNDivisionCode;
                             
                        }
                    }
                        }
                        $gnd->save();
                }
                  
                   return Redirect::to('viewGNDivisionVTA');
                } else {
                    return Redirect::to('editGNDivisionVTA?id=' . Input::get('id'))->withErrors($validator);
                }
                break;
            default:
        }
    }

    public function EleDisAjax() {
        $v = Input::get('DistrictCode');
        $ss = DSDivision::where('DistrictCode', "=", $v)->orderBy('ElectorateName')->get();
        $html = "<select name='DSDivisionCode' id='ElectorateCode'>";
        $html.="<option>--Select--</option>";
        foreach ($ss as $s) {
            $html .="<option value =\"$s->ElectorateCode\">$s->ElectorateName</option>";
        }
        $html .="</select>";

        echo $html;
    }
 

}
