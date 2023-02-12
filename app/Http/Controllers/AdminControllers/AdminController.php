<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Models\Core\Setting;
use App\Models\Core\Directory;
use Validator;
use Hash;
use Auth;

class AdminController extends Controller
{
	public function __construct(Setting $setting, Directory $directory)
	{
		$this->Setting = $setting;
		$this->Directory = $directory;
	}

	public function login()
	{
		if (Auth::check()) {
			// echo "dashboard";
			// exit;
			return redirect('/admin/dashboard/this_month');
		} else {
			$title = array('pageTitle' => Lang::get("labels.login_page_name"));
			return view("admin.login", $title);
		}
	}

	//login function
	public function checkLogin(Request $request)
	{
		$validator = Validator::make(
			array(
				'email'    => $request->email,
				'password' => $request->password
			),
			array(
				'email'    => 'required | email',
				'password' => 'required',
			)
		);
		//check validation
		if ($validator->fails()) {
			return redirect('admin/login')->withErrors($validator)->withInput();
		} else {
			//check authentication of email and password
			$adminInfo = array("email" => $request->email, "password" => $request->password, "status" => 1);

			if (auth()->attempt($adminInfo)) {
				$admin = auth()->user();

				$administrators = DB::table('users')->where('id', $admin->myid)->get();



				$categories_id = '';
				//admin category role
				if (auth()->user()->adminType != '1') {
					$categories_role = DB::table('categories_role')->where('admin_id', auth()->user()->myid)->get();
					if (!empty($categories_role) and count($categories_role) > 0) {
						$categories_id = $categories_role[0]->categories_ids;
					} else {
						$categories_id = '';
					}
				}

				session(['categories_id' => $categories_id]);
				return redirect()->intended('admin/dashboard/this_month')->with('administrators', $administrators);
			} else {
				return redirect('admin/login')->with('loginError', Lang::get("labels.EmailPasswordIncorrectText"));
			}
		}
	}

	//logout
	public function logout()
	{
		Auth::logout();
		return redirect('/admin/login');
	}

	// Dashboard
	public function dashboard(Request $request)
	{
		$title 			  = 	array('pageTitle' => Lang::get("labels.title_dashboard"));
		$language_id      = 	'1';

		$result 		  =		array();

		$reportBase		  = 	$request->reportBase;


		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.dashboard", $title)->with('result', $result);
	}
	//managerole
	// public function addrole(Request $request)
	// {


	// 	$title = array('pageTitle' => Lang::get("labels.EditAdminType"));
	// 	$result = array();
	// 	$user_types_id = $request->id;
	// 	$result['user_types_id'] = $user_types_id;

	// 	$adminType = DB::table('user_types')->where('user_types_id', $user_types_id)->get();
	// 	$result['adminType'] = $adminType;

	// 	$roles = DB::table('manage_role')->where('user_types_id', '=', $user_types_id)->get();

	// 	if (count($roles) > 0) {
	// 		$dashboard_view = $roles[0]->dashboard_view;

	// 		$media_view   = $roles[0]->view_media;
	// 		$media_create = $roles[0]->add_media;
	// 		$media_update = $roles[0]->edit_media;
	// 		$media_delete = $roles[0]->delete_media;

	// 		$directory_view   = $roles[0]->directory_view;
	// 		$directory_create = $roles[0]->directory_create;
	// 		$directory_update = $roles[0]->directory_update;
	// 		$directory_delete = $roles[0]->directory_delete;

	// 		$directory_advertise_view   = $roles[0]->directory_advertise_view;
	// 		$directory_advertise_create = $roles[0]->directory_advertise_create;
	// 		$directory_advertise_update = $roles[0]->directory_advertise_update;
	// 		$directory_advertise_delete = $roles[0]->directory_advertise_delete;

	// 		$directory_detail_view   = $roles[0]->directory_detail_view;
	// 		$directory_detail_create = $roles[0]->directory_detail_create;
	// 		$directory_detail_update = $roles[0]->directory_detail_update;
	// 		$directory_detail_delete = $roles[0]->directory_detail_delete;

