<?php
Route::group(array('before' => 'permissionFilter'), function() {
	//Special Routs
	// Update real end dates in course year plan 
	Route::any('UpdateAllExpectedCompletedDateCourseYearPlan',array('as'=>'UpdateAllExpectedCompletedDateCourseYearPlan','uses'=>'TrainingPlanReportController@UpdateAllExpectedCompletedDateCourseYearPlan'));
	//Special Routes End
 // Start UserTypeRole 
    Route::any('createUserTypeRole', array('as' => 'createUserTypeRole', 'uses' => 'UserTypeRoleController@createUserTypeRole'));
    Route::post('saveUserTypeRole', array('as' => 'saveUserTypeRole', 'uses' => 'UserTypeRoleController@saveUserTypeRole'));
    Route::any('ViewUserTypeRole', array('as' => 'ViewUserTypeRole', 'uses' => 'UserTypeRoleController@ViewUserTypeRole'));
    Route::any('ViewUserTypeRoleOne', array('as' => 'ViewUserTypeRoleOne', 'uses' => 'UserTypeRoleController@ViewUserTypeRoleOne'));
    Route::any('deleteUserTypeRole', array('as' => 'deleteUserTypeRole', 'uses' => 'UserTypeRoleController@deleteUserTypeRole'));
    // End UserTypeRole 
    Route::any('downloadExcelCourseDetails', array('as' => 'downloadExcelCourseDetails', 'uses' => 'CourseController@downloadExcel'));
	// start course Year Plan
	Route::any('editModulesToCourse',array('as'=>'editModulesToCourse','uses'=>'courseYearPlanController@editModulesToCourse'));
	Route::any('viewModulesToCourse',array('as'=>'viewModulesToCourse','uses'=>'courseYearPlanController@viewModulesToCourse'));
	Route::any('assignModulesToCourse',array('as'=>'assignModulesToCourse','uses'=>'courseYearPlanController@assignModulesToCourse'));
	Route::any('ConfirmCourseYearPlanFirstPage',array('as'=>'ConfirmCourseYearPlanFirstPage','uses'=>'courseYearPlanController@ConfirmCourseYearPlanFirstPage'));
	Route::any('ajaxGetFeePartFull',array('as'=>'ajaxGetFeePartFull','uses'=>'courseYearPlanController@ajaxGetFeePartFull'));
	Route::any('ConfirmCourseYearPlan',array('as'=>'ConfirmCourseYearPlan','uses'=>'courseYearPlanController@ConfirmCourseYearPlan'));
	Route::any('editCourseYearPlan',array('as'=>'editCourseYearPlan','uses'=>'courseYearPlanController@editCourseYearPlan'));
	Route::any('CreateCourseYearPlanOne',array('as'=>'CreateCourseYearPlanOne','uses'=>'courseYearPlanController@CreateCourseYearPlanOne'));
    Route::any('ajaxGetNvqLevelCourse',array('as'=>'ajaxGetNvqLevelCourse','uses'=>'courseYearPlanController@ajaxGetNvqLevelCourse'));	
	Route::any('CreateCourseYearPlan',array('as'=>'CreateCourseYearPlan','uses'=>'courseYearPlanController@CreateCourseYearPlan'));
	Route::any('CreateCourseYearPlan2',array('as'=>'CreateCourseYearPlan2','uses'=>'courseYearPlanController@CreateCourseYearPlan2'));
	Route::any('ajaxCheckedValues',array('as'=>'ajaxCheckedValues','uses'=>'courseYearPlanController@ajaxCheckedValues'));
	Route::any('viewCourseYearPlan',array('as'=>'viewCourseYearPlan','uses'=>'courseYearPlanController@viewCourseYearPlan'));
	Route::any('deleteCourseYearPlan',array('as'=>'deleteCourseYearPlan','uses'=>'courseYearPlanController@deleteCourseYearPlan'));
	Route::any('ajaxOrganisationLoad', array('as' => 'ajaxOrganisationLoad','uses' => 'courseYearPlanController@ajaxOrganisationLoad'));
    Route::any('SaveMOInstructor', array('as' => 'SaveMOInstructor','uses' => 'courseYearPlanController@SaveMOInstructor'));
    // end course Year Plan
    //start check List
    Route::any('viewCheckList', array('as' => 'viewCheckList', 'uses' => 'CheckListController@viewCheckList'));
    Route::any('deleteCheckList', array('as' => 'deleteCheckList', 'uses' => 'CheckListController@deleteCheckList'));
    Route::any('editCheckList', array('as' => 'editCheckList', 'uses' => 'CheckListController@editCheckList'));
    Route::any('createCheckList', array('as' => 'createCheckList', 'uses' => 'CheckListController@createCheckList'));
    Route::any('createCheckListPage2', array('as' => 'createCheckListPage2', 'uses' => 'CheckListController@createCheckListPage2'));
    //end check List
	Route::any('editHoliday',array('as' => 'editHoliday','uses' => 'HolidayController@actionEdit'));
	Route::any('createHoliday',array('as' => 'createHoliday','uses' => 'HolidayController@actionCreate'));
	Route::any('createHoliday',array('as' => 'createHoliday','uses' => 'HolidayController@actionCreate'));
	Route::get('holiday',array('as' => 'holiday','uses' => 'HolidayController@viewHoliday'));
    Route::get('findHoliday',array('as' => 'findHoliday','uses' => 'HolidayController@actionSearch'));
    Route::any('deleteHoliday', array('as' => 'deleteHoliday','uses' => 'HolidayController@actionDelete'));
    // start Accredit
    //start report 
    Route::any('ReportExpiredCourseList', array('as' => 'ReportExpiredCourseList', 'uses' => 'CourseAccreditationController@ReportExpiredCourseList'));
    Route::any('ReportActiveCourseList', array('as' => 'ReportActiveCourseList', 'uses' => 'CourseAccreditationController@ReportActiveCourseList'));
    //end report
    Route::any('ViewAccreditation', array('as' => 'ViewAccreditation', 'uses' => 'CourseAccreditationController@ViewAccreditation'));
    Route::any('ConformAccreditation', array('as' => 'ConformAccreditation', 'uses' => 'CourseAccreditationController@ConformAccreditation'));
    Route::any('ViewAccreditAssessed', array('as' => 'ViewAccreditAssessed', 'uses' => 'CourseAccreditationController@ViewAccreditAssessed'));
    Route::any('EditAccreditAssessed', array('as' => 'EditAccreditAssessed', 'uses' => 'CourseAccreditationController@EditAccreditAssessed'));
    Route::any('ViewAccreditRequest', array('as' => 'ViewAccreditRequest', 'uses' => 'CourseAccreditationController@ViewAccreditRequest'));
    Route::any('CreateAccreditRequest', array('as' => 'CreateAccreditRequest', 'uses' => 'CourseAccreditationController@CreateAccreditRequest'));
    Route::any('EditAccreditRequest', array('as' => 'EditAccreditRequest', 'uses' => 'CourseAccreditationController@EditAccreditRequest'));
    // end Accredit
    // module updated
    //Start Qualify Change
    Route::any('EditAutoQualifyResults',array('as' => 'EditAutoQualifyResults','uses' => 'ApplicantController@addQuaResults'));
    //End Qualify Change
    //start Institute
    Route::any('editInstitute', array('as' => 'editInstitute','uses' => 'InstituteController@actionEdit'));
    Route::get('institute',array('as' => 'institute','uses' => 'InstituteController@viewInstitute'));
    Route::get('findInstitute',array('as' => 'findCourse','uses' => 'InstituteController@actionSearch'));
    Route::post('deleteInstitute',array('as' => 'deleteInstitute','uses' => 'InstituteController@actionDelete'));
    // end Institute
    // Start Generated NIC
    Route::any('generatedNIC', array('as' => 'generatedNIC', 'uses' => 'GeneratedNICController@generatedNIC'));
    Route::any('ajaxGetGeneratedNIC', array('as' => 'ajaxGetGeneratedNIC', 'uses' => 'GeneratedNICController@ajaxGetGeneratedNIC'));
    // end Generated NIC
    Route::get('/',array('uses' => 'HomeController@login'));
    Route::get('role',array('uses' => 'RoleController@roleManager'));
    Route::get('logout',array('uses' => 'HomeController@logOut'));
    Route::any('authuser',array('uses' => 'HomeController@authuser'));
    Route::get('dashboard',array('as' => 'dashboard','uses' => 'HomeController@dashboard'));
    Route::get('courses',array('as' => 'courses','uses' => 'CourseController@viewCourses'));
    Route::get('register',array('as' => 'register','uses' => 'CourseController@registerCourse'));
    Route::get('regCourse',array('as' => 'regCourse','uses' => 'CourseController@regCourse'));
    Route::get('test',array('as' => 'test','uses' => 'HomeController@test'));
    Route::get('findCourse',array('as' => 'findCourse','uses' => 'CourseController@actionSearch'));
    Route::post('deleteCourse',array('as' => 'deleteCourse','uses' => 'CourseController@actionDelete'));
    Route::any('createCourse',array('as' => 'createCourse','uses' => 'CourseController@actionCreate'));
 Route::any
            (
            'editCourse', // Url pattern name
            array
        (
        'as' => 'editCourse', // to use return Redirect::route('dashboard');
        'uses' => 'CourseController@actionEdit'
            )
    );

    //log route
    Route::get
            (
            'log', // Url pattern name
            array
        (
        'as' => 'log', // to use return Redirect::route('dashboard');
        'uses' => 'LogDataController@viewLogData'
            )
    );

    Route::get
            (
            'findlog', // Url pattern name
            array
        (
        'as' => 'findlog', // to use return Redirect::route('dashboard');
        'uses' => 'LogDataController@actionSearch'
            )
    );
//log route
    //rejected view
    Route::any
            (
            'rejected', // Url pattern name
            array
        (
        'as' => 'rejected', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@viewRejected'
            )
    );
//rejected view

//Complete routes
    Route::any
            (
            'completecourse', // Url pattern name
            array
        (
        'as' => 'completecourse', // to use return Redirect::route('dashboard');
        'uses' => 'CourseStarteCompleteController@stComplete'
            )
    );

    Route::any
            (
            'completeExam', // Url pattern name
            array
        (
        'as' => 'completeExam', // to use return Redirect::route('dashboard');
        'uses' => 'CourseStarteCompleteController@exam'
            )
    );

    Route::any
            (
            'completeInplantPlaced', // Url pattern name
            array
        (
        'as' => 'completeInplantPlaced', // to use return Redirect::route('dashboard');
        'uses' => 'CourseStarteCompleteController@InplantPlaced'
            )
    );

    Route::any
            (
            'completeInplant', // Url pattern name
            array
        (
        'as' => 'completeInplant', // to use return Redirect::route('dashboard');
        'uses' => 'CourseStarteCompleteController@InplantCompleted'
            )
    );

    Route::any
            (
            'completebatch', // Url pattern name
            array
        (
        'as' => 'completebatch', // to use return Redirect::route('dashboard');
        'uses' => 'CompleteBatchController@CompleteBatch'
            )
    );
//Complete routes
 Route::any
            (
            'Org_inch', // Url pattern name 
            array
        (
        'as' => 'Org_inch', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@Incharge'
            )
    );

   Route::any('createDOPromotion', // Url pattern name
            array('as' => 'createDOPromotion','uses' => 'PromotionController@actionCreate'));
 

    Route::any
            (
            'Org_inch_edit', // Url pattern name 
            array
        (
        'as' => 'Org_inch_edit', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@Incharge_edit'
            )
    );

//Organization_Incharge routes.....

//examType routes.....
    Route::any
            (
            'ExamType_view', array
        (
        'as' => 'ExamType_view', // to use return Redirect::route('dashboard');
        'uses' => 'ExamTypeController@actionView'
            )
    );
    Route::any
            (
            'ExamType_deleted', array
        (
        'as' => 'ExamType_deleted', // to use return Redirect::route('dashboard');
        'uses' => 'ExamTypeController@actionDeleted'
            )
    );
    Route::any
            (
            'ExamType_create', array
        (
        'as' => 'ExamType_create', // to use return Redirect::route('dashboard');
        'uses' => 'ExamTypeController@actionCreate'
            )
    );
    Route::any
            (
            'ExamType_Ajax', array
        (
        'as' => 'ExamType_Ajax', // to use return Redirect::route('dashboard');
        'uses' => 'ExamTypeController@ExamTypeajax'
            )
    );
    Route::any
            (
            'ExamType_getmulorga', array
        (
        'as' => 'ExamType_getmulorga', // to use return Redirect::route('dashboard');
        'uses' => 'ExamTypeController@getmulorga'
            )
    );
    Route::any
            (
            'ExamType_getallorga', array
        (
        'as' => 'ExamType_getallorga', // to use return Redirect::route('dashboard');
        'uses' => 'ExamTypeController@getallorga'
            )
    );
//examType routes.....
//examattendence routes......
    Route::any
            (
            'ExAtten_view', array
        (
        'as' => 'ExAtten_view', // to use return Redirect::route('dashboard');
        'uses' => 'ExamAttendanceController@ViewAttendence'
            )
    );
    Route::any
            (
            'ExAtten_table', array
        (
        'as' => 'ExAtten_table', // to use return Redirect::route('dashboard');
        'uses' => 'ExamAttendanceController@table'
            )
    );
    Route::any
            (
            'ExAtten_Present', array
        (
        'as' => 'ExAtten_Present', // to use return Redirect::route('dashboard');
        'uses' => 'ExamAttendanceController@Present'
            )
    );
    Route::any
            (
            'ExAtten_getExam', array
        (
        'as' => 'ExAtten_getExam', // to use return Redirect::route('dashboard');
        'uses' => 'ExamAttendanceController@getExam'
            )
    );
    Route::any
            (
            'ExAtten_actionShow', array
        (
        'as' => 'ExAtten_actionShow', // to use return Redirect::route('dashboard');
        'uses' => 'ExamAttendanceController@actionShow'
            )
    );

//examattendence routes......
//examIndexno rutes..........
    Route::any
            (
            'ExIndex_actionView', array
        (
        'as' => 'ExIndex_actionView', // to use return Redirect::route('dashboard');
        'uses' => 'ExamIndexNoController@actionView'
            )
    );
    Route::any
            (
            'ExIndex_getCourseCode', array
        (
        'as' => 'ExIndex_getCourseCode', // to use return Redirect::route('dashboard');
        'uses' => 'ExamIndexNoController@getCourseCode'
            )
    );
    Route::any
            (
            'ExIndex_getExam', array
        (
        'as' => 'ExIndex_getExam', // to use return Redirect::route('dashboard');
        'uses' => 'ExamIndexNoController@getExam'
            )
    );
    Route::any
            (
            'ExIndex_giveIndexno', array
        (
        'as' => 'ExIndex_giveIndexno', // to use return Redirect::route('dashboard');
        'uses' => 'ExamIndexNoController@giveIndexno'
            )
    );
    Route::any
            (
            'ExIndex_actionCreate', array
        (
        'as' => 'ExIndex_actionCreate', // to use return Redirect::route('dashboard');
        'uses' => 'ExamIndexNoController@actionCreate'
            )
    );
    Route::any
            (
            'ExIndex_SearchView', array
        (
        'as' => 'ExIndex_SearchView', // to use return Redirect::route('dashboard');
        'uses' => 'ExamIndexNoController@SearchView'
            )
    );
    Route::any
            (
            'ExIndex_actionDelete', array
        (
        'as' => 'ExIndex_actionDelete', // to use return Redirect::route('dashboard');
        'uses' => 'ExamIndexNoController@actionDelete'
            )
    );
    Route::any
            (
            'ExIndex_ActionEdit', array
        (
        'as' => 'ExIndex_ActionEdit', // to use return Redirect::route('dashboard');
        'uses' => 'ExamIndexNoController@ActionEdit'
            )
    );
//examIndexno rutes..........
//course Transfer routes......
    Route::any
            (
            'CTran_actionView', array
        (
        'as' => 'CTran_actionView', // to use return Redirect::route('dashboard');
        'uses' => 'CourseTransferController@actionView'
            )
    );
    Route::any
            (
            'CTran_Searchnic', array
        (
        'as' => 'CTran_Searchnic', // to use return Redirect::route('dashboard');
        'uses' => 'CourseTransferController@Searchnic'
            )
    );
    Route::any
            (
            'CTran_Transfer', array
        (
        'as' => 'CTran_Transfer', // to use return Redirect::route('dashboard');
        'uses' => 'CourseTransferController@Transfer'
            )
    );
    Route::any
            (
            'CTran_TransferConfirm', array
        (
        'as' => 'CTran_TransferConfirm', // to use return Redirect::route('dashboard');
        'uses' => 'CourseTransferController@TransferConfirm'
            )
    );

//course Transfer routes......
//dtet event routes.....
    Route::any
            (
            'DtetEv_EventCreate', array
        (
        'as' => 'DtetEv_EventCreate', // to use return Redirect::route('dashboard');
        'uses' => 'DtetEventPlanController@EventCreate'
            )
    );
    Route::any
            (
            'DtetEv_Eventsave', array
        (
        'as' => 'DtetEv_Eventsave', // to use return Redirect::route('dashboard');
        'uses' => 'DtetEventPlanController@Eventsave'
            )
    );
    Route::any
            (
            'DtetEv_actionView', array
        (
        'as' => 'DtetEv_actionView', // to use return Redirect::route('dashboard');
        'uses' => 'DtetEventPlanController@actionView'
            )
    );
    Route::any
            (
            'DtetEv_actionDeleted', array
        (
        'as' => 'DtetEv_actionDeleted', // to use return Redirect::route('dashboard');
        'uses' => 'DtetEventPlanController@actionDeleted'
            )
    );
    Route::any
            (
            'DtetEv_actionEdit', array
        (
        'as' => 'DtetEv_actionEdit', // to use return Redirect::route('dashboard');
        'uses' => 'DtetEventPlanController@actionEdit'
            )
    );
    Route::any
            (
            'DtetEv_Autofill', array
        (
        'as' => 'DtetEv_Autofill', // to use return Redirect::route('dashboard');
        'uses' => 'DtetEventPlanController@Autofill'
            )
    );
//dtet event routes

//applicant routes.....
    Route::any('App_getResult', array('as' => 'App_getResult', 'uses' => 'ApplicantController@getResult'));

//applicant routes.....
// VARUNA ROUTES ENDS


    Route::get
            (
            'organisation', // Url pattern name
            array
        (
        'as' => 'organisation', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@viewOrganisation'
            )
    );
    Route::any
            (
            'createOrganisation', // Url pattern name
            array
        (
        'as' => 'createOrganisation', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@actionCreate'
            )
    );
    Route::get
            (
            'findOrganisation', // Url pattern name
            array
        (
        'as' => 'findOrganisation', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@actionSearch'
            )
    );
    Route::any
            (
            'editOrganisation', array
        (
        'as' => 'editOrganisation', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@actionEdit'
            )
    );

    Route::post
            (
            'deleteOrganisation', // Url pattern name
            array
        (
        'as' => 'deleteOrganisation', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@actionDelete'
            )
    );
    Route::any
            (
            'dateclosedOrganisation', array
        (
        'as' => 'dateclosedOrganisation', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@Dateclosed'
            )
    );

    Route::get
            (
            'disLoadajax', array
        (
        'as' => 'disLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@disAjax'
            )
    );
    Route::get
            (
            'CollegeLoadajax', array
        (
        'as' => 'CollegeLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@CollegeAjax'
            )
    );

    Route::post
            (
            'deleteCourse', // Url pattern name
            array
        (
        'as' => 'deleteCourse', // to use return Redirect::route('dashboard');
        'uses' => 'CourseController@actionDelete'
            )
    );
    Route::post
            (
            'deleteCourse', // Url pattern name
            array
        (
        'as' => 'deleteCourse', // to use return Redirect::route('dashboard');
        'uses' => 'CourseController@actionDelete'
            )
    );



    Route::get
            (
            'PaperAdvertisement', // Url pattern name
            array
        (
        'as' => 'PaperAdvertisement', // to use return Redirect::route('dashboard');
        'uses' => 'PaperAdvertisementController@viewAdvertisements'
            )
    );


    Route::get('download1234', array
        (
        'as' => 'download1234',
        'uses' => 'PaperAdvertisementController@getDownload'
            )
    );


    Route::get
            (
            'HolidayType', // Url pattern name
            array
        (
        'as' => 'HolidayType', // to use return Redirect::route('dashboard');
        'uses' => 'HolidayTypeController@viewHolidayTypes'
            )
    );

    Route::get
            (
            'findAdd', // Url pattern name
            array
        (
        'as' => 'findAdd', // to use return Redirect::route('dashboard');
        'uses' => 'PaperAdvertisementController@actionSearch'
            )
    );



    Route::post
            (
            'deleteHolidayType', // Url pattern name
            array
        (
        'as' => 'deleteHolidayType', // to use return Redirect::route('dashboard');
        'uses' => 'HolidayTypeController@actionDelete'
            )
    );

    Route::get
            (
            'searchHolidayType', // Url pattern name
            array
        (
        'as' => 'searchHolidayType', // to use return Redirect::route('dashboard');
        'uses' => 'HolidayTypeController@actionSearch'
            )
    );



    Route::get
            (
            'fdownload', // Url pattern name
            array
        (
        'as' => 'fdownload', // to use return Redirect::route('dashboard');
        'uses' => 'PaperAdvertisementController@getDownloadByKey2'
            )
    );

    Route::get
            (
            'pdownload', // Url pattern name
            array
        (
        'as' => 'pdownload', // to use return Redirect::route('dashboard');
        'uses' => 'PaperAdvertisementController@getDownloadByKey'
            )
    );

    Route::any
            (
            'createHolidayType', // Url pattern name
            array
        (
        'as' => 'createHolidayType', // to use return Redirect::route('dashboard');
        'uses' => 'HolidayTypeController@actionCreate'
            )
    );

    Route::any
            (
            'editHolidayType', // Url pattern name
            array
        (
        'as' => 'editHolidayType', // to use return Redirect::route('dashboard');
        'uses' => 'HolidayTypeController@actionEdit'
            )
    );

    Route::get
            (
            'Event', // Url pattern name
            array
        (
        'as' => 'Event', // to use return Redirect::route('dashboard');
        'uses' => 'EventController@viewEvents'
            )
    );

    Route::post
            (
            'deleteEvent', // Url pattern name
            array
        (
        'as' => 'deleteEvent', // to use return Redirect::route('dashboard');
        'uses' => 'EventController@actionDelete'
            )
    );

    Route::get
            (
            'searchEvent', // Url pattern name
            array
        (
        'as' => 'searchEvent', // to use return Redirect::route('dashboard');
        'uses' => 'EventController@actionSearch'
            )
    );

    Route::any
            (
            'createEvent', // Url pattern name
            array
        (
        'as' => 'createEvent', // to use return Redirect::route('dashboard');
        'uses' => 'EventController@actionCreate'
            )
    );

    Route::any
            (
            'editEvent', // Url pattern name
            array
        (
        'as' => 'editEvent', // to use return Redirect::route('dashboard');
        'uses' => 'EventController@actionEdit'
            )
    );
    Route::get
            (
            'coursestarted', // Url pattern name
            array
        (
        'as' => 'coursestarted', // to use return Redirect::route('dashboard');
        'uses' => 'CourseStartedController@viewCoursestarted'
            )
    );
    Route::get
            (
            'findCoursestarted', // Url pattern name
            array
        (
        'as' => 'findCoursestarted', // to use return Redirect::route('dashboard');
        'uses' => 'CoursestartedController@actionSearch'
            )
    );
    Route::any('ajaxCreateCourseCode', array('as' => 'ajaxCreateCourseCode', 'uses' => 'CourseStartedController@ajaxCreateCourseCode'));


    Route::any
            (
            'createCoursestarted', // Url pattern name
            array
        (
        'as' => 'createCoursestarted', // to use return Redirect::route('dashboard');
        'uses' => 'CoursestartedController@actionCreate'
            )
    );
    Route::any
            (
            'editCoursestarted', // Url pattern name
            array
        (
        'as' => 'editCoursestarted', // to use return Redirect::route('dashboard');
        'uses' => 'CourseStartedController@actionEdit'
            )
    );

    Route::get
            (
            'students', // Url pattern name
            array
        (
        'as' => 'students', // to use return Redirect::route('dashboard');
        'uses' => 'StudentController@viewStudents'
            )
    );
Route::get
            (
            'courses', // Url pattern name
            array
        (
        'as' => 'courses', // to use return Redirect::route('dashboard');
        'uses' => 'CourseController@viewCourses'
            )
    );


    Route::get
            (
            'getbyCourse', // Url pattern name
            array
        (
        'as' => 'getbyCourse', // to use return Redirect::route('dashboard');
        'uses' => 'StudentController@getStundetsByCourse'
            )
    );
Route::get
            (
            'register', // Url pattern name
            array
        (
        'as' => 'register', // to use return Redirect::route('dashboard');
        'uses' => 'CourseController@registerCourse'
            )
    );
 Route::get
            (
            'regCourse', // Url pattern name
            array
        (
        'as' => 'regCourse', // to use return Redirect::route('dashboard');
        'uses' => 'CourseController@regCourse'
            )
    );

 Route::get
            (
            'test', // Url pattern name
            array
        (
        'as' => 'test', // to use return Redirect::route('dashboard');
        'uses' => 'HomeController@test'
            )
    );


    Route::get
            (
            'findCourse', // Url pattern name
            array
        (
        'as' => 'findCourse', // to use return Redirect::route('dashboard');
        'uses' => 'CourseController@actionSearch'
            )
    );


    Route::post
            (
            'deleteCourse', // Url pattern name
            array
        (
        'as' => 'deleteCourse', // to use return Redirect::route('dashboard');
        'uses' => 'CourseController@actionDelete'
            )
    );

    Route::get
            (
            'findInstitute', // Url pattern name
            array
        (
        'as' => 'findInstitute', // to use return Redirect::route('dashboard');
        'uses' => 'InstituteController@actionSearch'
            )
    );

//Route::get('findBatch',array('uses'=>'BatchstartController@actionSearch'));
//
//
//Route::get
//(
//	'Batch', // Url pattern name
//	 array
//	 (
//	 	'as'=>'Batch', // to use return Redirect::route('dashboard');
//	 	'uses'=>'BatchstartController@viewbatchstart'
//	 )
//
//
//
//);
//
//
//
//
//
//Route::get
//(
//	'batchstart', // Url pattern name
//	 array
//	 (
//	 	'as'=>'batchstart', // to use return Redirect::route('dashboard');
//	 	'uses'=>'BatchstartController@viewbatchstart'
//	 )
//
//
//
//);
//
//
//
//
//Route::post
//(
//	'deleteBatch', // Url pattern name
//	 array
//	 (
//	 	'as'=>'deleteBatch', // to use return Redirect::route('dashboard');
//	 	'uses'=>'BatchstartController@actionDelete'
//	 )
//
//
//
//);
//
//
//
////Route::any
////(
////	'createBatch', // Url pattern name
////	 array
////	 (
////	 	'as'=>'createBatch', // to use return Redirect::route('dashboard');
////	 	'uses'=>'BatchstartController@actionCreate'
////	 )
////
////
////
////);
//
//
//
//Route::any
//(
//	'editBatch', // Url pattern name
//	 array
//	 (
//	 	'as'=>'editBatch', // to use return Redirect::route('dashboard');
//	 	'uses'=>'BatchstartController@actionEdit'
//	 )
//
//
//
//);
//Auto qualified start
    Route::any('AutoQual_getOlsubject', array('as' => 'AutoQual_getOlsubject', 'uses' => 'ApplicantQualifiedController@getOlsubject'));
    Route::any('AutoQualifiedOLAL', array('as' => 'AutoQualifiedOLAL', 'uses' => 'ApplicantQualifiedController@AutoQualifiedOLAL'));
    Route::any('AutoQualifiedOL', array('as' => 'AutoQualifiedOL', 'uses' => 'ApplicantQualifiedController@AutoQualifiedOL'));
    Route::any('AutoQualified', array('as' => 'AutoQualified', 'uses' => 'ApplicantQualifiedController@AutoQualified'));
    Route::any('SearchAutoQualified', array('as' => 'SearchAutoQualified', 'uses' => 'ApplicantQualifiedController@SearchAutoQualified'));
//Auto qualified end
//ISURU ROUTES START OLSUBJECT
    //ISURU ROUTES START

    Route::any('CTran_getCourseCode', array('as' => 'CTran_getCourseCode', 'uses' => 'CourseTransferController@getCourseCode'));
    Route::any('viewReportType', array('as' => 'viewReportType', 'uses' => 'ReportGenarationController@viewReportType'));
    Route::any('createReportType', array('as' => 'createReportType', 'uses' => 'ReportGenarationController@createReportType'));
    Route::any('editReportType', array('as' => 'editReportType', 'uses' => 'ReportGenarationController@editReportType'));
    Route::any('deleteReportType', array('as' => 'deleteReportType', 'uses' => 'ReportGenarationController@deleteReportType'));
    Route::any('viewSingleReportData', array('as' => 'viewSingleReportData', 'uses' => 'ReportGenarationController@viewSingleReportData'));
    Route::any('getColumnListReport', array('as' => 'getColumnListReport', 'uses' => 'ReportGenarationController@getColumnListReport'));
    //REPORTING TOOL START
    Route::any('viewReportToolHome', array('as' => 'viewReportToolHome', 'uses' => 'ReportGenarationToolController@viewReportToolHome'));
    Route::any('getReportNames', array('as' => 'getReportNames', 'uses' => 'ReportGenarationToolController@getReportNames'));
    Route::any('getReportData', array('as' => 'getReportData', 'uses' => 'ReportGenarationToolController@getReportData'));
    Route::any('getReportColoumnData', array('as' => 'getReportColoumnData', 'uses' => 'ReportGenarationToolController@getReportColoumnData'));
    Route::any('generateReport', array('as' => 'generateReport', 'uses' => 'ReportGenarationToolController@generateReport'));
    Route::any('downloadExcelReport', array('as' => 'downloadExcelReport', 'uses' => 'ReportGenarationToolController@downloadExcelReport'));
    //REPORTING TOOL END
    //ISURU ROUTES END
//*******************ROUTES ****************  
    Route::any('DownloadCourseTimeTable', array('as' => 'DownloadCourseTimeTable', 'uses' => 'TimeTableController@DownloadMyTimeTable'));
//Start  save SalaryScale
    Route::get(
            'saveSalaryScale', array(
        'as' => 'saveSalaryScale',
        'uses' => 'EmploymentController@saveSalaryScale'
            )
    );
//End save SalaryScale
//Start  edit SalaryScale
    Route::get(
            'saveupdateSalaryScale', array(
        'as' => 'saveupdateSalaryScale',
        'uses' => 'EmploymentController@saveupdateSalaryScale'
            )
    );

//End edit SalaryScale
// View EPF History
    Route::any(
            'ViewEPFHistory', array('as' => 'ViewEPFHistory',
        'uses' => 'EPFHistoryController@ViewEPFHistory')
    );
//End EPF History
//Start  edit Module
    Route::get(
            'saveupdateModule', array(
        'as' => 'saveupdateModule',
        'uses' => 'ModuleCourseController@saveupdateModule'
            )
    );

//End edit Module
//Start  Salary Scale
    Route::get(
            'ViewSalaryScale', array(
        'as' => 'ViewSalaryScale',
        'uses' => 'SalaryScaleController@ViewSalaryScale'
            )
    );
    Route::any(
            'deleteSalaryScale', array(
        'as' => 'deleteSalaryScale',
        'uses' => 'SalaryScaleController@deleteSalaryScale'
            )
    );
//End Salary Scale
// Check First Appointment Exist
    Route::any(
            'ChecktransferType', array(
        'as' => 'ChecktransferType',
        'uses' => 'PromotionController@ChecktransferType'
            )
    );
//End First Appointment Exist

    Route::any(
            'promotionExist', // Url pattern name
            array(
        'as' => 'promotionExist', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@promotionExist'
            )
    );
//Changes in Un Registered Applicant
    Route::any(
            'applicantUnRegistered', array('as' => 'applicantUnRegistered',
        'uses' => 'ScanController@applicantUnRegisteredHome')
    );
    Route::any(
            'getCourseListCodeCenterWise', array('as' => 'getCourseListCodeCenterWise',
        'uses' => 'ScanController@getCourseListCodeCenterWise')
    );
    Route::any(
            'getCourseListCodeApplicantQualifyScan', array('as' => 'getCourseListCodeApplicantQualifyScan',
        'uses' => 'ScanController@getCourseListCodeApplicantQualifyScan')
    );
    Route::any(
            'getYearApplicantQualifyScan', array('as' => 'getYearApplicantQualifyScan',
        'uses' => 'ScanController@getYearApplicantQualifyScan')
    );
    Route::any(
            'viewApplicantListUnRegistered', array('as' => 'viewApplicantListUnRegistered',
        'uses' => 'ScanController@viewApplicantListUnRegistered')
    );
    Route::any(
            'exceldownloadUnRegApp', array('as' => 'exceldownloadUnRegApp',
        'uses' => 'ScanController@exceldownloadUnRegApp')
    );
//End Changes in Un Registered Applicant
//Route::any('applicantUnRegistered', array('as'=>'applicantUnRegistered', 'uses'=>'ScanController@applicantUnRegisteredHome'));
//start course details
    Route::any('editCourseDetails', array('as' => 'editCourseDetails', 'uses' => 'CourseDetailsController@editCourseDetails'));
    Route::any('deleteCourseDetails', array('as' => 'deleteCourseDetails', 'uses' => 'CourseDetailsController@deleteCourseDetails'));
    Route::any('viewCourseDetails', array('as' => 'viewCourseDetails', 'uses' => 'CourseDetailsController@viewCourseDetails'));
    Route::any('createCourseDetails', array('as' => 'createCourseDetails', 'uses' => 'CourseDetailsController@createCourseDetails'));
//end course details
// Start Course Started 
    Route::any('deleteCoursestarted', array('as' => 'deleteCoursestarted', 'uses' => 'CourseStartedController@deleteCoursestarted'));
    Route::any('viewCourseStarted', array('as' => 'viewCourseStarted', 'uses' => 'CourseStartedController@viewCourseStarted'));
    Route::any('ajaxCreateCourseCode', array('as' => 'ajaxCreateCourseCode', 'uses' => 'CourseStartedController@ajaxCreateCourseCode'));
    Route::any('createCourseStarted', array('as' => 'createCourseStarted', 'uses' => 'CourseStartedController@createCourseStarted'));
// end Course Started
	// start course Year Plan
	Route::any('ConfirmCourseYearPlanFirstPage',array('as'=>'ConfirmCourseYearPlanFirstPage','uses'=>'courseYearPlanController@ConfirmCourseYearPlanFirstPage'));
	Route::any('ajaxGetFeePartFull',array('as'=>'ajaxGetFeePartFull','uses'=>'courseYearPlanController@ajaxGetFeePartFull'));
	Route::any('ConfirmCourseYearPlan',array('as'=>'ConfirmCourseYearPlan','uses'=>'courseYearPlanController@ConfirmCourseYearPlan'));
	Route::any('editCourseYearPlan',array('as'=>'editCourseYearPlan','uses'=>'courseYearPlanController@editCourseYearPlan'));
	Route::any('CreateCourseYearPlanOne',array('as'=>'CreateCourseYearPlanOne','uses'=>'courseYearPlanController@CreateCourseYearPlanOne'));
	Route::any('CreateCourseYearPlan',array('as'=>'CreateCourseYearPlan','uses'=>'courseYearPlanController@CreateCourseYearPlan'));
	Route::any('CreateCourseYearPlan2',array('as'=>'CreateCourseYearPlan2','uses'=>'courseYearPlanController@CreateCourseYearPlan2'));
	Route::any('ajaxCheckedValues',array('as'=>'ajaxCheckedValues','uses'=>'courseYearPlanController@ajaxCheckedValues'));
	Route::any('viewCourseYearPlan',array('as'=>'viewCourseYearPlan','uses'=>'courseYearPlanController@viewCourseYearPlan'));
	Route::any('deleteCourseYearPlan',array('as'=>'deleteCourseYearPlan','uses'=>'courseYearPlanController@deleteCourseYearPlan'));
	// end course Year Plan
//instructor time table start
Route::any('ViewInstructorTimeTable', array('as'=>'ViewInstructorTimeTable', 'uses'=>'InstructorTimeTableController@viewEntry'));
Route::any('findInstructorTimeTable', array('as'=>'findInstructorTimeTable', 'uses'=>'InstructorTimeTableController@actionSearch'));
//new
Route::any('DownloadMyTimeTable', array('as'=>'DownloadMyTimeTable', 'uses'=>'InstructorTimeTableController@DownloadMyTimeTable'));
//new
//instructor time table end
//HOD instructor time table start
Route::any('ViewHODInstructorTimeTable', array('as'=>'ViewHODInstructorTimeTable', 'uses'=>'HODInstructorTimeTableController@viewEntry'));
Route::any('findHODInstructorTimeTable', array('as'=>'findHODInstructorTimeTable', 'uses'=>'HODInstructorTimeTableController@actionSearch'));
//new
Route::any('DownloadHODInstructorTimeTable', array('as'=>'DownloadHODInstructorTimeTable', 'uses'=>'HODInstructorTimeTableController@DownloadMyTimeTable'));
//new
//HOD instructor time table end
//Offline Student Attendence
    Route::any
            (
            'ViewOfflineStudentAttendence', // Url pattern name
            array
        (
        'as' => 'ViewOfflineStudentAttendence', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@OfflineStudentAttendence'
            )
    );
    Route::any
            (
            'CreateOfflineStudentAttendence', // Url pattern name
            array
        (
        'as' => 'CreateOfflineStudentAttendence', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@actionCreate'
            )
    );
    Route::any
            (
            'getModules', // Url pattern name
            array
        (
        'as' => 'getModules', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@modules'
            )
    );
    Route::any
            (
            'getStudents1', // Url pattern name
            array
        (
        'as' => 'getStudents1', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@getStudents1'
            )
    );

    Route::any
            (
            'getmodulsajax', // Url pattern name
            array
        (
        'as' => 'getmodulsajax', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@getmodulsajax'
            )
    );

    Route::any
            (
            'searchOfflineStudentsAttendence', // Url pattern name
            array
        (
        'as' => 'searchOfflineStudentsAttendence', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@actionSearch'
            )
    );

    Route::any
            (
            'deleteOfflineStudentsAttendence', // Url pattern name
            array
        (
        'as' => 'deleteOfflineStudentsAttendence', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@actionDelete'
            )
    );
    Route::any
            (
            'editOfflineStudentsAttendence', // Url pattern name
            array
        (
        'as' => 'editOfflineStudentsAttendence', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@actionEditStudent'
            )
    );
    Route::any
            (
            'getToSlot', // Url pattern name
            array
        (
        'as' => 'getToSlot', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@getToSlot'
            )
    );
    Route::any
            (
            'GetModuleInstructor', // Url pattern name
            array
        (
        'as' => 'GetModuleInstructor', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@GetModuleInstructor'
            )
    );
    Route::any
            (
            'editStudentsAttendence', // Url pattern name
            array
        (
        'as' => 'editStudentsAttendence', // to use return Redirect::route('dashboard');
        'uses' => 'OfflineStudentAttendenceController@actionEdit'
            )
    );



//offline Student Attendence
//Time Slot start
    Route::any
            (
            'ViewTimeSlot', // Url pattern name
            array
        (
        'as' => 'ViewTimeSlot', // to use return Redirect::route('dashboard');
        'uses' => 'TimeSlotController@viewEntry'
            )
    );
    Route::any
            (
            'createSlot', // Url pattern name
            array
        (
        'as' => 'createSlot', // to use return Redirect::route('dashboard');
        'uses' => 'TimeSlotController@actionCreate'
            )
    );
    Route::any
            (
            'deleteSlot', // Url pattern name
            array
        (
        'as' => 'deleteSlot', // to use return Redirect::route('dashboard');
        'uses' => 'TimeSlotController@actionDelete'
            )
    );
    Route::any
            (
            'editSlot', // Url pattern name
            array
        (
        'as' => 'editSlot', // to use return Redirect::route('dashboard');
        'uses' => 'TimeSlotController@actionEdit'
            )
    );
Route::any('ajaxGetattachedCenter', array('as' => 'ajaxGetattachedCenter', 'uses' => 'courseYearPlanController@ajaxGetattachedCenter'));
//Time Slot End
//time table start
    Route::any
            (
            'ViewTimeTable', // Url pattern name
            array
        (
        'as' => 'ViewTimeTable', // to use return Redirect::route('dashboard');
        'uses' => 'TimeTableController@viewEntry'
            )
    );
    Route::any
            (
            'createTimeTable', // Url pattern name
            array
        (
        'as' => 'createTimeTable', // to use return Redirect::route('dashboard');
        'uses' => 'TimeTableController@actionCreate'
            )
    );
    Route::any
            (
            'TimeTableModule', // Url pattern name
            array
        (
        'as' => 'TimeTableModule', // to use return Redirect::route('dashboard');
        'uses' => 'TimeTableController@modules'
            )
    );
    Route::any
            (
            'findTimeTable', // Url pattern name
            array
        (
        'as' => 'findTimeTable', // to use return Redirect::route('dashboard');
        'uses' => 'TimeTableController@actionSearch'
            )
    );
    Route::any
            (
            'deleteTimeTable', // Url pattern name
            array
        (
        'as' => 'deleteTimeTable', // to use return Redirect::route('dashboard');
        'uses' => 'TimeTableController@actionDelete'
            )
    );
    Route::any
            (
            'editTimeTable', // Url pattern name
            array
        (
        'as' => 'editTimeTable', // to use return Redirect::route('dashboard');
        'uses' => 'TimeTableController@actionEdit'
            )
    );
    Route::any
            (
            'GetSlotView', // Url pattern name
            array
        (
        'as' => 'GetSlotView', // to use return Redirect::route('dashboard');
        'uses' => 'TimeTableController@GetGroupView'
            )
    );



//time table end
//Start Department
    Route::get
            (
            'department', // Url pattern name 
            array
        (
        'as' => 'department', // to use return Redirect::route('dashboard');
        'uses' => 'DepartmentController@viewDepartment'
            )
    );
    Route::any
            (
            'createDepartment', // Url pattern name 
            array
        (
        'as' => 'createDepartment', // to use return Redirect::route('dashboard');
        'uses' => 'DepartmentController@actionCreate'
            )
    );
    Route::get
            (
            'findDepartment', // Url pattern name 
            array
        (
        'as' => 'findDepartment', // to use return Redirect::route('dashboard');
        'uses' => 'DepartmentController@actionSearch'
            )
    );
    Route::any
            (
            'editDepartment', array
        (
        'as' => 'editDepartment', // to use return Redirect::route('dashboard');
        'uses' => 'DepartmentController@actionEdit'
            )
    );

    Route::post
            (
            'deleteDepartment', // Url pattern name 
            array
        (
        'as' => 'deleteDepartment', // to use return Redirect::route('dashboard');
        'uses' => 'DepartmentController@actionDelete'
            )
    );
//End Department
//start Trainee
    Route::any
            (
            'loadApplicantView', // Url pattern name
            array
        (
        'as' => 'loadApplicantView', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@loadapplicantView'
            )
    );
    //end Trainee
    // Start TraineeEmployment
    Route::any('viewTraineeEmployment', array('as' => 'viewTraineeEmployment', 'uses' => 'CheckListController@viewTraineeEmployment'));
    Route::any('editTraineeEmployment', array('as' => 'editTraineeEmployment', 'uses' => 'CheckListController@editTraineeEmployment'));
    Route::any('createTraineeEmployment', array('as' => 'createTraineeEmployment', 'uses' => 'CheckListController@createTraineeEmployment'));
    // end TraineeEmployment
// start Accredit
    //start report 
    Route::any('CourseAccreditationReportExecl', array('as' => 'CourseAccreditationReportExecl', 'uses' => 'CourseAccreditationController@CourseAccreditationReportExecl'));
    Route::any('ReportExpiredCourseList', array('as' => 'ReportExpiredCourseList', 'uses' => 'CourseAccreditationController@ReportExpiredCourseList'));
    Route::any('ReportActiveCourseList', array('as' => 'ReportActiveCourseList', 'uses' => 'CourseAccreditationController@ReportActiveCourseList'));
    //end report
    Route::any('ViewAccreditation', array('as' => 'ViewAccreditation', 'uses' => 'CourseAccreditationController@ViewAccreditation'));
    Route::any('ConformAccreditation', array('as' => 'ConformAccreditation', 'uses' => 'CourseAccreditationController@ConformAccreditation'));
    Route::any('ViewAccreditAssessed', array('as' => 'ViewAccreditAssessed', 'uses' => 'CourseAccreditationController@ViewAccreditAssessed'));
    Route::any('EditAccreditAssessed', array('as' => 'EditAccreditAssessed', 'uses' => 'CourseAccreditationController@EditAccreditAssessed'));
    Route::any('ViewAccreditRequest', array('as' => 'ViewAccreditRequest', 'uses' => 'CourseAccreditationController@ViewAccreditRequest'));
    Route::any('CreateAccreditRequest', array('as' => 'CreateAccreditRequest', 'uses' => 'CourseAccreditationController@CreateAccreditRequest'));
    Route::any('EditAccreditRequest', array('as' => 'EditAccreditRequest', 'uses' => 'CourseAccreditationController@EditAccreditRequest'));
    // end Accredit
//AppProgressReport End

    Route::any(
            'AppAjaxLoadOrga', array(
        'as' => 'AppAjaxLoadOrga',
        'uses' => 'AppProgressReportController@AppAjaxLoadOrga'
            )
    );

    Route::any(
            'AppAjaxLoadCLC', array(
        'as' => 'AppAjaxLoadCLC',
        'uses' => 'AppProgressReportController@AppAjaxLoadCLC'
            )
    );

    Route::any(
            'DownloadAppProgressReport', array(
        'as' => 'DownloadAppProgressReport',
        'uses' => 'AppProgressReportController@DownloadAppProgressReport'
            )
    );

    Route::any(
            'ViewAppProgressReport', array(
        'as' => 'ViewAppProgressReport',
        'uses' => 'AppProgressReportController@ViewAppProgressReport'
            )
    );

//AppProgressReport End
    //start check List
    Route::any('viewCheckList', array('as' => 'viewCheckList', 'uses' => 'CheckListController@viewCheckList'));
    Route::any('deleteCheckList', array('as' => 'deleteCheckList', 'uses' => 'CheckListController@deleteCheckList'));
    Route::any('editCheckList', array('as' => 'editCheckList', 'uses' => 'CheckListController@editCheckList'));
    Route::any('createCheckList', array('as' => 'createCheckList', 'uses' => 'CheckListController@createCheckList'));
    Route::any('createCheckListPage2', array('as' => 'createCheckListPage2', 'uses' => 'CheckListController@createCheckListPage2'));
//end check List
//Start Get Module Name
    Route::any(
            'getModuleName', array(
        'as' => 'getModuleName', // to use return Redirect::route('dashboard');
        'uses' => 'ModuleCourseController@getModuleNameAjax'
            )
    );
//Start Get Module Name
//Start Get Module Id
    Route::any(
            'getModuleId', array(
        'as' => 'getModuleId', // to use return Redirect::route('dashboard');
        'uses' => 'ModuleCourseController@getModuleIdAjax'
            )
    );
//Start Get Module Id
//Start A/L Subject
    Route::get
            (
            'viewALSubject', // Url pattern name
            array
        (
        'as' => 'viewALSubject', // to use return Redirect::route('dashboard');
        'uses' => 'ALSubjectController@viewALSubject'
            )
    );
    Route::any
            (
            'searchALSubject', // Url pattern name
            array
        (
        'as' => 'searchALSubject', // to use return Redirect::route('dashboard');
        'uses' => 'ALSubjectController@actionSearch'
            )
    );
    Route::any
            (
            'deleteALSubject', // Url pattern name
            array
        (
        'as' => 'deleteALSubject', // to use return Redirect::route('dashboard');
        'uses' => 'ALSubjectController@actionDelete'
            )
    );
    Route::any
            (
            'editALSubject', // Url pattern name
            array
        (
        'as' => 'editALSubject', // to use return Redirect::route('dashboard');
        'uses' => 'ALSubjectController@actionEdit'
            )
    );
    Route::any
            (
            'createALSubject', // Url pattern name
            array
        (
        'as' => 'createALSubject', // to use return Redirect::route('dashboard');
        'uses' => 'ALSubjectController@actionCreate'
            )
    );
    Route::any
            (
            'getALSubject', // Url pattern name
            array
        (
        'as' => 'getALSubject', // to use return Redirect::route('dashboard');
        'uses' => 'ALSubjectController@viewAL'
            )
    );
//End A/L Subject

    Route::get(
            'OlSubjects', array(
        'as' => 'OlSubjects',
        'uses' => 'OLSubjectController@viewOLSubject'
            )
    );

    Route::get(
            'findOLSubject', array(
        'as' => 'findOLSubject',
        'uses' => 'OLSubjectController@searchSubject'
            )
    );

    Route::any(
            'addOLSubject', array(
        'as' => 'addOLSubject',
        'uses' => 'OLSubjectController@addSubject'
            )
    );

    Route::any(
            'EditOLSubject', array(
        'as' => 'EditOLSubject',
        'uses' => 'OLSubjectController@editSubject'
            )
    );

    Route::get(
            'DeleteOLSubject', array(
        'uses' => 'OLSubjectController@deleteSubject'
            )
    );
//ISURU ROUTES END OLSUBJECT
//ISURU ROUTES START OLRESULT
    Route::any(
            'OLResultHome', array(
        'as' => 'OLResultHome',
        'uses' => 'OLResultController@viewOLResultPage'
            )
    );

    Route::post(
            'addOLResult', array(
        'as' => 'addOLResult',
        'uses' => 'OLResultController@addOLResult'
            )
    );

    Route::any(
            'editOLResult', array(
        'as' => 'editOLResult',
        'uses' => 'OLResultController@editOLResult'
            )
    );

    Route::get(
            'DeleteOLResult', array(
        'uses' => 'OLResultController@deleteOLResult'
            )
    );

    Route::get(
            'viewOLResult', array(
        'as' => 'viewOLResult',
        'uses' => 'OLResultController@viewOLResult'
            )
    );
//ISURU ROUTES END OLRESULT
//SUHADA ROUTES START
//Isuru ROUTES START
    Route::any(
            'OLResultHome', array(
        'as' => 'OLResultHome',
        'uses' => 'OLResultController@viewOLResultPage'
            )
    );

    Route::any(
            'addOLResult', array(
        'as' => 'addOLResult',
        'uses' => 'OLResultController@addOLResult'
            )
    );

    Route::get(
            'DeleteOLResult', array(
        'uses' => 'OLResultController@deleteOLResult'
            )
    );

    Route::get(
            'viewOLResult', array(
        'as' => 'viewOLResult',
        'uses' => 'OLResultController@viewOLResult'
            )
    );
//Isuru ROUTES END
//Isuru ROUTES START-Attendance
    Route::get(
            'EventAttendanceHome', array(
        'as' => 'EventAttendanceHome',
        'uses' => 'eventAttendanceController@viewEventAttendancePage'
            )
    );

    Route::any(
            'addEventAttendance', array(
        'as' => 'addEventAttendance',
        'uses' => 'eventAttendanceController@editAttendance'
            )
    );

    Route::get(
            'viewEventAttendance', array(
        'as' => 'viewEventAttendance',
        'uses' => 'eventAttendanceController@viewAttendance'
            )
    );
//Isuru ROUTES end-Attendance
//SUHADA ROUTES END
//Event Planned Start

    Route::get
            (
            'eventplanned', // Url pattern name
            array
        (
        'as' => 'eventplanned', // to use return Redirect::route('dashboard');
        'uses' => 'EventplannedController@viewEventplanned'
            )
    );
    Route::any
            (
            'createEventplanned', // Url pattern name
            array
        (
        'as' => 'createEventplanned', // to use return Redirect::route('dashboard');
        'uses' => 'EventplannedController@actionCreate'
            )
    );
    Route::get
            (
            'findEventplanned', // Url pattern name
            array
        (
        'as' => 'findEventplanned', // to use return Redirect::route('dashboard');
        'uses' => 'EventplannedController@actionSearch'
            )
    );
    Route::any
            (
            'editEventplanned', array
        (
        'as' => 'editEventplanned', // to use return Redirect::route('dashboard');
        'uses' => 'EventplannedController@actionEdit'
            )
    );
    Route::post
            (
            'deleteEventplanned', // Url pattern name
            array
        (
        'as' => 'deleteEventplanned', // to use return Redirect::route('dashboard');
        'uses' => 'EventplannedController@actionDelete'
            )
    );
    Route::any
            (
            'viewApplicantlist', array
        (
        'as' => 'viewApplicantlist', // to use return Redirect::route('dashboard');
        'uses' => 'EventplannedController@viewApplicantlist'
            )
    );
    Route::get('downloadpdf', array
        (
        'as' => 'downloadpdf',
        'uses' => 'EventplannedController@getDownloadpdf'
            )
    );
    Route::get('downloadxl', array
        (
        'as' => 'downloadxl',
        'uses' => 'EventplannedController@getDownloadxl'
            )
    );

    Route::get
            (
            'clcLoadajax', array
        (
        'as' => 'clcLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'EventplannedController@clcAjax'
            )
    );
//End Event Planned

    Route::get
            (
            'Results', // Url pattern name
            array
        (
        'as' => 'Results', // to use return Redirect::route('dashboard');
        'uses' => 'ResultsController@viewResults'
            )
    );

    Route::any
            (
            'deleteResults', // Url pattern name
            array
        (
        'as' => 'deleteResults', // to use return Redirect::route('dashboard');
        'uses' => 'ResultsController@actionDelete'
            )
    );

    Route::get
            (
            'searchResults', // Url pattern name
            array
        (
        'as' => 'searchResults', // to use return Redirect::route('dashboard');
        'uses' => 'ResultsController@actionSearch'
            )
    );


    Route::get('e', function() {


        $courses = EntryExamResults::all()->first();

        echo $courses->getApplicent;
    });

    Route::any
            (
            'createResult', // Url pattern name
            array
        (
        'as' => 'createResult', // to use return Redirect::route('dashboard');
        'uses' => 'ResultsController@actionCreate'
            )
    );

    Route::any
            (
            'editResult', // Url pattern name
            array
        (
        'as' => 'editResult', // to use return Redirect::route('dashboard');
        'uses' => 'ResultsController@actionEdit'
            )
    );

    Route::get
            (
            'viewResults', // Url pattern name
            array
        (
        'as' => 'viewResults', // to use return Redirect::route('dashboard');
        'uses' => 'ResultsController@viewResult'
            )
    );
//Kalhara Routes
    Route::any
            (
            'createApplicant1', // Url pattern name
            array
        (
        'as' => 'createApplicant1', // to use return Redirect::route('dashboard');
        'uses' => 'Applicant1Controller@actionCreate'
            )
    );

    Route::any
            (
            'listApplicant1', // Url pattern name
            array
        (
        'as' => 'listApplicant1', // to use return Redirect::route('dashboard');
        'uses' => 'Applicant1Controller@actionListview'
            )
    );
    Route::any(
            'OLResultHome1', array(
        'as' => 'OLResultHome1',
        'uses' => 'OLResult1Controller@viewOLResultPage'
            )
    );

    Route::any(
            'addOLResult1', array(
        'as' => 'addOLResult1',
        'uses' => 'OLResult1Controller@addOLResult'
            )
    );
    Route::get('downloadOAD', array
        (
        'as' => 'downloadOAD',
        'uses' => 'Applicant1Controller@getDownload'
            )
    );

//KC
    Route::get
            (
            'Dropout', // Url pattern name
            array
        (
        'as' => 'Dropout', // to use return Redirect::route('dashboard');
        'uses' => 'DropoutController@viewDropouts'
            )
    );

    Route::any
            (
            'deleteDropout', // Url pattern name
            array
        (
        'as' => 'deleteDropout', // to use return Redirect::route('dashboard');
        'uses' => 'DropoutController@actionDelete'
            )
    );

    Route::any
            (
            'searchDropout', // Url pattern name
            array
        (
        'as' => 'searchDropout', // to use return Redirect::route('dashboard');
        'uses' => 'DropoutController@actionSearch'
            )
    );
//KC
//INTERVIEW START
    Route::get
            (
            'interview', // Url pattern name
            array
        (
        'as' => 'interview', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@viewInterview'
            )
    );
    Route::any
            (
            'createInterview', // Url pattern name
            array
        (
        'as' => 'createInterview', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@actionCreate'
            )
    );
    Route::get
            (
            'findInterview', // Url pattern name
            array
        (
        'as' => 'findInterview', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@actionSearch'
            )
    );
    Route::any
            (
            'editInterview', array
        (
        'as' => 'editInterview', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@actionEdit'
            )
    );
    Route::post
            (
            'deleteInterview', // Url pattern name
            array
        (
        'as' => 'deleteInterview', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@actionDelete'
            )
    );
    Route::any('downloadInterview', array
        (
        'as' => 'downloadInterview',
        'uses' => 'InterviewController@getDownloadpdf'
            )
    );

    Route::any
            (
            'viewlist', array
        (
        'as' => 'viewlist', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@viewList'
            )
    );
    Route::any
            (
            'assignApplicants', array
        (
        'as' => 'assignApplicants', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@assign'
            )
    );
    Route::any
            (
            'editAssign', array
        (
        'as' => 'editAssign', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@assignEdit'
            )
    );
    Route::get
            (
            'indexLoadajax', array
        (
        'as' => 'indexLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@indexAjax'
            )
    );
    Route::post
            (
            'deleteInterviewApplicant', // Url pattern name
            array
        (
        'as' => 'deleteInterviewApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'InterviewController@deleteApplicant'
            )
    );
//END INTERVIEW
//Scan Applicant
    Route::any
            (
            'scan', array
        (
        'as' => 'scan', // to use return Redirect::route('dashboard');
        'uses' => 'ScanController@viewScan'
            )
    );
    Route::get
            (
            'findScan', // Url pattern name
            array
        (
        'as' => 'findScan', // to use return Redirect::route('dashboard');
        'uses' => 'ScanController@actionSearch'
            )
    );
    Route::get
            (
            'findScann', // Url pattern name
            array
        (
        'as' => 'findScann', // to use return Redirect::route('dashboard');
        'uses' => 'ScanController@actionFind'
            )
    );
    Route::any
            ('viewemail', array
        (
        'as' => 'viewemail',
        'uses' => 'ScanController@viewMail'
            )
    );
    Route::any
            ('sendemail', array
        (
        'as' => 'sendemail',
        'uses' => 'ScanController@sendMail'
            )
    );
    Route::post
            (
            'deleteScan', // Url pattern name
            array
        (
        'as' => 'deleteScan', // to use return Redirect::route('dashboard');
        'uses' => 'ScanController@actionDelete'
            )
    );


//End Scan Applicant
//Kalhara Routes End
//EventPlanned route
    //Sanduni Routes Start
    Route::any
            (
            'searchQualification', // Url pattern name
            array
        (
        'as' => 'searchQualification', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationController@viewQualification'
            )
    );


    Route::get
            (
            'findQualification', // Url pattern name
            array
        (
        'as' => 'findQualification', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationController@actionSearch'
            )
    );

    Route::any
            (
            'createQualification', // Url pattern name
            array
        (
        'as' => 'createQualification', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationController@actionCreate'
            )
    );

    Route::post
            (
            'deleteQualification', // Url pattern name
            array
        (
        'as' => 'deleteQualification', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationController@actionDelete'
            )
    );

    Route::any
            (
            'editQualification', // Url pattern name
            array
        (
        'as' => 'editQualification', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationController@actionEdit'
            )
    );

    Route::any
            (
            'searchEntry', // Url pattern name
            array
        (
        'as' => 'searchEntry', // to use return Redirect::route('dashboard');
        'uses' => 'EntryController@viewEntry'
            )
    );
    Route::get
            (
            'findEntry', // Url pattern name
            array
        (
        'as' => 'findEntry', // to use return Redirect::route('dashboard');
        'uses' => 'EntryController@actionSearch'
            )
    );
    Route::any
            (
            'createEntry', // Url pattern name
            array
        (
        'as' => 'createEntry', // to use return Redirect::route('dashboard');
        'uses' => 'EntryController@actionCreate'
            )
    );

    Route::any
            (
            'editEntry', // Url pattern name
            array
        (
        'as' => 'editEntry', // to use return Redirect::route('dashboard');
        'uses' => 'EntryController@actionEdit'
            )
    );

    Route::post
            (
            'deleteEntry', // Url pattern name
            array
        (
        'as' => 'deleteEntry', // to use return Redirect::route('dashboard');
        'uses' => 'EntryController@actionDelete'
            )
    );

    Route::any
            (
            'searchInstructor', // Url pattern name
            array
        (
        'as' => 'searchInstructor', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@viewInstructor'
            )
    );
    Route::get
            (
            'findInstructor', // Url pattern name
            array
        (
        'as' => 'findInstructor', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@actionSearch'
            )
    );

    Route::get
            (
            'findInstructorc', // Url pattern name
            array
        (
        'as' => 'findInstructorc', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@actionSearchD'
            )
    );


    Route::any
            (
            'createInstructor', // Url pattern name
            array
        (
        'as' => 'createInstructor', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@actionCreate'
            )
    );
    Route::post
            (
            'deleteInstructor', // Url pattern name
            array
        (
        'as' => 'deleteInstructor', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@actionDelete'
            )
    );

    Route::any
            (
            'editInstructor', // Url pattern name
            array
        (
        'as' => 'editInstructor', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@actionEdit'
            )
    );


    Route::get('check', function() {
        $org = Organisation::find(User::find(1)->organisationId)->first();

        echo $org->OrgaName;
    });
    Route::get('getbatchcode', function() {

        //echo json_encode( Batchstart::where('Deleted','!=',1)->where('Completed','!=','Yes')->where('InstituteId','=',1)->where('CourseCode','=',Input::get('corseid'))->get());

        $k = User::getSysUser()->instituteId;
        $l = User::getSysUser()->organisationId;
        $result = (Batchstart::where('Deleted', '!=', 1)->where('Completed', '!=', 'Yes')->where('InstituteId', '=', $k)->where('CourseCode', '=', Input::get('corseid'))->get());





        return json_encode($result->toArray());
    });
    Route::get('getempcode', function() {

        //echo json_encode( Batchstart::where('Deleted','!=',1)->where('Completed','!=','Yes')->where('InstituteId','=',1)->where('CourseCode','=',Input::get('corseid'))->get());
        // $k = User::getSysUser()->instituteId;
        //$l =  User::getSysUser()->organisationId;
        $n = Input::get('empid');
        $i = Input::get('orgid');
        $res = DB::select(DB::raw("SELECT employee.id ,employee.Name  FROM employmentcode,promotion,employee WHERE employmentcode.EmpCode=promotion.NewPost AND employmentcode.id ='" . $n . "' AND promotion.Emp_ID=employee.id AND promotion.ToOrganisation='" . $i . "' AND employee.Deleted!='1'"));

        return json_encode($res);




        //echo json_encode($res);
    });

    Route::any
            (
            'sasa', // Url pattern name
            array
        (
        'as' => 'sasa', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@actionCreate1'
            )
    );








    //Sanduni Routes End
//Promotion

    Route::get
            (
            'promotion', // Url pattern name
            array
        (
        'as' => 'promotion', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@viewPromotion'
            )
    );
    Route::get
            (
            'visitingEmpView', // Url pattern name
            array
        (
        'as' => 'visitingEmpView', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@viewVisitEmp'
            )
    );

    Route::any
            (
            'createPromotion', array
        (
        'as' => 'createPromotion', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@actionCreate'
            )
    );
    Route::get
            (
            'findPromotion', // Url pattern name
            array
        (
        'as' => 'findPromotion', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@actionSearch'
            )
    );
    Route::get
            (
            'findVisitPromotion', // Url pattern name
            array
        (
        'as' => 'findVisitPromotion', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@SearchVisitEmp'
            )
    );
    Route::post
            (
            'deletePromotion', // Url pattern name
            array
        (
        'as' => 'deletePromotion', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@actionDelete'
            )
    );
    Route::any
            (
            'createPromotion', // Url pattern name
            array
        (
        'as' => 'createPromotion', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@actionCreate'
            )
    );
    Route::any
            (
            'editPromotion', array
        (
        'as' => 'editPromotion', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@Edit'
            )
    );
    Route::get
            (
            'nicLoadajax', array
        (
        'as' => 'nicLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@nicAjax'
            )
    );
    Route::get
            (
            'idLoadajax', array
        (
        'as' => 'idLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@idAjax'
            )
    );
    Route::get
            (
            'promLoadajax', array
        (
        'as' => 'promLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'PromotionController@promoAjax'
            )
    );

//Promotion End
//Kalhara Routes
    Route::any
            (
            'createTrade1', // Url pattern name
            array
        (
        'as' => 'createTrade1', // to use return Redirect::route('dashboard');
        'uses' => 'Trade1Controller@actionCreate'
            )
    );
    Route::get(
            'viewTrades', array(
        'as' => 'viewTrades',
        'uses' => 'Trade1Controller@viewTrades'
            )
    );
    Route::get
            (
            'findTrade1', // Url pattern name
            array
        (
        'as' => 'findTrade1', // to use return Redirect::route('dashboard');
        'uses' => 'Trade1Controller@actionSearch'
            )
    );
    Route::any(
            'deleteTrade1', array(
        'as' => 'deleteTrade1',
        'uses' => 'Trade1Controller@actionDelete'
            )
    );

    Route::any
            (
            'editTrades', // Url pattern name
            array
        (
        'as' => 'editTrades', // to use return Redirect::route('dashboard');
        'uses' => 'Trade1Controller@actionEdit'
            )
    );
//Training Groups
    Route::any
            (
            'createClass', // Url pattern name
            array
        (
        'as' => 'createClass', // to use return Redirect::route('dashboard');
        'uses' => 'TraininggroupController@actioncreate'
            )
    );
    Route::any
            (
            'TrainingGroup', // Url pattern name 
            array
        (
        'as' => 'TrainingGroup', // to use return Redirect::route('dashboard');
        'uses' => 'TraininggroupController@actioncreate'
            )
    );
    Route::get(
            'viewTraininggroup', array(
        'as' => 'viewTraininggroup',
        'uses' => 'TraininggroupController@viewTraininggroups'
            )
    );
    Route::get
            (
            'findTraininggroups', // Url pattern name
            array
        (
        'as' => 'findTraininggroups', // to use return Redirect::route('dashboard');
        'uses' => 'TraininggroupController@actionSearch'
            )
    );
    Route::any(
            'DeleteTraininggroups', array(
        'as' => 'DeleteTraininggroups',
        'uses' => 'TraininggroupController@actionDelete'
            )
    );
    Route::any
            (
            'editTraininggroup', // Url pattern name
            array
        (
        'as' => 'editTraininggroup', // to use return Redirect::route('dashboard');
        'uses' => 'TraininggroupController@actionEdit'
            )
    );
    Route::get('downloadTG', array
        (
        'as' => 'downloadTG',
        'uses' => 'TraininggroupController@getDownload'
            )
    );


    Route::get('getdata', function() {


        //echo json_encode(Course::where('CourseListCode','=',Input::get('listcode')));
        $x = Course::where('CourseListCode', '=', Input::get('listcode'))->first();

        echo json_encode($x->toArray());
    });











// Kalhara Routes End
//QuaOrga
    Route::get
            (
            'quorga', // Url pattern name
            array
        (
        'as' => 'quorga', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationorganisationController@viewQuorga'
            )
    );
    Route::any
            (
            'createQuaorg', // Url pattern name
            array
        (
        'as' => 'createQuaorg', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationorganisationController@actionCreate'
            )
    );
    Route::get
            (
            'findQuorg', // Url pattern name
            array
        (
        'as' => 'findQuorg', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationorganisationController@actionSearch'
            )
    );
    Route::post
            (
            'deleteQuorg', // Url pattern name
            array
        (
        'as' => 'deleteQuorg', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationorganisationController@actionDelete'
            )
    );
    Route::any
            (
            'editQuorg', array
        (
        'as' => 'editQuorg', // to use return Redirect::route('dashboard');
        'uses' => 'QualificationorganisationController@actionEdit'
            )
    );

//EmpQua
    Route::get
            (
            'empqua', // Url pattern name
            array
        (
        'as' => 'empqua', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeequalificationController@viewEmpqua'
            )
    );
    Route::any
            (
            'createEmpqua', // Url pattern name
            array
        (
        'as' => 'createEmpqua', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeequalificationController@actionCreate'
            )
    );
    Route::get
            (
            'findEmpqua', // Url pattern name
            array
        (
        'as' => 'findEmpqua', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeequalificationController@actionSearch'
            )
    );
    Route::post
            (
            'deleteEmpqua', // Url pattern name
            array
        (
        'as' => 'deleteEmpqua', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeequalificationController@actionDelete'
            )
    );
    Route::any
            (
            'editEmpqua', array
        (
        'as' => 'editEmpqua', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeequalificationController@actionEdit'
            )
    );
    Route::get
            (
            'nicEmployeeQua', array
        (
        'as' => 'nicEmployeeQua', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeequalificationController@nicAjax'
            )
    );
//End Empqua
//KC
            Route::any('viewEmployeeDetails', array
        (
        'as' => 'viewEmployeeDetails',
        'uses' => 'employeeProfileController@viewDetails'
            )
    );
    Route::any('editEmpPro', array
        (
        'as' => 'editEmpPro',
        'uses' => 'employeeProfileController@edit'
            )
    );

    Route::get
            (
            'viewEmployee', // Url pattern name
            array
        (
        'as' => 'viewEmployee', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeController@viewEmployees'
            )
    );

    Route::any
            (
            'searchEmployee', // Url pattern name
            array
        (
        'as' => 'searchEmployee', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeController@actionSearch'
            )
    );

    Route::any
            (
            'deleteEmployee', // Url pattern name
            array
        (
        'as' => 'deleteEmployee', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeController@actionDelete'
            )
    );

    Route::any
            (
            'editEmployee', // Url pattern name
            array
        (
        'as' => 'editEmployee', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeController@actionEdit'
            )
    );

    Route::any
            (
            'createEmployee', // Url pattern name
            array
        (
        'as' => 'createEmployee', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeController@actionCreate'
            )
    );

    Route::get
            (
            'Employment', // Url pattern name
            array
        (
        'as' => 'Employment', // to use return Redirect::route('dashboard');
        'uses' => 'EmploymentController@viewEmployment'
            )
    );

    Route::any
            (
            'editEmployment', // Url pattern name
            array
        (
        'as' => 'editEmployment', // to use return Redirect::route('dashboard');
        'uses' => 'EmploymentController@actionEdit'
            )
    );

    Route::any
            (
            'searchEmployment', // Url pattern name
            array
        (
        'as' => 'searchEmployment', // to use return Redirect::route('dashboard');
        'uses' => 'EmploymentController@actionSearch'
            )
    );

    Route::any
            (
            'createEmployment', // Url pattern name
            array
        (
        'as' => 'createEmployment', // to use return Redirect::route('dashboard');
        'uses' => 'EmploymentController@actionCreate'
            )
    );

    Route::any
            (
            'deleteEmployment', // Url pattern name
            array
        (
        'as' => 'deleteEmployment', // to use return Redirect::route('dashboard');
        'uses' => 'EmploymentController@actionDelete'
            )
    );

    Route::get
            (
            'searchR', // Url pattern name
            array
        (
        'as' => 'searchR', // to use return Redirect::route('dashboard');
        'uses' => 'ResultsController@actionSearch1'
            )
    );

//ajaxemployee
    Route::any
            (
            'employeeajax', // Url pattern name
            array
        (
        'as' => 'employeeajax', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeController@nicAjax'
            )
    );


//ajaxemployee
//KC end
//leave routes begin

    Route::get(
            'LeaveHome', array(
        'as' => 'LeaveHome',
        'uses' => 'EmployeeLeaveApplyController@leaveHome'
            )
    );
    Route::any(
            'ApplyLeave', array(
        'as' => 'ApplyLeave',
        'uses' => 'EmployeeLeaveApplyController@applyLeave'
            )
    );

    Route::any(
            'loadApprovePerson', array(
        'as' => 'loadApprovePerson',
        'uses' => 'EmployeeLeaveApplyController@loadAprovePersonList'
            )
    );
    Route::get(
            'approveLeaveHome', array(
        'as' => 'approveLeaveHome',
        'uses' => 'EmployeeLeaveApplyController@approveLeaveHome'
            )
    );
    Route::any(
            'approveLeave', array(
        'as' => 'approveLeave',
        'uses' => 'EmployeeLeaveApplyController@approveLeave'
            )
    );
    Route::any(
            'viewLeave', array(
        'as' => 'viewLeave',
        'uses' => 'EmployeeLeaveApplyController@viewLeave'
            )
    );
    Route::get(
            'cancelLeave', array(
        'uses' => 'EmployeeLeaveApplyController@cancelLeave'
            )
    );
    Route::get(
            'loadTotalLeaveDays', array(
        'as' => 'loadTotalLeaveDays',
        'uses' => 'EmployeeLeaveApplyController@loadTotalLeaveDays'
            )
    );

//employee leave ends
//Isuru ROUTES Employee Attendace
    Route::get(
            'empYearlyReport', array(
        'as' => 'empYearlyReport',
        'uses' => 'MarkAttendanceController@empYearlyReport'
            )
    );
    Route::get(
            'empAttendanceReport', array(
        'as' => 'empAttendanceReport',
        'uses' => 'MarkAttendanceController@empSelectReport'
            )
    );
    Route::get(
            'stdAttendanceReport', array(
        'as' => 'stdAttendanceReport',
        'uses' => 'MarkAttendanceController@stdSelectReport'
            )
    );
    Route::get(
            'employeeMonth', array(
        'as' => 'employeeMonth',
        'uses' => 'MarkAttendanceController@empMonthReport'
            )
    );
    Route::get(
            'allemployeeMonth', array(
        'as' => 'allemployeeMonth',
        'uses' => 'MarkAttendanceController@allEmpMonthReport'
            )
    );
    Route::get(
            'markAttendanceHome', array(
        'as' => 'markAttendanceHome',
        'uses' => 'MarkAttendanceController@stdYearlyReportHome'
            )
    );
    Route::get(
            'stdYearlyReport', array(
        'as' => 'stdYearlyReport',
        'uses' => 'MarkAttendanceController@stdYearlyReport'
            )
    );
    Route::post(
            'markAttendance', array(
        'as' => 'markAttendance',
        'uses' => 'MarkAttendanceController@markAttendance'
            )
    );

    Route::get(
            'back123', array(
        'as' => 'back123',
        'uses' => 'MarkAttendanceController@back'
            )
    );

//Attendace routes ends
//trainee leave starts

    Route::get(
            'StudentLeaveHome', array(
        'as' => 'StudentLeaveHome',
        'uses' => 'TraineeLeaveApplyController@leaveHome'
            )
    );

    Route::any(
            'addStLeave', array(
        'as' => 'addStLeave',
        'uses' => 'TraineeLeaveApplyController@addleave'
            )
    );

    Route::any(
            'batchcodestleave', array(
        'as' => 'batchcodestleave',
        'uses' => 'TraineeLeaveApplyController@batchcodestleave'
            )
    );

    Route::any(
            'studentstleave', array(
        'as' => 'studentstleave',
        'uses' => 'TraineeLeaveApplyController@studentstleave'
            )
    );
    Route::get(
            'approveLeaveHomest', array(
        'as' => 'approveLeaveHomest',
        'uses' => 'TraineeLeaveApplyController@approveLeaveHome'
            )
    );
    Route::any(
            'approveLeavest', array(
        'as' => 'approveLeavest',
        'uses' => 'TraineeLeaveApplyController@approveLeave'
            )
    );
    Route::any(
            'viewLeavest', array(
        'as' => 'viewLeavest',
        'uses' => 'TraineeLeaveApplyController@viewLeave'
            )
    );
    Route::get(
            'cancelLeavest', array(
        'uses' => 'TraineeLeaveApplyController@cancelLeave'
            )
    );
//trainee leave route end
//kalhara routes
    Route::get
            (
            'loadDistrictAjax1', // Url pattern name
            array
        (
        'as' => 'loadDistrictAjax1', // to use return Redirect::route('dashboard');
        'uses' => 'Applicant1Controller@loadDistrictAjax'
            )
    );

    Route::get
            (
            'loadCourseAjax1', // Url pattern name
            array
        (
        'as' => 'loadCourseAjax1', // to use return Redirect::route('dashboard');
        'uses' => 'Applicant1Controller@loadCourseAjax'
            )
    );

//kalhara routes end
//prasanna route start
//Assessment start

    Route::any
            (
            'ConformAssResApprove', // Url pattern name 
            array
        (
        'as' => 'ConformAssResApprove', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@ConformAssResApprove'
            )
    );

    Route::any
            (
            'loadAssResApprove', // Url pattern name 
            array
        (
        'as' => 'loadAssResApprove', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@loadAssResApprove'
            )
    );

    Route::any
            (
            'ApproveAssResView', // Url pattern name 
            array
        (
        'as' => 'ApproveAssResView', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@ApproveAssResView'
            )
    );

    Route::any
            (
            'EditAssRes', // Url pattern name 
            array
        (
        'as' => 'EditAssRes', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@EditAssRes'
            )
    );


    Route::any
            (
            'EditAssessmentResult', // Url pattern name 
            array
        (
        'as' => 'EditAssessmentResult', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@EditAssessmentResult'
            )
    );

    Route::any
            (
            'deleteAssessmentResults', // Url pattern name 
            array
        (
        'as' => 'deleteAssessmentResults', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@DeleteAssResult'
            )
    );

    Route::any
            (
            'loadAssessmentResults', // Url pattern name 
            array
        (
        'as' => 'loadAssessmentResults', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@loadAssessmentResults'
            )
    );

    Route::any
            (
            'AssessmentNameAjax', // Url pattern name 
            array
        (
        'as' => 'AssessmentNameAjax', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@AssessmentNameAjax'
            )
    );

    Route::any
            (
            'viewAssessmentResults', // Url pattern name 
            array
        (
        'as' => 'viewAssessmentResults', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@viewAssessmentResults'
            )
    );
    Route::any
            (
            'traineeValidAjax', // Url pattern name 
            array
        (
        'as' => 'traineeValidAjax', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@traineeValidAjax'
            )
    );

    Route::any
            (
            'AssessmentAjax', // Url pattern name 
            array
        (
        'as' => 'AssessmentAjax', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@assessmentAjax'
            )
    );

    Route::any
            (
            'AssessmentAjaxNCC', // Url pattern name 
            array
        (
        'as' => 'AssessmentAjaxNCC', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@loadCCorBC'
            )
    );

    Route::any
            (
            'Assessment', // Url pattern name 
            array
        (
        'as' => 'Assessment', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@assessmentView'
            )
    );

    Route::any
            (
            'AssessmentCreate', // Url pattern name 
            array
        (
        'as' => 'AssessmentCreate', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@assessmentCreate'
            )
    );

    Route::any
            (
            'TraineeAssCreate', // Url pattern name 
            array
        (
        'as' => 'TraineeAssCreate', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeAssessmentController@TraineeAssCreate'
            )
    );

//Assessment end
//prasanna emp manage start

    Route::any(
            'empTrainingView', array(
        'as' => 'empTrainingView',
        'uses' => 'EmployeeTrainingController@empTraRecView'
            )
    );

    Route::any(
            'empTrainingSearch', array(
        'as' => 'empTrainingSearch',
        'uses' => 'EmployeeTrainingController@empTrainingSearch'
            )
    );

    Route::any(
            'empTraining', array(
        'as' => 'empTraining',
        'uses' => 'EmployeeTrainingController@empTraView'
            )
    );

    Route::any(
            'empTrainingCreate', array(
        'as' => 'empTrainingCreate',
        'uses' => 'EmployeeTrainingController@empTrainingCreate'
            )
    );

    Route::any(
            'empTrainingAjax', array(
        'as' => 'empTrainingAjax',
        'uses' => 'EmployeeTrainingController@empTrainingAjax'
            )
    );
    Route::any(
            'empTrainingAjaxDale', array(
        'as' => 'empTrainingAjaxDale',
        'uses' => 'EmployeeTrainingController@empTrainingAjaxDale'
            )
    );

//prasanna emp manage end
//applicant


    Route::get
            (
            'loadNicAjax', // Url pattern name
            array
        (
        'as' => 'loadNicAjax', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@loadNicAjax'
            )
    );

    Route::get
            (
            'loadDistrictAjax', // Url pattern name
            array
        (
        'as' => 'loadDistrictAjax', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@loadDistrictAjax'
            )
    );

    Route::get
            (
            'loadElectorateAjax', // Url pattern name
            array
        (
        'as' => 'loadElectorateAjax', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@loadElectorateAjax'
            )
    );

    Route::get
            (
            'loadNCCAjax', // Url pattern name
            array
        (
        'as' => 'loadNCCAjax', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@loadNCCAjax'
            )
    );

    Route::any
            (
            'onlineAjaxorga', // Url pattern name
            array
        (
        'as' => 'onlineAjaxorga', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@onlineAjaxorga'
            )
    );

    Route::any
            (
            'onlineAjaxprovince', // Url pattern name
            array
        (
        'as' => 'onlineAjaxprovince', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@onlineAjaxprovince'
            )
    );

    Route::get
            (
            'onlineloadCourseAjax', // Url pattern name
            array
        (
        'as' => 'onlineloadCourseAjax', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@onlineloadCourseAjax'
            )
    );

    Route::any
            (
            'onlineAjaxApplicant', // Url pattern name
            array
        (
        'as' => 'onlineAjaxApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@onlineAjaxApplicant'
            )
    );

    Route::any
            (
            'onlineAjaxncc', // Url pattern name
            array
        (
        'as' => 'onlineAjaxncc', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@onlineAjaxncc'
            )
    );

    Route::get
            (
            'loadCourseAjax', // Url pattern name
            array
        (
        'as' => 'loadCourseAjax', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@loadCourseAjax'
            )
    );

    Route::get
            (
            'applicants', // Url pattern name
            array
        (
        'as' => 'applicants', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@viewApplicant'
            )
    );

    Route::get
            (
            'findApplicant', // Url pattern name
            array
        (
        'as' => 'findApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@actionSearch'
            )
    );
    Route::get
            (
            'searchApplicant', // Url pattern name
            array
        (
        'as' => 'searchApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@listviewSearch'
            )
    );


    Route::post
            (
            'deleteApplicant', // Url pattern name
            array
        (
        'as' => 'deleteApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@actionDelete'
            )
    );


    Route::any
            (
            'createApplicant', // Url pattern name
            array
        (
        'as' => 'createApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@actionCreate'
            )
    );

    Route::any
            (
            'listApplicant', // Url pattern name
            array
        (
        'as' => 'listApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@actionListview'
            )
    );

    Route::any
            (
            'ListApplicantdownload', // Url pattern name
            array
        (
        'as' => 'ListApplicantdownload', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@downloadapplicant'
            )
    );

    Route::any
            (
            'ListApplicantdownloadexcel', // Url pattern name
            array
        (
        'as' => 'ListApplicantdownloadexcel', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@exceldownload'
            )
    );

    Route::any
            (
            'editApplicant', // Url pattern name
            array
        (
        'as' => 'editApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@actionEdit'
            )
    );

    Route::any
            (
            'editApplicantView', // Url pattern name 
            array
        (
        'as' => 'editApplicantView', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@actionEditview'
            )
    );


    Route::get('ajaxdale', array('uses' => 'ApplicantController@getCount'));

// student

    Route::any
            (
            'StudentRegistration', // Url pattern name
            array
        (
        'as' => 'StudentRegistration', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@actionCreate'
            )
    );
    Route::any
            (
            'StudentRegistrationView', // Url pattern name
            array
        (
        'as' => 'StudentRegistrationView', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@actionView'
            )
    );

    Route::get
            (
            'loadbatchcode', // Url pattern name
            array
        (
        'as' => 'loadbatchcode', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@getbatchcode'
            )
    );
    Route::get
            (
            'loadbatchcodeview', // Url pattern name
            array
        (
        'as' => 'loadbatchcodeview', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@getbatchcodeview'
            )
    );

    Route::post
            (
            'loadApplicant', // Url pattern name
            array
        (
        'as' => 'loadApplicant', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@loadapplicant'
            )
    );

    Route::any
            (
            'loadApplicantView', // Url pattern name
            array
        (
        'as' => 'loadApplicantView', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@loadapplicantView'
            )
    );

    Route::post
            (
            'deleteStudent', // Url pattern name
            array
        (
        'as' => 'deleteStudent', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@actionDelete'
            )
    );

    Route::any
            (
            'regTrainee', // Url pattern name
            array
        (
        'as' => 'regTrainee', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@createTrainee'
            )
    );

//applitutetest

    Route::any
            (
            'ApplituteTestRecords', // Url pattern name
            array
        (
        'as' => 'ApplituteTestRecords', // to use return Redirect::route('dashboard');
        'uses' => 'ApplitutetestController@actionAddedRecords'
            )
    );
    Route::any
            (
            'LoadApplituteTestRecords', // Url pattern name
            array
        (
        'as' => 'LoadApplituteTestRecords', // to use return Redirect::route('dashboard');
        'uses' => 'ApplitutetestController@actionLoadRecords'
            )
    );
    Route::any
            (
            'addApplituteResults', // Url pattern name
            array
        (
        'as' => 'addApplituteResults', // to use return Redirect::route('dashboard');
        'uses' => 'ApplitutetestController@addResults'
            )
    );
    Route::any
            (
            'addEditApplituteResults', // Url pattern name
            array
        (
        'as' => 'addEditApplituteResults', // to use return Redirect::route('dashboard');
        'uses' => 'ApplitutetestController@addEditResults'
            )
    );
    Route::any
            (
            'editApplituteResults', // Url pattern name
            array
        (
        'as' => 'editApplituteResults', // to use return Redirect::route('dashboard');
        'uses' => 'ApplitutetestController@editResults'
            )
    );
    Route::any
            (
            'loadApplituteResults', // Url pattern name
            array
        (
        'as' => 'loadApplituteResults', // to use return Redirect::route('dashboard');
        'uses' => 'ApplitutetestController@loadToeditResults'
            )
    );
    Route::any
            (
            'ViewApplituteResults', // Url pattern name
            array
        (
        'as' => 'ViewApplituteResults', // to use return Redirect::route('dashboard');
        'uses' => 'ApplitutetestController@loadToviewResults'
            )
    );
//batchtrainee

    Route::any
            (
            'BatchRegistration', // Url pattern name
            array
        (
        'as' => 'BatchRegistration', // to use return Redirect::route('dashboard');
        'uses' => 'BatchregistrationController@actionCreate'
            )
    );

//basicexamresults

    Route::any
            (
            'AddBasicExamResults', // Url pattern name
            array
        (
        'as' => 'AddBasicExamResults', // to use return Redirect::route('dashboard');
        'uses' => 'BasicexamController@actionAddedRecords'
            )
    );
    Route::any
            (
            'LoadBasicExamResults', // Url pattern name
            array
        (
        'as' => 'LoadBasicExamResults', // to use return Redirect::route('dashboard');
        'uses' => 'BasicexamController@actionLoadRecords'
            )
    );

    Route::any
            (
            'SetBasicExamResults', // Url pattern name
            array
        (
        'as' => 'SetBasicExamResults', // to use return Redirect::route('dashboard');
        'uses' => 'BasicexamController@addResults'
            )
    );
    Route::any
            (
            'SetEditBasicExamResults', // Url pattern name
            array
        (
        'as' => 'SetEditBasicExamResults', // to use return Redirect::route('dashboard');
        'uses' => 'BasicexamController@addEditResults'
            )
    );
    Route::any
            (
            'editBasicExamResults', // Url pattern name
            array
        (
        'as' => 'editBasicExamResults', // to use return Redirect::route('dashboard');
        'uses' => 'BasicexamController@editResults'
            )
    );

    Route::any
            (
            'loadBasicExamRecords', // Url pattern name
            array
        (
        'as' => 'loadBasicExamRecords', // to use return Redirect::route('dashboard');
        'uses' => 'BasicexamController@loadToeditResults'
            )
    );
    Route::any
            (
            'ViewBasicExamRecords', // Url pattern name
            array
        (
        'as' => 'ViewBasicExamRecords', // to use return Redirect::route('dashboard');
        'uses' => 'BasicexamController@loadToviewResults'
            )
    );

//tradecapacity

    Route::any
            (
            'CreateTradeCapacity', // Url pattern name
            array
        (
        'as' => 'CreateTradeCapacity', // to use return Redirect::route('dashboard');
        'uses' => 'TradecapacityController@actionCreate'
            )
    );

    Route::any
            (
            'ViewTradeCapacity', // Url pattern name
            array
        (
        'as' => 'ViewTradeCapacity', // to use return Redirect::route('dashboard');
        'uses' => 'TradecapacityController@viewTradecapacity'
            )
    );

    Route::any
            (
            'SearchTradeCapacity', // Url pattern name
            array
        (
        'as' => 'SearchTradeCapacity', // to use return Redirect::route('dashboard');
        'uses' => 'TradecapacityController@actionSearch'
            )
    );

    Route::any
            (
            'EditTradeCapacity', // Url pattern name
            array
        (
        'as' => 'EditTradeCapacity', // to use return Redirect::route('dashboard');
        'uses' => 'TradecapacityController@actionEdit'
            )
    );

    Route::any
            (
            'DeleteTradeCapacity', // Url pattern name
            array
        (
        'as' => 'DeleteTradeCapacity', // to use return Redirect::route('dashboard');
        'uses' => 'TradecapacityController@actionDelete'
            )
    );

//tradestudent

    Route::any
            (
            'CreateTradeStudent', // Url pattern name
            array
        (
        'as' => 'CreateTradeStudent', // to use return Redirect::route('dashboard');
        'uses' => 'TradestudentController@actionCreate'
            )
    );

    Route::any
            (
            'ViewTradeStudent', // Url pattern name
            array
        (
        'as' => 'ViewTradeStudent', // to use return Redirect::route('dashboard');
        'uses' => 'TradestudentController@actionView'
            )
    );

    Route::any
            (
            'SearchTradeStudent', // Url pattern name
            array
        (
        'as' => 'SearchTradeStudent', // to use return Redirect::route('dashboard');
        'uses' => 'TradestudentController@actionSearch'
            )
    );

    Route::any
            (
            'EditTradeStudent', // Url pattern name
            array
        (
        'as' => 'EditTradeStudent', // to use return Redirect::route('dashboard');
        'uses' => 'TradestudentController@actionEdit'
            )
    );

    Route::any
            (
            'DeleteTradeStudent', // Url pattern name
            array
        (
        'as' => 'DeleteTradeStudent', // to use return Redirect::route('dashboard');
        'uses' => 'TradestudentController@actionDelete'
            )
    );

    Route::any
            (
            'ajaxTradeStudent', // Url pattern name
            array
        (
        'as' => 'ajaxTradeStudent', // to use return Redirect::route('dashboard');
        'uses' => 'TradestudentController@ajaxStudent'
            )
    );

//basicTradeSelection

    Route::any
            (
            'TradeRegistration', // Url pattern name
            array
        (
        'as' => 'TradeRegistration', // to use return Redirect::route('dashboard');
        'uses' => 'BasictradeselectionController@actionCreate'
            )
    );

    Route::get
            (
            'loadTrade', // Url pattern name
            array
        (
        'as' => 'loadTrade', // to use return Redirect::route('dashboard');
        'uses' => 'BasictradeselectionController@loadtrade'
            )
    );


    Route::any
            (
            'viewStudent', // Url pattern name
            array
        (
        'as' => 'viewStudent', // to use return Redirect::route('dashboard');
        'uses' => 'BasictradeselectionController@viewStudent'
            )
    );

//prasanna route end
//ISURU ROUTES START EMPLOYEE-MOVEMENT
    Route::any(
            'applyMovement', array(
        'as' => 'applyMovement',
        'uses' => 'EmployeeMovementController@applyMovement'
            )
    );

    Route::any(
            'viewMovement', array(
        'as' => 'viewMovement',
        'uses' => 'EmployeeMovementController@viewMovement'
            )
    );

    Route::get(
            'cancelMovement', array(
        'uses' => 'EmployeeMovementController@cancelMovement'
            )
    );

    Route::get(
            'approveMovementHome', array(
        'as' => 'approveMovementHome',
        'uses' => 'EmployeeMovementController@approveMovementHome'
            )
    );

    Route::any(
            'approveMovement', array(
        'as' => 'approveMovement',
        'uses' => 'EmployeeMovementController@approveMovement'
            )
    );
//ISURU ROUTES END EMPLOYEE-MOVEMENT
//CENTE CODE

    Route::get
            (
            'cenLoadajax', array
        (
        'as' => 'cenLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'OrganisationController@cenAjax'
            )
    );
//END CENTER CODE
//sandu
    Route::get
            (
            'getmodule', array
        (
        'as' => 'getmodule', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@getmodule'
            )
    );


    Route::any
            (
            'getempcode1', array
        (
        'as' => 'getempcode1', // to use return Redirect::route('dashboard');
        'uses' => 'InscourseController@getempcode1'
            )
    );


//sandu
//ISURU ROUTES START ALRESULT
    Route::any(
            'ALResultHome', array(
        'as' => 'ALResultHome',
        'uses' => 'ALResultController@viewALResultPage'
            )
    );

    Route::any(
            'addALResult', array(
        'as' => 'addALResult',
        'uses' => 'ALResultController@addALResult'
            )
    );

    Route::any(
            'editALResult', array(
        'as' => 'editALResult',
        'uses' => 'ALResultController@editALResult'
            )
    );

    Route::any(
            'loadSubjectList', array(
        'as' => 'loadSubjectList',
        'uses' => 'ALResultController@loadSubjectList'
            )
    );

    Route::get(
            'viewALResult', array(
        'as' => 'viewALResult',
        'uses' => 'ALResultController@viewALResult'
            )
    );

    Route::get(
            'deleteALResult', array(
        'uses' => 'ALResultController@deleteALResult'
            )
    );
//ISURU ROUTES END ALRESULT
//ISURU ROUTES START TRAINEE ATTENDANCE
    Route::get(
            'viewTraineeAttendance', array('as' => 'viewTraineeAttendance',
        'uses' => 'TraineeAttendanceController@viewTraineeAttendance')
    );

    Route::get(
            'loadReportit', array('as' => 'loadReportit',
        'uses' => 'TraineeAttendanceController@reportType')
    );

    Route::get(
            'loadBatchit', array('as' => 'loadBatchit',
        'uses' => 'TraineeAttendanceController@getBatch')
    );

    Route::get(
            'traineeDailyAttendance', array('as' => 'traineeDailyAttendance',
        'uses' => 'TraineeAttendanceController@getData')
    );
//ISURU ROUTES END TRAINEE ATTENDANCE
//sandu vocational Institute
    Route::any(
            'searchvocins', array(
        'as' => 'searchvocins',
        'uses' => 'VocationalInsController@viewvocIns'
            )
    );


    Route::any(
            'searchvocinsID', array(
        'as' => 'searchvocinsID',
        'uses' => 'VocationalInsController@actionSearch'
            )
    );

    Route::any(
            'searchvocinsIDD', array(
        'as' => 'searchvocinsIDD',
        'uses' => 'VocationalInsController@actionSearchDD'
            )
    );
    Route::any(
            'createvocins', array(
        'as' => 'createvocins',
        'uses' => 'VocationalInsController@actionCreate'
            )
    );
    Route::any(
            'deletevocins', array(
        'as' => 'deletevocins',
        'uses' => 'VocationalInsController@actionDelete'
            )
    );
    Route::any(
            'editvocins', array(
        'as' => 'editvocins',
        'uses' => 'VocationalInsController@actionEdit'
            )
    );


// end sandu vocational Institute
//Employee Photograph
    Route::any(
            'Photo_Of_Employee', array(
        'as' => 'Photo_Of_Employee',
        'uses' => 'EmployeeController@image'
            )
    );
//Employee Photograph
//EDependency
    Route::get
            (
            'employeedependence', // Url pattern name 
            array
        (
        'as' => 'employeedependence', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeDependenceController@viewEmployeedependence'
            )
    );
    Route::any
            (
            'createEmployeedependence', // Url pattern name 
            array
        (
        'as' => 'createEmployeedependence', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeDependenceController@actionCreate'
            )
    );
    Route::get
            (
            'findEmployeedependence', // Url pattern name 
            array
        (
        'as' => 'findEmployeedependence', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeDependenceController@actionSearch'
            )
    );
    Route::any
            (
            'editEmployeedependence', array
        (
        'as' => 'editEmployeedependence', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeDependenceController@actionEdit'
            )
    );
    Route::post
            (
            'deleteEmployeedependence', // Url pattern name 
            array
        (
        'as' => 'deleteEmployeedependence', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeDependenceController@actionDelete'
            )
    );
    Route::get
            (
            'epfLoadajax', // Url pattern name
            array
        (
        'as' => 'epfLoadajax', // to use return Redirect::route('dashboard');
        'uses' => 'EmployeeDependenceController@epfAjax'
            )
    );
//End EDependency
//Dropout Routes Glagedarage Don Udara Lahiru Sampath Routes
  Route::any(
                'viewDropout12', array(
            'as' => 'viewDropout12',
            'uses' => 'DropoutViewController@viewDropout12'
                )
        );

        Route::any
                (
                'deleteDropout', // Url pattern name 
                array
            (
            'as' => 'deleteDropout',
            'uses' => 'DropoutViewController@actionDelete'
                )
        );
        Route::any
                (
                'downloadDropout', // Url pattern name 
                array
            (
            'as' => 'downloadDropout',
            'uses' => 'DropoutViewController@getDownload'
                )
        );
        Route::any
                (
                'createDropout1', // Url pattern name 
                array
            (
            'as' => 'createDropout1',
            'uses' => 'DropoutViewController@actioncreate'
                )
        );
        Route::any
                (
                'deleteDropout1', // Url pattern name 
                array
            (
            'as' => 'deleteDropout1',
            'uses' => 'DropoutViewController@actionadd'
                )
        );

        Route::any
                (
                'searchDropout1', // Url pattern name 
                array
            (
            'as' => 'searchDropout1',
            'uses' => 'DropoutViewController@actionsearch'
                )
        );
        Route::any
                (
                'searchDropout1', // Url pattern name 
                array
            (
            'as' => 'searchDropout1',
            'uses' => 'DropoutViewController@actionsearch'
                )
        );
        Route::any
                (
                'loadCourseCodes', // Url pattern name 
                array
            (
            'as' => 'loadCourseCodes',
            'uses' => 'DropoutViewController@loadCourseCodes'
                )
        );
        Route::any
                (
                'findDropouts', // Url pattern name 
                array
            (
            'as' => 'findDropouts',
            'uses' => 'DropoutViewController@findDropouts'
                )
        );

        Route::get
            (
            'toBeConfirmedDropoutsView', // Url pattern name
            array
        (
        'as' => 'toBeConfirmedDropoutsView', // to use return Redirect::route('dashboard');
        'uses' => 'DropoutViewController@toBeConfirmedDropoutsView'
            )
    );


Route::any
                (
                'toBeConfirmed', // Url pattern name 
                array
            (
            'as' => 'toBeConfirmed',
            'uses' => 'DropoutViewController@toBeConfirmed'
                )
        );

    Route::any
    (
        'toBeConfirmedDropoutsViewDownload', // Url pattern name
        array
        (
            'as' => 'toBeConfirmedDropoutsViewDownload',
            'uses' => 'DropoutViewController@toBeConfirmedDropoutsViewDownload'
        )
    );
    Route::any('getFeesPayment',array
        (
            'as' => 'getFeesPayment',
            'uses' => 'DropoutViewController@getFeesPayment'
        )
    );
    Route::any('getAttendenceDetails',array
        (
            'as' => 'getAttendenceDetails',
            'uses' => 'DropoutViewController@getAttendenceDetails'
        )
    );


        Route::any('pendingDropout', array('as' => 'pendingDropout', 'uses' => 'DropoutViewController@pendingDropout'));
        Route::any('ajaxGetPendingDropoutList', array('as' => 'ajaxGetPendingDropoutList', 'uses' => 'DropoutViewController@ajaxGetPendingDropoutList'));
        Route::any('undoDropout', array('as' => 'undoDropout', 'uses' => 'DropoutViewController@actionUndo'));

        Route::any('loadOrga', array('as' => 'loadOrga', 'uses' => 'DropoutViewController@loadDCode'));

//Dropout Routes End

//Scholarship routes kalhara
    Route::any
            (
            'viewScholarship', // Url pattern name 
            array
        (
        'as' => 'viewScholarship', // to use return Redirect::route('dashboard');
        'uses' => 'ScholarshipController@viewScholarship'
            )
    );
    Route::any
            (
            'deleteScholarship', // Url pattern name 
            array
        (
        'as' => 'deleteScholarship', // to use return Redirect::route('dashboard');
        'uses' => 'ScholarshipController@actionDelete'
            )
    );
    Route::any
            (
            'createScholarship', // Url pattern name 
            array
        (
        'as' => 'createScholarship', // to use return Redirect::route('dashboard');
        'uses' => 'ScholarshipController@actioncreate'
            )
    );
    Route::any
            (
            'editScholarship', // Url pattern name 
            array
        (
        'as' => 'editScholarship', // to use return Redirect::route('dashboard');
        'uses' => 'ScholarshipController@actionEdit'
            )
    );
    Route::any
            (
            'searchScholarship', // Url pattern name 
            array
        (
        'as' => 'searchScholarship', // to use return Redirect::route('dashboard');
        'uses' => 'ScholarshipController@actionSearch'
            )
    );
//Scholarship routes end
//ISURU ROUTES START JOBPLACEMENT
    Route::any(
            'createjobplacement', array('as' => 'createjobplacement',
        'uses' => 'RJobPlacementController@createJobPlacement')
    );

    Route::any(
            'editJobPlacement', array('as' => 'editJobPlacement',
        'uses' => 'RJobPlacementController@editJobPlacement')
    );

    Route::get(
            'getTraineeJP', array('as' => 'getTraineeJP',
        'uses' => 'RJobPlacementController@getTraineeName')
    );

    Route::get(
            'getCountryList', array('as' => 'getCountryList',
        'uses' => 'RJobPlacementController@getCountryList')
    );

    Route::get(
            'savePlacementCompany', array('as' => 'savePlacementCompany',
        'uses' => 'RJobPlacementController@createPlacementCompany')
    );

    Route::get(
            'getCompanyType', array('as' => 'getCompanyType',
        'uses' => 'RJobPlacementController@getCompanyType')
    );

    Route::get(
            'viewJobPlacement', array('as' => 'viewJobPlacement',
        'uses' => 'RJobPlacementController@viewJobPlacement')
    );

    Route::get(
            'getCompanyDetail', array('as' => 'getCompanyDetail',
        'uses' => 'RJobPlacementController@getCompanyDetail')
    );

    Route::get(
            'deleteJobPlacement', array('as' => 'deleteJobPlacement',
        'uses' => 'RJobPlacementController@deleteJobPlacement')
    );

    Route::get(
            'editPlacementCompany', array('as' => 'editPlacementCompany',
        'uses' => 'RJobPlacementController@editPlacementCompany')
    );

    Route::get(
            'deletePlacementCompany', array('as' => 'deletePlacementCompany',
        'uses' => 'RJobPlacementController@deletePlacementCompany')
    );
//ISURU ROUTES END JOBPLACEMENT
//Activity Routes KALHARA
    Route::any
            (
            'viewActivity', // Url pattern name 
            array
        (
        'as' => 'viewActivity', // to use return Redirect::route('dashboard');
        'uses' => 'activityController@viewActivity'
            )
    );
    Route::any
            (
            'createActivity', // Url pattern name 
            array
        (
        'as' => 'createActivity', // to use return Redirect::route('dashboard');
        'uses' => 'activityController@actionCreate'
            )
    );
    Route::any
            (
            'editactivity', // Url pattern name 
            array
        (
        'as' => 'editactivity', // to use return Redirect::route('dashboard');
        'uses' => 'activityController@actionEdit'
            )
    );
    Route::any
            (
            'searchActivity', // Url pattern name 
            array
        (
        'as' => 'searchActivity', // to use return Redirect::route('dashboard');
        'uses' => 'activityController@actionSearch'
            )
    );
//Activity routes kalhara end

//ISURU ROUTES START USERROLE
    Route::any(
            'viewUserRoleAssign', array('as' => 'viewUserRoleAssign',
        'uses' => 'UserRoleController@viewUserRoleAssign')
    );

    Route::any(
            'getActivityList', array('as' => 'getActivityList',
        'uses' => 'UserRoleController@getActivity')
    );
    Route::get(
            'addUserRoleAJAX', array('as' => 'addUserRoleAJAX',
        'uses' => 'UserRoleController@addUserRoleAJAX')
    );
    Route::get(
            'removeUserRoleAJAX', array('as' => 'removeUserRoleAJAX',
        'uses' => 'UserRoleController@removeUserRoleAJAX')
    );
    Route::POST(
            'addUserRoleAllAJAX', array('as' => 'addUserRoleAllAJAX',
        'uses' => 'UserRoleController@addUserRoleAllAJAX')
    );
    Route::POST(
            'removeUserRoleAllAJAX', array('as' => 'removeUserRoleAllAJAX',
        'uses' => 'UserRoleController@removeUserRoleAllAJAX')
    );
//ISURU ROUTES END USERROLE

//Kalhara Routes
    Route::any
            (
            'viewSubjectAssignment', // Url pattern name
            array
        (
        'as' => 'viewSubjectAssignment', // to use return Redirect::route('dashboard');
        'uses' => 'SubjectAssignmentController@viewSubjectAssignment'
            )
    );

    Route::any
            (
            'createSubjectAssignment', // Url pattern name
            array
        (
        'as' => 'createSubjectAssignment', // to use return Redirect::route('dashboard');
        'uses' => 'SubjectAssignmentController@actionCreate'
            )
    );
    
//kalhara routes end
    Route::any(
            'viewvisitingIns', array(
        'as' => 'viewvisitingIns',
        'uses' => 'VisitingInstructorController@viewInstructor'
            )
    );

    Route::any(
            'searchvisitingIns', array(
        'as' => 'searchvisitingIns',
        'uses' => 'VisitingInstructorController@actionSearch'
            )
    );
    Route::any(
            'editvisitingIns', array(
        'as' => 'editvisitingIns',
        'uses' => 'VisitingInstructorController@actionEdit'
            )
    );
    Route::any(
            'deletevisitingIns', array(
        'as' => 'deletevisitingIns',
        'uses' => 'VisitingInstructorController@actionDelete'
            )
    );

    Route::any(
            'createvisitingIns', array(
        'as' => 'createvisitingIns',
        'uses' => 'VisitingInstructorController@actionCreate'
            )
    );






//ISURU ROUTES START INTERVIEW_LETTER
    Route::any(
            'interviewLetterHome', array('as' => 'interviewLetterHome',
        'uses' => 'PrintInterviewLetterController@interviewLetterHome')
    );
    Route::any(
            'getCourseListCodeInterviewLetter', array('as' => 'getCourseListCodeInterviewLetter',
        'uses' => 'PrintInterviewLetterController@getCourseListCodeInterviewLetter')
    );
    Route::any(
            'viewInterviweeListInterviewLetters', array('as' => 'viewInterviweeListInterviewLetters',
        'uses' => 'PrintInterviewLetterController@viewInterviweeListInterviewLetters')
    );
    Route::any(
            'printInterviewLetterDTET', array('as' => 'printInterviewLetterDTET',
        'uses' => 'PrintInterviewLetterController@printInterviewLetterDTET')
    );
//ISURU ROUTES END INTERVIEW_LETTER
//ISURU ROUTES START APPLICANT_QUALIFY
    Route::any(
            'applicantQualifyHome', array('as' => 'applicantQualifyHome',
        'uses' => 'ApplicantQualifyController@applicantQualifyHome')
    );
    Route::any(
            'getCourseListCodeApplicantQualify', array('as' => 'getCourseListCodeApplicantQualify',
        'uses' => 'ApplicantQualifyController@getCourseListCodeApplicantQualify')
    );
    Route::any(
            'viewApplicantListQualify', array('as' => 'viewApplicantListQualify',
        'uses' => 'ApplicantQualifyController@viewApplicantListQualify')
    );
    Route::any(
            'viewApplicantDetailQualify', array('as' => 'viewApplicantDetailQualify',
        'uses' => 'ApplicantQualifyController@viewApplicantDetailQualify')
    );
    Route::any(
            'getApplicantOLResultQualify', array('as' => 'getApplicantOLResultQualify',
        'uses' => 'ApplicantQualifyController@getApplicantOLResultQualify')
    );
    Route::any(
            'getApplicantALResultQualify', array('as' => 'getApplicantALResultQualify',
        'uses' => 'ApplicantQualifyController@getApplicantALResultQualify')
    );
    Route::any(
            'updateApplicantDetailQualify', array('as' => 'updateApplicantDetailQualify',
        'uses' => 'ApplicantQualifyController@updateApplicantDetailQualify')
    );
//ISURU ROUTES END APPLICANT_QUALIFY
//ISURU ROUTES START REGISTRATION_CALLING_LETTER
    Route::any(
            'registrationCallingLetterHome', array('as' => 'registrationCallingLetterHome',
        'uses' => 'PrintRegistrationCallingLetterController@registrationCallingLetterHome')
    );
    Route::any(
            'getCourseListCodeRegistrationCallingLetter', array('as' => 'getCourseListCodeRegistrationCallingLetter',
        'uses' => 'PrintRegistrationCallingLetterController@getCourseListCodeRegistrationCallingLetter')
    );
    Route::any(
            'viewSelectedListRegistrationCallingLetters', array('as' => 'viewSelectedListRegistrationCallingLetters',
        'uses' => 'PrintRegistrationCallingLetterController@viewSelectedListRegistrationCallingLetters')
    );
    Route::any(
            'printRegistrationCallingLetterDTET', array('as' => 'printRegistrationCallingLetterDTET',
        'uses' => 'PrintRegistrationCallingLetterController@printRegistrationCallingLetterDTET')
    );
//ISURU ROUTES END REGISTRATION_CALLING_LETTER
//kelani routes

    Route::any
            (
            'editUsers', // Url pattern name 
            array
        (
        'as' => 'editUsers', // to use return Redirect::route('dashboard');
        'uses' => 'UserController@actionEdit'
            )
    );
    Route::get(
            'viewUsers', array(
        'as' => 'viewUsers',
        'uses' => 'UserController@viewUsers'
            )
    );
    Route::get
            (
            'findUser', // Url pattern name 
            array
        (
        'as' => 'findUser', // to use return Redirect::route('dashboard');
        'uses' => 'UserController@actionSearch'
            )
    );

    Route::any
            (
            'createUser', // Url pattern name 
            array
        (
        'as' => 'createUser', // to use return Redirect::route('dashboard');
        'uses' => 'UserController@actionCreate'
            )
    );


    Route::any
            (
            'deactivateUsers', // Url pattern name 
            array
        (
        'as' => 'deactivateUsers', // to use return Redirect::route('dashboard');
        'uses' => 'UserController@deactivateUsers'
            )
    );

    Route::any
            (
            'resetPassword', // Url pattern name 
            array
        (
        'as' => 'resetPassword', // to use return Redirect::route('dashboard');
        'uses' => 'UserController@resetPassword'
            )
    );


// end Kelani routes
//ISURU ROUTES START CHANGEPASSWORD
    Route::any(
            'changePassword', array('as' => 'changePassword',
        'uses' => 'ChangePasswordController@changePassword')
    );
//ISURU ROUTES END CHANGEPASSWORD
//ISURU
    //REPORTING TOOL ADMIN START
    Route::any('viewReportType', array('as' => 'viewReportType', 'uses' => 'ReportGenarationController@viewReportType'));
    Route::any('createReportType', array('as' => 'createReportType', 'uses' => 'ReportGenarationController@createReportType'));
    Route::any('editReportType', array('as' => 'editReportType', 'uses' => 'ReportGenarationController@editReportType'));
    Route::any('deleteReportType', array('as' => 'deleteReportType', 'uses' => 'ReportGenarationController@deleteReportType'));
    Route::any('viewSingleReportData', array('as' => 'viewSingleReportData', 'uses' => 'ReportGenarationController@viewSingleReportData'));
    Route::any('getColumnListReport', array('as' => 'getColumnListReport', 'uses' => 'ReportGenarationController@getColumnListReport'));
    //REPORTING TOOL ADMIN END    
    //REPORTING TOOL START
    Route::any('viewReportToolHome', array('as' => 'viewReportToolHome', 'uses' => 'ReportGenarationToolController@viewReportToolHome'));
    Route::any('getReportNames', array('as' => 'getReportNames', 'uses' => 'ReportGenarationToolController@getReportNames'));
    Route::any('getReportData', array('as' => 'getReportData', 'uses' => 'ReportGenarationToolController@getReportData'));
    Route::any('getSelectedColumnType', array('as' => 'getSelectedColumnType', 'uses' => 'ReportGenarationToolController@getSelectedColumnType'));
    Route::any('getReportColoumnData', array('as' => 'getReportColoumnData', 'uses' => 'ReportGenarationToolController@getReportColoumnData'));
    Route::any('generateReport', array('as' => 'generateReport', 'uses' => 'ReportGenarationToolController@generateReport'));
    Route::any('saveReportFromTool', array('as' => 'saveReportFromTool', 'uses' => 'ReportGenarationToolController@saveReportFromTool'));
    Route::any('downloadExcelFromTool', array('as' => 'downloadExcelFromTool', 'uses' => 'ReportGenarationToolController@downloadExcelFromTool'));
    Route::any('getColumnDistinctValues', array('as' => 'getColumnDistinctValues', 'uses' => 'ReportGenarationToolController@getColumnDistinctValues'));
    //REPORTING TOOL END
    //USER REPORT START
    Route::any('viewStaticReports', array('as' => 'viewStaticReports', 'uses' => 'ReportUserReportController@viewStaticReports'));
    Route::any('getSelectedUserStaticReport', array('as' => 'getSelectedUserStaticReport', 'uses' => 'ReportUserReportController@getSelectedUserStaticReport'));
    Route::any('deleteSelectedUserStaticReport', array('as' => 'deleteSelectedUserStaticReport', 'uses' => 'ReportUserReportController@deleteSelectedUserStaticReport'));
    Route::any('viewDynamicReports', array('as' => 'viewDynamicReports', 'uses' => 'ReportUserReportController@viewDynamicReports'));
    Route::any('getSelectedUserDynamicReport', array('as' => 'getSelectedUserDynamicReport', 'uses' => 'ReportUserReportController@getSelectedUserDynamicReport'));
    Route::any('deleteSelectedUserDynamicReport', array('as' => 'deleteSelectedUserDynamicReport', 'uses' => 'ReportUserReportController@deleteSelectedUserDynamicReport'));
    //USER REPORT END
//END ISURU
//ISURU ROUTES CourseStartedView Start
    Route::any('viewCourseStartedPage', array('as' => 'viewCourseStartedPage', 'uses' => 'CourseStartedNewController@viewCourseStartedPage'));
//ISURU ROUTES CourseStartedView End










});

