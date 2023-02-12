<?php
use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\AdminControllers\MediaController;


Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    // $exitCode = Artisan::call('config:cache');
});
Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/not_allowed', function () {
    return view('errors.not_found');
});

Route::group(['namespace' => 'AdminControllers', 'prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin/login');
    Route::post('/checkLogin', [AdminController::class, 'checkLogin']);
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/logout', [AdminController::class, 'logout']);
    // Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('/dashboard/{reportBase}', [AdminController::class, 'dashboard']);
});

Route::group(['prefix' => 'admin/media', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
    Route::get('/display', [MediaController::class, 'display'])->middleware('view_media');
    Route::get('/add', [MediaController::class, 'add'])->middleware('add_media');
    Route::post('/updatemediasetting', [MediaController::class, 'updatemediasetting'])->middleware('edit_media');
    Route::post('/uploadimage', [MediaController::class, 'fileUpload'])->middleware('add_media');
    Route::post('/delete', [MediaController::class, 'deleteimage'])->middleware('delete_media');
    Route::get('/detail/{id}', [MediaController::class, 'detailimage'])->middleware('view_media');
    Route::get('/refresh', [MediaController::class, 'refresh']);
    Route::post('/regenerateimage', [MediaController::class, 'regenerateimage'])->middleware('add_media');
});

// Route::group(['prefix' => 'admin/directory', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display', [DirectoryController::class, 'display'])->middleware('directory_view');
//     Route::get('/add', [DirectoryController::class, 'add'])->middleware('directory_create');
//     Route::post('/add', [DirectoryController::class, 'insert'])->middleware('directory_create');
//     Route::get('/edit/{id}', [DirectoryController::class, 'edit'])->middleware('directory_update');
//     Route::post('/update', [DirectoryController::class, 'update'])->middleware('directory_update');
//     Route::post('/delete', [DirectoryController::class, 'delete'])->middleware('directory_delete');
//     Route::post('/changeDirectoriesOrder', [DirectoryController::class, 'changeDirectoriesOrder'])->middleware('directory_update');
// });

// Route::group(['prefix' => 'admin/directorydetails', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display', [DirectoryDetailsController::class, 'display'])->middleware('directory_detail_view');
//     Route::get('/add', [DirectoryDetailsController::class, 'add'])->middleware('directory_detail_create');
//     Route::post('/add', [DirectoryDetailsController::class, 'insert'])->middleware('directory_detail_create');
//     Route::get('/edit/{id}', [DirectoryDetailsController::class, 'edit'])->middleware('directory_detail_update');
//     Route::post('/update', [DirectoryDetailsController::class, 'update'])->middleware('directory_detail_update');
//     Route::post('/delete', [DirectoryDetailsController::class, 'delete'])->middleware('directory_detail_delete');

//     Route::group(['prefix' => 'employee'], function () {
//         Route::get('/display/{directory_details_id}', [DirectoryDetailsController::class, 'directoryDetailsEmployee'])->middleware('directory_employee_view');
//         Route::get('/add/{directory_details_id}', [DirectoryDetailsController::class, 'directoryDetailsEmployeeAdd'])->middleware('directory_employee_create');
//         Route::post('/directoryDetailsEmployeeInsert', [DirectoryDetailsController::class, 'directoryDetailsEmployeeInsert'])->middleware('directory_employee_create');
//         Route::get('/edit/{directory_details_id}/{employee_id}', [DirectoryDetailsController::class, 'directoryDetailsEmployeeEdit'])->middleware('directory_employee_update');
//         Route::post('/update', [DirectoryDetailsController::class, 'directoryDetailsEmployeeUpdate'])->middleware('directory_employee_update');
//         Route::post('/delete', [DirectoryDetailsController::class, 'directoryDetailsEmployeeDelete'])->middleware('directory_employee_delete');
//     });

