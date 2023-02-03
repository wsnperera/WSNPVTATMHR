@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href="{{url('ViewNVQQualificationPackages')}}"> << Back to View </a>
                <h1>NVQ Qualification Packages<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST"/>
			@foreach($module as $module)
			 <input type="hidden" name="id" value="{{$module->id}}" />
				 <div class="control-group">
                    <label class="control-label" for="ModuleName">Trade:</label>
                        <div class="controls">
                               <select name="TradeId" id="TradeId" required>
							   <option value="">---Select Trade---</option>
							   @foreach($trades as $t)
							   <option @if ($t->TradeId == $module->tradeid) selected @endif value="{{$t->TradeId}}">{{$t->TradeName}}</option>
							   @endforeach
							   </select><span id="img1"></span>
                        </div>
                </div>  
				
               <div class="control-group">
                    <label class="control-label" for="ModuleName">Competency Standard Code:</label>
                        <div class="controls">
                                 <select name="Code" id="Code" required>
								 <option value="">---Select Competency Standard---</option>
								 @foreach($Competency as $s)
								 <option @if ($s->code == $module->cscode) selected @endif value="{{$s->code}}">{{$s->code}}-{{$s->name}}</option>
								 @endforeach
							 
							   </select>
								
                        </div>
                </div>   

				<div class="control-group">
                    <label class="control-label" for="modulecode">Package Code:</label>
                        <div class="controls">
                                <input type="text" name="Package"  value="{{$module->packagecode}}" required/>
                        </div>
                </div> 
				<div class="control-group">
                    <label class="control-label" for="modulecode">Package Level:</label>
                        <div class="controls">
                                <input type="text" name="Level"  value="{{$module->level}}" required/><font color="red">* If level is 4 - enter that value as 'L4'</font>
                        </div>
                </div> 
					@endforeach
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
        
    $.gritter.add({ title: "", text: "Competency Standard Edited Successfully", class_name: "gritter-warning gritter-center" });

    @endif
	 $("#TradeId").change(function() {
        var TradeId = $("#TradeId").val();
        $("#Code").html('');
        
        var msg = '--- Select Competency Standard ---';
      
            
                          $.ajax({

                                       beforeSend: function()
                                        {
                                            
                                            document.getElementById('img1').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                                        type: "GET",
                                        url: "{{url::to('LoadCompetencyCourseCreate')}}",
                                        data: {TradeId: TradeId},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#Code").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#Code").append("<option value=" + item.code + ">" +item.code + "-"+ item.name +  "</option>");



                                                });

                                        },
                                        complete: function() {
                                            document.getElementById('img1').innerHTML ="";

                                        }
                                });            

            
       
    });

    
</script>
      
           
               
               
               
      
        
        

    