//Start User Type
Route::get
        (
        'viewUserType', // Url pattern name
        array
    (
    'as' => 'viewUserType', // to use return Redirect::route('dashboard');
    'uses' => 'UserTypeController@viewUserType'
        )
);

Route::any
        (
        'searchUserType', // Url pattern name
        array
    (
    'as' => 'searchUserType', // to use return Redirect::route('dashboard');
    'uses' => 'UserTypeController@actionSearch'
        )
);

Route::any
        (
        'deleteUserType', // Url pattern name
        array
    (
    'as' => 'deleteUserType', // to use return Redirect::route('dashboard');
    'uses' => 'UserTypeController@actionDelete'
        )
);

Route::any
        (
        'editUserType', // Url pattern name
        array
    (
    'as' => 'editUserType', // to use return Redirect::route('dashboard');
    'uses' => 'UserTypeController@actionEdit'
        )
);

Route::any
        (
        'createUserType', // Url pattern name
        array
    (
    'as' => 'createUserType', // to use return Redirect::route('dashboard');
    'uses' => 'UserTypeController@actionCreate'
        )
);
//End User Type
//Electorate routes......
Route::any('Ele_actionView', array('as' => 'Ele_actionView', 'uses' => 'ElectorateController@actionView'));
Route::any('Ele_actionDeleted', array('as' => 'Ele_actionDeleted', 'uses' => 'ElectorateController@actionDeleted'));
Route::any('Ele_actionEdit', array('as' => 'Ele_actionEdit', 'uses' => 'ElectorateController@actionEdit'));
Route::any('Ele_actionCreate', array('as' => 'Ele_actionCreate', 'uses' => 'ElectorateController@actionCreate'));
Route::any('Ele_getDistrict', array('as' => 'Ele_getDistrict', 'uses' => 'ElectorateController@getDistrict'));
//Electorate routes......