	// 		$directory_employee_view   = $roles[0]->directory_employee_view;
	// 		$directory_employee_create = $roles[0]->directory_employee_create;
	// 		$directory_employee_update = $roles[0]->directory_employee_update;
	// 		$directory_employee_delete = $roles[0]->directory_employee_delete;

	// 		$news_view   = $roles[0]->news_view;
	// 		$news_create = $roles[0]->news_create;
	// 		$news_update = $roles[0]->news_update;
	// 		$news_delete = $roles[0]->news_delete;

	// 		$crop_view   = $roles[0]->crop_view;
	// 		$crop_create = $roles[0]->crop_create;
	// 		$crop_update = $roles[0]->crop_update;
	// 		$crop_delete = $roles[0]->crop_delete;

	// 		$crop_segment_view   = $roles[0]->crop_segment_view;
	// 		$crop_segment_create = $roles[0]->crop_segment_create;
	// 		$crop_segment_update = $roles[0]->crop_segment_update;
	// 		$crop_segment_delete = $roles[0]->crop_segment_delete;

	// 		$crop_segment_detail_view   = $roles[0]->crop_segment_detail_view;
	// 		$crop_segment_detail_create = $roles[0]->crop_segment_detail_create;
	// 		$crop_segment_detail_update = $roles[0]->crop_segment_detail_update;
	// 		$crop_segment_detail_delete = $roles[0]->crop_segment_detail_delete;

	// 		$slider_view   = $roles[0]->slider_view;
	// 		$slider_create = $roles[0]->slider_create;
	// 		$slider_update = $roles[0]->slider_update;
	// 		$slider_delete = $roles[0]->slider_delete;

	// 		$weather_view = $roles[0]->weather_view;
	// 		$weather_update = $roles[0]->weather_update;

	// 		$manage_admins_view   = $roles[0]->manage_admins_view;
	// 		$manage_admins_create = $roles[0]->manage_admins_create;
	// 		$manage_admins_update = $roles[0]->manage_admins_update;
	// 		$manage_admins_delete = $roles[0]->manage_admins_delete;

	// 		$admintype_view = $roles[0]->admintype_view;
	// 		$admintype_create = $roles[0]->admintype_create;
	// 		$admintype_update = $roles[0]->admintype_update;
	// 		$admintype_delete = $roles[0]->admintype_delete;
	// 		$manage_admins_role = $roles[0]->manage_admins_role;
	// 	} else {
	// 		$dashboard_view = '0';

	// 		$media_view   = '0';
	// 		$media_create = '0';
	// 		$media_update = '0';
	// 		$media_delete = '0';

	// 		$directory_view   = '0';
	// 		$directory_create = '0';
	// 		$directory_update = '0';
	// 		$directory_delete = '0';

	// 		$directory_advertise_view   = '0';
	// 		$directory_advertise_create = '0';
	// 		$directory_advertise_update = '0';
	// 		$directory_advertise_delete = '0';

	// 		$directory_detail_view   = '0';
	// 		$directory_detail_create = '0';
	// 		$directory_detail_update = '0';
	// 		$directory_detail_delete = '0';

	// 		$directory_employee_view   = '0';
	// 		$directory_employee_create = '0';
	// 		$directory_employee_update = '0';
	// 		$directory_employee_delete = '0';

	// 		$news_view   = '0';
	// 		$news_create = '0';
	// 		$news_update = '0';
	// 		$news_delete = '0';

	// 		$crop_view   = '0';
	// 		$crop_create = '0';
	// 		$crop_update = '0';
	// 		$crop_delete = '0';

	// 		$crop_segment_view   = '0';
	// 		$crop_segment_create = '0';
	// 		$crop_segment_update = '0';
	// 		$crop_segment_delete = '0';

