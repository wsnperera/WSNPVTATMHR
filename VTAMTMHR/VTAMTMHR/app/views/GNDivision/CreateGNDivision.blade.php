@include('includes.bar')       
<a href="{{url('viewGNDivision')}}"> << Back to GN Division </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    GN Division			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('createGNDivisionVTA')}}" method="POST" >
                              
                 <div class="control-group">
                     <label class="control-label" for="District">District Name</label>
                <div class="controls">
                    <select name="DistrictCode" id="DistrictCode">
                        <option value="">---Select---</option>
                        @foreach ($District as $d)
                        <option value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
                        @endforeach
                    </select>
                    <span id="ajax_img3"></span>
                </div>
            </div>
                
                 <div class="control-group">
                     <label class="control-label" for="DSDivisionCode">DS Division Name</label>
                <div class="controls">
                    <select name="DSDivisionCode" id="ElectorateCode">
                        <option value="">--Select--</option>
<!--                        @foreach ($Electorate as $e)
                        <option value="{{$e->ElectorateCode}}">{{$e->ElectorateName}}</option>
                        @endforeach-->
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="GNDivisionName">GN Division Name</label>
                <div class="controls">
                    <input type="text" name="GNDivisionName"  />
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save</button>
                </div>
            </div>
            </form>

        </div><!--/.span-->

        <!--/span 4 for error handling -->

<!--        <div class="span4">-->

            <!-- Error Handling --!>
                    @if($errors->has())
                          @foreach($errors->all() as $msg)
            <!-- Error Message --!>
              <div class="alert alert-error">
                 <button type="button" class="close" data-dismiss="alert">
                         <i class="icon-remove"></i>
                 </button>
                 <strong> <i class="icon-remove"></i>{{$msg}}</strong>
              </div>
            <!-- Error Message --!>
      @endforeach
    @endif
            <!-- Error Handling --!>
    </div>
            <!--/span 4-->
            <!--PAGE CONTENT ENDS-->

        </div><!--/.row-fluid-->
    </div><!--/.page-content-->
   @include('includes.footer')  
   <script>

        @if (isset($done))

                $.gritter.add({title: "", text: "GNDivision Added Successfully", class_name: "gritter-info gritter-center"});

        @endif
         $("#DistrictCode").change(function() {

            var dc = document.getElementById('DistrictCode').value;
            $.ajax({
                url: "{{url::to('EleGNDivisionjaxVTA')}}",
                data: {DistrictCode: dc},
                beforeSend: function() {
                    document.getElementById('ajax_img3').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                },
                success: function(result)
                {         
                    document.getElementById('ElectorateCode').innerHTML = result;
                },
                complete: function() {
                    document.getElementById('ajax_img3').innerHTML = "";
                }
            });
        });
             
</script>
        