//Change in Promotion
Route::any('designationSalaryScaleLoadajax', // Url pattern name
            array( 'as' => 'designationSalaryScaleLoadajax','uses' => 'PromotionController@designationSalaryScaleLoadajax'));
Route::any('createDOPromotion', // Url pattern name
            array('as' => 'createDOPromotion','uses' => 'PromotionController@actionCreate'));
Route::any('PromotionNewPostCheck', // Url pattern name
            array('as' => 'PromotionNewPostCheck','uses' => 'PromotionController@PromotionNewPostCheck'));
Route::any('PromotionNewPostCheckDO', // Url pattern name
            array('as' => 'PromotionNewPostCheckDO','uses' => 'PromotionController@PromotionNewPostCheckDO'));
Route::any('CheckTransferTypeName', // Url pattern name
            array( 'as' => 'CheckTransferTypeName','uses' => 'PromotionController@CheckTransferTypeName'));
//End


//Employee Trade
Route::any(
        'saveTrade', // Url pattern name
        array('as' => 'saveTrade', 'uses' => 'EmployeeController@saveTrade'));
Route::any(
        'saveupdateTrade', // Url pattern name
        array('as' => 'saveupdateTrade', 'uses' => 'EmployeeController@saveupdateTrade'));

//End Employee Trade
//Iresha
  Route::any(
   'checkmodulepackage', array(
        'as' => 'checkmodulepackage', 
        'uses' => 'courseYearPlanController@checkmodulepackage'
            )
    );
