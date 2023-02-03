@include('includes.bar')       
<a href="{{url('viewEmployee')}}"> << Back to Employee </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <!--PAGE CONTENT BEGINS-->

            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee			
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('createEmployee')}}" method="POST" enctype="multipart/form-data"/>
            <h4 style="text-align: right"> <b style="color: red">*</b></<b>Required/Mandatory Fields </b></h4>
            <!--my-->
            <!--my-->
            <div class="control-group">
                <label class="control-label" for="InstituteId">Organisation Name</label>
                <div class="controls">
                    <input type="text"  readonly="readonly" value="{{$institute}}"/>
                    <input type="hidden" name="InstituteId" value="{{$in_id}}"/>
                </div>
            </div>

            <div class="page-header position-relative"></div>
            <b>Personal Details</b>
           

            <div class="control-group">
                <label class="control-label" for="EPFNo">Employee Reference No</label>
                <div class="controls">
                    <input type="text" name="EPFNo" id="EPFNo"  value="{{Input::old('EPFNo')}}" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Initials">Initials</label>
                <div class="controls">
                    <input type="text" name="Initials" id="Initials" required /><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Name">Name</label>
                <div class="controls">
                    <input type="text" name="Name" id="Name" required /><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="LastName">Last Name</label>
                <div class="controls">
                    <input type="text" name="LastName" id="LastName" required /><b style="color: red">*</b>
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" for="NIC">NIC</label>
                <div class="controls">
                    <input type="text" name="NIC" id="load_nic_val" required/><b style="color: red">*</b>
                    <span id="ajax_img2"></span>

                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="Sex">Sex</label>
                <div class="controls">
                    <input type="text"name="Sex" id="Sex" readonly/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="DOB">DOB</label>
                <div class="controls">
                    <input type="date" name="DOB" id="DOB" readonly/>
                </div>
            </div>


            
           

           
            

            

          
         

           
        
           
   
            
        
            
        
            <div class="page-header position-relative"></div>
            <b>Currently Working Centre</b>
            <div class="control-group">
                <label class="control-label" for="Emergency">Crenter name</label>
                <div class="controls">
                     <select name="ToOrganisation" id="ToOrganisation" required>
                            <option value="">--Select--</option>
                            @foreach($centers as $c)
                            <option value="{{$c->id}}">{{$c->OrgaName}} - ({{$c->Type}})</option>
                            @endforeach
                        </select>
                        <b style="color: red">*</b>
                </div>
            </div>
             <div class="page-header position-relative"></div>
            <b>Current Designation</b>
            <div class="control-group">
                <label class="control-label" for="Emergency">Designation</label>
                <div class="controls">
                     <select name="Designation" id="Designation" required>
                            <option value="">--Select--</option>
                            @foreach($designations as $d)
                            <option value="{{$d->id}}">{{$d->Designation}}</option>
                            @endforeach
                        </select>
                        <b style="color: red">*</b>
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

        <div class="span4">

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

                $.gritter.add({title: "", text: "Employee Added Successfully", class_name: "gritter-info gritter-center"});

        @endif

      


    

        $("#load_nic_val").blur(function() {
            document.getElementById('DOB').value = "";
            document.getElementById('Sex').value = "";
            var s_nic = document.getElementById('load_nic_val').value;
            document.getElementById('load_nic_val').style.border = "";
            if (s_nic === " ") {
                document.getElementById('load_nic_val').style.border = "2px solid red";
            } else if (s_nic === "") {
                document.getElementById('load_nic_val').style.border = "";
            } else if (s_nic.length < 10) {
                if (isNaN(s_nic)) {
                    document.getElementById('load_nic_val').style.border = "2px solid red";
                }
            } else if (s_nic.length === 10) {
                var nic = s_nic;
                var myarray = new Array();
                myarray = nic.split("");
                if (myarray[9] === "V" || myarray[9] === "X") {

                    var y = myarray[0] + myarray[1];
                    var d = myarray[2] + myarray[3] + myarray[4];
                    dob_calculate(y, d);
                } else {
                    document.getElementById('load_nic_val').style.border = "2px solid red";
                }
            }else if (s_nic.length < 12) 
        {
            if (isNaN(s_nic)) 
            {
                document.getElementById('load_nic_val').style.border = "2px solid red";
            }
        } 

        else if (s_nic.length === 12) 
        {
            var nic = s_nic;
            var myarray = new Array();
            myarray = nic.split("");
            
            $("#updateBtn").show(); 
            var y = myarray[0] + myarray[1]+ myarray[2] + myarray[3];
            var d = myarray[4] + myarray[5] + myarray[6];

            //alert(y);

            dob_calculate_new(y, d);
        }    

        else if (s_nic.length > 12) 
        {
            document.getElementById('load_nic_val').style.border = "2px solid red";
        }

        });
		
		function dob_calculate_new(y, d) {
        var y = parseInt(y);
        var d = parseInt(d);
        var sex = '';
        var my_year = y;
        var my_month = '';
        var my_date = '';
        if (d < 500) {
            sex = 'Male';
            if (d <= 31) {
                my_month = '01';
                my_date = d;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 60) {
                my_month = '02';
                my_date = d - 31;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 91) {
                my_month = '03';
                my_date = d - 60;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 121) {
                my_month = '04';
                my_date = d - 91;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 152) {
                my_month = '05';
                my_date = d - 121;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 182) {
                my_month = '06';
                my_date = d - 152;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 213) {
                my_month = '07';
                my_date = d - 182;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 244) {
                my_month = '08';
                my_date = d - 213;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 274) {
                my_month = '09';
                my_date = d - 244;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 305) {
                my_month = '10';
                my_date = d - 274;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 335) {
                my_month = '11';
                my_date = d - 305;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else {
                my_month = '12';
                my_date = d - 335;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            }

            var dob = my_year + '-' + my_month + '-' + my_date;
            document.getElementById('DOB').value = dob;
            document.getElementById('Sex').value = sex;

        } else {
            sex = 'Female';
            if (d <= 531) {
                my_month = '01';
                my_date = d - 500;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 560) {
                my_month = '02';
                my_date = d - 531;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 591) {
                my_month = '03';
                my_date = d - 560;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 621) {
                my_month = '04';
                my_date = d - 591;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 652) {
                my_month = '05';
                my_date = d - 621;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 682) {
                my_month = '06';
                my_date = d - 652;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 713) {
                my_month = '07';
                my_date = d - 682;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 744) {
                my_month = '08';
                my_date = d - 713;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 774) {
                my_month = '09';
                my_date = d - 744;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 805) {
                my_month = '10';
                my_date = d - 774;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else if (d <= 835) {
                my_month = '11';
                my_date = d - 805;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            } else {
                my_month = '12';
                my_date = d - 835;
                if (my_date < 10) {
                    my_date = '0' + my_date;
                }
            }

            var dob = my_year + '-' + my_month + '-' + my_date;
            document.getElementById('DOB').value = dob;
            document.getElementById('Sex').value = sex;
        }
    }
    
        function dob_calculate(y, d) {
            var y = parseInt(y);
            var d = parseInt(d);
            var sex = '';
            var my_year = 1900 + y;
            var my_month = '';
            var my_date = '';
            if (d < 500) {
                sex = 'Male';
                if (d <= 31) {
                    my_month = '01';
                    my_date = d;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 60) {
                    my_month = '02';
                    my_date = d - 31;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 91) {
                    my_month = '03';
                    my_date = d - 60;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 121) {
                    my_month = '04';
                    my_date = d - 91;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 152) {
                    my_month = '05';
                    my_date = d - 121;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 182) {
                    my_month = '06';
                    my_date = d - 152;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 213) {
                    my_month = '07';
                    my_date = d - 182;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 244) {
                    my_month = '08';
                    my_date = d - 213;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 274) {
                    my_month = '09';
                    my_date = d - 244;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 305) {
                    my_month = '10';
                    my_date = d - 274;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 335) {
                    my_month = '11';
                    my_date = d - 305;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 366) {
                    my_month = '12';
                    my_date = d - 335;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else {
                    alert('This is not a valid NIC Number \n\ Enter a Valid NIC Number...!');
                }

                var dob = my_year + '-' + my_month + '-' + my_date;
                document.getElementById('DOB').value = dob;
                document.getElementById('Sex').value = sex;

            } else {
                sex = 'Female';
                if (d <= 531) {
                    my_month = '01';
                    my_date = d - 500;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 560) {
                    my_month = '02';
                    my_date = d - 531;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 591) {
                    my_month = '03';
                    my_date = d - 560;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 621) {
                    my_month = '04';
                    my_date = d - 591;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 652) {
                    my_month = '05';
                    my_date = d - 621;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 682) {
                    my_month = '06';
                    my_date = d - 652;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 713) {
                    my_month = '07';
                    my_date = d - 682;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 744) {
                    my_month = '08';
                    my_date = d - 713;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 774) {
                    my_month = '09';
                    my_date = d - 744;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 805) {
                    my_month = '10';
                    my_date = d - 774;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 835) {
                    my_month = '11';
                    my_date = d - 805;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else if (d <= 866) {
                    my_month = '12';
                    my_date = d - 835;
                    if (my_date < 10) {
                        my_date = '0' + my_date;
                    }
                } else {
                    alert('This is not a valid NIC Number \n\ Enter a Valid NIC Number...!');
                }

                var dob = my_year + '-' + my_month + '-' + my_date;
                document.getElementById('DOB').value = dob;
                document.getElementById('Sex').value = sex;
            }
            nic_data_load();
        }

     

      
  


 


           function nic_data_load() {
                                    var s_nic = document.getElementById('load_nic_val').value;
                                  alert(s_nic);
                                    document.getElementById('load_nic_val').style.border = "1px solid #777";
                                    $.ajax({
                                        url: "{{url::to('loadNicAjaxDetails')}}",
                                        data: {nic: s_nic},
                                        beforeSend: function() {
                                            document.getElementById('ajax_img2').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                                        success: function(result) {
                                            var d = result.split('|#|');
                                            var EPFNo = d[0];
                                            var LastName = d[1];
                                            var Initials = d[2];
                                            var Name = d[3];
                                            var DOB = d[4];
                                            //var CivilStatus = d[5];
                                           // var PAddress = d[6];
                                           // var Mobile = d[7];
                                           // var Race = d[8];
                                            //var Religion = d[9];
                                           // var BloodGroup = d[10];
                                            //var PassportNo = d[11];
                                           // var CAddress = d[12];
                                           // var DistrictName = d[13];
                                          //  var DSDivision = d[14];
                                          //  var Contact = d[15];
                                           // var Email = d[16];
                                           // var OContact = d[17];
                                           // var OMobile = d[18];
                                           // var OEmail = d[19];
                                            var dale = d[5];
                                           //alert(Mobile);
                                            document.getElementById('EPFNo').value = EPFNo;
                                            $('#Initials').val(Initials);
                                            $('#Name').val(Name);
                                            $('#LastName').val(LastName);
                                            $('#DOB').val(DOB);
                                            //$('#CivilStatus').val(CivilStatus);
                                            //$('#PAddress').val(PAddress);
                                           // $('#Mobile').val(Mobile);
                                           // $('#Race').val(Race);
                                           // $('#Religion').val(Religion);
                                           // $('#BloodGroup').val(BloodGroup);
                                          //  $('#PassportNo').val(PassportNo);
                                          //  $('#CAddress').val(CAddress);
                                          //  $('#DistrictName').val(DistrictName);
                                         //   $('#DSDivision').val(DSDivision);
                                          //  $('#Contact').val(Contact);
                                           // $('#Email').val(Email);
                                           // $('#OContact').val(OContact);
                                           // $('#OMobile').val(OMobile);
                                           // $('#OEmail').val(OEmail);

                                           // document.getElementById('FullName').value = FullName;
                                           //document.getElementById('Address').innerHTML = Address;
                                           // document.getElementById('NameWithInitialsSinhala').value = name_sin_tam;
                                           // document.getElementById('address_sinhala_tamil').value = address_sin_tam;
                                          //  $('#Province option[value="' + province + '"]').attr('selected', 'selected');
                                          //  document.getElementById('District').innerHTML = '<option value=' + district + '>' + district + '</option>';
                                          //  document.getElementById('Electorate').innerHTML = '<option value=' + electro + '>' + electro + '</option>';
                                          //  document.getElementById('Grama_Sewa_Division').value = grama;
                                          //  document.getElementById('Tel').value = tel_h;
                                          //  document.getElementById('Tel_mob').value = tel_m;
                                           // document.getElementById('email').value = email;
                                           // $('#Medium option[value="' + medium + '"]').attr('selected', 'selected');
                                            if (dale === "dale") {
                                                document.getElementById('nic_records').innerHTML = '';
                                            } else {
                                                document.getElementById('nic_records').innerHTML = dale;
                                            }
                                        },
                                        complete: function() {
                                            document.getElementById('ajax_img2').innerHTML = '';
                                        }
                                    });
                                }
    </script>
