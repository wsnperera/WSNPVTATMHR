@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Institute<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
            <form class="form-horizontal" action='{{url('editInstitute')}}' method="POST">
            <input type="hidden" name="InstituteId" value="{{$institute->InstituteId}}" />
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Name : </label>
                        <div class="controls">
                            <input type="text" name="InstituteName" value="{{$institute->InstituteName}}"/>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Name of the Head : </label>
                        <div class="controls">
                            <input type="text" name="HeadName" value="{{$institute->HeadName}}"/>
                        </div>
                </div>
                <div class="control-group">
                        <label class="control-label" for="CourseListCode">Designation : </label>
                            <div class="controls">
                                <input type="text" name="designation" value="{{$institute->designation}}"/>
                            </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Address : </label>
                        <div class="controls">
                            <textarea rows="5" name="InstituteAddress">{{$institute->InstituteAddress}}</textarea>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">District : </label>
                        <div class="controls">
                                <Select name="InstituteDistrict">
                                    @foreach($dis as $v)
                                        @if($v->DistrictName==$institute->InstituteDistrict)
                                            <option selected>{{$v->DistrictName}}</option>>
                                        @else
                                            <option>{{$v->DistrictName}}</option>>
                                        @endif
                                    @endforeach
                                </select>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Country : </label>
                        <div class="controls">
                            <input type="text" name="InstituteCountry"  value="{{$institute->InstituteCountry}}" readonly />
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Web Site : </label>
                        <div class="controls">
                                <input type="text" name="webSite"  value="{{$institute->webSite}}"/>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Tel-No 1 : </label>
                        <div class="controls">
                                <input type="text" name="InstituteTele1"  value="{{$institute->InstituteTele1}}"/>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Tel-No 2 : </label>
                        <div class="controls">
                                <input type="text" name="InstituteTele2"  value="{{$institute->InstituteTele2}}"/>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Fax : </label>
                        <div class="controls">
                                <input type="text" name="Fax"  value="{{$institute->Fax}}"/>
                        </div>
                </div>
            <div class="control-group">
                    <label class="control-label" for="CourseListCode">Email : </label>
                        <div class="controls">
                                <input type="text" name="InstituteEmail" value="{{$institute->InstituteEmail}}" />
                        </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-small btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
            <div class="span4">
                @if($errors->has())
                    @foreach($errors->all() as $msg)
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                            <strong> <i class="icon-remove"></i>{{$msg}}</strong>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
<script>
    
    @if(isset($done))
        
    $.gritter.add({ title: "", text: "Institute Added Successfully", class_name: "gritter-info gritter-center" });

    @endif
    
</script>