	// 		$crop_segment_detail_view   = '0';
	// 		$crop_segment_detail_create = '0';
	// 		$crop_segment_detail_update = '0';
	// 		$crop_segment_detail_delete = '0';

	// 		$slider_view   = '0';
	// 		$slider_create = '0';
	// 		$slider_update = '0';
	// 		$slider_delete = '0';

	// 		$weather_view = '0';
	// 		$weather_update = '0';

	// 		$manage_admins_view   = '0';
	// 		$manage_admins_create = '0';
	// 		$manage_admins_update = '0';
	// 		$manage_admins_delete = '0';

	// 		$admintype_view = '0';
	// 		$admintype_create = '0';
	// 		$admintype_update = '0';
	// 		$admintype_delete = '0';
	// 		$manage_admins_role = '0';
	// 	}


	// 	$result2[0]['link_name'] = 'dashboard';
	// 	$result2[0]['permissions'] = array('0' => array('name' => 'dashboard_view', 'value' => $dashboard_view));

	// 	$result2[1]['link_name'] = 'Media';
	// 	$result2[1]['permissions'] = array(
	// 		'0' => array('name' => 'media_view', 'value' => $media_view),
	// 		'1' => array('name' => 'media_create', 'value' => $media_create),
	// 		'2' => array('name' => 'media_update', 'value' => $media_update),
	// 		'3' => array('name' => 'media_delete', 'value' => $media_delete),
	// 	);

	// 	$result2[2]['link_name'] = 'Directory';
	// 	$result2[2]['permissions'] = array(
	// 		'0' => array('name' => 'directory_view', 'value' => $directory_view),
	// 		'1' => array('name' => 'directory_create', 'value' => $directory_create),
	// 		'2' => array('name' => 'directory_update', 'value' => $directory_update),
	// 		'3' => array('name' => 'directory_delete', 'value' => $directory_delete),
	// 	);

	// 	$result2[3]['link_name'] = 'DirectoryAdvertise';
	// 	$result2[3]['permissions'] = array(
	// 		'0' => array('name' => 'directory_advertise_view', 'value' => $directory_advertise_view),
	// 		'1' => array('name' => 'directory_advertise_create', 'value' => $directory_advertise_create),
	// 		'2' => array('name' => 'directory_advertise_update', 'value' => $directory_advertise_update),
	// 		'3' => array('name' => 'directory_advertise_delete', 'value' => $directory_advertise_delete),
	// 	);

	// 	$result2[4]['link_name'] = 'DirectoryDetail';
	// 	$result2[4]['permissions'] = array(
	// 		'0' => array('name' => 'directory_detail_view', 'value' => $directory_detail_view),
	// 		'1' => array('name' => 'directory_detail_create', 'value' => $directory_detail_create),
	// 		'2' => array('name' => 'directory_detail_update', 'value' => $directory_detail_update),
	// 		'3' => array('name' => 'directory_detail_delete', 'value' => $directory_detail_delete),
	// 	);

	// 	$result2[5]['link_name'] = 'DirectoryEmployee';
	// 	$result2[5]['permissions'] = array(
	// 		'0' => array('name' => 'directory_employee_view', 'value' => $directory_employee_view),
	// 		'1' => array('name' => 'directory_employee_create', 'value' => $directory_employee_create),
	// 		'2' => array('name' => 'directory_employee_update', 'value' => $directory_employee_update),
	// 		'3' => array('name' => 'directory_employee_delete', 'value' => $directory_employee_delete),
	// 	);

	// 	$result2[6]['link_name'] = 'news';
	// 	$result2[6]['permissions'] = array(
	// 		'0' => array('name' => 'news_view', 'value' => $news_view),
	// 		'1' => array('name' => 'news_create', 'value' => $news_create),
	// 		'2' => array('name' => 'news_update', 'value' => $news_update),
	// 		'3' => array('name' => 'news_delete', 'value' => $news_delete)
	// 	);