Route::any(
   'getNVQmoduleProgram', array(
        'as' => 'getNVQmoduleProgram', 
        'uses' => 'courseYearPlanController@getNVQmoduleProgram'
            )
    );
Route::any(
   'ajaxgetQualifications', array(
        'as' => 'ajaxgetQualifications', 
        'uses' => 'courseYearPlanController@ajaxgetQualifications'
            )
    );
Route::any(
   'assignModulesToCourse', array(
        'as' => 'assignModulesToCourse', 
        'uses' => 'courseYearPlanController@assignModulesToCourse'
            )
    );
Route::any(
   'getNVQmoduleProgramedit', array(
        'as' => 'getNVQmoduleProgramedit', 
        'uses' => 'courseYearPlanController@getNVQmoduleProgramedit'
            )
    );
Route::any(
   'ajaxgetnewQualifications', array(
        'as' => 'ajaxgetnewQualifications', 
        'uses' => 'courseYearPlanController@ajaxgetnewQualifications'
            )
    );
Route::any(
   'ajaxdeletemodules', array(
        'as' => 'ajaxdeletemodules', 
        'uses' => 'courseYearPlanController@ajaxdeletemodules'
            )
    );
Route::any(
   'getcompetencystandardnew', array(
        'as' => 'getcompetencystandardnew', 
        'uses' => 'courseYearPlanController@getcompetencystandardnew'
            )
    );
 Route::any('pleaseSubmitForm', array('as' => 'pleaseSubmitForm', 'uses' => 'FeesController@payFee'));


 //************************** Udara Applicant method of awwerness
Route::any('loadInstructorAjax', array('as' => 'loadInstructorAjax', 'uses' => 'ApplicantController@loadInstructorAjax'));
//********************************************************************

//*********** Applicant CAtegory

Route::any('CreateApplicantCategory', array('as' => 'CreateApplicantCategory','uses' => 'ApplicantCategoryController@createApplicantCategory'));
Route::any('ViewApplicantCategory', array('as' => 'ViewApplicantCategory','uses' => 'ApplicantCategoryController@viewApplicantCategory'));
Route::any('EditApplicantCategory', array('as' => 'EditApplicantCategory','uses' => 'ApplicantCategoryController@editApplicantCategory'));
Route::any('deleteApplicantCategory', array('as' => 'deleteApplicantCategory','uses' => 'ApplicantCategoryController@deleteApplicantCategory'));

//*****************************

//*******************
Route::get
            (
            'loadGNDivisionAjax', // Url pattern name
            array
        (
        'as' => 'loadGNDivisionAjax', // to use return Redirect::route('dashboard');
        'uses' => 'ApplicantController@loadGNDivisionAjax'
            )
    );
//*******************





Route::any('AddNecessaryEmployeeALSubject', 
            array('uses' => 'EmployeeALResultController@AddNecessaryEmployeeALSubject'));
 Route::any('AddNecessaryEmployeeOLSubject', 
            array('uses' => 'EmployeeOLResultController@AddNecessaryEmployeeOLSubject'));
//Start GN Division
    Route::get( 'viewGNDivisionVTA', // Url pattern name 
            array('as' => 'viewGNDivisionVTA', 'uses' => 'GNDivisionController@viewGNDivision' ));
    Route::any( 'searchGNDivisionVTA', // Url pattern name 
            array('as' => 'searchGNDivisionVTA','uses' => 'GNDivisionController@actionSearch'));
    Route::any( 'deleteGNDivisionVTA', // Url pattern name 
            array('as' => 'deleteGNDivisionVTA','uses' => 'GNDivisionController@actionDelete'));
    Route::any('editGNDivisionVTA', // Url pattern name 
            array('as' => 'editGNDivisionVTA','uses' => 'GNDivisionController@actionEdit'));
    Route::any('createGNDivisionVTA', // Url pattern name 
            array('as' => 'createGNDivisionVTA','uses' => 'GNDivisionController@actionCreate'));
    Route::any( 'EleGNDivisionjaxVTA', // Url pattern name
            array('as' => 'EleGNDivisionjaxVTA', 'uses' => 'GNDivisionController@EleDisAjax'));
//  End GNDivision
   Route::any
            (
            'createUserDO', // Url pattern name 
            array
        (
        'as' => 'createUserDO', // to use return Redirect::route('dashboard');
        'uses' => 'UserController@actionCreateDO'
            )
    );

Route::any
            (
            'getEmployeecreateUserDO', // Url pattern name 
            array
        (
        'as' => 'getEmployeecreateUserDO', // to use return Redirect::route('dashboard');
        'uses' => 'UserController@getEmployeecreateUserDO'
            )
    );
   




 
Route::any('downloadExcelTraineeKal', // Url pattern name
            array( 'as' => 'downloadExcelTraineeKal','uses' => 'TraineeController@downloadExcel'));

 Route::any
            (
            'EditTraineeView', // Url pattern name
            array
        (
        'as' => 'EditTraineeView', // to use return Redirect::route('dashboard');
        'uses' => 'TraineeController@actionEditview'
            )
    );
Route::any('centerWiseReport', array('as' => 'centerWiseReport', 'uses' => 'CenterWiseReportController@centerWiseReport_downloadExcel'));


//promotion New
Route::any('createDOPromotionNew', array('as' => 'createDOPromotionNew','uses' => 'PromotionNewController@actionCreate'));
Route::any('promotionExistNew', array('as' => 'promotionExistNew', 'uses' => 'PromotionNewController@promotionExist'));
Route::any('nicLoadajaxNew', array('as' => 'nicLoadajaxNew', 'uses' => 'PromotionNewController@nicAjax'));
Route::any('DashboardViewPromotionConfirmation', array('as' => 'DashboardViewPromotionConfirmation','uses' => 'PromotionNewController@DashboardViewPromotionConfirmation'));
Route::any('ConfirmationForPromotion', array('as' => 'ConfirmationForPromotion','uses' => 'PromotionNewController@ConfirmPromotion'));
Route::any('ViewForPromotionNew', array('as' => 'ViewForPromotionNew','uses' => 'PromotionNewController@viewPromotion'));
Route::any('deletePromotionNew', array('as' => 'deletePromotionNew','uses' => 'PromotionNewController@actionDelete'));







//Student Attendance Percentage - Start - Udara
Route::any('ViewStudentAttendancePercentage',array('as' => 'ViewStudentAttendancePercentage', 'uses' => 'StudentAttendancePercentageController@viewStudentAttendancePercentage'));

Route::any('loadOrganisation',array('as' => 'loadOrganisation', 'uses' => 'StudentAttendancePercentageController@loadOrganisations'));
Route::any('loadCourseCode',array('as' => 'loadCourseCode', 'uses' => 'StudentAttendancePercentageController@loadCourseCodes'));

Route::any('ajaxGetStudentAttendanceDetails',array('as' => 'ajaxGetStudentAttendanceDetails', 'uses' => 'StudentAttendancePercentageController@ajaxGetStudentAttendanceDetails'));
//Student Attendance Percentage - End - Udara

//Student Total Attendance Percentage - Start - Udara
Route::any('ViewStudentDailyAttendancePercentage',array('as' => 'ViewStudentDailyAttendancePercentage', 'uses' => 'StudentDailyAttendancePercentageController@viewStudentDailyAttendancePercentage'));

Route::any('loadOrganisation',array('as' => 'loadOrganisation', 'uses' => 'StudentDailyAttendancePercentageController@loadOrganisations'));
Route::any('loadCourseCode',array('as' => 'loadCourseCode', 'uses' => 'StudentDailyAttendancePercentageController@loadCourseCodes'));

Route::any('ajaxGetStudentDailyAttendanceDetails',array('as' => 'ajaxGetStudentDailyAttendanceDetails', 'uses' => 'StudentDailyAttendancePercentageController@ajaxGetStudentDailyAttendanceDetails'));
//Student Total Attendance Percentage - End - Udara

Route::any(
        'getNVQCompetencyStandardNew', array(
    'as' => 'getNVQCompetencyStandardNew',
    'uses' => 'courseYearPlanController@getNVQCompetencyStandardNew'
        )
);




//Categorize Employee base on their Position [Report]
Route::get
        (
        'CategorizeEmpPosition', // Url pattern name
        array
    (
    'as' => 'CategorizeEmpPosition', // to use return Redirect::route('dashboard');
    'uses' => 'EmployeeController@EmpPosition'
        )
);
//End - Categorize Employee base on their Position [Report]

//Employee Announcement Start
Route::any(
        'viewEmployeeAnnouncements', // Url pattern name 
        array(
    'as' => 'viewEmployeeAnnouncements', // to use return Redirect::route('dashboard');
    'uses' => 'EmployeeAnnouncementsController@viewEmployeeAnnouncements'
));
Route::any(
        'viewEmployeeAnnouncementsDocs', // Url pattern name
        array(
            'as' => 'viewEmployeeAnnouncementsDocs', // to use return Redirect::route('dashboard');
            'uses' => 'EmployeeAnnouncementsController@viewEmployeeAnnouncementsDocs'
        ));

//Employee Announcement End

//Employee SMS Send start
Route::any(
    'sendSmsToEmployee',
    array('as' => 'sendSmsToEmployee',  'uses' => 'EmployeeSMSSendController@sendSmsToEmployee')
);
//Employee SMS Send end

Route::any(
            'loadNicAjaxDetails', array(
        'as' => 'loadNicAjaxDetails',
        'uses' => 'EmployeeController@loadNicAjaxDetails'
            )
    );
 Route::any(
            'loadCourseCodes1', array(
        'as' => 'loadCourseCodes1',
        'uses' => 'DropoutViewController@loadCourseCodes1'
            )
    );

// Update Expected Completed
   Route::any(
            'test1', array(
        'as' => 'test1',
        'uses' => 'UpdateExpectedCompletedMannuallyController@test1'
            )
    );
// Update Expected Completed End 



//dropout report 
  Route::any('DropoutReport', array
        (
        'as' => 'DropoutReport',
        'uses' => 'DropoutReportController@DropoutReport'
            )
    );
  Route::any('dropoutreportSearch', array
        (
        'as' => 'dropoutreportSearch',
        'uses' => 'DropoutReportController@dropoutreportSearch'
            )
    );
  Route::any('downloadDropoutreportSummary', array
        (
        'as' => 'downloadDropoutreportSummary',
        'uses' => 'DropoutReportController@downloadDropoutreportSummary'
            )
    );
 //end dropout report 






 Route::any('downloadOrganisationDetails', array
        (
        'as' => 'downloadOrganisationDetails',
        'uses' => 'OrganisationController@downloadOrganisationDetails'
            )
    );

Route::any('SearchGraduateEmployee', array
        (
        'as' => 'SearchGraduateEmployee',
        'uses' => 'NewGraduateController@courseload'
            )
    );
    Route::any('CosecodewiseStudentDetailsDownload', array
        (
        'as' => 'CosecodewiseStudentDetailsDownload',
        'uses' => 'NewGraduateController@CosecodewiseStudentDetailsDownload'
            )
    );
   Route::any('getstudentdetails', array
        (
        'as' => 'getstudentdetails',
        'uses' => 'NewGraduateController@getstudentdetails'
            )
    );
  
  
  
   
  

Route::any
                    (
                    'loadCourseList', // Url pattern name
                    array
                (
                'as' => 'loadCourseList', // to use return Redirect::route('dashboard');
                'uses' => 'TraineeController@loadCourseList'
                    )
            );
			
			// module updated
    // start ModuleCourse
    Route::get('ViewModuleCourse', array('as' => 'ViewModuleCourse', 'uses' => 'ModuleCourseController@ViewModuleCourse'));
    Route::any('deleteModuleCourse', array('as' => 'deleteModuleCourse', 'uses' => 'ModuleCourseController@deleteModuleCourse'));
    Route::any('CreateModuleCourse', array('as' => 'CreateModuleCourse', 'uses' => 'ModuleCourseController@CreateModuleCourse'));
    Route::any('editModuleCourse', array('as' => 'editModuleCourse', 'uses' => 'ModuleCourseController@editModuleCourse'));
    Route::get('findModuleCourse', array('as' => 'findModuleCourse', 'uses' => 'ModuleCourseController@findModuleCourse'));
    // end ModuleCourse
// start Module
    Route::get('ViewModule', array('as' => 'ViewModule', 'uses' => 'ModuleController@ViewModule'));
    Route::any('deleteModule', array('as' => 'deleteModule', 'uses' => 'ModuleController@deleteModule'));
    Route::any('CreateModule', array('as' => 'CreateModule', 'uses' => 'ModuleController@CreateModule'));
    Route::any('editModule', array('as' => 'editModule', 'uses' => 'ModuleController@editModule'));
    Route::get('findModule', array('as' => 'findModule', 'uses' => 'ModuleController@findModule'));
    // end module
    Route::any
            (
            'moduleCourseexist', // Url pattern name
            array
        (
        'as' => 'moduleCourseexist', // to use return Redirect::route('dashboard');
        'uses' => 'ModuleCourseController@moduleCourseexist'
            )
    );

    Route::get(
            'saveModule', array(
        'as' => 'saveModule',
        'uses' => 'ModuleCourseController@saveModule'
            )
    );

    Route::get(
            'saveTask', array(
        'as' => 'saveTask',
        'uses' => 'ModuleTaskController@saveTask'
            )
    );
    

    // module updated end
    // start Module
    Route::get('ViewModule', array('as' => 'ViewModule', 'uses' => 'ModuleController@ViewModule'));
    Route::any('deleteModule', array('as' => 'deleteModule', 'uses' => 'ModuleController@deleteModule'));
    Route::any('CreateModule', array('as' => 'CreateModule', 'uses' => 'ModuleController@CreateModule'));
    Route::any('editModule', array('as' => 'editModule', 'uses' => 'ModuleController@editModule'));
    Route::get('findModule', array('as' => 'findModule', 'uses' => 'ModuleController@findModule'));
    // end module
    // start ModuleCourse
    Route::get('ViewModuleCourse', array('as' => 'ViewModuleCourse', 'uses' => 'ModuleCourseController@ViewModuleCourse'));
    Route::any('deleteModuleCourse', array('as' => 'deleteModuleCourse', 'uses' => 'ModuleCourseController@deleteModuleCourse'));
    Route::any('CreateModuleCourse', array('as' => 'CreateModuleCourse', 'uses' => 'ModuleCourseController@CreateModuleCourse'));
    Route::any('editModuleCourse', array('as' => 'editModuleCourse', 'uses' => 'ModuleCourseController@editModuleCourse'));
    Route::get('findModuleCourse', array('as' => 'findModuleCourse', 'uses' => 'ModuleCourseController@findModuleCourse'));
    Route::get(
            'saveModuleforTask', array(
        'as' => 'saveModuleforTask',
        'uses' => 'ModuleTaskController@saveModuleforTask'
            )
    );
    // end ModuleCourse
    //start task 
    Route::get('ViewModuleTask', array('as' => 'ViewModuleTask', 'uses' => 'ModuleTaskController@ViewModuleTask'));
    Route::any('deleteModuleTask', array('as' => 'deleteModuleTask', 'uses' => 'ModuleTaskController@deleteModuleTask'));
    Route::any('CreateModuleTask', array('as' => 'CreateModuleTask', 'uses' => 'ModuleTaskController@CreateModuleTask'));

    Route::get('ViewModuleTaskSeq', array('as' => 'ViewModuleTaskSeq', 'uses' => 'ModuleTaskSeqController@ViewModuleTaskSeq'));
    Route::get('SearchModuleTaskSeq', array('as' => 'SearchModuleTaskSeq', 'uses' => 'ModuleTaskSeqController@findModuleTaskSeq'));
    Route::any('deleteModuleTaskSeq', array('as' => 'deleteModuleTaskSeq', 'uses' => 'ModuleTaskSeqController@deleteModuleTaskSeq'));
     Route::any('PrintModuleTaskSeq', array('as' => 'PrintModuleTaskSeq', 'uses' => 'ModuleTaskSeqController@PrintModuleTaskSeq'));

    Route::get('ViewTask', array('as' => 'ViewTask', 'uses' => 'TaskController@ViewTask'));
    Route::any('deleteTask', array('as' => 'deleteTask', 'uses' => 'TaskController@deleteTask'));
    //Route::any('CreateModuleTask', array('as' => 'CreateModuleTask', 'uses' => 'ModuleTaskController@CreateModuleTask'));
    //Route::any('editModuleCourse', array('as' => 'editModuleCourse', 'uses' => 'ModuleCourseController@editModuleCourse'));
    //Route::get('findModuleCourse', array('as' => 'findModuleCourse', 'uses' => 'ModuleCourseController@findModuleCourse'));
        Route::post('saveAll', array('as' => 'saveAll', 'uses' => 'ModuleTaskController@saveAll'));

     Route::any
            (
            'moduleTaskexist', // Url pattern name
            array
        (
        'as' => 'moduleTaskeexist', // to use return Redirect::route('dashboard');
        'uses' => 'ModuleTaskController@moduleTaskexist'
            )
    );
             Route::any
            (
            'moduleTaskOrderexist', // Url pattern name
            array
        (
        'as' => 'moduleTaskOrderexist', // to use return Redirect::route('dashboard');
        'uses' => 'ModuleTaskController@moduleTaskOrderexist'
            )
    );
            Route::get(
            'getTaskId', array(
        'as' => 'getTaskId',
        'uses' => 'ModuleTaskController@getTaskIdAjax'
            )
    );

    //end task routs
//nvq exam level 1-3 & 4{SP} start
Route::any('EUViewTrainees',array('as'=>'EUViewTrainees' , 'uses' => 'NVQExamLoadCourseDetailsController@load_centers'));
Route::any('EUview_courses',array('as'=>'EUview_courses' , 'uses' => 'NVQExamLoadCourseDetailsController@view_courses'));
Route::any('EUviewNVQnewStudentDetails',array('as'=>'EUviewNVQnewStudentDetails' , 'uses' => 'NVQExamLoadCourseDetailsController@view_students'));
Route::any('EUviewStudentsCourseWise',array('as'=>'EUviewStudentsCourseWise' , 'uses' => 'NVQExamLoadCourseDetailsController@viewStudentsCourseWise'));
Route::get('AssessorCreate', array('as' => 'AssessorCreate','uses' => 'AssessorController@AssessorCreate'));
Route::get('getWorkingPlace', array('as' => 'getWorkingPlace','uses' => 'AssessorController@getWorkingPlace'));
Route::get('saveAssessorInstitute', array('as' => 'saveAssessorInstitute','uses' => 'AssessorController@saveAssessorInstitute'));
Route::any('getInstitureNameAssessor', array('as' => 'getInstitureNameAssessor', 'uses' => 'AssessorController@getInstitureNameAssessor'));
Route::any('saveAssessorWorkingPlace', array('as' => 'saveAssessorWorkingPlace','uses' => 'AssessorController@saveAssessorWorkingPlace'));
Route::any('saveAssessorRecord', array('as' => 'saveAssessorRecord','uses' => 'AssessorController@saveAssessorRecord'));
Route::any('ViewAndDownloadAssessor', array('as' => 'ViewAndDownloadAssessor','uses' => 'AssessorController@ViewAndDownloadAssessor'));
Route::any('PrintAssessorList', array('as' => 'PrintAssessorList','uses' => 'AssessorController@PrintAssessorList'));
Route::any('DownloadExcelAssessorList', array('as' => 'DownloadExcelAssessorList','uses' => 'AssessorController@DownloadExcelAssessorList'));
Route::any('GetNVTINDO', array('as' => 'GetNVTINDO','uses' => 'AssessorController@GetNVTINDO'));
Route::any('EUGetOngoingCoursese', array('as' => 'EUGetOngoingCoursese','uses' => 'AssessorController@EUGetOngoingCoursese'));
Route::any('LoadAssessors1', array('as' => 'LoadAssessors1','uses' => 'AssessorController@LoadAssessors1'));
Route::any('LoadAssessors2', array('as' => 'LoadAssessors2','uses' => 'AssessorController@LoadAssessors2'));
Route::any('ViewNPrintLettersForAssignedAssessors', array('as' => 'ViewNPrintLettersForAssignedAssessors','uses' =>'AssessorController@ViewNPrintLettersForAssignedAssessors'));
Route::any('GetNominatedCourses', array('as' => 'GetNominatedCourses','uses' => 'AssessorController@GetNominatedCourses'));
Route::any('PrintAssessorAssignedLetter', array('as' => 'PrintAssessorAssignedLetter','uses' => 'AssessorController@PrintAssessorAssignedLetter'));
Route::any('DORejectAssignedAssessor', array('as' => 'DORejectAssignedAssessor','uses' => 'AssessorController@DORejectAssignedAssessor'));
Route::any('RenominateAssessor', array('as' => 'RenominateAssessor','uses' => 'AssessorController@RenominateAssessor'));
Route::any('getRenominateCenters', array('as' => 'getRenominateCenters','uses' => 'AssessorController@getRenominateCenters'));
Route::any('getAssessorTable', array('as' => 'getAssessorTable','uses' => 'AssessorController@getAssessorTable'));
Route::any('getAssessorCount', array('as' => 'getAssessorCount','uses' => 'AssessorController@getAssessorCount'));
Route::any('SchedulePreAssessment', array('as' => 'SchedulePreAssessment','uses' => 'AssessorController@SchedulePreAssessment'));
Route::any('ScheduleFinalAssessment', array('as' => 'ScheduleFinalAssessment','uses' => 'AssessorController@ScheduleFinalAssessment'));
Route::any('TempEnterResult', array('as' => 'TempEnterResult','uses' => 'AssessorController@TempEnterResult'));
Route::any('TEMPEUGetOngoingCoursese', array('as' => 'TEMPEUGetOngoingCoursese','uses' => 'AssessorController@TEMPEUGetOngoingCoursese'));
Route::any('TEMPLoadTraineeList', array('as' => 'TEMPLoadTraineeList','uses' => 'AssessorController@TEMPLoadTraineeList'));
Route::any('TEMPgetUnits', array('as' => 'TEMPgetUnits','uses' => 'AssessorController@TEMPgetUnits'));
Route::any('TempViewResult', array('as' => 'TempViewResult','uses' => 'AssessorController@TempViewResult'));
Route::any('TEMPLoadTraineemodulelistwithresult', array('as' => 'TEMPLoadTraineemodulelistwithresult','uses' => 'AssessorController@TEMPLoadTraineemodulelistwithresult'));
Route::any('printFinaAttendance',array('as'=>'printFinaAttendance' , 'uses' => 'NVQFinalExamSelectController@printFinaAttendance'));
Route::any('GetNominatedCourses', array('as' => 'GetNominatedCourses','uses' => 'NVQFinalExamSelectController@GetNominatedCourses'));
Route::any('printFinaAttendanceStudents',array('as'=>'printFinaAttendanceStudents' , 'uses' => 'NVQFinalExamSelectController@printFinaAttendanceStudents'));
Route::any('GETAjaxQualificationStudent', array('as' => 'GETAjaxQualificationStudent','uses' => 'AssessorController@GETAjaxQualificationStudent'));
Route::any('PrintAttendanceSheet2', array('as' => 'PrintAttendanceSheet2','uses' => 'NVQFinalExamSelectController@PrintAttendanceSheet2'));
Route::any('PrintAttendanceSheet3', array('as' => 'PrintAttendanceSheet3','uses' => 'NVQFinalExamSelectController@PrintAttendanceSheet3'));
Route::any('EUExamResultEnter', array('as' => 'EUExamResultEnter','uses' => 'AssessorController@EUExamResultEnter'));
Route::any('EULoadStudentExamResultEnter', array('as' => 'EULoadStudentExamResultEnter','uses' => 'AssessorController@EULoadStudentExamResultEnter'));
Route::any('SaveModuleResult', array('as' => 'SaveModuleResult','uses' => 'AssessorController@SaveModuleResult'));
Route::any('returnToTraineeList', array('as' => 'returnToTraineeList','uses' => 'AssessorController@returnToTraineeList'));
Route::any('AssignTraineesToPreAssessment', array('as' => 'AssignTraineesToPreAssessment','uses' => 'AssessorController@AssignTraineesToPreAssessment'));
Route::any('AssignTraineesToFinalAssessment', array('as' => 'AssignTraineesToFinalAssessment','uses' => 'AssessorController@AssignTraineesToFinalAssessment'));
Route::any('GetScheduledPreAssDates', array('as' => 'GetScheduledPreAssDates','uses' => 'AssessorController@GetScheduledPreAssDates'));
Route::any('SavePreAssessmentAttendence', array('as' => 'SavePreAssessmentAttendence','uses' => 'AssessorController@SavePreAssessmentAttendence'));
Route::any('PrintPreAssessmentAttendence', array('as' => 'PrintPreAssessmentAttendence','uses' => 'AssessorController@PrintPreAssessmentAttendence'));
Route::any('ViewOriginalResultSheet', array('as' => 'ViewOriginalResultSheet','uses' => 'AssessorController@ViewOriginalResultSheet'));
Route::any('EditOriginalResultSheet', array('as' => 'EditOriginalResultSheet','uses' => 'AssessorController@EditOriginalResultSheet'));
Route::any('SaveEditOriginalResultSheet', array('as' => 'SaveEditOriginalResultSheet','uses' => 'AssessorController@SaveEditOriginalResultSheet'));
Route::any('ReturntoResultSheet', array('as' => 'ReturntoResultSheet','uses' => 'AssessorController@ReturntoResultSheet'));
Route::any('ROANameList', array('as' => 'ROANameList','uses' => 'AssessorController@ROANameList'));
Route::any('ConfirmResultCenter', array('as' => 'ConfirmResultCenter','uses' => 'AssessorController@ConfirmResultCenter'));
Route::any('ConfirmResultProvince', array('as' => 'ConfirmResultProvince','uses' => 'AssessorController@ConfirmResultProvince'));
Route::any('EnterCertificateDelivery', array('as' => 'EnterCertificateDelivery','uses' => 'AssessorController@EnterCertificateDelivery'));
Route::any('getFinalAssessedCourse', array('as' => 'getFinalAssessedCourse','uses' => 'AssessorController@getFinalAssessedCourse'));
Route::any('CreateCertificateDelivery', array('as' => 'CreateCertificateDelivery','uses' => 'AssessorController@CreateCertificateDelivery'));
Route::any('GetCertificateOfficer', array('as' => 'GetCertificateOfficer','uses' => 'AssessorController@GetCertificateOfficer'));
Route::any('PrintCertificateOfficer', array('as' => 'PrintCertificateOfficer','uses' => 'AssessorController@PrintCertificateOfficer'));
Route::any('PrintNVQStudentList', array('as' => 'PrintNVQStudentList','uses' => 'AssessorController@PrintNVQStudentList'));
Route::any('TVECDocReceive', array('as' => 'TVECDocReceive','uses' => 'AssessorController@TVECDocReceive'));
Route::any('saveTVECDocReceive', array('as' => 'saveTVECDocReceive','uses' => 'AssessorController@saveTVECDocReceive'));

