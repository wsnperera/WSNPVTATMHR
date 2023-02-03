<?php

class UserTypeController extends BaseController {

    public function viewUserType() {
        $UserType = UserType::where('Deleted', '!=', 1)->get();
        $v = View::make('UserType.UserType');
        $v->UserType = $UserType;
        $v->user = User::getSysUser();
        return $v;
    }

    public function actionDelete() {
        $id = Input::get('id');
        $UserType = UserType::findOrFail($id);
        $UserType->Deleted = 1;
        $UserType->save();
        return Redirect::to('viewUserType');
    }

    public function actionSearch() {
        $v = View::make('UserType.UserType');
        $searchKey = Input::get('serachkey');
        $UserType = UserType::where('Deleted', '!=', 1)->where("UType", "=", $searchKey)->get();
        $v->user = User::getSysUser();
        $v->UserType = $UserType;
        $v->Issearch = true;
        return $v;
    }

    public function actionCreate() {
        $view = View::make('UserType.CreateUserType');
        $method = Request::getMethod();
        $view->user = User::getSysUser();
        $ins = User::getSysUser()->instituteId;
        $view->institute = Institue::where('InstituteId', '=', $ins)->pluck('InstituteName');
        $view->in_id = $ins;
        if ($method == 'GET') {

            return $view;
        }
        if ($method == 'POST') {
            $validator = UserType::validate(Input::all());
            if ($validator->passes()) {

                $ut = new UserType();
                $ut->fill(Input::all());
                $ut->created_at = \Carbon\Carbon::now();
                $ut->User = User::getSysUser()->userID;
                $ut->save();


                return Redirect::to('viewUserType');
            } else {
                return Redirect::to('createUserType')->withErrors($validator);
            }
            return $view;
        }
    }

    public function actionEdit() {
        switch (Request::getMethod()) {
            case 'GET':
                $view = View::make('UserType.EditUserType');
                $id = Input::get('id');
                $view->UserType = UserType::where('id', '=', $id)->first();
                $view->user = User::getSysUser();
                $ins = User::getSysUser()->instituteId;
                $view->institute = Institue::where('InstituteId', '=', $ins)->pluck('InstituteName');
                $view->in_id = $ins;
                return $view;
                break;

            case 'POST':
                $validator = UserType::validateedit(Input::all());
                if ($validator->passes()) {
                    $id = Input::get('id');
                    $ut = UserType::find($id);
                    $ut->fill(Input::all());
                    $ut->updated_at = 1;
                   $ut->save();
                        return Redirect::to('viewUserType' );
                } else {
                    return Redirect::to('editUserType?id=' . Input::get('id'))->withErrors($validator);
                }
                break;
            default:
        }
    }

}
