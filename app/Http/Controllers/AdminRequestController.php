<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



class AdminRequestController extends Controller

{

	public function profileUpdateRequest()

	{

		$data = array();

		$data['employees'] = \App\User::where('request_json','!=',null)->where('role','!=',1)->orderBy('id','DESC')->get();

		return view('admin.requests.profile-requests',$data);

	}

	public function getProfileUpdateRequest($id)

	{

		$data = array();

		$user = \App\User::where('id',$id)->first();
		$data['details'] = \App\EmployeePersonalDetail::where('user_id',$id)->first();

		if(is_null($user)){

			return redirect('/admin/request/profile-update/')->with('error','User not found.');

		}else{

			if(is_null($user->request_json)){

				return redirect('/admin/request/profile-update')->with('error','No Request Found');

			}else{

				$data['employee'] = $user;

				$data['profile'] = json_decode($user->request_json);

				return view('admin.requests.profile-request',$data);

			}

		}

	}

	public function approveProfileUpdateRequest($id)

	{

		$user = \App\User::where('id',$id)->first();

		if(is_null($user)){

			return redirect('/admin/request/profile-update')->with('error','User not found.');

		}

		else{

			if(is_null($user->request_json)){

				return redirect('/admin/request/profile-update')->with('error','No Request Found');

			}else{

				$profile = json_decode($user->request_json);

				$user->first_name = $profile->first_name;

				$user->last_name = $profile->last_name;

				$user->save();

				$employee =  \App\EmployeePersonalDetail::where('user_id',$user->id)->first();

				$employee->address = $profile->address;

				$employee->bank_account = $profile->bank_account;

				$employee->martial_status = $profile->martial_status;

				$employee->phone_number = $profile->phone_number;

				$employee->anniversary_date = $profile->anniversary_date;

				$employee->dob = $profile->dob;

				$employee->personal_email = $profile->personal_email;

				$employee->father_name = $profile->father_name;

				$employee->mother_name = $profile->mother_name;

				$employee->parent_contact_number = $profile->parent_contact_number;

				$employee->save();

				$user->request_json = null;

				$user->is_request_approved = 1;

				if($user->save()){

					/*-----------------------------------Send notification-----------------------*/

					$receiver = array($user->id);

					$title = "Admin Approved Your Profile change request.";

					$message = "Admin Approved Your Profile change request.";

					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

					/*-----------------------------------Send notification-------------------------*/

					return redirect('/admin/request/profile-update')->with('success','Request Updated Successfully.');

				}else{

					return redirect('/admin/request/profile-update')->with('error','Something Went Wrong');

				}

			}

		}

	}



	public function discardProfileUpdateRequest($id)

	{

		$user = \App\User::where('id',$id)->first();

		if(is_null($user)){

			return redirect('/admin/request/profile-update/')->with('error','User not found.');

		}else{

			if(is_null($user->request_json)){

				return redirect('/admin/request/profile-update')->with('error','No Request Found');

			}else{

				$user->request_json = null;

				$user->is_request_approved = -1;

				if($user->save()){

					/*-----------------------------------Send notification-----------------------*/

					$receiver = array($user->id);

					$title = "Admin Discarded Your Profile change request.";

					$message = "Admin Discarded Your Profile change request.";

					NotificationController::notify(\Auth::user()->id,$receiver,$title,$message);

					/*-----------------------------------Send notification-------------------------*/

					return redirect('/admin/request/profile-update')->with('success','Request Updated Successfully.');

				}else{

					return redirect('/admin/request/profile-update')->with('error','Something Went Wrong');

				}

			}

		}

	}

}