Route::any('CertificateHandoverToStudent', array('as' => 'CertificateHandoverToStudent','uses' => 'AssessorController@CertificateHandoverToStudent'));

Route::any('CreateCertificateHandoverToStudent', array('as' => 'CreateCertificateHandoverToStudent','uses' => 'AssessorController@CreateCertificateHandoverToStudent'));
Route::any('loadNICCertificateList', array('as' => 'loadNICCertificateList','uses' => 'AssessorController@loadNICCertificateList'));
Route::any('AddContinuousAssessmentMarks', array('as' => 'AddContinuousAssessmentMarks','uses' => 'AssessorController@AddContinuousAssessmentMarks'));
Route::any('DipGetNominatedCourses', array('as' => 'DipGetNominatedCourses','uses' => 'AssessorController@DipGetNominatedCourses'));
Route::any('DipGetModuleCourses', array('as' => 'DipGetModuleCourses','uses' => 'AssessorController@DipGetModuleCourses'));
Route::any('DipGetAssessmentNo', array('as' => 'DipGetAssessmentNo','uses' => 'AssessorController@DipGetAssessmentNo'));
Route::any('SaveDipGetAssessmentNo', array('as' => 'SaveDipGetAssessmentNo','uses' => 'AssessorController@SaveDipGetAssessmentNo'));
Route::any('GetDipGetAssessmentTraineeList', array('as' => 'GetDipGetAssessmentTraineeList','uses' => 'AssessorController@GetDipGetAssessmentTraineeList'));
Route::any('ViewContinuousAssessmentMarks', array('as' => 'ViewContinuousAssessmentMarks','uses' => 'AssessorController@ViewContinuousAssessmentMarks'));
Route::any('PrintNVQAddmissionCard', array('as' => 'PrintNVQAddmissionCard','uses' => 'AssessorController@PrintNVQAddmissionCard'));
Route::any('PrintAdd', array('as' => 'PrintAdd','uses' => 'AssessorController@PrintAdd'));

//nvq exam level 1-3 & 4{SP} end
// actual time table start

Route::any('CreateActualTimeTable', array('as' => 'CreateActualTimeTable','uses' => 'MOActualTimeTableController@CreateActualTimeTable'));
Route::any('GenarateActualTimeTable', array('as' => 'GenarateActualTimeTable','uses' => 'MOActualTimeTableController@GenarateActualTimeTable'));
Route::any('GetMOCourselistCodes', array('as' => 'GetMOCourselistCodes','uses' => 'MOActualTimeTableController@GetMOCourselistCodes'));
Route::any('GetOrmit', array('as' => 'GetOrmit','uses' => 'MOActualTimeTableController@GetOrmit'));
Route::any('SaveDatesOrmit', array('as' => 'SaveDatesOrmit','uses' => 'MOActualTimeTableController@SaveDatesOrmit'));
Route::any('CheckRevisionDate', array('as' => 'CheckRevisionDate','uses' => 'MOActualTimeTableController@CheckRevisionDate'));
Route::any('ViewActualTimeTable', array('as' => 'ViewActualTimeTable','uses' => 'MOActualTimeTableController@ViewActualTimeTable'));
Route::any('SearchMOActualTimeTable', array('as' => 'SearchMOActualTimeTable','uses' => 'MOActualTimeTableController@SearchMOActualTimeTable'));
Route::any('DownloadMOActualTimeTable', array('as' => 'DownloadMOActualTimeTable','uses' => 'MOActualTimeTableController@DownloadMOActualTimeTable'));
Route::any('printActualTimeTablePDF', array('as' => 'printActualTimeTablePDF','uses' => 'MOActualTimeTableController@printActualTimeTablePDF'));

Route::any('ViewWeekTimeTable', array('as' => 'ViewWeekTimeTable','uses' => 'MOActualTimeTableController@ViewWeekTimeTable'));
Route::any('ViewWeekTimeTableLoadWeekNo', array('as' => 'ViewWeekTimeTableLoadWeekNo','uses' => 'MOActualTimeTableController@ViewWeekTimeTableLoadWeekNo'));

Route::any('FindWeekTimeTableLoadWeekNo', array('as' => 'FindWeekTimeTableLoadWeekNo','uses' => 'MOActualTimeTableController@FindWeekTimeTableLoadWeekNo'));
Route::any('PrintPDFWeekTimeTableLoadWeekNo', array('as' => 'PrintPDFWeekTimeTableLoadWeekNo','uses' => 'MOActualTimeTableController@PrintPDFWeekTimeTableLoadWeekNo'));

Route::any('CreateMOCenterMonitoringPlan', array('as' => 'CreateMOCenterMonitoringPlan','uses' => 'MOActualTimeTableController@CreateMOCenterMonitoringPlan'));
Route::any('loaddistrictcentersin', array('as' => 'loaddistrictcentersin','uses' => 'MOActualTimeTableController@loaddistrictcentersin'));
Route::any('FilterCourseYearPlans', array('as' => 'FilterCourseYearPlans','uses' => 'MOActualTimeTableController@FilterCourseYearPlans'));
Route::any('FilterCourseYearPlans1', array('as' => 'FilterCourseYearPlans1','uses' => 'MOActualTimeTableController@FilterCourseYearPlans1'));
Route::any('MOCMCheckPlanneddate', array('as' => 'MOCMCheckPlanneddate','uses' => 'MOActualTimeTableController@MOCMCheckPlanneddate'));
Route::any('ViewTOMOCenterMonitoringPlan', array('as' => 'ViewTOMOCenterMonitoringPlan','uses' => 'MOActualTimeTableController@ViewTOMOCenterMonitoringPlan'));
Route::any('ViewDDADMOCenterMonitoringPlan', array('as' => 'ViewDDADMOCenterMonitoringPlan','uses' => 'MOActualTimeTableController@ViewDDADMOCenterMonitoringPlan'));
Route::any('GetEmpIdFromCenterMO', array('as' => 'GetEmpIdFromCenterMO','uses' => 'MOActualTimeTableController@GetEmpIdFromCenterMO'));
Route::any('DDADRejectMOCenterMOnitoringPlan', array('as' => 'DDADRejectMOCenterMOnitoringPlan','uses' => 'MOActualTimeTableController@DDADRejectMOCenterMOnitoringPlan'));
Route::any('DDADConfirmMOCenterMOnitoringPlan', array('as' => 'DDADConfirmMOCenterMOnitoringPlan','uses' => 'MOActualTimeTableController@DDADConfirmMOCenterMOnitoringPlan'));
Route::any('DeleteTOMOnitoringPlan', array('as' => 'DeleteTOMOnitoringPlan','uses' => 'MOActualTimeTableController@DeleteTOMOnitoringPlan'));
//////////////////////////////////
Route::any('ViewCriteriaCategory', array('as' => 'ViewCriteriaCategory','uses' => 'MOActualTimeTableController@ViewCriteriaCategory'));
Route::any('CreateCriteriaCategory', array('as' => 'CreateCriteriaCategory','uses' => 'MOActualTimeTableController@CreateCriteriaCategory'));
Route::any('DeleteCriteriaCategory', array('as' => 'DeleteCriteriaCategory','uses' => 'MOActualTimeTableController@DeleteCriteriaCategory'));
Route::any('ViewCriteriaEmpType', array('as' => 'ViewCriteriaEmpType','uses' => 'MOActualTimeTableController@ViewCriteriaEmpType'));
Route::any('CreateCriteriaEmpType', array('as' => 'CreateCriteriaEmpType','uses' => 'MOActualTimeTableController@CreateCriteriaEmpType'));
Route::any('DeleteCriteriaEmpType', array('as' => 'DeleteCriteriaEmpType','uses' => 'MOActualTimeTableController@DeleteCriteriaEmpType'));
Route::any('ViewCriteriaClass', array('as' => 'ViewCriteriaClass','uses' => 'MOActualTimeTableController@ViewCriteriaClass'));
Route::any('CreateCriteriaClass', array('as' => 'CreateCriteriaClass','uses' => 'MOActualTimeTableController@CreateCriteriaClass'));
Route::any('DeleteCriteriaClass', array('as' => 'DeleteCriteriaClass','uses' => 'MOActualTimeTableController@DeleteCriteriaClass'));
Route::any('ViewCriterias', array('as' => 'ViewCriterias','uses' => 'MOActualTimeTableController@ViewCriterias'));
Route::any('CreateCriterias', array('as' => 'CreateCriterias','uses' => 'MOActualTimeTableController@CreateCriterias'));
Route::any('GetCalClass', array('as' => 'GetCalClass','uses' => 'MOActualTimeTableController@GetCalClass'));

Route::any('DoMonitor', array('as' => 'DoMonitor','uses' => 'MOActualTimeTableController@DoMonitor'));
Route::any('LoadMonitoringForm', array('as' => 'LoadMonitoringForm','uses' => 'MOActualTimeTableController@LoadMonitoringForm'));
Route::any('LoadMonitoringForm', array('as' => 'LoadMonitoringForm','uses' => 'MOActualTimeTableController@LoadMonitoringForm'));
Route::any('EditTOMonitoringFormEntered', array('as' => 'EditTOMonitoringFormEntered','uses' => 'MOActualTimeTableController@EditTOMonitoringFormEntered'));
Route::any('ViewTOMonitoringFormEntered', array('as' => 'ViewTOMonitoringFormEntered','uses' => 'MOActualTimeTableController@ViewTOMonitoringFormEntered'));
Route::any('PrintTOMonitoringFormEntered', array('as' => 'PrintTOMonitoringFormEntered','uses' => 'MOActualTimeTableController@PrintTOMonitoringFormEntered'));
Route::any('DeleteSubCriteria', array('as' => 'DeleteSubCriteria','uses' => 'MOActualTimeTableController@DeleteSubCriteria'));
//Question Bank Start
Route::any('ViewQuestions', array('as' => 'ViewQuestions','uses' => 'MOActualTimeTableController@ViewQuestions'));
Route::any('CreateQuestions', array('as' => 'CreateQuestions','uses' => 'MOActualTimeTableController@CreateQuestions'));
Route::any('SearchQuestions', array('as' => 'SearchQuestions','uses' => 'MOActualTimeTableController@SearchQuestions'));
Route::any('LoadQuestionModuleCourse', array('as' => 'LoadQuestionModuleCourse','uses' => 'MOActualTimeTableController@LoadQuestionModuleCourse'));
Route::any('LoadQuestionModuleTask', array('as' => 'LoadQuestionModuleTask','uses' => 'MOActualTimeTableController@LoadQuestionModuleTask'));
Route::any('EditQuestions', array('as' => 'EditQuestions','uses' => 'MOActualTimeTableController@EditQuestions'));
Route::any('DeleteQuestions', array('as' => 'DeleteQuestions','uses' => 'MOActualTimeTableController@DeleteQuestions'));
Route::any('DownloadQuestionPaper', array('as' => 'DownloadQuestionPaper','uses' => 'MOActualTimeTableController@DownloadQuestionPaper'));
Route::any('ViewCoursePlanReport', array('as' => 'ViewCoursePlanReport','uses' => 'MOActualTimeTableController@ViewCoursePlanReport'));
Route::any('PrintCoursePlanReport', array('as' => 'PrintCoursePlanReport','uses' => 'MOActualTimeTableController@PrintCoursePlanReport'));
Route::any('ViewCoursePlanReportW', array('as' => 'ViewCoursePlanReportW','uses' => 'MOActualTimeTableController@ViewCoursePlanReportW'));
Route::any('PrintCoursePlanReportW', array('as' => 'PrintCoursePlanReportW','uses' => 'MOActualTimeTableController@PrintCoursePlanReportW'));
Route::any('ViewDistrictWiseMonitoringProgress', array('as' => 'ViewDistrictWiseMonitoringProgress','uses' => 'MOActualTimeTableController@ViewDistrictWiseMonitoringProgress'));
Route::any('LoadViewDistrictWiseMonitoringProgress', array('as' => 'LoadViewDistrictWiseMonitoringProgress','uses' => 'MOActualTimeTableController@LoadViewDistrictWiseMonitoringProgress'));
Route::any('DownloadLoadViewDistrictWiseMonitoringProgress', array('as' => 'DownloadLoadViewDistrictWiseMonitoringProgress','uses' => 'MOActualTimeTableController@DownloadLoadViewDistrictWiseMonitoringProgress'));
Route::any('ViewWeekTimeTableLoadMonth', array('as' => 'ViewWeekTimeTableLoadMonth','uses' => 'MOActualTimeTableController@ViewWeekTimeTableLoadMonth'));
Route::any('ViewDistrictWiseMonitoringProgressSummary', array('as' => 'ViewDistrictWiseMonitoringProgressSummary','uses' => 'MOActualTimeTableController@ViewDistrictWiseMonitoringProgressSummary'));
Route::any('LoadViewDistrictWiseMonitoringProgresssummary', array('as' => 'LoadViewDistrictWiseMonitoringProgresssummary','uses' => 'MOActualTimeTableController@LoadViewDistrictWiseMonitoringProgresssummary'));
Route::any('DownloadLoadViewDistrictWiseMonitoringProgressSummary', array('as' => 'DownloadLoadViewDistrictWiseMonitoringProgressSummary','uses' => 'MOActualTimeTableController@DownloadLoadViewDistrictWiseMonitoringProgressSummary'));
Route::any('ViewCourseMonitoringDetailswithMarksReport', array('as' => 'ViewCourseMonitoringDetailswithMarksReport','uses' => 'MOActualTimeTableController@ViewCourseMonitoringDetailswithMarksReport'));
Route::any('LoadCourseMonitoringDetailswithMarksReport', array('as' => 'LoadCourseMonitoringDetailswithMarksReport','uses' => 'MOActualTimeTableController@LoadCourseMonitoringDetailswithMarksReport'));
Route::any('DownloadCourseMonitoringDetailswithMarksReport', array('as' => 'DownloadCourseMonitoringDetailswithMarksReport','uses' => 'MOActualTimeTableController@DownloadCourseMonitoringDetailswithMarksReport'));
Route::any('ViewAverageCourseMonitoringDetailswithMarksReport', array('as' => 'ViewAverageCourseMonitoringDetailswithMarksReport','uses' => 'MOActualTimeTableController@ViewAverageCourseMonitoringDetailswithMarksReport'));
Route::any('LoadAverageCourseMonitoringDetailswithMarksReport', array('as' => 'LoadAverageCourseMonitoringDetailswithMarksReport','uses' => 'MOActualTimeTableController@LoadAverageCourseMonitoringDetailswithMarksReport'));
Route::any('DownloadAverageCourseMonitoringDetailswithMarksReport', array('as' => 'DownloadAverageCourseMonitoringDetailswithMarksReport','uses' => 'MOActualTimeTableController@DownloadAverageCourseMonitoringDetailswithMarksReport'));
Route::any('LoadTradeWiseCLCmoTask', array('as' => 'LoadTradeWiseCLCmoTask','uses' => 'ModuleTaskController@LoadTradeWiseCLCmoTask'));
Route::any('LoadTradeWiseCLCmoTask11', array('as' => 'LoadTradeWiseCLCmoTask11','uses' => 'ModuleTaskController@LoadTradeWiseCLCmoTask11'));
Route::any('LoadCompetencyCourseCreate', array('as' => 'LoadCompetencyCourseCreate','uses' => 'CourseController@LoadCompetencyCourseCreate'));
Route::any('LoadNVQCourseComPackage', array('as' => 'LoadNVQCourseComPackage','uses' => 'CourseController@LoadNVQCourseComPackage'));
Route::any('AssignQPackageModules', array('as' => 'AssignQPackageModules','uses' => 'CourseController@AssignQPackageModules'));
Route::any('CreateQPackageModules', array('as' => 'CreateQPackageModules','uses' => 'CourseController@CreateQPackageModules'));
Route::any('LoadNVQCourseComPackageQQ', array('as' => 'LoadNVQCourseComPackageQQ','uses' => 'CourseController@LoadNVQCourseComPackageQQ'));
Route::any('LoadModuleTableQPack', array('as' => 'LoadModuleTableQPack','uses' => 'CourseController@LoadModuleTableQPack'));
Route::any('EditQPackageModules', array('as' => 'EditQPackageModules','uses' => 'CourseController@EditQPackageModules'));
Route::any('ViewListQPackageModules', array('as' => 'ViewListQPackageModules','uses' => 'CourseController@ViewListQPackageModules'));
Route::any('DeleteQPackageModules', array('as' => 'DeleteQPackageModules','uses' => 'CourseController@DeleteQPackageModules'));
Route::any('LoadPackageModuleListForModuleTask', array('as' => 'LoadPackageModuleListForModuleTask','uses' => 'ModuleCourseController@LoadPackageModuleListForModuleTask'));
Route::any('LoadNVQCourseComPackageQQQ', array('as' => 'LoadNVQCourseComPackageQQQ','uses' => 'CourseController@LoadNVQCourseComPackageQQQ'));
Route::any('updatewrongorder', array('as' => 'updatewrongorder','uses' => 'ModuleTaskSeqController@updatewrongorder'));
Route::any('ViewTrainingPlanReportCheck', array('as' => 'ViewTrainingPlanReportCheck','uses' => 'TrainingPlanReportController@ViewTrainingPlanReportCheck'));
Route::any('loaddistrictcentersin', array('as' => 'loaddistrictcentersin','uses' => 'MOActualTimeTableController@loaddistrictcentersin'));
Route::any('PrintPDFTrainingPlanReportCheck', array('as' => 'PrintPDFTrainingPlanReportCheck','uses' => 'TrainingPlanReportController@PrintPDFTrainingPlanReportCheck'));
Route::any('PrintExcelTrainingPlanReportCheck', array('as' => 'PrintExcelTrainingPlanReportCheck','uses' => 'TrainingPlanReportController@PrintExcelTrainingPlanReportCheck'));
//center wise summery report
Route::any('ViewDistrictWiseMonitoringProgressSummaryCenter', array('as' => 'ViewDistrictWiseMonitoringProgressSummaryCenter','uses' => 'MOActualTimeTableController@ViewDistrictWiseMonitoringProgressSummaryCenter'));
Route::any('LoadViewDistrictWiseMonitoringProgresssummaryCenter', array('as' => 'LoadViewDistrictWiseMonitoringProgresssummaryCenter','uses' => 'MOActualTimeTableController@LoadViewDistrictWiseMonitoringProgresssummaryCenter'));
Route::any('DownloadLoadViewDistrictWiseCenterMonitoringProgressSummary', array('as' => 'DownloadLoadViewDistrictWiseCenterMonitoringProgressSummary','uses' => 'MOActualTimeTableController@DownloadLoadViewDistrictWiseCenterMonitoringProgressSummary'));
//NEW
Route::any('loadWeekTimeTableWiuthAjax', array('as' => 'loadWeekTimeTableWiuthAjax','uses' => 'MOActualTimeTableController@loadWeekTimeTableWiuthAjax'));
//Training Plan Update District/NVTI
Route::any('ViewTrainingPlanUpdateDisNVTI', array('as' => 'ViewTrainingPlanUpdateDisNVTI','uses' => 'TrainingPlanReportController@ViewTrainingPlanUpdateDisNVTI'));
Route::any('editCourseYearPlanDisNVTI',array('as'=>'editCourseYearPlanDisNVTI','uses'=>'TrainingPlanReportController@editCourseYearPlanDisNVTI'));
//Training Plan Update Exam Unit
Route::any('ViewTrainingPlanUpdateTestingEva', array('as' => 'ViewTrainingPlanUpdateTestingEva','uses' => 'TrainingPlanReportController@ViewTrainingPlanUpdateTestingEva'));
Route::any('editCourseYearPlanTestingEva',array('as'=>'editCourseYearPlanTestingEva','uses'=>'TrainingPlanReportController@editCourseYearPlanTestingEva'));
Route::any('PrintPDFTrainingPlanReportByTestingEva', array('as' => 'PrintPDFTrainingPlanReportByTestingEva','uses' => 'TrainingPlanReportController@PrintPDFTrainingPlanReportByTestingEva'));
Route::any('PrintExcelTrainingPlanReportByTestingEva', array('as' => 'PrintExcelTrainingPlanReportByTestingEva','uses' => 'TrainingPlanReportController@PrintExcelTrainingPlanReportByTestingEva'));
//2018-02-22
Route::any('PrintPDFTrainingPlanReportByTestingEva1', array('as' => 'PrintPDFTrainingPlanReportByTestingEva1','uses' => 'TrainingPlanReportController@PrintPDFTrainingPlanReportByTestingEva1'));
Route::any('PrintExcelTrainingPlanReportByTestingEva1', array('as' => 'PrintExcelTrainingPlanReportByTestingEva1','uses' => 'TrainingPlanReportController@PrintExcelTrainingPlanReportByTestingEva1'));
//center wise summery report
Route::any('ViewCriteariaWiseMonitoringProgressReport', array('as' => 'ViewCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@ViewCriteariaWiseMonitoringProgressReport'));
Route::any('LoadViewCriteariaWiseMonitoringProgressReport', array('as' => 'LoadViewCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@LoadViewCriteariaWiseMonitoringProgressReport'));
Route::any('DownloadLoadViewCriteariaWiseMonitoringProgressReport', array('as' => 'DownloadLoadViewCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@DownloadLoadViewCriteariaWiseMonitoringProgressReport'));
Route::any('CriteariaWiseloaddistrictcentersin', array('as' => 'CriteariaWiseloaddistrictcentersin','uses' => 'TrainingPlanReportController@CriteariaWiseloaddistrictcentersin'));
Route::any('CriteariaWiseFilterCourseYearPlans1', array('as' => 'CriteariaWiseFilterCourseYearPlans1','uses' => 'TrainingPlanReportController@CriteariaWiseFilterCourseYearPlans1'));
//sub critearia Progress Report
Route::any('ViewSubCriteariaWiseMonitoringProgressReport', array('as' => 'ViewSubCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@ViewSubCriteariaWiseMonitoringProgressReport'));
Route::any('LoadViewSubCriteariaWiseMonitoringProgressReport', array('as' => 'LoadViewSubCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@LoadViewSubCriteariaWiseMonitoringProgressReport'));
Route::any('DownloadLoadViewSubCriteariaWiseMonitoringProgressReport', array('as' => 'DownloadLoadViewSubCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@DownloadLoadViewSubCriteariaWiseMonitoringProgressReport'));
//Edit BY DIsTO
Route::any('ViewTrainingPlanUpdateDisNVTIDOTO', array('as' => 'ViewTrainingPlanUpdateDisNVTIDOTO','uses' => 'TrainingPlanReportController@ViewTrainingPlanUpdateDisNVTIDOTO'));
Route::any('editCourseYearPlanDisNVTIDOTO',array('as'=>'editCourseYearPlanDisNVTIDOTO','uses'=>'TrainingPlanReportController@editCourseYearPlanDisNVTIDOTO'));
//Center Monitoring Criteria
Route::any('ViewCenterCriteriaClass', array('as' => 'ViewCenterCriteriaClass','uses' => 'CenterMonitoringController@ViewCenterCriteriaClass'));
Route::any('CreateCenterCriteriaClass', array('as' => 'CreateCenterCriteriaClass','uses' => 'CenterMonitoringController@CreateCenterCriteriaClass'));
Route::any('DeleteCenterCriteriaClass', array('as' => 'DeleteCenterCriteriaClass','uses' => 'CenterMonitoringController@DeleteCenterCriteriaClass'));
Route::any('ViewCenterCriteriaEmpType', array('as' => 'ViewCenterCriteriaEmpType','uses' => 'CenterMonitoringController@ViewCenterCriteriaEmpType'));
Route::any('CreateCenterCriteriaEmpType', array('as' => 'CreateCenterCriteriaEmpType','uses' => 'CenterMonitoringController@CreateCenterCriteriaEmpType'));
Route::any('DeleteCenterCriteriaEmpType', array('as' => 'DeleteCenterCriteriaEmpType','uses' => 'CenterMonitoringController@DeleteCenterCriteriaEmpType'));
Route::any('ViewCenterCriteriaCategory', array('as' => 'ViewCenterCriteriaCategory','uses' => 'CenterMonitoringController@ViewCenterCriteriaCategory'));
Route::any('CreateCenterCriteriaCategory', array('as' => 'CreateCenterCriteriaCategory','uses' => 'CenterMonitoringController@CreateCenterCriteriaCategory'));
Route::any('DeleteCenterCriteriaCategory', array('as' => 'DeleteCenterCriteriaCategory','uses' => 'CenterMonitoringController@DeleteCenterCriteriaCategory'));
Route::any('ViewCenterCriterias', array('as' => 'ViewCenterCriterias','uses' => 'CenterMonitoringController@ViewCenterCriterias'));
Route::any('CreateCenterCriterias', array('as' => 'CreateCenterCriterias','uses' => 'CenterMonitoringController@CreateCenterCriterias'));
Route::any('GetCenterCalClass', array('as' => 'GetCenterCalClass','uses' => 'CenterMonitoringController@GetCenterCalClass'));
Route::any('DeleteSubCenterCriteria', array('as' => 'DeleteSubCenterCriteria','uses' => 'CenterMonitoringController@DeleteSubCenterCriteria'));

//Center Monitoring Plan
Route::any('CreateMOCenterNewMonitoringPlan', array('as' => 'CreateMOCenterNewMonitoringPlan','uses' => 'CenterMonitoringController@CreateMOCenterNewMonitoringPlan'));
Route::any('FilterCourseYearPlansNew', array('as' => 'FilterCourseYearPlansNew','uses' => 'CenterMonitoringController@FilterCourseYearPlansNew'));
Route::any('ViewTOMONewCenterMonitoringPlan', array('as' => 'ViewTOMONewCenterMonitoringPlan','uses' => 'CenterMonitoringController@ViewTOMONewCenterMonitoringPlan'));
Route::any('DeleteTONewMOnitoringPlan', array('as' => 'DeleteTONewMOnitoringPlan','uses' => 'CenterMonitoringController@DeleteTONewMOnitoringPlan'));
Route::any('ViewDDADMONewCenterMonitoringPlan', array('as' => 'ViewDDADMONewCenterMonitoringPlan','uses' => 'CenterMonitoringController@ViewDDADMONewCenterMonitoringPlan'));
Route::any('DDADRejectMONewCenterMOnitoringPlan', array('as' => 'DDADRejectMONewCenterMOnitoringPlan','uses' => 'CenterMonitoringController@DDADRejectMONewCenterMOnitoringPlan'));
Route::any('DDADConfirmMONewCenterMOnitoringPlan', array('as' => 'DDADConfirmMONewCenterMOnitoringPlan','uses' => 'CenterMonitoringController@DDADConfirmMONewCenterMOnitoringPlan'));
//Do Center Monitoring
Route::any('DoNewCenterMonitor', array('as' => 'DoNewCenterMonitor','uses' => 'CenterMonitoringController@DoNewCenterMonitor'));
Route::any('LoadNewCenterMonitoringForm', array('as' => 'LoadNewCenterMonitoringForm','uses' => 'CenterMonitoringController@LoadNewCenterMonitoringForm'));
Route::any('EditNewCenterTOMonitoringFormEntered', array('as' => 'EditNewCenterTOMonitoringFormEntered','uses' => 'CenterMonitoringController@EditNewCenterTOMonitoringFormEntered'));
Route::any('ViewNewCenterTOMonitoringFormEntered', array('as' => 'ViewNewCenterTOMonitoringFormEntered','uses' => 'CenterMonitoringController@ViewNewCenterTOMonitoringFormEntered'));
Route::any('PrintNewCenterTOMonitoringFormEntered', array('as' => 'PrintNewCenterTOMonitoringFormEntered','uses' => 'CenterMonitoringController@PrintNewCenterTOMonitoringFormEntered'));

//Second Rev Generate Time Table
Route::any('SecondRevGetOrmit', array('as' => 'SecondRevGetOrmit','uses' => 'MOActualTimeTableController@SecondRevGetOrmit'));
Route::any('UpdateTimetabletaskList', array('as' => 'UpdateTimetabletaskList','uses' => 'MOActualTimeTableController@UpdateTimetabletaskList'));
Route::any('InstantCourseApprovals', array('as' => 'InstantCourseApprovals','uses' => 'MOActualTimeTableController@InstantCourseApprovals'));
Route::any('InstantCenterApprovals', array('as' => 'InstantCenterApprovals','uses' => 'MOActualTimeTableController@InstantCenterApprovals'));

//Center Monitoring Criteria Wise Progress Report
Route::any('ViewCenterCriteariaWiseMonitoringProgressReport', array('as' => 'ViewCenterCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@ViewCenterCriteariaWiseMonitoringProgressReport'));
Route::any('LoadViewCenterCriteariaWiseMonitoringProgressReport', array('as' => 'LoadViewCenterCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@LoadViewCenterCriteariaWiseMonitoringProgressReport'));
Route::any('DownloadLoadViewCenterCriteariaWiseMonitoringProgressReport', array('as' => 'DownloadLoadViewCenterCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@DownloadLoadViewCenterCriteariaWiseMonitoringProgressReport'));

//Center Monitoring Sub Criteria Wise Progress Report
Route::any('ViewCenterSubCriteariaWiseMonitoringProgressReport', array('as' => 'ViewCenterSubCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@ViewCenterSubCriteariaWiseMonitoringProgressReport'));
Route::any('LoadViewCenterSubCriteariaWiseMonitoringProgressReport', array('as' => 'LoadViewCenterSubCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@LoadViewCenterSubCriteariaWiseMonitoringProgressReport'));
Route::any('DownloadLoadViewCenterSubCriteariaWiseMonitoringProgressReport', array('as' => 'DownloadLoadViewCenterSubCriteariaWiseMonitoringProgressReport','uses' => 'TrainingPlanReportController@DownloadLoadViewCenterSubCriteariaWiseMonitoringProgressReport'));
//Center District Wise Monitoring progress report
Route::any('ViewDistrictWiseCenterMonitoringProgress', array('as' => 'ViewDistrictWiseCenterMonitoringProgress','uses' => 'MOActualTimeTableController@ViewDistrictWiseCenterMonitoringProgress'));
Route::any('LoadViewDistrictWiseCenterMonitoringProgress', array('as' => 'LoadViewDistrictWiseCenterMonitoringProgress','uses' => 'MOActualTimeTableController@LoadViewDistrictWiseCenterMonitoringProgress'));
Route::any('DownloadLoadViewDistrictWiseCenterMonitoringProgress', array('as' => 'DownloadLoadViewDistrictWiseCenterMonitoringProgress','uses' => 'MOActualTimeTableController@DownloadLoadViewDistrictWiseCenterMonitoringProgress'));
//start Competency Standards
Route::get('ViewCompetemcyStandard', array('as' => 'ViewCompetemcyStandard', 'uses' => 'CompetencyStandardController@ViewCompetemcyStandard'));
Route::any('deleteCompetemcyStandard', array('as' => 'deleteCompetemcyStandard', 'uses' => 'CompetencyStandardController@deleteCompetemcyStandard'));
Route::any('CreateCompetemcyStandard', array('as' => 'CreateCompetemcyStandard', 'uses' => 'CompetencyStandardController@CreateCompetemcyStandard'));
Route::any('editCompetemcyStandard', array('as' => 'editCompetemcyStandard', 'uses' => 'CompetencyStandardController@editCompetemcyStandard'));
Route::get('findCompetemcyStandard', array('as' => 'findCompetemcyStandard', 'uses' => 'CompetencyStandardController@findCompetemcyStandard'));
//end Competency Standards
// start NVQ Packages
Route::get('ViewNVQQualificationPackages', array('as' => 'ViewNVQQualificationPackages', 'uses' => 'CompetencyStandardController@ViewNVQQualificationPackages'));
Route::any('deleteNVQQualificationPackages', array('as' => 'deleteNVQQualificationPackages', 'uses' => 'CompetencyStandardController@deleteNVQQualificationPackages'));
Route::any('CreateNVQQualificationPackages', array('as' => 'CreateNVQQualificationPackages', 'uses' => 'CompetencyStandardController@CreateNVQQualificationPackages'));
Route::any('editNVQQualificationPackages', array('as' => 'editNVQQualificationPackages', 'uses' => 'CompetencyStandardController@editNVQQualificationPackages'));
Route::get('findNVQQualificationPackages', array('as' => 'findNVQQualificationPackages', 'uses' => 'CompetencyStandardController@findNVQQualificationPackages'));
//end  NVQ Packages
Route::any('InactiveModuletask', array('as' => 'InactiveModuletask', 'uses' => 'ModuleTaskSeqController@InactiveModuletask'));
//coursewise Monitoring Count acoording to the duration
Route::any('ViewcoursewisemonitoringCountReport', array('as' => 'ViewcoursewisemonitoringCountReport','uses' => 'CountReportController@ViewcoursewisemonitoringCountReport'));
Route::any('LoadViewcoursewisemonitoringCountReport', array('as' => 'LoadViewcoursewisemonitoringCountReport','uses' => 'CountReportController@LoadViewcoursewisemonitoringCountReport'));
Route::any('DownloadLoadViewcoursewisemonitoringCountReport', array('as' => 'DownloadLoadViewcoursewisemonitoringCountReport','uses' => 'CountReportController@DownloadLoadViewcoursewisemonitoringCountReport'));
//history Module Task Seq
Route::get('HistoryViewModuleTaskSeq', array('as' => 'HistoryViewModuleTaskSeq', 'uses' => 'ModuleTaskSeqController@HistoryViewModuleTaskSeq'));
Route::get('HistorySearchModuleTaskSeq', array('as' => 'HistorySearchModuleTaskSeq', 'uses' => 'ModuleTaskSeqController@HistorySearchModuleTaskSeq'));
Route::any('HistoryPrintModuleTaskSeq', array('as' => 'HistoryPrintModuleTaskSeq', 'uses' => 'ModuleTaskSeqController@HistoryPrintModuleTaskSeq'));
Route::any('GetcourseVertions', array('as' => 'GetcourseVertions', 'uses' => 'ModuleTaskSeqController@GetcourseVertions'));

