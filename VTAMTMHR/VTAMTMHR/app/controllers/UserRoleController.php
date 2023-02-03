<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserRoleController
 *
 * @author User
 */
class UserRoleController extends BaseController {

    //put your code here
    public function viewUserRoleAssign() {
        $view = View::make('UserRole.UserRoleView');
        return $view;
    }

    public function getActivity() {
        $username = Input::get('username');
        $user = User::where('userName', '=', $username)->where('active', '=', 1)->first();
        $html = '';
        $error = '';
        if (!empty($user)) {
            $activity = Activity::all();
            $userDefineP = UserRole::where('userid', '=', $user->userID)->where('Deleted', '!=', 1)->where("permission", "=", 1)->get();
            $addedUP = array();

            $html .= '<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <div class="table-header center">
                <h3>'.$username.'</h3>
                <input type="hidden" name="username" id="username" value="'.$username.'" readonly>
                </div>
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center">
                                <label>
                                    <input type="checkbox" id="actall" />
					<span class="lbl"></span>
				</label>
                            </th>
                            <th class="center">Activity Name</th>
                        </tr>
                    </thead>
                    <tbody>';
            if (!empty($userDefineP)) {
                foreach ($userDefineP as $udp) {
                    array_push($addedUP, $udp->activityid);
                }
            }
            foreach ($activity as $ac) {
                $html .= '<tr>';
                if (in_array($ac->activityid, $addedUP)) {
                    $html .= '<td class="center">
                            <label>
				<input type="checkbox" name="activityid[]" id="activityid" value="' . $ac->activityid . '" checked/>
                                <span class="lbl"></span>
                            </label>'
                            . '</td>'
                            . '<td>' . $ac->activityname . '</td>';
                } else {
                    $html .= '<td class="center">
                            <label>
				<input type="checkbox" name="activityid[]" id="activityid" value="' . $ac->activityid . '" />
                                <span class="lbl"></span>
                            </label>
			</td>'
                            . '<td>' . $ac->activityname . '</td>';
                }
                $html .= '</tr>';
            }
            $html.= '</tbody></table></div>';
            $json = array("html" => $html, "error" => $error);
        } else {
            $html .= '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">'
                    . '<i class="icon-remove"></i>'
                    . '</button>'
                    . '<strong>'
                    . ' <i class="icon-remove"></i>'
                    . 'User Name Not Found'
                    . '</strong><br/></div>';
            $error = 'true';
            $json = array("html" => $html, "error" => $error);
        }
        echo json_encode($json, 0);
    }

//    public function assignPrevilage() {
//        $actvityid = Input::get('activityid');
//        $username = Input::get('username');
//        $user = User::where('userName', '=', $username)->where('Deleted', '!=', 1)->first();
//        $userroleold = UserRole::where('userid', '=', $user->userID)->where('Deleted', '!=', 1)->get();
//        if (!empty($userroleold)) {
//            foreach ($userroleold as $uro) {
//                $uro2 = UserRole::find($uro->id);
//                $uro2->permission = 0;
//                $uro2->Deleted = 1;
//                $uro2->DateEntered = \Carbon\Carbon::now();
//                $uro2->User = User::getSysUser()->userID;
//                $uro2->save();
//            }
//        }
//        for ($i = 0; $i < count($actvityid); $i++) {
//            $userrole = UserRole::where('userid', '=', $user->userID)->where('activityid', '=', $actvityid[$i])->first();
//            if (!empty($userrole)) {
//                $adduserrole = UserRole::find($userrole->id);
//                $adduserrole->permission = 1;
//                $adduserrole->Deleted = 0;
//                ;
//                $adduserrole->DateEntered = \Carbon\Carbon::now();
//                $adduserrole->User = User::getSysUser()->userID;
//                $adduserrole->save();
//            } else {
//                $adduserrole = new UserRole;
//                $adduserrole->activityid = $actvityid[$i];
//                $adduserrole->userid = $user->userID;
//                $adduserrole->permission = 1;
//                $adduserrole->Deleted = 0;
//                $adduserrole->DateEntered = \Carbon\Carbon::now();
//                $adduserrole->User = User::getSysUser()->userID;
//                $adduserrole->save();
//            }
//        }
//        return Redirect::to('viewUserRoleAssign')->with('done', 'Privileges Added Successfully');
//    }

    public function addUserRoleAJAX() {
        $id = Input::get("id");
        $username = Input::get("username");
        $user = User::where('userName', '=', $username)->first();
            $adduserrole = new UserRole();
            $adduserrole->activityid = $id;
            $adduserrole->userid = $user->userID;
            $adduserrole->permission = 1;
            $adduserrole->Deleted = 0;
			$adduserrole->InstituteId = User::getSysUser()->instituteId;
            $adduserrole->DateEntered = \Carbon\Carbon::now();
            $adduserrole->User = User::getSysUser()->userID;
            $adduserrole->save();
    }

    public function removeUserRoleAJAX() {
        $id = Input::get("id");
        $username = Input::get("username");
        $user = User::where('userName', '=', $username)->first();
        UserRole::where('userid', '=', $user->userID)->where('activityid', '=', $id)->delete();
    }

    public function addUserRoleAllAJAX() {
        $id = Input::get("id");
        $username = Input::get("username");
        $user = User::where('userName', '=', $username)->first();
        for ($i = 0; $i < count($id); $i++) {
            $adduserrole = new UserRole();
            $adduserrole->activityid = $id[$i];
            $adduserrole->userid = $user->userID;
            $adduserrole->permission = 1;
            $adduserrole->Deleted = 0;
            $adduserrole->DateEntered = \Carbon\Carbon::now();
            $adduserrole->User = User::getSysUser()->userID;
            $adduserrole->save();
        }
    }

    public function removeUserRoleAllAJAX() {
        $id = Input::get("id");
        $username = Input::get("username");
        $user = User::where('userName', '=', $username)->first();
        for ($i = 0; $i < count($id); $i++) {
            UserRole::where('userid', '=', $user->userID)->where('activityid', '=', $id[$i])->delete();
        }
    }

}
