@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Institute<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action="{{url('createInstitute')}}" method="POST"/>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Institute Name : </label>
                        <div class="controls">
                                <input type="text" name="InstituteName"  />
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Address : </label>
                        <div class="controls">
                                <input type="text" name="InstituteAddress"  />
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">District : </label>
                        <div class="controls">
                                <Select name="InstituteDistrict">
                                    @foreach($dis as $v)
                                    <option>{{$v->DistrictName}}</option>>
                                    @endforeach
                                </select>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Country : </label>
                        <div class="controls">
                                <input type="text" name="InstituteCountry"  />
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Tel-No 1 : </label>
                        <div class="controls">
                                <input type="text" name="InstituteTele1"  />
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Tel-No 2 : </label>
                        <div class="controls">
                                <input type="text" name="InstituteTele2"  />
                        </div>
                </div>
            <div class="control-group">
                    <label class="control-label" for="CourseListCode">Email : </label>
                        <div class="controls">
                                <input type="text" name="InstituteEmail"  />
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
@include('includes.footer')
<script>
    
    @if(isset($done))
        
    $.gritter.add({ title: "", text: "Institute Added Successfully", class_name: "gritter-info gritter-center" });

    @endif
    
</script>
      
           
               
               
               
      
        
        

    