//Accreditation New Developing
Route::any('ViewAccreditationNew', array('as' => 'ViewAccreditationNew', 'uses' => 'NewAccreditationController@ViewAccreditationNew'));
Route::any('CreateAccreditationNew', array('as' => 'CreateAccreditationNew', 'uses' => 'NewAccreditationController@CreateAccreditationNew'));
Route::any('LoadAccreditationCDList', array('as' => 'LoadAccreditationCDList', 'uses' => 'NewAccreditationController@LoadAccreditationCDList'));
Route::any('LoadAccreditationCDListII', array('as' => 'LoadAccreditationCDListII', 'uses' => 'NewAccreditationController@LoadAccreditationCDListII'));
Route::any('DeleteAccreditationNew', array('as' => 'DeleteAccreditationNew', 'uses' => 'NewAccreditationController@DeleteAccreditationNew'));
Route::any('DownloadExcelAccreditationNew', array('as' => 'DownloadExcelAccreditationNew', 'uses' => 'NewAccreditationController@DownloadExcelAccreditationNew'));
Route::any('LoadMoinstructorListDis', array('as' => 'LoadMoinstructorListDis','uses' => 'TrainingPlanReportController@LoadMoinstructorListDis'));
Route::any('loadaccreditationTimetable', array('as' => 'loadaccreditationTimetable','uses' => 'NewAccreditationController@loadaccreditationTimetable'));
// district wse percentage
Route::any('ViewDistrictWisePercentageReport', array('as' => 'ViewDistrictWisePercentageReport','uses' => 'CountReportController@ViewDistrictWisePercentageReport'));
Route::any('LoadViewDistrictWisePercentageReport', array('as' => 'LoadViewDistrictWisePercentageReport','uses' => 'CountReportController@LoadViewDistrictWisePercentageReport'));
Route::any('DownloadLoadViewDistrictWisePercentageReport', array('as' => 'DownloadLoadViewDistrictWisePercentageReport','uses' => 'CountReportController@DownloadLoadViewDistrictWisePercentageReport'));
//user createALSubject
Route::any('loadempcentersin', array('as' => 'loadempcentersin','uses' => 'UserController@loadempcentersin'));
//AccreditationPayment
Route::any('ViewAccreditationPaymentNew', array('as' => 'ViewAccreditationPaymentNew', 'uses' => 'NewAccreditationController@ViewAccreditationPaymentNew'));
Route::any('CreateAccreditationPaymentNew', array('as' => 'CreateAccreditationPaymentNew', 'uses' => 'NewAccreditationController@CreateAccreditationPaymentNew'));
Route::any('loadaccreditationapplicationTimetable', array('as' => 'loadaccreditationapplicationTimetable', 'uses' => 'NewAccreditationController@loadaccreditationapplicationTimetable'));
Route::any('DeleteAccreditationPaymentNew', array('as' => 'DeleteAccreditationPaymentNew', 'uses' => 'NewAccreditationController@DeleteAccreditationPaymentNew'));
Route::any('ADDpaymentshortcut', array('as' => 'ADDpaymentshortcut', 'uses' => 'NewAccreditationController@ADDpaymentshortcut'));
Route::any('ADDpaymentshortcut11', array('as' => 'ADDpaymentshortcut11', 'uses' => 'NewAccreditationController@ADDpaymentshortcut11'));

// Accteditation District Wise Report
Route::any('ViewAccreditationDistrictWiseReport', array('as' => 'ViewAccreditationDistrictWiseReport','uses' => 'CountReportController@ViewAccreditationDistrictWiseReport'));
Route::any('LoadViewAccreditationDistrictWiseReport', array('as' => 'LoadViewAccreditationDistrictWiseReport','uses' => 'CountReportController@LoadViewAccreditationDistrictWiseReport'));
Route::any('DownloadLoadViewAccreditationDistrictWiseReport', array('as' => 'DownloadLoadViewAccreditationDistrictWiseReport','uses' => 'CountReportController@DownloadLoadViewAccreditationDistrictWiseReport'));

//TempCourseYearPlan Update 2016/2017

Route::any('ViewTrainingPlanUpdateTestingEvaOld', array('as' => 'ViewTrainingPlanUpdateTestingEvaOld','uses' => 'TempCourseYearPlanController@ViewTrainingPlanUpdateTestingEvaOld'));
Route::any('editCourseYearPlanTestingEvaOld',array('as'=>'editCourseYearPlanTestingEvaOld','uses'=>'TempCourseYearPlanController@editCourseYearPlanTestingEvaOld'));
Route::any('OLDSaveMOInstructor', array('as' => 'OLDSaveMOInstructor','uses' => 'TempCourseYearPlanController@OLDSaveMOInstructor'));
Route::any('loaddistrictcentersinTCOld', array('as' => 'loaddistrictcentersinTCOld','uses' => 'TempCourseYearPlanController@loaddistrictcentersinTCOld'));
Route::any('LoadMooldinstructorListDis', array('as' => 'LoadMooldinstructorListDis','uses' => 'TempCourseYearPlanController@LoadMooldinstructorListDis'));
Route::any('PrintExcelTrainingPlanReportByTestingEva1OLD', array('as' => 'PrintExcelTrainingPlanReportByTestingEva1OLD','uses' => 'TempCourseYearPlanController@PrintExcelTrainingPlanReportByTestingEva1OLD'));
//Accreditation CourseWise Report
Route::any('ViewAccreditationCourseWiseReport', array('as' => 'ViewAccreditationCourseWiseReport','uses' => 'CountReportController@ViewAccreditationCourseWiseReport'));
Route::any('LoadViewAccreditationCourseWiseReport', array('as' => 'LoadViewAccreditationCourseWiseReport','uses' => 'CountReportController@LoadViewAccreditationCourseWiseReport'));
Route::any('DownloadLoadViewAccreditationCourseWiseReport', array('as' => 'DownloadLoadViewAccreditationCourseWiseReport','uses' => 'CountReportController@DownloadLoadViewAccreditationCourseWiseReport'));
Route::any('Accreditationtrdaecourse', array('as' => 'Accreditationtrdaecourse','uses' => 'CountReportController@Accreditationtrdaecourse'));

Route::any('loaddistrictcourseinTCOld', array('as' => 'loaddistrictcourseinTCOld','uses' => 'TempCourseYearPlanController@loaddistrictcourseinTCOld'));
Route::any('QuestionBankSaveAll', array('as' => 'QuestionBankSaveAll','uses' => 'MOActualTimeTableController@QuestionBankSaveAll'));

//Monitoring Comments

Route::any('ViewComments', array('as' => 'ViewComments', 'uses' => 'MoCommentController@ViewComments'));
Route::any('LoadCommentCentreList', array('as' => 'LoadCommentCentreList', 'uses' => 'MoCommentController@LoadCommentCentreList'));
Route::any('UpdateCommentIgnored', array('as' => 'UpdateCommentIgnored', 'uses' => 'MoCommentController@UpdateCommentIgnored'));
Route::any('UpdateCommentClosed', array('as' => 'UpdateCommentClosed', 'uses' => 'MoCommentController@UpdateCommentClosed'));
Route::any('MoAddNewComment', array('as' => 'MoAddNewComment', 'uses' => 'MoCommentController@MoAddNewComment'));
Route::any('GetCurrentCommentList', array('as' => 'GetCurrentCommentList', 'uses' => 'MoCommentController@GetCurrentCommentList'));
Route::any('GetCommentDistrict', array('as' => 'GetCommentDistrict', 'uses' => 'MoCommentController@GetCommentDistrict'));
Route::any('SaveMoCommentAssignOfc', array('as' => 'SaveMoCommentAssignOfc', 'uses' => 'MoCommentController@SaveMoCommentAssignOfc'));
Route::any('ViewMyComments', array('as' => 'ViewMyComments', 'uses' => 'MoCommentController@ViewMyComments'));
Route::any('SaveMoMyCommentAssignOfc', array('as' => 'SaveMoMyCommentAssignOfc', 'uses' => 'MoCommentController@SaveMoMyCommentAssignOfc'));

Route::any('DownloadCOurseModuletaskQAll', array('as' => 'DownloadCOurseModuletaskQAll','uses' => 'MOActualTimeTableController@DownloadCOurseModuletaskQAll'));
Route::any('printQuestionList', array('as' => 'printQuestionList','uses' => 'MOActualTimeTableController@printQuestionList'));
Route::any('DownloadRandomQuestionPaper', array('as' => 'DownloadRandomQuestionPaper','uses' => 'MOActualTimeTableController@DownloadRandomQuestionPaper'));
Route::any('printRandomGeneratedMCQPaper', array('as' => 'printRandomGeneratedMCQPaper','uses' => 'MOActualTimeTableController@printRandomGeneratedMCQPaper'));

Route::any('InstantAccreditationApplication', array('as' => 'InstantAccreditationApplication','uses' => 'MOActualTimeTableController@InstantAccreditationApplication'));
Route::any('InstantAccreditationRecordPending', array('as' => 'InstantAccreditationRecordPending','uses' => 'MOActualTimeTableController@InstantAccreditationRecordPending'));
Route::any('InstantAccreditationAppliRecordPending', array('as' => 'InstantAccreditationAppliRecordPending','uses' => 'MOActualTimeTableController@InstantAccreditationAppliRecordPending'));
Route::any('InstantAccreditationPaymentPending', array('as' => 'InstantAccreditationPaymentPending','uses' => 'MOActualTimeTableController@InstantAccreditationPaymentPending'));
Route::any('getinstructorsMoCmPlan', array('as' => 'getinstructorsMoCmPlan','uses' => 'MOActualTimeTableController@getinstructorsMoCmPlan'));
//start course details
Route::any('editCourseDetails',array('as'=>'editCourseDetails','uses'=>'CourseDetailsController@editCourseDetails'));
Route::any('deleteCourseDetails',array('as'=>'deleteCourseDetails','uses'=>'CourseDetailsController@deleteCourseDetails'));
Route::any('viewCourseDetails',array('as'=>'viewCourseDetails','uses'=>'CourseDetailsController@viewCourseDetails'));
Route::any('createCourseDetails',array('as'=>'createCourseDetails','uses'=>'CourseDetailsController@createCourseDetails'));
//end course details
// Start Course Started 
Route::any('deleteCoursestarted',array('as'=>'deleteCoursestarted','uses'=>'CourseStartedController@deleteCoursestarted'));
Route::any('viewCourseStarted',array('as'=>'viewCourseStarted','uses'=>'CourseStartedController@viewCourseStarted'));
Route::any('ajaxCreateCourseCode',array('as'=>'ajaxCreateCourseCode','uses'=>'CourseStartedController@ajaxCreateCourseCode'));
Route::any('createCourseStarted',array('as'=>'createCourseStarted','uses'=>'CourseStartedController@createCourseStarted'));
// end Course Started
// start course Year Plan
Route::any('ConfirmCourseYearPlanFirstPage',array('as'=>'ConfirmCourseYearPlanFirstPage','uses'=>'courseYearPlanController@ConfirmCourseYearPlanFirstPage'));
Route::any('ajaxGetFeePartFull',array('as'=>'ajaxGetFeePartFull','uses'=>'courseYearPlanController@ajaxGetFeePartFull'));
Route::any('ConfirmCourseYearPlan',array('as'=>'ConfirmCourseYearPlan','uses'=>'courseYearPlanController@ConfirmCourseYearPlan'));
Route::any('editCourseYearPlan',array('as'=>'editCourseYearPlan','uses'=>'courseYearPlanController@editCourseYearPlan'));
Route::any('CreateCourseYearPlanOne',array('as'=>'CreateCourseYearPlanOne','uses'=>'courseYearPlanController@CreateCourseYearPlanOne'));
Route::any('CreateCourseYearPlan',array('as'=>'CreateCourseYearPlan','uses'=>'courseYearPlanController@CreateCourseYearPlan'));
Route::any('CreateCourseYearPlan2',array('as'=>'CreateCourseYearPlan2','uses'=>'courseYearPlanController@CreateCourseYearPlan2'));
Route::any('ajaxCheckedValues',array('as'=>'ajaxCheckedValues','uses'=>'courseYearPlanController@ajaxCheckedValues'));
Route::any('viewCourseYearPlan',array('as'=>'viewCourseYearPlan','uses'=>'courseYearPlanController@viewCourseYearPlan'));
Route::any('deleteCourseYearPlan',array('as'=>'deleteCourseYearPlan','uses'=>'courseYearPlanController@deleteCourseYearPlan'));
// end course Year Plan

//HRM start
Route::any('ViewHrServiceCategory', array('as' => 'ViewHrServiceCategory', 'uses' => 'HRServiceCategoryController@ViewHrServiceCategory'));
Route::any('CreateHrServiceCategory', array('as' => 'CreateHrServiceCategory', 'uses' => 'HRServiceCategoryController@CreateHrServiceCategory'));
Route::any('PrintHrServiceCategory', array('as' => 'PrintHrServiceCategory', 'uses' => 'HRServiceCategoryController@PrintHrServiceCategory'));
Route::any('DeleteHrServiceCategory', array('as' => 'DeleteHrServiceCategory', 'uses' => 'HRServiceCategoryController@DeleteHrServiceCategory'));
Route::any('EditHrServiceCategory', array('as' => 'EditHrServiceCategory', 'uses' => 'HRServiceCategoryController@EditHrServiceCategory'));
Route::any('ServiceCategorySaveAll', array('as' => 'ServiceCategorySaveAll', 'uses' => 'HRServiceCategoryController@ServiceCategorySaveAll'));
Route::any('SearchHrServiceCategory', array('as' => 'SearchHrServiceCategory', 'uses' => 'HRServiceCategoryController@SearchHrServiceCategory'));
Route::any('DeactivateHrServiceCategory', array('as' => 'DeactivateHrServiceCategory', 'uses' => 'HRServiceCategoryController@DeactivateHrServiceCategory'));

Route::any('ViewHrEmploymentCode', array('as' => 'ViewHrEmploymentCode', 'uses' => 'HRServiceCategoryController@ViewHrEmploymentCode'));
Route::any('CreateHrEmploymentCode', array('as' => 'CreateHrEmploymentCode', 'uses' => 'HRServiceCategoryController@CreateHrEmploymentCode'));
Route::any('SearchHrEmploymentCode', array('as' => 'SearchHrEmploymentCode', 'uses' => 'HRServiceCategoryController@SearchHrEmploymentCode'));
Route::any('EditHrEmploymentCode', array('as' => 'EditHrEmploymentCode', 'uses' => 'HRServiceCategoryController@EditHrEmploymentCode'));
Route::any('DeleteHrEmploymentCode', array('as' => 'DeleteHrEmploymentCode', 'uses' => 'HRServiceCategoryController@DeleteHrEmploymentCode'));
Route::any('SaveAjaxHrEmploymentCode', array('as' => 'SaveAjaxHrEmploymentCode', 'uses' => 'HRServiceCategoryController@SaveAjaxHrEmploymentCode'));
Route::any('LoadAjaxServiceCategoryYear', array('as' => 'LoadAjaxServiceCategoryYear', 'uses' => 'HRServiceCategoryController@LoadAjaxServiceCategoryYear'));
Route::any('TransEmpServiceCategorySaveAll', array('as' => 'TransEmpServiceCategorySaveAll', 'uses' => 'HRServiceCategoryController@TransEmpServiceCategorySaveAll'));
Route::any('PrintHrEmploymentCode', array('as' => 'PrintHrEmploymentCode', 'uses' => 'HRServiceCategoryController@PrintHrEmploymentCode'));
Route::any('DeactivateHrEmploymentCode', array('as' => 'DeactivateHrEmploymentCode', 'uses' => 'HRServiceCategoryController@DeactivateHrEmploymentCode'));

Route::any('ViewCardreDetails', array('as' => 'ViewCardreDetails', 'uses' => 'HRServiceCategoryController@ViewCardreDetails'));
Route::any('CreateCardreDetails', array('as' => 'CreateCardreDetails', 'uses' => 'HRServiceCategoryController@CreateCardreDetails'));
Route::any('DeleteCardreDetails', array('as' => 'DeleteCardreDetails', 'uses' => 'HRServiceCategoryController@DeleteCardreDetails'));
Route::any('EditCardreDetails', array('as' => 'EditCardreDetails', 'uses' => 'HRServiceCategoryController@EditCardreDetails'));
Route::any('PrintCardreDetails', array('as' => 'PrintCardreDetails', 'uses' => 'HRServiceCategoryController@PrintCardreDetails'));

Route::any('ViewOfficeTimes', array('as' => 'ViewOfficeTimes', 'uses' => 'HRServiceCategoryController@ViewOfficeTimes'));
Route::any('CreateOfficeTimes', array('as' => 'CreateOfficeTimes', 'uses' => 'HRServiceCategoryController@CreateOfficeTimes'));
Route::any('DeleteOfficeTimes', array('as' => 'DeleteOfficeTimes', 'uses' => 'HRServiceCategoryController@DeleteOfficeTimes'));
Route::any('EditOfficeTimes', array('as' => 'EditOfficeTimes', 'uses' => 'HRServiceCategoryController@EditOfficeTimes'));
Route::any('SaveAjaxtOfficeTimes', array('as' => 'SaveAjaxtOfficeTimes', 'uses' => 'HRServiceCategoryController@SaveAjaxtOfficeTimes'));

//HR Employee
Route::any('CreateHREmployee', array('as' => 'CreateHREmployee', 'uses' => 'HREmployeeController@CreateHREmployee'));
Route::any('ViewHREmployee', array('as' => 'ViewHREmployee', 'uses' => 'HREmployeeController@ViewHREmployee'));
Route::any('EditHREmployee', array('as' => 'EditHREmployee', 'uses' => 'HREmployeeController@EditHRoEmployee'));
Route::any('DeleteHREmployee', array('as' => 'DeleteHREmployee', 'uses' => 'HREmployeeController@DeleteHREmployee'));
Route::any('HRloadNicAjaxDetails', array('as' => 'HRloadNicAjaxDetails', 'uses' => 'HREmployeeController@HRloadNicAjaxDetails'));
Route::any('HRPhotoEdit', array('as' => 'HRPhotoEdit', 'uses' => 'HREmployeeController@HRPhotoEdit'));
Route::any('AddHREmployeeNIC', array('as' => 'AddHREmployeeNIC', 'uses' => 'HREmployeeController@AddHREmployeeNIC'));
Route::any('AddHREmployeeEPF', array('as' => 'AddHREmployeeEPF', 'uses' => 'HREmployeeController@AddHREmployeeEPF'));

//HR Promotion
Route::any('EditHRPromotion', array('as' => 'EditHRPromotion', 'uses' => 'HRPromotionController@EditHRPromotion'));
Route::any('DeleteHRPromotion', array('as' => 'DeleteHRPromotion', 'uses' => 'HRPromotionController@DeleteHRPromotion'));
Route::any('ViewHRPromotion', array('as' => 'ViewHRPromotion', 'uses' => 'HRPromotionController@ViewHRPromotion'));
Route::any('CreateHRPromotion', array('as' => 'CreateHRPromotion', 'uses' => 'HRPromotionController@CreateHRPromotion'));
Route::any('LoadAjaxServiceCategoryGrade', array('as' => 'LoadAjaxServiceCategoryGrade', 'uses' => 'HRServiceCategoryController@LoadAjaxServiceCategoryGrade'));
Route::any('getSalaryScaleValue', array('as' => 'getSalaryScaleValue', 'uses' => 'HRServiceCategoryController@getSalaryScaleValue'));
Route::any('HRpromotionExist', array('as' => 'HRpromotionExist', 'uses' => 'HRPromotionController@HRpromotionExist'));
Route::any('HEGetEPFList', array('as' => 'HEGetEPFList', 'uses' => 'HRPromotionController@HEGetEPFList'));
Route::any('HECheckTransferTypeName', array('as' => 'HECheckTransferTypeName', 'uses' => 'HRPromotionController@HECheckTransferTypeName'));
Route::any('HEChecktransferType', array('as' => 'HEChecktransferType', 'uses' => 'HRPromotionController@HEChecktransferType'));
Route::any('HEepfLoadajaxDes', array('as' => 'HEepfLoadajaxDes', 'uses' => 'HRPromotionController@HEepfLoadajaxDes'));
Route::any('ViewHRPromotionHistory', array('as' => 'ViewHRPromotionHistory', 'uses' => 'HRPromotionController@ViewHRPromotionHistory'));

Route::any('ViewHRUniversity', array('as' => 'ViewHRUniversity', 'uses' => 'HRPromotionController@ViewHRUniversity'));
Route::any('CreateHRUniversity', array('as' => 'CreateHRUniversity', 'uses' => 'HRPromotionController@CreateHRUniversity'));
Route::any('EditHRUniversity', array('as' => 'EditHRUniversity', 'uses' => 'HRPromotionController@EditHRUniversity'));
Route::any('DeleteHRUniversity', array('as' => 'DeleteHRUniversity', 'uses' => 'HRPromotionController@DeleteHRUniversity'));
//hrqualificationtype
Route::any('ViewHRQualificationType', array('as' => 'ViewHRQualificationType', 'uses' => 'HRPromotionController@ViewHRQualificationType'));
Route::any('CreateHRQualificationType', array('as' => 'CreateHRQualificationType', 'uses' => 'HRPromotionController@CreateHRQualificationType'));
Route::any('EditHRQualificationType', array('as' => 'EditHRQualificationType', 'uses' => 'HRPromotionController@EditHRQualificationType'));
Route::any('DeleteHRQualificationType', array('as' => 'DeleteHRQualificationType', 'uses' => 'HRPromotionController@DeleteHRQualificationType'));
//hrqualificationcategory
Route::any('ViewHRQualificationCategory', array('as' => 'ViewHRQualificationCategory', 'uses' => 'HRPromotionController@ViewHRQualificationCategory'));
Route::any('CreateHRQualificationCategory', array('as' => 'CreateHRQualificationCategory', 'uses' => 'HRPromotionController@CreateHRQualificationCategory'));
Route::any('EditHRQualificationCategory', array('as' => 'EditHRQualificationCategory', 'uses' => 'HRPromotionController@EditHRQualificationCategory'));
Route::any('DeleteHRQualificationCategory', array('as' => 'DeleteHRQualificationCategory', 'uses' => 'HRPromotionController@DeleteHRQualificationCategory'));

//hrqualification
Route::any('ViewHRQualification', array('as' => 'ViewHRQualification', 'uses' => 'HRPromotionController@ViewHRQualification'));
Route::any('CreateHRQualification', array('as' => 'CreateHRQualification', 'uses' => 'HRPromotionController@CreateHRQualification'));
Route::any('EditHRQualification', array('as' => 'EditHRQualification', 'uses' => 'HRPromotionController@EditHRQualification'));
Route::any('DeleteHRQualification', array('as' => 'DeleteHRQualification', 'uses' => 'HRPromotionController@DeleteHRQualification'));

//hrEmployeeQualification
Route::any('ViewHREmployeeQualification', array('as' => 'ViewHREmployeeQualification', 'uses' => 'HRPromotionController@ViewHREmployeeQualification'));
Route::any('CreateHREmployeeQualification', array('as' => 'CreateHREmployeeQualification', 'uses' => 'HRPromotionController@CreateHREmployeeQualification'));
Route::any('EditHREmployeeQualification', array('as' => 'EditHREmployeeQualification', 'uses' => 'HRPromotionController@EditHREmployeeQualification'));
Route::any('DeleteHREmployeeQualification', array('as' => 'DeleteHREmployeeQualification', 'uses' => 'HRPromotionController@DeleteHREmployeeQualification'));
Route::any('HREmpQualificationTypeAjax', array('as' => 'HREmpQualificationTypeAjax', 'uses' => 'HRPromotionController@HREmpQualificationTypeAjax'));
Route::any('HRsaveQualificationDescription', array('as' => 'HRsaveQualificationDescription', 'uses' => 'HRPromotionController@HRsaveQualificationDescription'));
Route::any('HRnicAjax', array('as' => 'HRnicAjax', 'uses' => 'HRPromotionController@HRnicAjax'));
Route::any('ViewHREmployeeQualificationHistory', array('as' => 'ViewHREmployeeQualificationHistory', 'uses' => 'HRPromotionController@ViewHREmployeeQualificationHistory'));

//hremployee workexperience
Route::any('ViewHREmployeeExperience', array('as' => 'ViewHREmployeeExperience', 'uses' => 'HRPromotionController@ViewHREmployeeExperience'));
Route::any('CreateHREmployeeExperience', array('as' => 'CreateHREmployeeExperience', 'uses' => 'HRPromotionController@CreateHREmployeeExperience'));
Route::any('EditHREmployeeExperience', array('as' => 'EditHREmployeeExperience', 'uses' => 'HRPromotionController@EditHREmployeeExperience'));
Route::any('DeleteHREmployeeExperience', array('as' => 'DeleteHREmployeeExperience', 'uses' => 'HRPromotionController@DeleteHREmployeeExperience'));
Route::any('ViewHREmployeeExperienceHistory', array('as' => 'ViewHREmployeeExperienceHistory', 'uses' => 'HRPromotionController@ViewHREmployeeExperienceHistory'));
//hrexperiencecompany
Route::any('ViewHRExperienceCompany', array('as' => 'ViewHRExperienceCompany', 'uses' => 'HRPromotionController@ViewHRExperienceCompany'));
Route::any('CreateHRExperienceCompany', array('as' => 'CreateHRExperienceCompany', 'uses' => 'HRPromotionController@CreateHRExperienceCompany'));
Route::any('EditHRExperienceCompany', array('as' => 'EditHRExperienceCompany', 'uses' => 'HRPromotionController@EditHRExperienceCompany'));
Route::any('DeleteHRExperienceCompany', array('as' => 'DeleteHRExperienceCompany', 'uses' => 'HRPromotionController@DeleteHRExperienceCompany'));
//hrexperienceDesignation
Route::any('ViewHRExperienceDesignation', array('as' => 'ViewHRExperienceDesignation', 'uses' => 'HRPromotionController@ViewHRExperienceDesignation'));
Route::any('CreateHRExperienceDesignation', array('as' => 'CreateHRExperienceDesignation', 'uses' => 'HRPromotionController@CreateHRExperienceDesignation'));
Route::any('EditHRExperienceDesignation', array('as' => 'EditHRExperienceDesignation', 'uses' => 'HRPromotionController@EditHRExperienceDesignation'));
Route::any('DeleteHRExperienceDesignation', array('as' => 'DeleteHRExperienceDesignation', 'uses' => 'HRPromotionController@DeleteHRExperienceDesignation'));
//hremployeeProfile
Route::any('ViewHREmployeeProfile', array('as' => 'ViewHREmployeeProfile', 'uses' => 'HRPromotionController@ViewHREmployeeProfile'));
Route::any('HREmployeeProfileajaxViewData', array('as' => 'HREmployeeProfileajaxViewData', 'uses' => 'HRPromotionController@HREmployeeProfileajaxViewData'));
Route::any('HREmployeeProfileGetStudentData', array('as' => 'HREmployeeProfileGetStudentData', 'uses' => 'HRPromotionController@HREmployeeProfileGetStudentData'));
Route::any('ajaxDwnStudentProfile', array('as' => 'ajaxDwnStudentProfile', 'uses' => 'HRPromotionController@dwnStudentProfile'));
Route::any('LoadAjaxServiceCategorySteps', array('as' => 'LoadAjaxServiceCategorySteps', 'uses' => 'HRServiceCategoryController@LoadAjaxServiceCategorySteps'));
Route::any('GetTransferTypeAvailable', array('as' => 'GetTransferTypeAvailable', 'uses' => 'HRPromotionController@GetTransferTypeAvailable'));
Route::any('PrintHREmployeeProfile', array('as' => 'PrintHREmployeeProfile', 'uses' => 'HRPromotionController@PrintHREmployeeProfile'));
//hremployeeEBQualification
Route::any('ViewHREmployeeEBQualification', array('as' => 'ViewHREmployeeEBQualification', 'uses' => 'HRPromotionController@ViewHREmployeeEBQualification'));
Route::any('CreateHREmployeeEBQualification', array('as' => 'CreateHREmployeeEBQualification', 'uses' => 'HRPromotionController@CreateHREmployeeEBQualification'));
Route::any('EditHREmployeeEBQualification', array('as' => 'EditHREmployeeEBQualification', 'uses' => 'HRPromotionController@EditHREmployeeEBQualification'));
Route::any('DeleteHREmployeeEBQualification', array('as' => 'DeleteHREmployeeEBQualification', 'uses' => 'HRPromotionController@DeleteHREmployeeEBQualification'));
Route::any('ViewHREmployeeEBQualificationHistory', array('as' => 'ViewHREmployeeEBQualificationHistory', 'uses' => 'HRPromotionController@ViewHREmployeeEBQualificationHistory'));

//hremployee Training
Route::any('ViewHREmployeeTraining', array('as' => 'ViewHREmployeeTraining', 'uses' => 'HRPromotionController@ViewHREmployeeTraining'));
Route::any('CreateHREmployeeTraining', array('as' => 'CreateHREmployeeTraining', 'uses' => 'HRPromotionController@CreateHREmployeeTraining'));
Route::any('EditHREmployeeTraining', array('as' => 'EditHREmployeeTraining', 'uses' => 'HRPromotionController@EditHREmployeeTraining'));
Route::any('DeleteHREmployeeTraining', array('as' => 'DeleteHREmployeeTraining', 'uses' => 'HRPromotionController@DeleteHREmployeeTraining'));
Route::any('ViewHREmployeeTrainingHistory', array('as' => 'ViewHREmployeeTrainingHistory', 'uses' => 'HRPromotionController@ViewHREmployeeTrainingHistory'));

//hremployeeloan
Route::any('ViewHREmployeeLoan', array('as' => 'ViewHREmployeeLoan', 'uses' => 'HRPromotionController@ViewHREmployeeLoan'));
Route::any('CreateHREmployeeLoan', array('as' => 'CreateHREmployeeLoan', 'uses' => 'HRPromotionController@CreateHREmployeeLoan'));
Route::any('EditHREmployeeLoan', array('as' => 'EditHREmployeeLoan', 'uses' => 'HRPromotionController@EditHREmployeeLoan'));
Route::any('DeleteHREmployeeLoan', array('as' => 'DeleteHREmployeeLoan', 'uses' => 'HRPromotionController@DeleteHREmployeeLoan'));
Route::any('ViewHREmployeeLoanHistory', array('as' => 'ViewHREmployeeLoanHistory', 'uses' => 'HRPromotionController@ViewHREmployeeLoanHistory'));
Route::any('LoadhrEmployeeGuarantorwithourOwner', array('as' => 'LoadhrEmployeeGuarantorwithourOwner', 'uses' => 'HRPromotionController@LoadhrEmployeeGuarantorwithourOwner'));

//hrpersonalfiledoc
Route::any('ViewHRPersonalFileDoc', array('as' => 'ViewHRPersonalFileDoc', 'uses' => 'HRPromotionController@ViewHRPersonalFileDoc'));
Route::any('CreateHRPersonalFileDoc', array('as' => 'CreateHRPersonalFileDoc', 'uses' => 'HRPromotionController@CreateHRPersonalFileDoc'));
Route::any('EditHRPersonalFileDoc', array('as' => 'EditHRPersonalFileDoc', 'uses' => 'HRPromotionController@EditHRPersonalFileDoc'));
Route::any('DeleteHRPersonalFileDoc', array('as' => 'DeleteHRPersonalFileDoc', 'uses' => 'HRPromotionController@DeleteHRPersonalFileDoc'));

//hremployeepersonalfiledocument
Route::any('ViewHREmployeePersonalFileDoc', array('as' => 'ViewHREmployeePersonalFileDoc', 'uses' => 'HRPromotionController@ViewHREmployeePersonalFileDoc'));
Route::any('CreateHREmployeePersonalFileDoc', array('as' => 'CreateHREmployeePersonalFileDoc', 'uses' => 'HRPromotionController@CreateHREmployeePersonalFileDoc'));
Route::any('EditHREmployeePersonalFileDoc', array('as' => 'EditHREmployeePersonalFileDoc', 'uses' => 'HRPromotionController@EditHREmployeePersonalFileDoc'));
Route::any('DeleteHREmployeePersonalFileDoc', array('as' => 'DeleteHREmployeePersonalFileDoc', 'uses' => 'HRPromotionController@DeleteHREmployeePersonalFileDoc'));
Route::any('ViewHREmployeePersonalFileDocHistory', array('as' => 'ViewHREmployeePersonalFileDocHistory', 'uses' => 'HRPromotionController@ViewHREmployeePersonalFileDocHistory'));

//HROl Attempt
Route::any('ViewHROLAttempt', array('as' => 'ViewHROLAttempt', 'uses' => 'HRPromotionController@ViewHROLAttempt'));
Route::any('CreateHROLAttempt', array('as' => 'CreateHROLAttempt', 'uses' => 'HRPromotionController@CreateHROLAttempt'));
Route::any('EditHROLAttempt', array('as' => 'EditHROLAttempt', 'uses' => 'HRPromotionController@EditHROLAttempt'));
Route::any('DeleteHROLAttempt', array('as' => 'DeleteHROLAttempt', 'uses' => 'HRPromotionController@DeleteHROLAttempt'));
//HROlsubject
Route::any('ViewHROLSubject', array('as' => 'ViewHROLSubject', 'uses' => 'HRPromotionController@ViewHROLSubject'));
Route::any('CreateHROLSubject', array('as' => 'CreateHROLSubject', 'uses' => 'HRPromotionController@CreateHROLSubject'));
Route::any('EditHROLSubject', array('as' => 'EditHROLSubject', 'uses' => 'HRPromotionController@EditHROLSubject'));
Route::any('DeleteHROLSubject', array('as' => 'DeleteHROLSubject', 'uses' => 'HRPromotionController@DeleteHROLSubject'));
//hrmedium
Route::any('ViewHROLMedium', array('as' => 'ViewHROLMedium', 'uses' => 'HRPromotionController@ViewHROLMedium'));
Route::any('CreateHROLMedium', array('as' => 'CreateHROLMedium', 'uses' => 'HRPromotionController@CreateHROLMedium'));
Route::any('EditHROLMedium', array('as' => 'EditHROLMedium', 'uses' => 'HRPromotionController@EditHROLMedium'));
Route::any('DeleteHROLMedium', array('as' => 'DeleteHROLMedium', 'uses' => 'HRPromotionController@DeleteHROLMedium'));
//hrOlgrades
Route::any('ViewHROLGrades', array('as' => 'ViewHROLGrades', 'uses' => 'HRPromotionController@ViewHROLGrades'));
Route::any('CreateHROLGrades', array('as' => 'CreateHROLGrades', 'uses' => 'HRPromotionController@CreateHROLGrades'));
Route::any('EditHROLGrades', array('as' => 'EditHROLGrades', 'uses' => 'HRPromotionController@EditHROLGrades'));
Route::any('DeleteHROLGrades', array('as' => 'DeleteHROLGrades', 'uses' => 'HRPromotionController@DeleteHROLGrades'));

//hremployeeordineryresults
Route::any('ViewHREmployeeOLResults', array('as' => 'ViewHREmployeeOLResults', 'uses' => 'HRPromotionController@ViewHREmployeeOLResults'));
Route::any('CreateHREmployeeOLResults', array('as' => 'CreateHREmployeeOLResults', 'uses' => 'HRPromotionController@CreateHREmployeeOLResults'));
Route::any('EditHREmployeeOLResults', array('as' => 'EditHREmployeeOLResults', 'uses' => 'HRPromotionController@EditHREmployeeOLResults'));
Route::any('DeleteHREmployeeOLResults', array('as' => 'DeleteHREmployeeOLResults', 'uses' => 'HRPromotionController@DeleteHREmployeeOLResults'));
Route::any('HREmployeeOLResultsCheckAttept', array('as' => 'HREmployeeOLResultsCheckAttept', 'uses' => 'HRPromotionController@HREmployeeOLResultsCheckAttept'));
Route::any('HREmployeeOLResultsSheet', array('as' => 'HREmployeeOLResultsSheet', 'uses' => 'HRPromotionController@HREmployeeOLResultsSheet'));
Route::any('ViewHREmployeeOLResultsSheetHistory', array('as' => 'ViewHREmployeeOLResultsSheetHistory', 'uses' => 'HRPromotionController@ViewHREmployeeOLResultsSheetHistory'));


//HRAl Attempt
Route::any('ViewHRALAttempt', array('as' => 'ViewHRALAttempt', 'uses' => 'HRPromotionController@ViewHRALAttempt'));
Route::any('CreateHRALAttempt', array('as' => 'CreateHRALAttempt', 'uses' => 'HRPromotionController@CreateHRALAttempt'));
Route::any('EditHRALAttempt', array('as' => 'EditHRALAttempt', 'uses' => 'HRPromotionController@EditHRALAttempt'));
Route::any('DeleteHRALAttempt', array('as' => 'DeleteHRALAttempt', 'uses' => 'HRPromotionController@DeleteHRALAttempt'));

//HRAlsubject
Route::any('ViewHRALSubject', array('as' => 'ViewHRALSubject', 'uses' => 'HRPromotionController@ViewHRALSubject'));
Route::any('CreateHRALSubject', array('as' => 'CreateHRALSubject', 'uses' => 'HRPromotionController@CreateHRALSubject'));
Route::any('EditHRALSubject', array('as' => 'EditHRALSubject', 'uses' => 'HRPromotionController@EditHRALSubject'));
Route::any('DeleteHRALSubject', array('as' => 'DeleteHRALSubject', 'uses' => 'HRPromotionController@DeleteHRALSubject'));
//HRAlsubject
Route::any('ViewHRALStream', array('as' => 'ViewHRALStream', 'uses' => 'HRPromotionController@ViewHRALStream'));
Route::any('CreateHRALStream', array('as' => 'CreateHRALStream', 'uses' => 'HRPromotionController@CreateHRALStream'));
Route::any('EditHRALStream', array('as' => 'EditHRALStream', 'uses' => 'HRPromotionController@EditHRALStream'));
Route::any('DeleteHRALStream', array('as' => 'DeleteHRALStream', 'uses' => 'HRPromotionController@DeleteHRALStream'));