	// 	$result2[7]['link_name'] = 'Crop';
	// 	$result2[7]['permissions'] = array(
	// 		'0' => array('name' => 'crop_view', 'value' => $crop_view),
	// 		'1' => array('name' => 'crop_create', 'value' => $crop_create),
	// 		'2' => array('name' => 'crop_update', 'value' => $crop_update),
	// 		'3' => array('name' => 'crop_delete', 'value' => $crop_delete)
	// 	);

	// 	$result2[8]['link_name'] = 'CropSegment';
	// 	$result2[8]['permissions'] = array(
	// 		'0' => array('name' => 'crop_segment_view', 'value' => $crop_segment_view),
	// 		'1' => array('name' => 'crop_segment_create', 'value' => $crop_segment_create),
	// 		'2' => array('name' => 'crop_segment_update', 'value' => $crop_segment_update),
	// 		'3' => array('name' => 'crop_segment_delete', 'value' => $crop_segment_delete)
	// 	);

	// 	$result2[9]['link_name'] = 'CropSegmentDetail';
	// 	$result2[9]['permissions'] = array(
	// 		'0' => array('name' => 'crop_segment_detail_view', 'value' => $crop_segment_detail_view),
	// 		'1' => array('name' => 'crop_segment_detail_create', 'value' => $crop_segment_detail_create),
	// 		'2' => array('name' => 'crop_segment_detail_update', 'value' => $crop_segment_detail_update),
	// 		'3' => array('name' => 'crop_segment_detail_delete', 'value' => $crop_segment_detail_delete)
	// 	);

	// 	$result2[10]['link_name'] = 'Slider';
	// 	$result2[10]['permissions'] = array(
	// 		'0' => array('name' => 'slider_view', 'value' => $slider_view),
	// 		'1' => array('name' => 'slider_create', 'value' => $slider_create),
	// 		'2' => array('name' => 'slider_update', 'value' => $slider_update),
	// 		'3' => array('name' => 'slider_delete', 'value' => $slider_delete)
	// 	);

	// 	$result2[11]['link_name'] = 'Weather';
	// 	$result2[11]['permissions'] = array(
	// 		'0' => array('name' => 'weather_view', 'value' => $weather_view),
	// 		'1' => array('name' => 'weather_update', 'value' => $weather_update)
	// 	);

	// 	$result2[12]['link_name'] = 'manage_admins';
	// 	$result2[12]['permissions'] = array(
	// 		'0' => array('name' => 'manage_admins_view', 'value' => $manage_admins_view),
	// 		'1' => array('name' => 'manage_admins_create', 'value' => $manage_admins_create),
	// 		'2' => array('name' => 'manage_admins_update', 'value' => $manage_admins_update),
	// 		'3' => array('name' => 'manage_admins_delete', 'value' => $manage_admins_delete)
	// 	);

	// 	$result2[13]['link_name'] = 'Admin Types';
	// 	$result2[13]['permissions'] = array(
	// 		'0' => array('name' => 'admintype_view', 'value' => $admintype_view),
	// 		'1' => array('name' => 'admintype_create', 'value' => $admintype_create),
	// 		'2' => array('name' => 'admintype_update', 'value' => $admintype_update),
	// 		'3' => array('name' => 'admintype_delete', 'value' => $admintype_delete),
	// 		'4' => array('name' => 'manage_admins_role', 'value' => $manage_admins_role)
	// 	);

	// 	$result['data'] = $result2;
	// 	$result['commonContent'] = $this->Setting->commonContent();
	// 	return view("admin.admins.roles.addrole", $title)->with('result', $result);
	// }

	// //addnewroles
	// public function addnewroles(Request $request)
	// {

	// 	$user_types_id = $request->user_types_id;
	// 	DB::table('manage_role')->where('user_types_id', $user_types_id)->delete();

	// 	$roles = DB::table('manage_role')->insert([
	// 		'user_types_id'			=>	 $request->user_types_id,
	// 		'dashboard_view' => $request->dashboard_view,

