<?php

class UserTypeRoleController extends BaseController {

    public function createUserTypeRole() {
        $view = View::make('UserTypeRole.createUserTypeRole');
        $method = Request::getMethod();
        if ($method == "GET") {
            $view->userType = UserType::all();
            return $view;
        } else {
            $view->secondPage = TRUE;
            $view->userType = UserType::where('id', '=', Input::get('utypeid'))->first();
            $view->activity = DB::select('SELECT * FROM activity WHERE Deleted=0 and activityid not in(select activityid from usertyperole where utypeid="' . Input::get('utypeid') . '" and Deleted=0)');
            return $view;
        }
    }

    public function saveUserTypeRole() {
        $arry = Input::get('activityid');
        if (count($arry) >= 1) {
            foreach ($arry as $utid) {
                $utr = new UserTypeRole;
                $utr->utypeid = Input::get('utypeid');
                $utr->activityid = $utid;
                $utr->permission = 1;
                $utr->User = User::getSysUser()->instituteId;
                $utr->DateEntered = \Carbon\Carbon::now();
                if ($utr->save()) {
                    $thistypeusers = User::where("userType", "=", Input::get('utypeid'))->where("Deleted", "!=", 1)->get();
                    foreach ($thistypeusers as $ttu) {
                        $userroleexsist = UserRole::where("userid", "=", $ttu->userID)->where("activityid", "=", $utid)->where('Deleted','=',0)
                                        ->where("permission", "=", 1)->first();
                        if (!empty($userroleexsist)) {
                            $new = UserRole::find($userroleexsist->id);
                            $new->activityid = $utid;
                            $new->userid = $ttu->userID;
                            $new->permission = 1;
                            $new->User = User::getSysUser()->userID;
                            $new->save();
                        } else {
                            $new = new UserRole();
                            $new->activityid = $utid;
                            $new->userid = $ttu->userID;
                            $new->permission = 1;
                            $new->User = User::getSysUser()->userID;
                            $new->save();
                        }
                    }
                }
            }
        }
        return Redirect::to('ViewUserTypeRole');
    }

    public function ViewUserTypeRole() {
        $view = View::make('UserTypeRole.ViewUserTypeRole');
        $view->userTypeRole = UserTypeRole::where('Deleted', '=', 0)->groupBy('utypeid')->get();
        return $view;
    }

    public function ViewUserTypeRoleOne() {
        $view = View::make('UserTypeRole.ViewUserTypeRoleOne');
        $view->userTypeRole = UserTypeRole::where('Deleted', '=', 0)->where('utypeid', '=', Input::get('id'))->get();
        return $view;
    }

    public function deleteUserTypeRole() {
        $id = Input::get('id');
        $utr = UserTypeRole::findOrFail($id); // if not found show 404 page
        $utr->Deleted = 1;
        if ($utr->save()) {
            $thistypeusers = User::where("userType", "=", $utr->utypeid)->where("Deleted", "!=", 1)->lists("userID");
            if (!empty($thistypeusers)) {
                UserRole::whereIn("userid", $thistypeusers)->where("activityid", "=", $utr->activityid)->where("Deleted", "!=", 1)->delete();
            }
        }
        return Redirect::back();
    }

}