//hremployeealresults
Route::any('ViewHREmployeeALResults', array('as' => 'ViewHREmployeeALResults', 'uses' => 'HRPromotionController@ViewHREmployeeALResults'));
Route::any('CreateHREmployeeALResults', array('as' => 'CreateHREmployeeALResults', 'uses' => 'HRPromotionController@CreateHREmployeeALResults'));
Route::any('EditHREmployeeALResults', array('as' => 'EditHREmployeeALResults', 'uses' => 'HRPromotionController@EditHREmployeeALResults'));
Route::any('DeleteHREmployeeALResults', array('as' => 'DeleteHREmployeeALResults', 'uses' => 'HRPromotionController@DeleteHREmployeeALResults'));
Route::any('HREmployeeALResultsCheckAttept', array('as' => 'HREmployeeALResultsCheckAttept', 'uses' => 'HRPromotionController@HREmployeeALResultsCheckAttept'));
Route::any('HREmployeeALResultsSheet', array('as' => 'HREmployeeALResultsSheet', 'uses' => 'HRPromotionController@HREmployeeALResultsSheet'));
Route::any('ViewHREmployeeALResultsSheetHistory', array('as' => 'ViewHREmployeeALResultsSheetHistory', 'uses' => 'HRPromotionController@ViewHREmployeeALResultsSheetHistory'));

//hrtraining Institute 2018-10-01
Route::any('ViewHRTrainingInstitute', array('as' => 'ViewHRTrainingInstitute', 'uses' => 'HRPromotionController@ViewHRTrainingInstitute'));
Route::any('CreateHRTrainingInstitute', array('as' => 'CreateHRTrainingInstitute', 'uses' => 'HRPromotionController@CreateHRTrainingInstitute'));
Route::any('EditHRTrainingInstitute', array('as' => 'EditHRTrainingInstitute', 'uses' => 'HRPromotionController@EditHRTrainingInstitute'));
Route::any('DeleteHRTrainingInstitute', array('as' => 'DeleteHRTrainingInstitute', 'uses' => 'HRPromotionController@DeleteHRTrainingInstitute'));

//hr training Program
Route::any('ViewHRTrainingProgram', array('as' => 'ViewHRTrainingProgram', 'uses' => 'HRPromotionController@ViewHRTrainingProgram'));
Route::any('CreateHRTrainingProgram', array('as' => 'CreateHRTrainingProgram', 'uses' => 'HRPromotionController@CreateHRTrainingProgram'));
Route::any('EditHRTrainingProgram', array('as' => 'EditHRTrainingProgram', 'uses' => 'HRPromotionController@EditHRTrainingProgram'));
Route::any('DeleteHRTrainingProgram', array('as' => 'DeleteHRTrainingProgram', 'uses' => 'HRPromotionController@DeleteHRTrainingProgram'));

//hrtransfer type

Route::any('ViewHRTransferType', array('as' => 'ViewHRTransferType', 'uses' => 'HRPromotionController@ViewHRTransferType'));
Route::any('CreateHRTransferType', array('as' => 'CreateHRTransferType', 'uses' => 'HRPromotionController@CreateHRTransferType'));
Route::any('EditHRTransferType', array('as' => 'EditHRTransferType', 'uses' => 'HRPromotionController@EditHRTransferType'));
Route::any('DeleteHRTransferType', array('as' => 'DeleteHRTransferType', 'uses' => 'HRPromotionController@DeleteHRTransferType'));
//hr employee type
Route::any('ViewHREmployeeType', array('as' => 'ViewHREmployeeType', 'uses' => 'HRPromotionController@ViewHREmployeeType'));
Route::any('CreateHREmployeeType', array('as' => 'CreateHREmployeeType', 'uses' => 'HRPromotionController@CreateHREmployeeType'));
Route::any('EditHREmployeeType', array('as' => 'EditHREmployeeType', 'uses' => 'HRPromotionController@EditHREmployeeType'));
Route::any('DeleteHREmployeeType', array('as' => 'DeleteHREmployeeType', 'uses' => 'HRPromotionController@DeleteHREmployeeType'));

//hr department
Route::any('ViewHRDepartment', array('as' => 'ViewHRDepartment', 'uses' => 'HRPromotionController@ViewHRDepartment'));
Route::any('CreateHRDepartment', array('as' => 'CreateHRDepartment', 'uses' => 'HRPromotionController@CreateHRDepartment'));
Route::any('EditHRDepartment', array('as' => 'EditHRDepartment', 'uses' => 'HRPromotionController@EditHRDepartment'));
Route::any('DeleteHRDepartment', array('as' => 'DeleteHRDepartment', 'uses' => 'HRPromotionController@DeleteHRDepartment'));

//hr loan type
Route::any('ViewHRLoanType', array('as' => 'ViewHRLoanType', 'uses' => 'HRPromotionController@ViewHRLoanType'));
Route::any('CreateHRLoanType', array('as' => 'CreateHRLoanType', 'uses' => 'HRPromotionController@CreateHRLoanType'));
Route::any('EditHRLoanType', array('as' => 'EditHRLoanType', 'uses' => 'HRPromotionController@EditHRLoanType'));
Route::any('DeleteHRLoanType', array('as' => 'DeleteHRLoanType', 'uses' => 'HRPromotionController@DeleteHRLoanType'));

//will expire
Route::any('InstantAccreditationWillExpire', array('as' => 'InstantAccreditationWillExpire','uses' => 'MOActualTimeTableController@InstantAccreditationWillExpire'));
Route::any('DownloadAccreditationWillExpire', array('as' => 'DownloadAccreditationWillExpire','uses' => 'MOActualTimeTableController@DownloadAccreditationWillExpire'));
Route::any('DownloadAccreditationInstaApplication', array('as' => 'DownloadAccreditationInstaApplication','uses' => 'MOActualTimeTableController@DownloadAccreditationInstaApplication'));
Route::any('DownloadAccreditationInstaPayment', array('as' => 'DownloadAccreditationInstaPayment','uses' => 'MOActualTimeTableController@DownloadAccreditationInstaPayment'));

Route::any('extrastepsload', array('as' => 'extrastepsload','uses' => 'HRServiceCategoryController@extrastepsload'));
Route::any('ViewWeekTimeTableLoadCalenderYear', array('as' => 'ViewWeekTimeTableLoadCalenderYear','uses' => 'MOActualTimeTableController@ViewWeekTimeTableLoadCalenderYear'));

Route::any('HrEmployeepersonalfileCompleted', array('as' => 'HrEmployeepersonalfileCompleted', 'uses' => 'HREmployeeController@HrEmployeepersonalfileCompleted'));
Route::any('ViewHREmployeeIncrements', array('as' => 'ViewHREmployeeIncrements', 'uses' => 'HRPromotionController@ViewHREmployeeIncrements'));
Route::any('DownloadAnnualIncrementForm', array('as' => 'DownloadAnnualIncrementForm', 'uses' => 'HRPromotionController@DownloadAnnualIncrementForm'));
Route::any('DownloadAnnualIncrementPaymentForm', array('as' => 'DownloadAnnualIncrementPaymentForm', 'uses' => 'HRPromotionController@DownloadAnnualIncrementPaymentForm'));
Route::any('EditHREmployeeIncrements', array('as' => 'EditHREmployeeIncrements', 'uses' => 'HRPromotionController@EditHREmployeeIncrements'));
Route::any('EditHREmployeeIncrementsAction', array('as' => 'EditHREmployeeIncrementsAction', 'uses' => 'HRPromotionController@EditHREmployeeIncrementsAction'));
Route::any('ViewHREmployeeIncrementsReactive', array('as' => 'ViewHREmployeeIncrementsReactive', 'uses' => 'HRPromotionController@ViewHREmployeeIncrementsReactive'));
Route::any('ActionIncrementReactive', array('as' => 'ActionIncrementReactive', 'uses' => 'HRPromotionController@ActionIncrementReactive'));
Route::any('HREmployeeIncrementsEditMode', array('as' => 'HREmployeeIncrementsEditMode', 'uses' => 'HRPromotionController@HREmployeeIncrementsEditMode'));
Route::any('HREmployeeEditIncrementsEditMode', array('as' => 'HREmployeeEditIncrementsEditMode', 'uses' => 'HRPromotionController@HREmployeeEditIncrementsEditMode'));
Route::any('ViewIncrementHistory', array('as' => 'ViewIncrementHistory', 'uses' => 'HRPromotionController@ViewIncrementHistory'));
Route::any('InstantIncrements', array('as' => 'InstantIncrements','uses' => 'HRPromotionController@InstantIncrements'));
Route::any('DownloadIncrementList', array('as' => 'DownloadIncrementList','uses' => 'HRPromotionController@DownloadIncrementList'));
Route::any('InstantRetirements', array('as' => 'InstantRetirements','uses' => 'HRPromotionController@InstantRetirements'));
Route::any('DownloadRetirementList', array('as' => 'DownloadRetirementList','uses' => 'HRPromotionController@DownloadRetirementList'));

Route::any('ViewDistrictStaffReport', array('as' => 'ViewDistrictStaffReport','uses' => 'HRReportController@ViewDistrictStaffReport'));
Route::any('LoadDistrictStaffReport', array('as' => 'LoadDistrictStaffReport','uses' => 'HRReportController@LoadDistrictStaffReport'));
Route::any('DownloadDistrictStaffReport', array('as' => 'DownloadDistrictStaffReport','uses' => 'HRReportController@DownloadDistrictStaffReport'));
Route::any('ViewDistrictAgeServiceStaffReport', array('as' => 'ViewDistrictAgeServiceStaffReport','uses' => 'HRReportController@ViewDistrictAgeServiceStaffReport'));
Route::any('LoadDistrictAgeServiceStaffReport', array('as' => 'LoadDistrictAgeServiceStaffReport','uses' => 'HRReportController@LoadDistrictAgeServiceStaffReport'));
Route::any('DownloadDistrictAgeServiceStaffReport', array('as' => 'DownloadDistrictAgeServiceStaffReport','uses' => 'HRReportController@DownloadDistrictAgeServiceStaffReport'));
Route::any('ViewDistrictRetirementStaffReport', array('as' => 'ViewDistrictRetirementStaffReport','uses' => 'HRReportController@ViewDistrictRetirementStaffReport'));
Route::any('LoadDistrictRetirementStaffReport', array('as' => 'LoadDistrictRetirementStaffReport','uses' => 'HRReportController@LoadDistrictRetirementStaffReport'));
Route::any('DownloadDistrictRetirementStaffReport', array('as' => 'DownloadDistrictRetirementStaffReport','uses' => 'HRReportController@DownloadDistrictRetirementStaffReport'));
Route::any('ViewDistrictInstructorNotTrainingStaffReport', array('as' => 'ViewDistrictInstructorNotTrainingStaffReport','uses' => 'HRReportController@ViewDistrictInstructorNotTrainingStaffReport'));
Route::any('LoadDistrictInstructorNotTrainingStaffReport', array('as' => 'LoadDistrictInstructorNotTrainingStaffReport','uses' => 'HRReportController@LoadDistrictInstructorNotTrainingStaffReport'));
Route::any('DownloadDistrictInstructorNotTrainingStaffReport', array('as' => 'DownloadDistrictInstructorNotTrainingStaffReport','uses' => 'HRReportController@DownloadDistrictInstructorNotTrainingStaffReport'));

//2018-12-17
Route::any('ViewDistrictProvinceWiseOfficerPercentageReport', array('as' => 'ViewDistrictProvinceWiseOfficerPercentageReport','uses' => 'CountReportController@ViewDistrictProvinceWiseOfficerPercentageReport'));
Route::any('LoadDistrictProvinceWiseOfficerPercentageReport', array('as' => 'LoadDistrictProvinceWiseOfficerPercentageReport','uses' => 'CountReportController@LoadDistrictProvinceWiseOfficerPercentageReport'));
Route::any('DownLoadDistrictProvinceWiseOfficerPercentageReport', array('as' => 'DownLoadDistrictProvinceWiseOfficerPercentageReport','uses' => 'CountReportController@DownLoadDistrictProvinceWiseOfficerPercentageReport'));

//2018-12-21 Crentre Login
Route::any('CreateVTCDailyTask', array('as' => 'CreateVTCDailyTask','uses' => 'MOActualTimeTableController@CreateVTCDailyTask'));
Route::any('DialyTaskTimeTableTaskList', array('as' => 'DialyTaskTimeTableTaskList','uses' => 'MOActualTimeTableController@DialyTaskTimeTableTaskList'));
Route::any('FilterCourseYearPlansDailyTimeTable', array('as' => 'FilterCourseYearPlansDailyTimeTable','uses' => 'MOActualTimeTableController@FilterCourseYearPlansDailyTimeTable'));

//2019-01-11 HOcenterMonitoring
Route::any('ViewHOCenterMonitoringGrade', array('as' => 'ViewHOCenterMonitoringGrade','uses' => 'MOActualTimeTableController@ViewHOCenterMonitoringGrade'));
Route::any('CreateHOCenterMonitoringGrade', array('as' => 'CreateHOCenterMonitoringGrade','uses' => 'MOActualTimeTableController@CreateHOCenterMonitoringGrade'));
Route::any('DeleteHOCenterMonitoringGrade', array('as' => 'DeleteHOCenterMonitoringGrade','uses' => 'MOActualTimeTableController@DeleteHOCenterMonitoringGrade'));
Route::any('ViewHOCenterMonitoringQuestionAnswerType', array('as' => 'ViewHOCenterMonitoringQuestionAnswerType','uses' => 'MOActualTimeTableController@ViewHOCenterMonitoringQuestionAnswerType'));
Route::any('CreateHOCenterMonitoringQuestionAnswerType', array('as' => 'CreateHOCenterMonitoringQuestionAnswerType','uses' => 'MOActualTimeTableController@CreateHOCenterMonitoringQuestionAnswerType'));
Route::any('DeleteHOCenterMonitoringQuestionAnswerType', array('as' => 'DeleteHOCenterMonitoringQuestionAnswerType','uses' => 'MOActualTimeTableController@DeleteHOCenterMonitoringQuestionAnswerType'));

Route::any('ViewHOCenterMonitoringQuestion', array('as' => 'ViewHOCenterMonitoringQuestion','uses' => 'MOActualTimeTableController@ViewHOCenterMonitoringQuestion'));
Route::any('CreateHOCenterMonitoringQuestion', array('as' => 'CreateHOCenterMonitoringQuestion','uses' => 'MOActualTimeTableController@CreateHOCenterMonitoringQuestion'));
Route::any('DeleteHOCenterMonitoringQuestion', array('as' => 'DeleteHOCenterMonitoringQuestion','uses' => 'MOActualTimeTableController@DeleteHOCenterMonitoringQuestion'));

Route::any('ViewHOCenterMonitoringQuestionAnswers', array('as' => 'ViewHOCenterMonitoringQuestionAnswers','uses' => 'MOActualTimeTableController@ViewHOCenterMonitoringQuestionAnswers'));
Route::any('CreateHOCenterMonitoringQuestionAnswers', array('as' => 'CreateHOCenterMonitoringQuestionAnswers','uses' => 'MOActualTimeTableController@CreateHOCenterMonitoringQuestionAnswers'));
Route::any('DeleteHOCenterMonitoringQuestionAnswers', array('as' => 'DeleteHOCenterMonitoringQuestionAnswers','uses' => 'MOActualTimeTableController@DeleteHOCenterMonitoringQuestionAnswers'));

Route::any('ViewHOCenterMonitoringForms', array('as' => 'ViewHOCenterMonitoringForms','uses' => 'MOActualTimeTableController@ViewHOCenterMonitoringForms'));
Route::any('DeleteHOCenterMonitoringForms', array('as' => 'DeleteHOCenterMonitoringForms','uses' => 'MOActualTimeTableController@DeleteHOCenterMonitoringForms'));
Route::any('CreateHOCenterMonitoringForms', array('as' => 'CreateHOCenterMonitoringForms','uses' => 'MOActualTimeTableController@CreateHOCenterMonitoringForms'));
Route::any('EditHOCenterMonitoringForms', array('as' => 'EditHOCenterMonitoringForms','uses' => 'MOActualTimeTableController@EditHOCenterMonitoringForms'));
Route::any('ViewHOCenterMonitoringFormsEntered', array('as' => 'ViewHOCenterMonitoringFormsEntered','uses' => 'MOActualTimeTableController@ViewHOCenterMonitoringFormsEntered'));
Route::any('PrintHOCenterMonitoringFormsEntered', array('as' => 'PrintHOCenterMonitoringFormsEntered','uses' => 'MOActualTimeTableController@PrintHOCenterMonitoringFormsEntered'));

Route::any('ViewHrServiceCategorySalaryConversion', array('as' => 'ViewHrServiceCategorySalaryConversion', 'uses' => 'HRServiceCategoryController@ViewHrServiceCategorySalaryConversion'));
Route::any('CreateHrServiceCategorySalaryConversion', array('as' => 'CreateHrServiceCategorySalaryConversion', 'uses' => 'HRServiceCategoryController@CreateHrServiceCategorySalaryConversion'));
Route::any('SearchHrServiceCategorySalaryConversion', array('as' => 'SearchHrServiceCategorySalaryConversion', 'uses' => 'HRServiceCategoryController@SearchHrServiceCategorySalaryConversion'));
Route::any('ServiceCategorySalaryConversionSaveAll', array('as' => 'ServiceCategorySalaryConversionSaveAll', 'uses' => 'HRServiceCategoryController@ServiceCategorySalaryConversionSaveAll'));
Route::any('EditHrServiceCategorySalaryConversion', array('as' => 'EditHrServiceCategorySalaryConversion', 'uses' => 'HRServiceCategoryController@EditHrServiceCategorySalaryConversion'));
Route::any('DeleteHrServiceCategorySalaryConversion', array('as' => 'DeleteHrServiceCategorySalaryConversion', 'uses' => 'HRServiceCategoryController@DeleteHrServiceCategorySalaryConversion'));
Route::any('PrintHrServiceCategorySalaryConversion', array('as' => 'PrintHrServiceCategorySalaryConversion', 'uses' => 'HRServiceCategoryController@PrintHrServiceCategorySalaryConversion'));

Route::any('DownloadHOCenterMonitoringFormsExcel', array('as' => 'DownloadHOCenterMonitoringFormsExcel','uses' => 'MOActualTimeTableController@DownloadHOCenterMonitoringFormsExcel'));
Route::any('ViewHOCenterMonitoringGradewiseReport', array('as' => 'ViewHOCenterMonitoringGradewiseReport','uses' => 'MOActualTimeTableController@ViewHOCenterMonitoringGradewiseReport'));
Route::any('LoadHOCenterMonitoringGradewiseReport', array('as' => 'LoadHOCenterMonitoringGradewiseReport','uses' => 'MOActualTimeTableController@LoadHOCenterMonitoringGradewiseReport'));
Route::any('DownloadHOCenterMonitoringGradewiseReport', array('as' => 'DownloadHOCenterMonitoringGradewiseReport','uses' => 'MOActualTimeTableController@DownloadHOCenterMonitoringGradewiseReport'));
Route::any('ViewHOCenterMonitoringGradewiseFullDetailsReport', array('as' => 'ViewHOCenterMonitoringGradewiseFullDetailsReport','uses' => 'MOActualTimeTableController@ViewHOCenterMonitoringGradewiseFullDetailsReport'));
Route::any('LoadHOCenterMonitoringGradewiseFullDetailsReport', array('as' => 'LoadHOCenterMonitoringGradewiseFullDetailsReport','uses' => 'MOActualTimeTableController@LoadHOCenterMonitoringGradewiseFullDetailsReport'));
Route::any('DownloadHOCenterMonitoringGradewiseFullDetailsReport', array('as' => 'DownloadHOCenterMonitoringGradewiseFullDetailsReport','uses' => 'MOActualTimeTableController@DownloadHOCenterMonitoringGradewiseFullDetailsReport'));
Route::any('EditHOCenterGradingQuestion', array('as' => 'EditHOCenterGradingQuestion','uses' => 'MOActualTimeTableController@EditHOCenterGradingQuestion'));
Route::any('EditHOCenterGradingQuestionAnswers', array('as' => 'EditHOCenterGradingQuestionAnswers','uses' => 'MOActualTimeTableController@EditHOCenterGradingQuestionAnswers'));

Route::any('ViewInstructorQuestionType', array('as' => 'ViewInstructorQuestionType','uses' => 'MOActualTimeTableController@ViewInstructorQuestionType'));
Route::any('CreateInstructorQuestionType', array('as' => 'CreateInstructorQuestionType','uses' => 'MOActualTimeTableController@CreateInstructorQuestionType'));
Route::any('DeleteInstructorQuestionType', array('as' => 'DeleteInstructorQuestionType','uses' => 'MOActualTimeTableController@DeleteInstructorQuestionType'));
Route::any('ViewInstructorCriteriaCategory', array('as' => 'ViewInstructorCriteriaCategory','uses' => 'MOActualTimeTableController@ViewInstructorCriteriaCategory'));
Route::any('CreateInstructorCriteriaCategory', array('as' => 'CreateInstructorCriteriaCategory','uses' => 'MOActualTimeTableController@CreateInstructorCriteriaCategory'));
Route::any('DeleteInstructorCriteriaCategory', array('as' => 'DeleteInstructorCriteriaCategory','uses' => 'MOActualTimeTableController@DeleteInstructorCriteriaCategory'));
Route::any('ViewInstructorCriteriaCategoryQuestion', array('as' => 'ViewInstructorCriteriaCategoryQuestion','uses' => 'MOActualTimeTableController@ViewInstructorCriteriaCategoryQuestion'));
Route::any('CreateInstructorCriteriaCategoryQuestion', array('as' => 'CreateInstructorCriteriaCategoryQuestion','uses' => 'MOActualTimeTableController@CreateInstructorCriteriaCategoryQuestion'));
Route::any('EditInstructorCriteriaCategoryQuestion', array('as' => 'EditInstructorCriteriaCategoryQuestion','uses' => 'MOActualTimeTableController@EditInstructorCriteriaCategoryQuestion'));
Route::any('DeleteInstructorCriteriaCategoryQuestion', array('as' => 'DeleteInstructorCriteriaCategoryQuestion','uses' => 'MOActualTimeTableController@DeleteInstructorCriteriaCategoryQuestion'));

Route::any('ViewInstructorCriteriaCategoryAnswers', array('as' => 'ViewInstructorCriteriaCategoryAnswers','uses' => 'MOActualTimeTableController@ViewInstructorCriteriaCategoryAnswers'));
Route::any('CreateInstructorCriteriaCategoryAnswers', array('as' => 'CreateInstructorCriteriaCategoryAnswers','uses' => 'MOActualTimeTableController@CreateInstructorCriteriaCategoryAnswers'));
Route::any('EditInstructorCriteriaCategoryAnswers', array('as' => 'EditInstructorCriteriaCategoryAnswers','uses' => 'MOActualTimeTableController@EditInstructorCriteriaCategoryAnswers'));
Route::any('DeleteInstructorCriteriaCategoryAnswers', array('as' => 'DeleteInstructorCriteriaCategoryAnswers','uses' => 'MOActualTimeTableController@DeleteInstructorCriteriaCategoryAnswers'));
Route::any('CreateInstructorCriteriaForms', array('as' => 'CreateInstructorCriteriaForms','uses' => 'MOActualTimeTableController@CreateInstructorCriteriaForms'));
Route::any('MOInstructorLoadCourse', array('as' => 'MOInstructorLoadCourse','uses' => 'MOActualTimeTableController@MOInstructorLoadCourse'));
Route::any('SaveMOInstructorGrading', array('as' => 'SaveMOInstructorGrading','uses' => 'MOActualTimeTableController@SaveMOInstructorGrading'));
Route::any('ViewInstructorCriteriaForms', array('as' => 'ViewInstructorCriteriaForms','uses' => 'MOActualTimeTableController@ViewInstructorCriteriaForms'));
Route::any('EditInstructorCriteriaForms', array('as' => 'EditInstructorCriteriaForms','uses' => 'MOActualTimeTableController@EditInstructorCriteriaForms'));
Route::any('ViewInstructorCriteriaFormsEntered', array('as' => 'ViewInstructorCriteriaFormsEntered','uses' => 'MOActualTimeTableController@ViewInstructorCriteriaFormsEntered'));
Route::any('DeleteInstructorCriteriaFormsEntered', array('as' => 'DeleteInstructorCriteriaFormsEntered','uses' => 'MOActualTimeTableController@DeleteInstructorCriteriaFormsEntered'));
Route::any('PrintInstructorCriteriaFormsEntered', array('as' => 'PrintInstructorCriteriaFormsEntered','uses' => 'MOActualTimeTableController@PrintInstructorCriteriaFormsEntered'));

Route::any('viewCourseCatogory', array('as' => 'viewCourseCatogory','uses' => 'CourseController@viewCourseCatogory'));
Route::any('CreateCourseCatogory', array('as' => 'CreateCourseCatogory','uses' => 'CourseController@CreateCourseCatogory'));
Route::any('EditCourseCatogory', array('as' => 'EditCourseCatogory','uses' => 'CourseController@EditCourseCatogory'));
Route::any('DeletedCourseCatogory', array('as' => 'DeletedCourseCatogory','uses' => 'CourseController@DeletedCourseCatogory'));

Route::any('ViewCourseMonitoringVersion', array('as' => 'ViewCourseMonitoringVersion','uses' => 'MOActualTimeTableController@ViewCourseMonitoringVersion'));
Route::any('EditCourseMonitoringVersion', array('as' => 'EditCourseMonitoringVersion','uses' => 'MOActualTimeTableController@EditCourseMonitoringVersion'));
Route::any('CreateCourseMonitoringVersion', array('as' => 'CreateCourseMonitoringVersion','uses' => 'MOActualTimeTableController@CreateCourseMonitoringVersion'));
Route::any('DeleteCourseMonitoringVersion', array('as' => 'DeleteCourseMonitoringVersion','uses' => 'MOActualTimeTableController@DeleteCourseMonitoringVersion'));
Route::any('EditCriteriaCategory', array('as' => 'EditCriteriaCategory','uses' => 'MOActualTimeTableController@EditCriteriaCategory'));

Route::any('ViewHRUserEPFList', array('as' => 'ViewHRUserEPFList', 'uses' => 'HRPromotionController@ViewHRUserEPFList'));
Route::any('CreateHRUserEPFList', array('as' => 'CreateHRUserEPFList', 'uses' => 'HRPromotionController@CreateHRUserEPFList'));
Route::any('EditHRUserEPFList', array('as' => 'EditHRUserEPFList', 'uses' => 'HRPromotionController@EditHRUserEPFList'));
Route::any('DeleteHRUserEPFList', array('as' => 'DeleteHRUserEPFList', 'uses' => 'HRPromotionController@DeleteHRUserEPFList'));

Route::any('DownloadHOInstructorGradingFormsExcel', array('as' => 'DownloadHOInstructorGradingFormsExcel','uses' => 'MOActualTimeTableController@DownloadHOInstructorGradingFormsExcel'));

Route::any('InstantAccreditationTobeUpgradeApplication', array('as' => 'InstantAccreditationTobeUpgradeApplication','uses' => 'MOActualTimeTableController@InstantAccreditationTobeUpgradeApplication'));
Route::any('DownloadAccreditationInstaTobeUpgradeApplication', array('as' => 'DownloadAccreditationInstaTobeUpgradeApplication','uses' => 'MOActualTimeTableController@DownloadAccreditationInstaTobeUpgradeApplication'));

Route::any('DeleteHREmployeeIncrementApprovedRecord', array('as' => 'DeleteHREmployeeIncrementApprovedRecord', 'uses' => 'HRPromotionController@DeleteHREmployeeIncrementApprovedRecord'));
Route::any('CourseMonitoringPlanEdit', array('as' => 'CourseMonitoringPlanEdit','uses' => 'MOActualTimeTableController@CourseMonitoringPlanEdit'));

Route::any('ViewInstructorCriteriaFormsReportI', array('as' => 'ViewInstructorCriteriaFormsReportI','uses' => 'MOActualTimeTableController@ViewInstructorCriteriaFormsReportI'));
Route::any('loaddistrictBatchCategory', array('as' => 'loaddistrictBatchCategory','uses' => 'MOActualTimeTableController@loaddistrictBatchCategory'));
Route::any('loaddistrictBatchCategoryLevel', array('as' => 'loaddistrictBatchCategoryLevel','uses' => 'MOActualTimeTableController@loaddistrictBatchCategoryLevel'));
Route::any('DownloadHOInstructorGradingReport1FormsExcel', array('as' => 'DownloadHOInstructorGradingReport1FormsExcel','uses' => 'MOActualTimeTableController@DownloadHOInstructorGradingReport1FormsExcel'));

Route::any('EditHREmployeeIncrementsHistory', array('as' => 'EditHREmployeeIncrementsHistory', 'uses' => 'HRPromotionController@EditHREmployeeIncrementsHistory'));

Route::any('DownloadMOViewCommentsExcelNew', array('as' => 'DownloadMOViewCommentsExcelNew', 'uses' => 'MoCommentController@DownloadMOViewCommentsExcelNew'));

Route::any('DownloadExamDepartmentResultSheetOL', array('as' => 'DownloadExamDepartmentResultSheetOL','uses' => 'HRPromotionController@DownloadExamDepartmentResultSheetOL'));
Route::any('DownloadExamDepartmentResultSheetAL', array('as' => 'DownloadExamDepartmentResultSheetAL','uses' => 'HRPromotionController@DownloadExamDepartmentResultSheetAL'));

Route::any('ViewHREmployeeServiceLettersIssued', array('as' => 'ViewHREmployeeServiceLettersIssued','uses' => 'HRPromotionController@ViewHREmployeeServiceLettersIssued'));
Route::any('CreateHREmployeeServiceLetters', array('as' => 'CreateHREmployeeServiceLetters','uses' => 'HRPromotionController@CreateHREmployeeServiceLetters'));
Route::any('DownloadHREmployeeServiceLetter', array('as' => 'DownloadHREmployeeServiceLetter','uses' => 'HRPromotionController@DownloadHREmployeeServiceLetter'));
Route::any('DeleteHREmployeeServiceLetter', array('as' => 'DeleteHREmployeeServiceLetter','uses' => 'HRPromotionController@DeleteHREmployeeServiceLetter'));

Route::any('DeleteTOADCriteriaCategoryAnswers', array('as' => 'DeleteTOADCriteriaCategoryAnswers','uses' => 'MOActualTimeTableController@DeleteTOADCriteriaCategoryAnswers'));
Route::any('CreateTOCriteriaForms', array('as' => 'CreateTOCriteriaForms','uses' => 'MOActualTimeTableController@CreateTOCriteriaForms'));
Route::any('loaddistrictcentersinTO', array('as' => 'loaddistrictcentersinTO','uses' => 'MOActualTimeTableController@loaddistrictcentersinTO'));
Route::any('loaddistrictcentersinTOName', array('as' => 'loaddistrictcentersinTOName','uses' => 'MOActualTimeTableController@loaddistrictcentersinTOName'));
Route::any('ViewTOCriteriaForms', array('as' => 'ViewTOCriteriaForms','uses' => 'MOActualTimeTableController@ViewTOCriteriaForms'));
Route::any('EditTOCriteriaForms', array('as' => 'EditTOCriteriaForms','uses' => 'MOActualTimeTableController@EditTOCriteriaForms'));
Route::any('ViewTOCriteriaFormsEntered', array('as' => 'ViewTOCriteriaFormsEntered','uses' => 'MOActualTimeTableController@ViewTOCriteriaFormsEntered'));
Route::any('PrintTOCriteriaFormsEntered', array('as' => 'PrintTOCriteriaFormsEntered','uses' => 'MOActualTimeTableController@PrintTOCriteriaFormsEntered'));
Route::any('DeleteTOCriteriaFormsEntered', array('as' => 'DeleteTOCriteriaFormsEntered','uses' => 'MOActualTimeTableController@DeleteTOCriteriaFormsEntered'));
Route::any('DownloadTOGradingFormsExcel', array('as' => 'DownloadTOGradingFormsExcel','uses' => 'MOActualTimeTableController@DownloadTOGradingFormsExcel'));
Route::any('CreateADDDCriteriaForms', array('as' => 'CreateADDDCriteriaForms','uses' => 'MOActualTimeTableController@CreateADDDCriteriaForms'));
Route::any('loaddistrictcentersinADName', array('as' => 'loaddistrictcentersinADName','uses' => 'MOActualTimeTableController@loaddistrictcentersinADName'));
Route::any('ViewADDDCriteriaForms', array('as' => 'ViewADDDCriteriaForms','uses' => 'MOActualTimeTableController@ViewADDDCriteriaForms'));
Route::any('DownloadADDDGradingFormsExcel', array('as' => 'DownloadADDDGradingFormsExcel','uses' => 'MOActualTimeTableController@DownloadADDDGradingFormsExcel'));
Route::any('EditADDDCriteriaForms', array('as' => 'EditADDDCriteriaForms','uses' => 'MOActualTimeTableController@EditADDDCriteriaForms'));
Route::any('ViewADDDCriteriaFormsEntered', array('as' => 'ViewADDDCriteriaFormsEntered','uses' => 'MOActualTimeTableController@ViewADDDCriteriaFormsEntered'));
Route::any('PrintADDDCriteriaFormsEntered', array('as' => 'PrintADDDCriteriaFormsEntered','uses' => 'MOActualTimeTableController@PrintADDDCriteriaFormsEntered'));
Route::any('DeleteADDDCriteriaFormsEntered', array('as' => 'DeleteADDDCriteriaFormsEntered','uses' => 'MOActualTimeTableController@DeleteADDDCriteriaFormsEntered'));

Route::any('ViewCriteriaTOADEmpType', array('as' => 'ViewCriteriaTOADEmpType','uses' => 'MOActualTimeTableController@ViewCriteriaTOADEmpType'));
Route::any('CreateCriteriaTOADEmpType', array('as' => 'CreateCriteriaTOADEmpType','uses' => 'MOActualTimeTableController@CreateCriteriaTOADEmpType'));
Route::any('DeleteCriteriaTOADEmpType', array('as' => 'DeleteCriteriaTOADEmpType','uses' => 'MOActualTimeTableController@DeleteCriteriaTOADEmpType'));
Route::any('ViewInstructorCriteriaTOADCategory', array('as' => 'ViewInstructorCriteriaTOADCategory','uses' => 'MOActualTimeTableController@ViewInstructorCriteriaTOADCategory'));
Route::any('CreateInstructorCriteriaTOADCategory', array('as' => 'CreateInstructorCriteriaTOADCategory','uses' => 'MOActualTimeTableController@CreateInstructorCriteriaTOADCategory'));
Route::any('DeleteInstructorCriteriaTOADCategory', array('as' => 'DeleteInstructorCriteriaTOADCategory','uses' => 'MOActualTimeTableController@DeleteInstructorCriteriaTOADCategory'));
Route::any('ViewTOADQuestionAnswerType', array('as' => 'ViewTOADQuestionAnswerType','uses' => 'MOActualTimeTableController@ViewTOADQuestionAnswerType'));
Route::any('CreateTOADQuestionAnswerType', array('as' => 'CreateTOADQuestionAnswerType','uses' => 'MOActualTimeTableController@CreateTOADQuestionAnswerType'));
Route::any('DeleteTOADQuestionAnswerType', array('as' => 'DeleteTOADQuestionAnswerType','uses' => 'MOActualTimeTableController@DeleteTOADQuestionAnswerType'));
Route::any('ViewTOADCriteriaCategoryQuestion', array('as' => 'ViewTOADCriteriaCategoryQuestion','uses' => 'MOActualTimeTableController@ViewTOADCriteriaCategoryQuestion'));
Route::any('CreateTOADCriteriaCategoryQuestion', array('as' => 'CreateTOADCriteriaCategoryQuestion','uses' => 'MOActualTimeTableController@CreateTOADCriteriaCategoryQuestion'));
Route::any('EditTOADCriteriaCategoryQuestion', array('as' => 'EditTOADCriteriaCategoryQuestion','uses' => 'MOActualTimeTableController@EditTOADCriteriaCategoryQuestion'));
Route::any('DeleteTOADCriteriaCategoryQuestion', array('as' => 'DeleteTOADCriteriaCategoryQuestion','uses' => 'MOActualTimeTableController@DeleteTOADCriteriaCategoryQuestion'));
Route::any('ViewTOADCriteriaQuestionAnswers', array('as' => 'ViewTOADCriteriaQuestionAnswers','uses' => 'MOActualTimeTableController@ViewTOADCriteriaQuestionAnswers'));
Route::any('CreateTOADCriteriaCategoryAnswers', array('as' => 'CreateTOADCriteriaCategoryAnswers','uses' => 'MOActualTimeTableController@CreateTOADCriteriaCategoryAnswers'));
Route::any('EditTOADCriteriaCategoryAnswers', array('as' => 'EditTOADCriteriaCategoryAnswers','uses' => 'MOActualTimeTableController@EditTOADCriteriaCategoryAnswers'));
Route::any('DeleteTOADCriteriaCategoryAnswers', array('as' => 'DeleteTOADCriteriaCategoryAnswers','uses' => 'MOActualTimeTableController@DeleteTOADCriteriaCategoryAnswers'));

