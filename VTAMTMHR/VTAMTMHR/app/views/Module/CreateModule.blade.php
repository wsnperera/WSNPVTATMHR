@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewModule')}}> << Back to Module </a>
                <h1>Module<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='CreateModule' method="POST"/>
                <div class="control-group">
                    <label class="control-label" for="ModuleName">Module Name : </label>
                        <div class="controls">
                                <input type="text" name="ModuleName"  />
                        </div>
                </div>   

				<div class="control-group">
                    <label class="control-label" for="modulecode">Module Code : </label>
                        <div class="controls">
                                <input type="text" name="modulecode"  />
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
        
    $.gritter.add({ title: "", text: "Module Added Successfully", class_name: "gritter-info gritter-center" });

    @endif
    
</script>
      
           
               
               
               
      
        
        

    