	// 		'view_media' => $request->media_view,
	// 		'add_media' => $request->media_create,
	// 		'edit_media' => $request->media_update,
	// 		'delete_media' => $request->media_delete,

	// 		'directory_view' => $request->directory_view,
	// 		'directory_create' => $request->directory_create,
	// 		'directory_update' => $request->directory_update,
	// 		'directory_delete' => $request->directory_delete,

	// 		'directory_advertise_view' => $request->directory_advertise_view,
	// 		'directory_advertise_create' => $request->directory_advertise_create,
	// 		'directory_advertise_update' => $request->directory_advertise_update,
	// 		'directory_advertise_delete' => $request->directory_advertise_delete,

	// 		'directory_detail_view' => $request->directory_detail_view,
	// 		'directory_detail_create' => $request->directory_detail_create,
	// 		'directory_detail_update' => $request->directory_detail_update,
	// 		'directory_detail_delete' => $request->directory_detail_delete,

	// 		'directory_employee_view' => $request->directory_employee_view,
	// 		'directory_employee_create' => $request->directory_employee_create,
	// 		'directory_employee_update' => $request->directory_employee_update,
	// 		'directory_employee_delete' => $request->directory_employee_delete,

	// 		'news_view' => $request->news_view,
	// 		'news_create' => $request->news_create,
	// 		'news_update' => $request->news_update,
	// 		'news_delete' => $request->news_delete,

	// 		'crop_view' => $request->crop_view,
	// 		'crop_create' => $request->crop_create,
	// 		'crop_update' => $request->crop_update,
	// 		'crop_delete' => $request->crop_delete,

	// 		'crop_segment_view' => $request->crop_segment_view,
	// 		'crop_segment_create' => $request->crop_segment_create,
	// 		'crop_segment_update' => $request->crop_segment_update,
	// 		'crop_segment_delete' => $request->crop_segment_delete,

	// 		'crop_segment_detail_view' => $request->crop_segment_detail_view,
	// 		'crop_segment_detail_create' => $request->crop_segment_detail_create,
	// 		'crop_segment_detail_update' => $request->crop_segment_detail_update,
	// 		'crop_segment_detail_delete' => $request->crop_segment_detail_delete,

	// 		'slider_view' => $request->slider_view,
	// 		'slider_create' => $request->slider_create,
	// 		'slider_update' => $request->slider_update,
	// 		'slider_delete' => $request->slider_delete,

	// 		'weather_view' => $request->weather_view,
	// 		'weather_update' => $request->weather_update,

	// 		'manage_admins_view' => $request->manage_admins_view,
	// 		'manage_admins_create' => $request->manage_admins_create,
	// 		'manage_admins_update' => $request->manage_admins_update,
	// 		'manage_admins_delete' => $request->manage_admins_delete,

	// 		'admintype_view' => $request->admintype_view,
	// 		'admintype_create' => $request->admintype_create,
	// 		'admintype_update' => $request->admintype_update,
	// 		'admintype_delete' => $request->admintype_delete,
	// 		'manage_admins_role' => $request->manage_admins_role,

	// 	]);

	// 	$message = Lang::get("labels.Roles has been added successfully");
	// 	return redirect()->back()->with('message', $message);
	// }

	public function termAndCondition(Request $request)
    {
        // $data = array('page_number' => '0', 'type' => '', 'products_id' => $products_id, 'limit' => 1, 'min_price' => '', 'max_price' => '');
        $detail = DB::table('cms')->where('cms_id',1)->select('cms.cms_text')->first();
        //print_r($detail);exit;

        return view("web.termAndCondition")->with('detail', $detail);
    }

    public function privacyPolicy(Request $request)
    {
        // $data = array('page_number' => '0', 'type' => '', 'products_id' => $products_id, 'limit' => 1, 'min_price' => '', 'max_price' => '');
        $detail = DB::table('cms')->where('cms_id',7)->select('cms.cms_text')->first();
        //print_r($detail);exit;

        return view("web.privacy_policy")->with('detail', $detail);
    }

}
