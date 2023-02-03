@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href="{{url('ViewCompetemcyStandard')}}"> << Back to View </a>
                <h1>Competency Standard<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST"/>
			
				 <div class="control-group">
                    <label class="control-label" for="ModuleName">Trade:</label>
                        <div class="controls">
                               <select name="TradeId" id="TradeId" required>
							   <option value="">---Select Trade---</option>
							   @foreach($trades as $t)
							   <option value="{{$t->TradeId}}">{{$t->TradeName}}</option>
							   @endforeach
							   </select>
                        </div>
                </div>  
				
                <div class="control-group">
                    <label class="control-label" for="ModuleName">Competency Standard Code:</label>
                        <div class="controls">
                                <input type="text" name="Code" required />
                        </div>
                </div>   

				<div class="control-group">
                    <label class="control-label" for="modulecode">Competency Standard Name:</label>
                        <div class="controls">
                                <input type="text" name="name"  required/>
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
        
    $.gritter.add({ title: "", text: "Competency Standard Added Successfully", class_name: "gritter-warning gritter-center" });

    @endif
    
</script>
      
           
               
               
               
      
        
        

    