//     Route::group(['prefix' => 'images'], function () {
//         Route::get('/display/{directory_details_id}', [DirectoryDetailsController::class, 'detailImages'])->middleware('directory_detail_view');
//         Route::get('/add/{directory_details_id}', [DirectoryDetailsController::class, 'detailImagesAdd'])->middleware('directory_detail_create');
//         Route::post('/detailImagesInsert', [DirectoryDetailsController::class, 'detailImagesInsert'])->middleware('directory_detail_create');
//         Route::get('/edit/{directory_details_id}/{directory_detail_images_id}', [DirectoryDetailsController::class, 'detailImagesEdit'])->middleware('directory_detail_update');
//         Route::post('/detailImagesUpdate', [DirectoryDetailsController::class, 'detailImagesUpdate'])->middleware('directory_detail_update');
//         Route::post('/detailImagesDelete', [DirectoryDetailsController::class, 'detailImagesDelete'])->middleware('directory_detail_delete');
//     });
// });

// Route::group(['prefix' => 'admin/newscategories', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display', [NewsCategoriesController::class, 'display'])->middleware('view_news');
//     Route::get('/add', [NewsCategoriesController::class, 'add'])->middleware('add_news');
//     Route::post('/add', [NewsCategoriesController::class, 'insert'])->middleware('add_news');
//     Route::get('/edit/{id}', [NewsCategoriesController::class, 'edit'])->middleware('edit_news');
//     Route::post('/update', [NewsCategoriesController::class, 'update'])->middleware('edit_news');
//     Route::post('/delete', [NewsCategoriesController::class, 'delete'])->middleware('delete_news');
//     // Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
//     //Route::get('/dashboard/{reportBase}', [AdminController::class, 'dashboard']);
// });

// Route::group(['prefix' => 'admin/news', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display', [NewsController::class,'display'])->middleware('view_news');
//     Route::get('/add', [NewsController::class,'add'])->middleware('add_news');
//     Route::post('/add', [NewsController::class,'insert'])->middleware('add_news');
//     Route::get('/edit/{id}', [NewsController::class,'edit'])->middleware('edit_news');
//     Route::post('/update', [NewsController::class,'update'])->middleware('edit_news');
//     Route::post('/delete', [NewsController::class,'delete'])->middleware('delete_news');
//     //Route::get('/filter', [NewsController::class,'filter']);
// });
// // cities
// Route::group(['prefix' => 'admin/city', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display', [CityController::class, 'display']);
//     Route::get('/add', [CityController::class, 'add']);
//     Route::post('/add', [CityController::class, 'insert']);
//     Route::get('/edit/{id}', [CityController::class, 'edit']);
//     Route::post('/update', [CityController::class, 'update']);
//     Route::post('/delete', [CityController::class, 'delete']);
// });

// Route::group(['prefix' => 'admin/crop', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display', [CropController::class, 'display'])->middleware('crop_view');
//     Route::get('/add', [CropController::class, 'add'])->middleware('crop_create');
//     Route::post('/add', [CropController::class, 'insert'])->middleware('crop_create');
//     Route::get('/edit/{id}', [CropController::class, 'edit'])->middleware('crop_update');
//     Route::post('/update', [CropController::class, 'update'])->middleware('crop_update');
//     Route::post('/delete', [CropController::class, 'delete'])->middleware('crop_delete');
//     Route::post('/changeCropsOrder', [CropController::class, 'changeCropsOrder'])->middleware('crop_update');

//     Route::group(['prefix' => 'images'], function () {
//         Route::get('/display/{crop_id}', [CropController::class, 'cropImages'])->middleware('crop_view');
//         Route::get('/add/{crop_id}', [CropController::class, 'cropImagesAdd'])->middleware('crop_create');
//         Route::post('/cropImagesInsert', [CropController::class, 'cropImagesInsert'])->middleware('crop_create');
//         Route::get('/edit/{crop_id}/{crop_image_id}', [CropController::class, 'cropImagesEdit'])->middleware('crop_update');
//         Route::post('/cropImagesUpdate', [CropController::class, 'cropImagesUpdate'])->middleware('crop_update');
//         Route::post('/cropImagesDelete', [CropController::class, 'cropImagesDelete'])->middleware('crop_delete');
//     });

