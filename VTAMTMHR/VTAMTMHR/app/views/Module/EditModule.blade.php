@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewModule')}}> << Back to Module </a>
                <h1>Module<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
            <form class="form-horizontal" action='editModule' method="POST"/>
                <input type="hidden" name="ModuleId" value="{{$module->ModuleId}}" />
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Module Name : </label>
                        <div class="controls">
                                <input type="text" name="ModuleName"  value="{{$module->ModuleName}}"/>
                        </div>
                </div>
				 <div class="control-group">
                    <label class="control-label" for="CourseListCode">Module Code : </label>
                        <div class="controls">
                                <input type="text" name="ModuleCode"  value="{{$module->ModuleCode}}"/>
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
        
    $.gritter.add({ title: "", text: "Test Center Added Successfully", class_name: "gritter-info gritter-center" });

    @endif
    
</script>