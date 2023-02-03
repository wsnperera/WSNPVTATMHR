<?php

class DropoutController extends BaseController {

    public function viewDropouts() {
        $v = View::make('Dropouts.Dropout');
        $coursecode = Coursestarted::where('Deleted', "!=", "1")->get();
        $v->coursecodes = $coursecode;
        $v->user = User::getSysUser();
        $course_code = Input::get('coursecode');
        $v->cou_co = $course_code;
        $course_start = Coursestarted::where('CourseCode', '=', $course_code)->where('Deleted', '!=', 1)->pluck('StartDate');
        $course_end = Coursestarted::where('CourseCode', '=', $course_code)->where('Deleted', '!=', 1)->pluck('ExpectedCompleted');
        $v->User = User::getSysUser();

        if ($course_start <= date('Y-m-d') && $course_end >= date('Y-m-d')) {
            
            $sql = "SELECT a.* FROM trainee a
                      WHERE a.CourseCode = '" . $course_code . "' AND a.Deleted != 1";

            $Event = DB::select($sql);
            $v->Event = $Event;
        }
     return $v;
    }

    public function actionDelete() {

        $cid = Input::get('NIC');
        $course = Trainee::where('NIC', '=', $cid)->first(); // if not found show 404 page

        $course->Deleted = 1;
		$course->Changed = 1;
        $course->User = User::getSysUser()->userID;
        $course->save();


        if ($course->save()) {
            $x = Trainee::where('NIC', "=", Request::get('NIC'))->first();
            $user = User::getSysUser()->userID;
                $drop = new Dropout(array('InstituteId' => $x->InstituteId, 'OrgaId' => $x->OrgaId, 'CourseCode' => $x->CourseCode, 'Stdid' => $x->id, 'Training_No' => $x->Training_No));
                $drop->save();
                $d = Dropout::where('Stdid','=',$x->id)->first();
                $d->User = $user;
				$d->DateEntered = date('y-m-d');
                $d->save();
                return Redirect::to('Dropout');
         }
    }

    public function actionSearch() {

        $v = View::make('Dropouts.Dropout');
        $coursecode = Coursestarted::where('Deleted', "!=", "1")->get();
        $v->coursecodes = $coursecode;
        $v->user = User::getSysUser();
        $course_code = Input::get('course_c');
        $v->cou_co = $course_code;
        $course_start = Coursestarted::where('CourseCode', '=', $course_code)->where('Deleted', '!=', 1)->pluck('StartDate');
        $course_end = Coursestarted::where('CourseCode', '=', $course_code)->where('Deleted', '!=', 1)->pluck('ExpectedCompleted');
        $searchKey = Input::get('serachkey');


        if ($course_start <= date('Y-m-d') && $course_end >= date('Y-m-d')) {

            $sql = "SELECT a.* FROM trainee a
                      WHERE a.CourseCode = '" . $course_code . "'
                    AND a.NIC = '" . $searchKey . "'";

            $Event = DB::select($sql);

            $v->Event = $Event;
            $v->Issearch = true;
        }

        return $v;
    }

}