//     Route::get('/segment/{id}', [CropController::class, 'segment'])->middleware('crop_segment_view');
//     Route::get('/segmentAdd/{id}', [CropController::class, 'segmentAdd'])->middleware('crop_segment_create');
//     Route::post('/segmentInsert', [CropController::class, 'segmentInsert'])->middleware('crop_segment_create');
//     Route::get('/segmentEdit/{crop_id}/{crop_segments_id}', [CropController::class, 'segmentEdit'])->middleware('crop_segment_update');
//     Route::post('/segmentUpdate', [CropController::class, 'segmentUpdate'])->middleware('crop_segment_update');
//     Route::post('/segmentDelete', [CropController::class, 'segmentDelete'])->middleware('crop_segment_delete');

//     Route::get('/segmentDetail/{crop_id}/{crop_segments_id}', [CropController::class, 'segmentDetail'])->middleware('crop_segment_detail_view');
//     Route::get('/segmentDetailAdd/{crop_id}/{crop_segments_id}', [CropController::class, 'segmentDetailAdd'])->middleware('crop_segment_detail_create');
//     Route::post('/segmentDetailInsert', [CropController::class, 'segmentDetailInsert'])->middleware('crop_segment_detail_create');
//     Route::get('/segmentDetailEdit/{crop_id}/{crop_segments_id}/{segment_details_id}', [CropController::class, 'segmentDetailEdit'])->middleware('crop_segment_detail_update');
//     Route::post('/segmentDetailUpdate', [CropController::class, 'segmentDetailUpdate'])->middleware('crop_segment_detail_update');
//     Route::post('/segmentDetailDelete', [CropController::class, 'segmentDetailDelete'])->middleware('crop_segment_detail_delete');

//     Route::group(['prefix' => 'segmentDetail/images'], function () {
//         Route::get('/display/{crop_id}/{crop_segments_id}/{segment_details_id}', [CropController::class, 'segmentDetailImages'])->middleware('crop_segment_detail_view');
//         Route::get('/add/{crop_id}/{crop_segments_id}/{segment_details_id}', [CropController::class, 'segmentDetailImageAdd'])->middleware('crop_segment_detail_create');
//         Route::post('/segmentDetailImageInsert', [CropController::class, 'segmentDetailImageInsert'])->middleware('crop_segment_detail_create');
//         Route::get('/edit/{crop_id}/{crop_segments_id}/{segment_details_id}/{segment_detail_images_id}', [CropController::class, 'segmentDetailImageEdit'])->middleware('crop_segment_detail_update');
//         Route::post('/segmentDetailImageUpdate', [CropController::class, 'segmentDetailImageUpdate'])->middleware('crop_segment_detail_update');
//         Route::post('/segmentDetailImageDelete', [CropController::class, 'segmentDetailImageDelete'])->middleware('crop_segment_detail_delete');
//     });


// });
//     //sliders
// Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/sliders', [AdminSlidersController::class,'sliders'])->middleware('slider_view');
//     Route::get('/addsliderimage', [AdminSlidersController::class,'addsliderimage'])->middleware('slider_create');
//     Route::post('/addNewSlide', [AdminSlidersController::class,'addNewSlide'])->middleware('slider_create');
//     Route::get('/editslide/{id}', [AdminSlidersController::class,'editslide'])->middleware('slider_update');
//     Route::post('/updateSlide', [AdminSlidersController::class,'updateSlide'])->middleware('slider_update');
//     Route::post('/deleteSlider/', [AdminSlidersController::class,'deleteSlider'])->middleware('slider_delete');

// });

