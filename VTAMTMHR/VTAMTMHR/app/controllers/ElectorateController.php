<?php

class ElectorateController extends BaseController{
    public function actionView(){
        $view = View::make('Electro.ElectroView');
        $view->electro = Electorate::all();
        return $view;
    }
    public function actionDeleted(){
        $id = Input::get('id');
//        echo $id;
        Electorate::where('ElectorateCode','=',$id)->delete();
//        $rcd = Electorate::find($rec->ElectorateCode);
//        $rcd->Delete();
        return Redirect::to('Ele_actionView');
    }
    public function actionCreate(){
        $method = Request::getMethod();
        $view = View::make('Electro.ElectCreate');
        if($method == "GET"){
            $view->province = Province::all();
            return $view;
        }
        if($method == "POST"){
            $validator = Electorate::validate(Input::all());
            if ($validator->passes()) {
                $i = new Electorate;
                $i->fill(Input::all());
                $i->save();
                $view->province = Province::all();
                return $view->with("done", true);
            }else {
                return Redirect::to('Ele_actionCreate')->withErrors($validator);
            }
//            $id = Input::get('DistrictCode');
//            echo $id;
        }
    }
    public function getDistrict(){
        $id = Input::get('prvnc');
        $rec = District::where('ProvinceCode','=',$id)->get();
        echo $rec;
    }
    public function actionEdit(){
        
    }
}
