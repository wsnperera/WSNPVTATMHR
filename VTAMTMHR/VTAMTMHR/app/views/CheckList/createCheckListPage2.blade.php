@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Check List<small><i class="icon-double-angle-right"></i>Create</small></h1>
                <a href="viewCheckList"><< Back To Main</a>
            </div>
            <form class="form-horizontal" action='' method="POST">
                <input type="hidden" name="appPK" value="{{$a->id}}" />
                <input type="hidden" name="courseYearPlanID" value="{{$courseYearPlanID}}" />
                <table class="table">
                    <tr>
                        <td></td>
                        <td>Course List Code</td>
                        <td colspan="5">
                            <b>{{$a->CourseListCode}}</b>
                            @if($parallelGroups=='Yes')
                            &nbsp;&nbsp;Course Code : 
                                <b>
                                    <select name="couseCodePG" required="true">
                                        <option></option>
                                        @foreach($couseCode as $cc)
                                        <option value="{{$cc->CS_ID}}">{{$cc->CourseCode}}</option>
                                        @endforeach
                                    </select>
                                </b>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Applicant Name With Initials</td>
                        <td colspan="5"><b>{{$a->NameWithInitials}}</b></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>NIC</td>
                        <td colspan="5"><b>{{$a->NIC}}</b></td>
                    </tr>
                    <tr>
                        <td>(1)</td>
                        <td>Original Application</td>
                        <td>
                            <lable>
                                <input class='checkVP' id="originalApplication" name='originalApplication' type="checkbox" value="1" checked="true"/>
                                <span class="lbl"></span>
                            </lable>
                        </td>
                        <td></td>
                        <td>(2)</td>
                        <td>Interview Letter</td>
                        <td>
                            <lable>
                                <input class='checkVP' id="interviewLetter" name='interviewLetter' type="checkbox" value="1" checked="true"/>
                                <span class="lbl"></span>
                            </lable>
                        </td>
                    </tr>
                    <tr>
                        <td>(3)</td>
                        <td>Selected Letter</td>
                        <td>
                            <lable>
                                <input class='checkVP' id="selectedLetter" name='selectedLetter' type="checkbox" value="1" checked="true"/>
                                <span class="lbl"></span>
                            </lable>
                        </td>
                        <td></td>
                        <td>(4)</td>
                        <td>Birth Certificate</td>
                        <td>
                            <lable>
                                <input class='checkVP' name='birthCertificate' id="birthCertificate" type="checkbox" value="1" />
                                <span class="lbl" style="color: red"><b>*</b></span>
                            </lable>
                        </td>
                    </tr>
                    <tr>
                        <td>(5)</td>
                        <td>Education Certificate</td>
                        <td>
                            <lable>
                                <input class='checkVP' name='eduCertificate' id="eduCertificate" type="checkbox" value="1" />
                                <span class="lbl" style="color: red"><b>*</b></span>
                            </lable>
                        </td>
                        <td></td>
                        <td>(6)</td>
                        <td>Student Leaving Certificate/Service Letter</td>
                        <td>
                            <lable>
                                <input class='checkVP' name='serviceLetter' id="serviceLetter" type="checkbox" value="1" />
                                <span class="lbl" style="color: red"><b>*</b></span>
                            </lable>
                        </td>
                    </tr>
                    <tr>
                        <td>(7)</td>
                        <td>Two Pictures</td>
                        <td>
                            <lable>
                                <input class='checkVP' name='picture' id="picture" type="checkbox" value="1" />
                                <span class="lbl"></span>
                            </lable>
                        </td>
                        <td></td>
                        <td>(8)</td>
                        <td>Student Society Receipt</td>
                        <td>
                            <lable>
                                <input class='checkVP' name='studentSocietyReceipt' id="studentSocietyReceipt" type="checkbox" value="1" />
                                <span class="lbl"></span>
                            </lable>
                        </td>
                    </tr>
                    <tr>
                        <td>(9)</td>
                        <td>Course Fee Receipt</td>
                        @if(ApplicantDocumentList::getFee($a->CourseListCode))
                            <td>
                                <lable>
                                    <input class='checkVP' name='courseFeeReceipt' id="courseFeeReceipt" type="checkbox" value="1" />
                                    <span class="lbl" style="color: red"><b>*</b></span>
                                </lable>
                            </td>
                        @else
                            <td>
                                <input class='checkVP' name='courseFeeReceipt'  type="hidden" value="1" />
                                <lable>
                                    <input class='checkVP' type="checkbox" value="1" checked="true" disabled="true"/>
                                    <span class="lbl"></span>
                                </lable>
                            </td>
                        @endif
                        <td></td>
                        <td>(10)</td>
                        <td>Gramaseva Certificate</td>
                        <td><lable>
                                <input class='checkVP' name='gramasevaCertificate' id="gramasevaCertificate" type="checkbox" value="1" />
                                <span class="lbl" style="color: red"><b>*</b></span>
                            </lable>
                        </td>
                    </tr>
                    <tr>
                        <td>(11)</td>
                        <td>Character Certificate</td>
                        <td><lable>
                                <input class='checkVP' name='characterCertificate' id="characterCertificate" type="checkbox" value="1" />
                                <span class="lbl" style="color: red"><b>*</b></span>
                            </lable>
                        </td>
                        <td></td>
                        <td>(12)</td>
                        <td>Medical Certificate</td>
                        <td><lable>
                                <input class='checkVP' name='medicalCertificate' id="medicalCertificate" type="checkbox" value="1" />
                                <span class="lbl"></span>
                            </lable>
                        </td>
                    </tr>
                    <tr>
                        <td>(13)</td>
                        <td>Guardian Statement/Service Certificate</td>
                        <td><lable>
                                <input class='checkVP' name='serviceCertificate' id="serviceCertificate" type="checkbox" value="1" />
                                <span class="lbl" style="color: red"><b>*</b></span>
                            </lable>
                        </td>
                        <td></td>
                        <td></td>
                        <td>
                            <input type="submit" class="btn btn-small btn-primary btn-block" value="Save"/>
                        </td>
                        <td>
                            <lable>
                                <input  class='checkVP' name='' value="1" type="checkbox" onchange="check(this)" />
                                <span class="lbl"><b> All</b></span>
                            </lable>
                        </td>
                    </tr>
                </table>
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
    function check(x)
    {
        if(x.checked==true)
        {
            document.getElementById("originalApplication").checked = true;
            document.getElementById("interviewLetter").checked = true;
            document.getElementById("selectedLetter").checked = true;
            document.getElementById("birthCertificate").checked = true;
            document.getElementById("eduCertificate").checked = true;
            document.getElementById("serviceLetter").checked = true;
            document.getElementById("picture").checked = true;
            document.getElementById("studentSocietyReceipt").checked = true;
            document.getElementById("gramasevaCertificate").checked = true;
            document.getElementById("characterCertificate").checked = true;
            document.getElementById("medicalCertificate").checked = true;
            document.getElementById("serviceCertificate").checked = true;
            document.getElementById("courseFeeReceipt").checked = true;
        }
        else
        {
            document.getElementById("originalApplication").checked = false;
            document.getElementById("interviewLetter").checked = false;
            document.getElementById("selectedLetter").checked = false;
            document.getElementById("birthCertificate").checked = false;
            document.getElementById("eduCertificate").checked = false;
            document.getElementById("serviceLetter").checked = false;
            document.getElementById("picture").checked = false;
            document.getElementById("studentSocietyReceipt").checked = false;
            document.getElementById("gramasevaCertificate").checked = false;
            document.getElementById("characterCertificate").checked = false;
            document.getElementById("medicalCertificate").checked = false;
            document.getElementById("serviceCertificate").checked = false;
            document.getElementById("courseFeeReceipt").checked = false;
        }   
    }
    @if(isset($done))
        
    $.gritter.add({ title: "", text: "Test Center Added Successfully", class_name: "gritter-info gritter-center" });

    @endif
    
</script>