// Route::group(['prefix' => 'admin/Directorydetailadvertise', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display/{id}', [AdminDirectoryDetaiilAdvertise::class,'display'])->middleware('directory_advertise_view');
//     Route::get('/add/{id}', [AdminDirectoryDetaiilAdvertise::class,'add'])->middleware('directory_advertise_create');
//     Route::post('/add', [AdminDirectoryDetaiilAdvertise::class,'insert'])->middleware('directory_advertise_create');
//     Route::get('/edit/{direc_details_id}/{details_advertise_id}', [AdminDirectoryDetaiilAdvertise::class,'edit'])->middleware('directory_advertise_update');
//     Route::post('/update', [AdminDirectoryDetaiilAdvertise::class,'update'])->middleware('directory_advertise_update');
//     Route::post('/delete', [AdminDirectoryDetaiilAdvertise::class,'delete'])->middleware('directory_advertise_delete');
// });

// Route::group(['prefix' => 'admin/weather', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display', [WeatherController::class, 'display'])->middleware('weather_view');
//     Route::get('/edit/{id}', [WeatherController::class, 'edit'])->middleware('weather_update');
//     Route::post('/update', [WeatherController::class, 'update'])->middleware('weather_update');

// });

// Route::group(['prefix' => 'admin/weatherImg', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/display', [WeatherController::class, 'displayImg'])->middleware('weather_view');
//     Route::get('/edit/{id}', [WeatherController::class, 'editImg'])->middleware('weather_update');
//     Route::post('/update', [WeatherController::class, 'updateImg'])->middleware('weather_update');

// });


// //admin managements
// Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'AdminControllers'], function () {
//     Route::get('/admins', [AdminController::class, 'admins'])->middleware('view_manage_admin');
//     Route::get('/addadmins',[AdminController::class, 'addadmins'])->middleware('add_manage_admin');
//     Route::post('/addnewadmin',[AdminController::class, 'addnewadmin'])->middleware('add_manage_admin');
//     Route::get('/editadmin/{id}',[AdminController::class, 'editadmin'])->middleware('edit_manage_admin');
//     Route::post('/updateadmin',[AdminController::class, 'updateadmin'])->middleware('edit_manage_admin');
//     Route::post('/deleteadmin',[AdminController::class, 'deleteadmin'])->middleware('delete_manage_admin');

//     //admin managements
//     Route::get('/manageroles',[AdminController::class, 'manageroles'])->middleware('view_admin_type');
//     Route::get('/addrole/{id}',[AdminController::class, 'addrole'])->middleware('manage_role');
//     Route::post('/addnewroles',[AdminController::class, 'addnewroles'])->middleware('manage_role');
//     Route::get('/addadmintype',[AdminController::class, 'addadmintype'])->middleware('add_admin_type');
//     Route::post('/addnewtype',[AdminController::class, 'addnewtype'])->middleware('add_admin_type');
//     Route::get('/editadmintype/{id}',[AdminController::class, 'editadmintype'])->middleware('edit_admin_type');
//     Route::post('/updatetype',[AdminController::class, 'updatetype'])->middleware('edit_admin_type');
//     Route::post('/deleteadmintype',[AdminController::class, 'deleteadmintype'] )->middleware('delete_admin_type');

//     //web terms of use
//     Route::get('/editTermsConditions', [AdminController::class,'editTermsConditions']);
//     Route::post('/updateTermsConditions', [AdminController::class,'updateTermsConditions']);

//     Route::get('/editPrivacyPolicy', [AdminController::class,'editPrivacyPolicy']);
//     Route::post('/updatePrivacyPolicy', [AdminController::class,'updatePrivacyPolicy']);

//     Route::get('/addnotification', [AdminController::class,'addnotification']);
//     Route::post('/sendnotification', [AdminController::class,'fcmNotification']);

//     Route::get('/contactDetail', [AdminController::class,'contactDetail']);
//     Route::post('/updateContactDetail', [AdminController::class,'updateContactDetail']);

// });

















?>
