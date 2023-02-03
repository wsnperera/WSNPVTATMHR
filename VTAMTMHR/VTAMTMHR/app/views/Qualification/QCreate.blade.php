@include('includes.bar')       

<div class="page-content">

    <div class="row-fluid">


        <div class="span8">

            <!--PAGE CONTENT BEGINS-->

            <!--/.page-header-->

            <div class="page-header position-relative">

                <h1>
                    Qualification			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->




            <form class="form-horizontal" action="{{url('createQualification')}}" method="POST"/>




            <!-- Choose Institute -->

            <div class="control-group">

                <label class="control-label" for="InstituteId">Choose Institue</label>

                <div class="controls">

                    <select name="InstituteId">

                        @foreach ($institutes as $i)

                        <option value="{{$i->InstituteId}}">{{$i->InstituteName}}</option>

                        @endforeach


                    </select>

                </div>

                <!-- Choose Institute -->
                <br/>


                <!-- Course Trade -->

                <div class="control-group">

                    <label class="control-label" for="OrganisationId">Organisation</label>

                    <div class="controls">

                        <select name="OrganisationId">

                            @foreach($trades as $t)

                            <option value="{{$t->id}}">{{$t->OrgaName}}</option>     

                            @endforeach

                        </select>

                    </div>

                </div>

                <!-- Course Trade -->








                <!-- NVQ -->

                <div class="control-group">

                    <label class="control-label" for="Qualification">Qualification</label>

                    <div class="controls">

                        <input type="text" name="Qualification"  />

                    </div>

                </div>









                <!-- Submit Button -->

                <div class="control-group">

                    <div class="controls">

                        <button type="submit" class="btn btn-small btn-primary">Save</button>

                    </div>
                </div>


                <!-- Submit Button -->






            </div>

            </form>







        </div><!--/.span-->




        <!--/span 4 for error handling -->

        <div class="span4">

            <!-- Error Handling -->

            @if($errors->has())

            @foreach($errors->all() as $msg)

            <!-- Error Message -->

            <div class="alert alert-error">

                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>

                <strong> <i class="icon-remove"></i>{{$msg}}</strong>

            </div>

            <!-- Error Message -->

            @endforeach

            @endif

            <!-- Error Handling -->






        </div>
        <!--/span 4-->





        <!--PAGE CONTENT ENDS-->

    </div><!--/.row-fluid-->
</div><!--/.page-content-->


@include('includes.footer')   


<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif

</script>