Route::any('ViewTrainingPlanUpdateIROJT', array('as' => 'ViewTrainingPlanUpdateIROJT','uses' => 'TrainingPlanReportController@ViewTrainingPlanUpdateIROJT'));
Route::any('editCourseYearPlanOJT',array('as'=>'editCourseYearPlanOJT','uses'=>'TrainingPlanReportController@editCourseYearPlanOJT'));

Route::any('ViewIRCompany', array('as' => 'ViewIRCompany', 'uses' => 'IRDivisionController@ViewIRCompany'));
Route::any('CreateIRCompany', array('as' => 'CreateIRCompany', 'uses' => 'IRDivisionController@CreateIRCompany'));
Route::any('EditIRCompany', array('as' => 'EditIRCompany', 'uses' => 'IRDivisionController@EditIRCompany'));
Route::any('DeleteIRCompany', array('as' => 'DeleteIRCompany', 'uses' => 'IRDivisionController@DeleteIRCompany'));
Route::any('ViewIROJTVacancy', array('as' => 'ViewIROJTVacancy', 'uses' => 'IRDivisionController@ViewIROJTVacancy'));
Route::any('CreateIROJTVacancy', array('as' => 'CreateIROJTVacancy', 'uses' => 'IRDivisionController@CreateIROJTVacancy'));
Route::any('EditIROJTVacancy', array('as' => 'EditIROJTVacancy', 'uses' => 'IRDivisionController@EditIROJTVacancy'));
Route::any('DeleteIROJTVacancy', array('as' => 'DeleteIROJTVacancy', 'uses' => 'IRDivisionController@DeleteIROJTVacancy'));
Route::any('LoadIRCompanyFromElectorate', array('as' => 'LoadIRCompanyFromElectorate','uses' => 'IRDivisionController@LoadIRCompanyFromElectorate'));
Route::any('LoadIRTradeOccupation', array('as' => 'LoadIRTradeOccupation','uses' => 'IRDivisionController@LoadIRTradeOccupation'));
Route::any('ViewIRJOBPVacancy', array('as' => 'ViewIRJOBPVacancy', 'uses' => 'IRDivisionController@ViewIRJOBPVacancy'));
Route::any('CreateIRJOBPVacancy', array('as' => 'CreateIRJOBPVacancy', 'uses' => 'IRDivisionController@CreateIRJOBPVacancy'));
Route::any('EditIRJOBPVacancy', array('as' => 'EditIRJOBPVacancy', 'uses' => 'IRDivisionController@EditIRJOBPVacancy'));
Route::any('DeleteIRJOBPVacancy', array('as' => 'DeleteIRJOBPVacancy', 'uses' => 'IRDivisionController@DeleteIRJOBPVacancy'));

Route::any('ViewOJTStudents', array('as' => 'ViewOJTStudents','uses' => 'IRDivisionController@ViewOJTStudents'));
Route::any('editOJTStudents',array('as'=>'editOJTStudents','uses'=>'IRDivisionController@editOJTStudents'));
Route::any('OJTCourseFilter', array('as' => 'OJTCourseFilter','uses' => 'IRDivisionController@OJTCourseFilter'));
Route::any('DeleteOJTStudents', array('as' => 'DeleteOJTStudents', 'uses' => 'IRDivisionController@DeleteOJTStudents'));
Route::any('PrintOJTStudents', array('as' => 'PrintOJTStudents','uses' => 'IRDivisionController@PrintOJTStudents'));
Route::any('OJTSplacementtudents',array('as'=>'OJTSplacementtudents','uses'=>'IRDivisionController@OJTSplacementtudents'));
Route::any('GetOJTAvailableVacancy', array('as' => 'GetOJTAvailableVacancy','uses' => 'IRDivisionController@GetOJTAvailableVacancy'));
Route::any('ViewOJTStudentHistory', array('as' => 'ViewOJTStudentHistory', 'uses' => 'IRDivisionController@ViewOJTStudentHistory'));
Route::any('editOJTStudentsHistory',array('as'=>'editOJTStudentsHistory','uses'=>'IRDivisionController@editOJTStudentsHistory'));
Route::any('AddOJTStudentDropout', array('as' => 'AddOJTStudentDropout', 'uses' => 'IRDivisionController@AddOJTStudentDropout'));
Route::any('DeleteOJTStudentsPlacement', array('as' => 'DeleteOJTStudentsPlacement', 'uses' => 'IRDivisionController@DeleteOJTStudentsPlacement'));
Route::any('CreateIRTrainee', array('as' => 'CreateIRTrainee', 'uses' => 'IRDivisionController@CreateIRTrainee'));
Route::any('ViewOJTPlacedStudents', array('as' => 'ViewOJTPlacedStudents','uses' => 'IRDivisionController@ViewOJTPlacedStudents'));
Route::any('MarkOJTCompletion', array('as' => 'MarkOJTCompletion','uses' => 'IRDivisionController@MarkOJTCompletion'));
Route::any('PrintOJTPlacedStudents', array('as' => 'PrintOJTPlacedStudents','uses' => 'IRDivisionController@PrintOJTPlacedStudents'));
Route::any('ViewAssignPODSDivitions', array('as' => 'ViewAssignPODSDivitions', 'uses' => 'IRDivisionController@ViewAssignPODSDivitions'));
Route::any('CreateAssignPODSDivitions', array('as' => 'CreateAssignPODSDivitions', 'uses' => 'IRDivisionController@CreateAssignPODSDivitions'));
Route::any('OJTGetEmpIdPO', array('as' => 'OJTGetEmpIdPO','uses' => 'IRDivisionController@OJTGetEmpIdPO'));
Route::any('EditAssignPODSDivitions', array('as' => 'EditAssignPODSDivitions', 'uses' => 'IRDivisionController@EditAssignPODSDivitions'));
Route::any('DeleteAssignPODSDivitions', array('as' => 'DeleteAssignPODSDivitions', 'uses' => 'IRDivisionController@DeleteAssignPODSDivitions'));
Route::any('ViewMyOJTStudents', array('as' => 'ViewMyOJTStudents','uses' => 'IRDivisionController@ViewMyOJTStudents'));
Route::any('PrintOJTPlacedMyStudents', array('as' => 'PrintOJTPlacedMyStudents','uses' => 'IRDivisionController@PrintOJTPlacedMyStudents'));

Route::any('ViewHOInstructorGradingFullDetailsReport', array('as' => 'ViewHOInstructorGradingFullDetailsReport','uses' => 'MOActualTimeTableController@ViewHOInstructorGradingFullDetailsReport'));
Route::any('LoadHOInstructorGradingFullDetailsReport', array('as' => 'LoadHOInstructorGradingFullDetailsReport','uses' => 'MOActualTimeTableController@LoadHOInstructorGradingFullDetailsReport'));
Route::any('DownloadInstructorGradingFullDetailsReport', array('as' => 'DownloadInstructorGradingFullDetailsReport','uses' => 'MOActualTimeTableController@DownloadInstructorGradingFullDetailsReport'));

Route::any('DownloadOJTCourseWiseCountReportExcel', array('as' => 'DownloadOJTCourseWiseCountReportExcel','uses' => 'IRDivisionController@DownloadOJTCourseWiseCountReportExcel'));
Route::any('ViewOJTCourseWiseCountReport', array('as' => 'ViewOJTCourseWiseCountReport','uses' => 'IRDivisionController@ViewOJTCourseWiseCountReport'));
Route::any('LoadOJTCourseWiseCountReport', array('as' => 'LoadOJTCourseWiseCountReport','uses' => 'IRDivisionController@LoadOJTCourseWiseCountReport'));

Route::any('DownloadOJTDistrictWiseCountReportExcel', array('as' => 'DownloadOJTDistrictWiseCountReportExcel','uses' => 'IRDivisionController@DownloadOJTDistrictWiseCountReportExcel'));
Route::any('ViewOJTDistrictWiseCountReport', array('as' => 'ViewOJTDistrictWiseCountReport','uses' => 'IRDivisionController@ViewOJTDistrictWiseCountReport'));
Route::any('LoadOJTDistrictWiseCountReport', array('as' => 'LoadOJTDistrictWiseCountReport','uses' => 'IRDivisionController@LoadOJTDistrictWiseCountReport'));

Route::any('ViewJOBPStudents', array('as' => 'ViewJOBPStudents','uses' => 'IRDivisionController@ViewJOBPStudents'));
Route::any('JOBPplacementtudents',array('as'=>'JOBPplacementtudents','uses'=>'IRDivisionController@JOBPplacementtudents'));
Route::any('GetJOBpAvailableVacancy', array('as' => 'GetJOBpAvailableVacancy','uses' => 'IRDivisionController@GetJOBpAvailableVacancy'));
Route::any('ViewJOBPStudentHistory', array('as' => 'ViewJOBPStudentHistory', 'uses' => 'IRDivisionController@ViewJOBPStudentHistory'));
Route::any('editJOBPStudentsHistory',array('as'=>'editJOBPStudentsHistory','uses'=>'IRDivisionController@editJOBPStudentsHistory'));
Route::any('AddJOBPStudentDropout', array('as' => 'AddJOBPStudentDropout', 'uses' => 'IRDivisionController@AddJOBPStudentDropout'));
Route::any('DeleteJOBPStudentsPlacement', array('as' => 'DeleteJOBPStudentsPlacement', 'uses' => 'IRDivisionController@DeleteJOBPStudentsPlacement'));

Route::any('DownloadJOBPCourseWiseCountReportExcel', array('as' => 'DownloadJOBPCourseWiseCountReportExcel','uses' => 'IRDivisionController@DownloadJOBPCourseWiseCountReportExcel'));
Route::any('ViewJOBPCourseWiseCountReport', array('as' => 'ViewJOBPCourseWiseCountReport','uses' => 'IRDivisionController@ViewJOBPCourseWiseCountReport'));
Route::any('LoadJOBPCourseWiseCountReport', array('as' => 'LoadJOBPCourseWiseCountReport','uses' => 'IRDivisionController@LoadJOBPCourseWiseCountReport'));

Route::any('DownloadJOBPDistrictWiseCountReportExcel', array('as' => 'DownloadJOBPDistrictWiseCountReportExcel','uses' => 'IRDivisionController@DownloadJOBPDistrictWiseCountReportExcel'));
Route::any('ViewJOBPDistrictWiseCountReport', array('as' => 'ViewJOBPDistrictWiseCountReport','uses' => 'IRDivisionController@ViewJOBPDistrictWiseCountReport'));
Route::any('LoadJOBPDistrictWiseCountReport', array('as' => 'LoadJOBPDistrictWiseCountReport','uses' => 'IRDivisionController@LoadJOBPDistrictWiseCountReport'));

Route::any('DownloadAnnualIncrementPaymentFormB', array('as' => 'DownloadAnnualIncrementPaymentFormB', 'uses' => 'HRPromotionController@DownloadAnnualIncrementPaymentFormB'));

Route::any('ViewOJTStudentsDoc', array('as' => 'ViewOJTStudentsDoc','uses' => 'IRDivisionController@ViewOJTStudentsDoc'));
Route::any('ViewOJTStudentsDocumentList',array('as'=>'ViewOJTStudentsDocumentList','uses'=>'IRDivisionController@ViewOJTStudentsDocumentList'));
Route::any('DownloadOJTAttendeceSheet', array('as' => 'DownloadOJTAttendeceSheet', 'uses' => 'IRDivisionController@DownloadOJTAttendeceSheet'));
Route::any('DownloadOJTPlacementLetter', array('as' => 'DownloadOJTPlacementLetter', 'uses' => 'IRDivisionController@DownloadOJTPlacementLetter'));
Route::any('DownloadOJTVerificationForm', array('as' => 'DownloadOJTVerificationForm', 'uses' => 'IRDivisionController@DownloadOJTVerificationForm'));
Route::any('DownloadOJTCompletionForm', array('as' => 'DownloadOJTCompletionForm', 'uses' => 'IRDivisionController@DownloadOJTCompletionForm'));
Route::any('DownloadOJTAgreementEngForm', array('as' => 'DownloadOJTAgreementEngForm', 'uses' => 'IRDivisionController@DownloadOJTAgreementEngForm'));

Route::any('DownloadAnnualIncrementPaymentFormReactive', array('as' => 'DownloadAnnualIncrementPaymentFormReactive', 'uses' => 'HRPromotionController@DownloadAnnualIncrementPaymentFormReactive'));
Route::any('DownloadAnnualIncrementPaymentFormBReactive', array('as' => 'DownloadAnnualIncrementPaymentFormBReactive', 'uses' => 'HRPromotionController@DownloadAnnualIncrementPaymentFormBReactive'));

Route::any('IRFilterCourseYearPlans1', array('as' => 'IRFilterCourseYearPlans1','uses' => 'IRDivisionController@IRFilterCourseYearPlans1'));

Route::any('DeleteHREmployeeIncrementHistory', array('as' => 'DeleteHREmployeeIncrementHistory', 'uses' => 'HRPromotionController@DeleteHREmployeeIncrementHistory'));
Route::any('IRloaddistricDSDivision', array('as' => 'IRloaddistricDSDivision','uses' => 'IRDivisionController@IRloaddistricDSDivision'));

Route::any('IRDropoutListPrintPdf', array('as' => 'IRDropoutListPrintPdf','uses' => 'IRDivisionController@IRDropoutListPrintPdf'));

Route::any('DownloadOJTPOMonitoringForm', array('as' => 'DownloadOJTPOMonitoringForm', 'uses' => 'IRDivisionController@DownloadOJTPOMonitoringForm'));
Route::any('IRCreatePOMonitoringData',array('as'=>'IRCreatePOMonitoringData','uses'=>'IRDivisionController@IRCreatePOMonitoringData'));
Route::any('IRGetMonitoringPOList', array('as' => 'IRGetMonitoringPOList', 'uses' => 'IRDivisionController@IRGetMonitoringPOList'));
Route::any('ViewOJTStudentPOMonitoringHistory', array('as' => 'ViewOJTStudentPOMonitoringHistory', 'uses' => 'IRDivisionController@ViewOJTStudentPOMonitoringHistory'));
Route::any('DeleteOJTStudentsPOMonitoringHistory', array('as' => 'DeleteOJTStudentsPOMonitoringHistory', 'uses' => 'IRDivisionController@DeleteOJTStudentsPOMonitoringHistory'));
Route::any('PrintOJTVacancy', array('as' => 'PrintOJTVacancy','uses' => 'IRDivisionController@PrintOJTVacancy'));
Route::any('PrintIRJobVacancy', array('as' => 'PrintIRJobVacancy','uses' => 'IRDivisionController@PrintIRJobVacancy'));

Route::any('ActionIncrementReactiveDate', array('as' => 'ActionIncrementReactiveDate', 'uses' => 'HRPromotionController@ActionIncrementReactiveDate'));

Route::any('ViewInstructorGradingInstructorCountReport', array('as' => 'ViewInstructorGradingInstructorCountReport','uses' => 'MOActualTimeTableController@ViewInstructorGradingInstructorCountReport'));
Route::any('DownloadInstructorGradingInstructorCountReport', array('as' => 'DownloadInstructorGradingInstructorCountReport','uses' => 'MOActualTimeTableController@DownloadInstructorGradingInstructorCountReport'));

Route::any('ViewYearwiseTimeTableIssuingReport', array('as' => 'ViewYearwiseTimeTableIssuingReport','uses' => 'MOActualTimeTableController@ViewYearwiseTimeTableIssuingReport'));
Route::any('DownloadYearwiseTimeTableIssuingReport', array('as' => 'DownloadYearwiseTimeTableIssuingReport','uses' => 'MOActualTimeTableController@DownloadYearwiseTimeTableIssuingReport'));

Route::any('DownloadInstructorGradingFullDetailsReport1', array('as' => 'DownloadInstructorGradingFullDetailsReport1','uses' => 'MOActualTimeTableController@DownloadInstructorGradingFullDetailsReport1'));

Route::any('PrintOJTCompany', array('as' => 'PrintOJTCompany','uses' => 'IRDivisionController@PrintOJTCompany'));

Route::any('KPIHRnicAjax', array('as' => 'KPIHRnicAjax', 'uses' => 'HrKPIController@KPIHRnicAjax'));
Route::any('CreateHREmployeeKPICriterias', array('as' => 'CreateHREmployeeKPICriterias', 'uses' => 'HrKPIController@CreateHREmployeeKPICriterias'));
Route::any('KPICriteriasaveAll', array('as' => 'KPICriteriasaveAll', 'uses' => 'HrKPIController@KPICriteriasaveAll'));
Route::any('ViewHREmployeeKPICriterias', array('as' => 'ViewHREmployeeKPICriterias','uses' => 'HrKPIController@ViewHREmployeeKPICriterias'));
Route::any('ViewHREmployeeKPICriteriasList', array('as' => 'ViewHREmployeeKPICriteriasList','uses' => 'HrKPIController@ViewHREmployeeKPICriteriasList'));
Route::any('DeleteHREmployeeKPICriteria', array('as' => 'DeleteHREmployeeKPICriteria','uses' => 'HrKPIController@DeleteHREmployeeKPICriteria'));
Route::any('DeleteHREmployeeKPICriteriaList', array('as' => 'DeleteHREmployeeKPICriteriaList','uses' => 'HrKPIController@DeleteHREmployeeKPICriteriaList'));
Route::any('EditHREmployeeKPICriteriaList', array('as' => 'EditHREmployeeKPICriteriaList', 'uses' => 'HrKPIController@EditHREmployeeKPICriteriaList'));
Route::any('EditHREmployeeKPICriteriaListActiveStatus', array('as' => 'EditHREmployeeKPICriteriaListActiveStatus', 'uses' => 'HrKPIController@EditHREmployeeKPICriteriaListActiveStatus'));
Route::any('EditHREmployeeKPICriteriaListActiveStatus1', array('as' => 'EditHREmployeeKPICriteriaListActiveStatus1', 'uses' => 'HrKPIController@EditHREmployeeKPICriteriaListActiveStatus1'));
Route::any('ViewKPISchedule', array('as' => 'ViewKPISchedule', 'uses' => 'HrKPIController@ViewKPISchedule'));
Route::any('CreateKPISchedule', array('as' => 'CreateKPISchedule', 'uses' => 'HrKPIController@CreateKPISchedule'));
Route::any('DeleteKPISchedule', array('as' => 'DeleteKPISchedule', 'uses' => 'HrKPIController@DeleteKPISchedule'));
Route::any('EditKPISchedule', array('as' => 'EditKPISchedule', 'uses' => 'HrKPIController@EditKPISchedule'));
Route::any('SaveAjaxKPISchedule', array('as' => 'SaveAjaxKPISchedule', 'uses' => 'HrKPIController@SaveAjaxKPISchedule'));
Route::any('EndKPISchedule', array('as' => 'EndKPISchedule', 'uses' => 'HrKPIController@EndKPISchedule'));
Route::any('ViewKPIForms', array('as' => 'ViewKPIForms','uses' => 'HrKPIController@ViewKPIForms'));
Route::any('CreateKPIForm', array('as' => 'CreateKPIForm','uses' => 'HrKPIController@CreateKPIForm'));
Route::any('EditKPIForm', array('as' => 'EditKPIForm','uses' => 'HrKPIController@EditKPIForm'));
Route::any('ViewSeltKPIForm', array('as' => 'ViewSeltKPIForm','uses' => 'HrKPIController@ViewSeltKPIForm'));
Route::any('PrintSeltKPIForm', array('as' => 'PrintSeltKPIForm','uses' => 'HrKPIController@PrintSeltKPIForm'));
Route::any('KPISubmitSelfForm', array('as' => 'KPISubmitSelfForm','uses' => 'HrKPIController@KPISubmitSelfForm'));
Route::any('ViewKPISuperviseForms', array('as' => 'ViewKPISuperviseForms','uses' => 'HrKPIController@ViewKPISuperviseForms'));
Route::any('CreateKPISuperviseForm', array('as' => 'CreateKPISuperviseForm','uses' => 'HrKPIController@CreateKPISuperviseForm'));
Route::any('ViewSeltKPISuperviseForm', array('as' => 'ViewSeltKPISuperviseForm','uses' => 'HrKPIController@ViewSeltKPISuperviseForm'));
Route::any('KPIApproveCompleteForm', array('as' => 'KPIApproveCompleteForm','uses' => 'HrKPIController@KPIApproveCompleteForm'));
Route::any('ViewEmpLPISummeryReport', array('as' => 'ViewEmpLPISummeryReport','uses' => 'HrKPIController@ViewEmpLPISummeryReport'));
Route::any('LoadEmpLPISummeryReport', array('as' => 'LoadEmpLPISummeryReport','uses' => 'HrKPIController@LoadEmpLPISummeryReport'));
Route::any('DownloadEmpLPISummeryReport', array('as' => 'DownloadEmpLPISummeryReport','uses' => 'HrKPIController@DownloadEmpLPISummeryReport'));
//Controll KPI Permissions
Route::any('AccsessEnterAllEmployeeKPICriteria', array('as' => 'AccsessEnterAllEmployeeKPICriteria','uses' => 'HrKPIController@AccsessEnterAllEmployeeKPICriteria'));
Route::any('AccsessEnterAllEmployeeKPIForms', array('as' => 'AccsessEnterAllEmployeeKPICriteria','uses' => 'HrKPIController@AccsessEnterAllEmployeeKPICriteria'));

Route::any('IRAddDropoutReason', array('as' => 'IRAddDropoutReason','uses' => 'IRDivisionController@IRAddDropoutReason'));
Route::any('IRAddDropoutReasonGiveApproval', array('as' => 'IRAddDropoutReasonGiveApproval','uses' => 'IRDivisionController@IRAddDropoutReasonGiveApproval'));

Route::get('IRdisLoadajax', array('as' => 'IRdisLoadajax','uses' => 'IRDivisionController@IRdisLoadajax'));
Route::get('UpdateOJTOccupiedcolumn', array('as' => 'UpdateOJTOccupiedcolumn','uses' => 'IRDivisionController@UpdateOJTOccupiedcolumn'));

Route::any('IRFilterCourseYearPlans111', array('as' => 'IRFilterCourseYearPlans111','uses' => 'IRDivisionController@IRFilterCourseYearPlans111'));
Route::any('IROJTStudentProfileGetStudentData', array('as' => 'IROJTStudentProfileGetStudentData', 'uses' => 'IRDivisionController@IROJTStudentProfileGetStudentData'));
Route::any('IROJTStudentProfileajaxViewData', array('as' => 'IROJTStudentProfileajaxViewData', 'uses' => 'IRDivisionController@IROJTStudentProfileajaxViewData'));
Route::any('IRJOBPStudentProfileajaxViewData', array('as' => 'IRJOBPStudentProfileajaxViewData', 'uses' => 'IRDivisionController@IRJOBPStudentProfileajaxViewData'));
Route::any('IRJOBPStudentProfileGetStudentData', array('as' => 'IRJOBPStudentProfileGetStudentData', 'uses' => 'IRDivisionController@IRJOBPStudentProfileGetStudentData'));

Route::get('UpdateJOBPOccupiedcolumn', array('as' => 'UpdateJOBPOccupiedcolumn','uses' => 'IRDivisionController@UpdateJOBPOccupiedcolumn'));
//2022-01-05
Route::any('ViewTMTaskList', array('as' => 'ViewTMTaskList','uses' => 'TrainingMaterialController@ViewTMTaskList'));
Route::any('CreateTMTaskList', array('as' => 'CreateTMTaskList','uses' => 'TrainingMaterialController@CreateTMTaskList'));
Route::any('TMProcessActiveStatus1', array('as' => 'TMProcessActiveStatus1','uses' => 'TrainingMaterialController@TMProcessActiveStatus1'));
Route::any('TMProcessActiveStatus', array('as' => 'TMProcessActiveStatus','uses' => 'TrainingMaterialController@TMProcessActiveStatus'));
Route::any('DeleteTMTaskList', array('as' => 'DeleteTMTaskList','uses' => 'TrainingMaterialController@DeleteTMTaskList'));
Route::any('ViewTMProcessSchedule', array('as' => 'ViewTMProcessSchedule', 'uses' => 'TrainingMaterialController@ViewTMProcessSchedule'));
Route::any('CreateTMProcessSchedule', array('as' => 'CreateTMProcessSchedule', 'uses' => 'TrainingMaterialController@CreateTMProcessSchedule'));
Route::any('DeleteTMProcessSchedule', array('as' => 'DeleteTMProcessSchedule', 'uses' => 'TrainingMaterialController@DeleteTMProcessSchedule'));
Route::any('EditTMProcessSchedule', array('as' => 'EditTMProcessSchedule', 'uses' => 'TrainingMaterialController@EditTMProcessSchedule'));
Route::any('SaveAjaxTMProcessSchedule', array('as' => 'SaveAjaxTMProcessSchedule', 'uses' => 'TrainingMaterialController@SaveAjaxTMProcessSchedule'));
Route::any('ViewTrainingPlanUpdateDisNVTIDOTOTM', array('as' => 'ViewTrainingPlanUpdateDisNVTIDOTOTM','uses' => 'TrainingMaterialController@ViewTrainingPlanUpdateDisNVTIDOTOTM'));
Route::any('editCourseYearPlanDisNVTIDOTOTM',array('as'=>'editCourseYearPlanDisNVTIDOTOTM','uses'=>'TrainingMaterialController@editCourseYearPlanDisNVTIDOTOTM'));
Route::any('ViewIndividualCourseProgDisNVTIDOTOTM',array('as'=>'ViewIndividualCourseProgDisNVTIDOTOTM','uses'=>'TrainingMaterialController@ViewIndividualCourseProgDisNVTIDOTOTM'));
Route::any('PrintExcelTrainingmaterial', array('as' => 'PrintExcelTrainingmaterial','uses' => 'TrainingMaterialController@PrintExcelTrainingmaterial'));
Route::any('PrintPDFTrainingmaterial', array('as' => 'PrintPDFTrainingmaterial','uses' => 'TrainingMaterialController@PrintPDFTrainingmaterial'));
//2022-01-11
Route::any('ViewTrainingMaterialProcessWiseSummeryReport', array('as' => 'ViewTrainingMaterialProcessWiseSummeryReport','uses' => 'TrainingMaterialController@ViewTrainingMaterialProcessWiseSummeryReport'));
Route::any('LoadTrainingMaterialProcessWiseSummeryReport', array('as' => 'LoadTrainingMaterialProcessWiseSummeryReport','uses' => 'TrainingMaterialController@LoadTrainingMaterialProcessWiseSummeryReport'));
Route::any('DownloadTrainingMaterialProcessWiseSummeryReport', array('as' => 'DownloadTrainingMaterialProcessWiseSummeryReport','uses' => 'TrainingMaterialController@DownloadTrainingMaterialProcessWiseSummeryReport'));
//2022-02-02
Route::any('AddModuleTaskSeqOrderNo', array('as' => 'AddModuleTaskSeqOrderNo', 'uses' => 'ModuleTaskSeqController@AddModuleTaskSeqOrderNo'));
//2022-02-10
Route::any('AddModuleTaskSeqSessionNo', array('as' => 'AddModuleTaskSeqSessionNo', 'uses' => 'ModuleTaskSeqController@AddModuleTaskSeqSessionNo'));
//2022-03-03
Route::any('GiveSpecialPermissionMOCenterMOnitoringPlan', array('as' => 'GiveSpecialPermissionMOCenterMOnitoringPlan','uses' => 'MOActualTimeTableController@GiveSpecialPermissionMOCenterMOnitoringPlan'));
Route::any('CancelSpecialPermissionMOCenterMOnitoringPlan', array('as' => 'CancelSpecialPermissionMOCenterMOnitoringPlan','uses' => 'MOActualTimeTableController@CancelSpecialPermissionMOCenterMOnitoringPlan'));
//2022-03-08 ExAM req
Route::any('ExamAssesorAssigningView', array('as' => 'ExamAssesorAssigningView','uses' => 'ExamDivisionController@ExamAssesorAssigningView'));
Route::any('editExamAssesorAssigningView',array('as'=>'editExamAssesorAssigningView','uses'=>'ExamDivisionController@editExamAssesorAssigningView'));
Route::any('PrintExamAssesorAssigningView', array('as' => 'PrintExamAssesorAssigningView','uses' => 'ExamDivisionController@PrintExamAssesorAssigningView'));
Route::any('viewUnits', array('as' => 'viewUnits','uses' => 'ExamDivisionController@viewUnits'));
Route::any('CreateUnits', array('as' => 'CreateUnits','uses' => 'ExamDivisionController@CreateUnits'));
Route::any('EditUnits', array('as' => 'EditUnits','uses' => 'ExamDivisionController@EditUnits'));
Route::any('DeletedUnits', array('as' => 'DeletedUnits','uses' => 'ExamDivisionController@DeletedUnits'));
Route::any('ExamAssignAssessorForCourse', array('as' => 'ExamAssignAssessorForCourse','uses' => 'ExamDivisionController@ExamAssignAssessorForCourse'));
Route::any('ExamViewNPrintLettersForAssignedAssessors', array('as' => 'ExamViewNPrintLettersForAssignedAssessors','uses' =>'ExamDivisionController@ExamViewNPrintLettersForAssignedAssessors'));
Route::any('ExamPrintAssessorAssignedLetter', array('as' => 'ExamPrintAssessorAssignedLetter','uses' => 'ExamDivisionController@ExamPrintAssessorAssignedLetter'));
Route::any('ExamPrintAssessorAssignedLetterForRenominated', array('as' => 'ExamPrintAssessorAssignedLetterForRenominated','uses' => 'ExamDivisionController@ExamPrintAssessorAssignedLetterForRenominated'));
Route::any('NVQPackageUnit',array('as'=>'NVQPackageUnit','uses'=>'NVQPackageUnitsController@ViewNVQPackagePackageUnit'));
Route::any('CreateNVQUnits',array('as'=>'CreateNVQUnits','uses'=>'NVQPackageUnitsController@CreateNVQUnits'));
Route::any('FindIDNVQUnits',array('as'=>'FindIDNVQUnits','uses'=>'NVQPackageUnitsController@FindIDNVQUnits'));
Route::any('FindNVQUnits',array('as'=>'FindNVQUnits','uses'=>'NVQPackageUnitsController@FilterCode'));
Route::any('SaveNVQUNITS',array('as'=>'SaveNVQUNITS','uses'=>'NVQPackageUnitsController@SaveNvqUnits'));
Route::any('EditNVQUnits',array('as'=>'EditNVQUnits','uses'=>'NVQPackageUnitsController@EditNVQUnits'));
Route::post('UpdateEdit',array('as'=>'UpdateEdit','uses'=>'NVQPackageUnitsController@EditDataSave'));
Route::any('DeletePackage',array('as'=>'DeletePackage','uses'=>'NVQPackageUnitsController@DeletePackage'));
Route::any('Savedata',array('as'=>'Savedata','uses'=>'NVQPackageUnitsController@Savedata'));
Route::any('viewunit',array('as'=>'viewunit','uses'=>'NVQPackageUnits1Controller@viewunit'));
Route::any('ExamAssignTraineesToPreAssessment', array('as' => 'ExamAssignTraineesToPreAssessment','uses' => 'ExamDivisionController@ExamAssignTraineesToPreAssessment'));
Route::any('ExamGetCenterCourseListBatchwise', array('as' => 'ExamGetCenterCourseListBatchwise','uses' => 'ExamDivisionController@ExamGetCenterCourseListBatchwise'));
Route::any('ExamSavePreAssessmentAttendence', array('as' => 'ExamSavePreAssessmentAttendence','uses' => 'ExamDivisionController@ExamSavePreAssessmentAttendence'));
Route::any('ExamPrintPreAssessmentAttendence', array('as' => 'ExamPrintPreAssessmentAttendence','uses' => 'ExamDivisionController@ExamPrintPreAssessmentAttendence'));
Route::any('ExamAddRepeatersToAssessment', array('as' => 'ExamAddRepeatersToAssessment','uses' => 'ExamDivisionController@ExamAddRepeatersToAssessment'));
Route::any('ExamSaveRepeatersToAssessment', array('as' => 'ExamSaveRepeatersToAssessment','uses' => 'ExamDivisionController@ExamSaveRepeatersToAssessment'));
Route::any('ExamViewandprintFinaAttendance', array('as' => 'ExamViewandprintFinaAttendance','uses' => 'ExamDivisionController@ExamViewandprintFinaAttendance'));
Route::any('ExamPrintAttendanceSheet2', array('as' => 'ExamPrintAttendanceSheet2','uses' => 'ExamDivisionController@ExamPrintAttendanceSheet2'));
Route::any('ExamPrintAttendanceSheet3', array('as' => 'ExamPrintAttendanceSheet3','uses' => 'ExamDivisionController@ExamPrintAttendanceSheet3'));
Route::any('ExamPrintNVQAddmissionCard', array('as' => 'ExamPrintNVQAddmissionCard','uses' => 'ExamDivisionController@ExamPrintNVQAddmissionCard'));
Route::any('ExamNewEUExamResultEnter', array('as' => 'ExamNewEUExamResultEnter','uses' => 'ExamDivisionController@ExamNewEUExamResultEnter'));
Route::any('ExamNewEULoadStudentExamResultEnterOriginal', array('as' => 'ExamNewEULoadStudentExamResultEnterOriginal','uses' => 'ExamDivisionController@ExamNewEULoadStudentExamResultEnterOriginal'));
Route::any('ExamSaveModuleResult', array('as' => 'ExamSaveModuleResult','uses' => 'ExamDivisionController@ExamSaveModuleResult'));
Route::any('ExamreturnToTraineeList', array('as' => 'ExamreturnToTraineeList','uses' => 'ExamDivisionController@ExamreturnToTraineeList'));
Route::any('ExamConfirmResultCenter', array('as' => 'ExamConfirmResultCenter','uses' => 'ExamDivisionController@ExamConfirmResultCenter'));
Route::any('ExamTempViewResult', array('as' => 'ExamTempViewResult','uses' => 'ExamDivisionController@ExamTempViewResult'));
Route::any('ExamTEMPLoadTraineeList', array('as' => 'ExamTEMPLoadTraineeList','uses' => 'ExamDivisionController@ExamTEMPLoadTraineeList'));
Route::any('ExamGETAjaxQualificationStudent', array('as' => 'ExamGETAjaxQualificationStudent','uses' => 'ExamDivisionController@ExamGETAjaxQualificationStudent'));
Route::any('ExamTEMPLoadTraineemodulelistwithresult', array('as' => 'ExamTEMPLoadTraineemodulelistwithresult','uses' => 'ExamDivisionController@ExamTEMPLoadTraineemodulelistwithresult'));
Route::any('RefreshIncrement', array('as' => 'RefreshIncrement','uses' => 'HomeController@RefreshIncrement'));
//send to the server
Route::any('HrEvaluationFormSubmissionStatus', array('as' => 'HrEvaluationFormSubmissionStatus','uses' => 'HRPromotionController@HrEvaluationFormSubmissionStatus'));

