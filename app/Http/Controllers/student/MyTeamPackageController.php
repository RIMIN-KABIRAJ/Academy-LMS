<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\OfflinePayment;
use App\Models\TeamPackageMember;
use App\Models\TeamPackagePurchase;
use App\Models\TeamTrainingPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MyTeamPackageController extends Controller
{
    public function index()
    {
        $page_data['packages'] = TeamPackagePurchase::join('team_training_packages', 'team_package_purchases.package_id', 'team_training_packages.id')
            ->join('courses', 'team_training_packages.course_id', 'courses.id')
            ->where('team_package_purchases.user_id', auth()->user()->id)
            ->where('team_package_purchases.status', 1)
            ->select(
                'team_training_packages.*',
                'courses.title as course_title',
                'courses.slug as course_slug'
            )
            ->latest('id')->paginate(10)->appends(request()->query());

        // check the expiry of purchased packages
        $packages = TeamPackagePurchase::join('team_training_packages', 'team_package_purchases.package_id', 'team_training_packages.id')
            ->where('team_package_purchases.status', 1)
            ->where('team_package_purchases.user_id', auth()->user()->id)
            ->where('team_training_packages.expiry_type', 'limited')
            ->where('team_training_packages.expiry_date', '<', time())
            ->pluck('team_package_purchases.package_id')->toArray();
        foreach ($packages as $package) {
            TeamPackagePurchase::where('user_id', auth()->user()->id)->where('package_id', $package)->update(['status' => 0]);
        }

        return view('frontend.default.student.my_team_packages.index', $page_data);
    }

    public function show($slug)
    {
        // check purchase
        $package = TeamPackagePurchase::join('team_training_packages', 'team_package_purchases.package_id', 'team_training_packages.id')
            ->join('courses', 'team_training_packages.course_id', 'courses.id')
            ->where('team_package_purchases.user_id', auth()->user()->id)
            ->where('team_package_purchases.status', 1)
            ->where('team_training_packages.slug', $slug)
            ->select(
                'team_training_packages.*',
                'courses.title as course_title',
                'courses.slug as course_slug'
            )->first();

        if (! $package) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $page_data['package'] = $package;
        $page_data['members'] = TeamPackageMember::join('users', 'team_package_members.member_id', 'users.id')
            ->join('team_training_packages', 'team_package_members.team_package_id', 'team_training_packages.id')
            ->select('team_package_members.*', 'users.name as name', 'users.email as email', 'users.photo as photo', 'team_training_packages.course_id')
            ->where([
                'team_package_members.leader_id'       => auth()->user()->id,
                'team_package_members.team_package_id' => $package->id,
            ])->paginate(10);

        $page_data['purchased_packages'] = TeamPackagePurchase::join('team_training_packages', 'team_package_purchases.package_id', 'team_training_packages.id')
            ->where('team_package_purchases.user_id', auth()->user()->id)
            ->where('team_package_purchases.package_id', $package->id)
            ->select('team_package_purchases.*', 'team_training_packages.title', 'team_training_packages.slug')
            ->latest('id')->paginate(15);

        return view('frontend.default.student.my_team_packages.details', $page_data);
    }

    public function search_members(Request $request, $package_id = '')
    {
        $user = User::where('email', $request->email)->select('users.id', 'users.name', 'users.email', 'users.photo')->first();
        if ($package_id && $user) {
            $status = TeamPackageMember::where('team_package_id', $package_id)->where('member_id', $user->id)->exists() ? 1 : 0;

            $page_data['user']       = $user;
            $page_data['status']     = $status;
            $page_data['package_id'] = $package_id;

            return view('frontend.default.student.my_team_packages.search_member', $page_data);
        }
    }

    public function member_action($action)
    {
        $packageId = request()->query('package_id');
        $userId    = request()->query('user_id');

        $package = TeamTrainingPackage::find($packageId);
        $user    = User::find($userId);

        // Check if the user is the team leader
        if ($user->email === auth()->user()->email) {
            Session::flash('error', get_phrase('You are the team leader.'));
            return redirect()->back();
        }

        // check purchase
        $purchased_package = TeamPackagePurchase::where('user_id', auth()->user()->id)->where('package_id', $package->id)->first();
        if (! $purchased_package) {
            return redirect()->back()->with('error', get_phrase('Forbidden! Access denied.'));
        }

        $package_member = TeamPackageMember::where('leader_id', auth()->user()->id)
            ->where('team_package_id', $package->id)->where('member_id', $user->id)->first();

        // enrollment query
        $user_enrollment = Enrollment::where('course_id', $package->course_id)->where('user_id', $user->id)->first();

        if ($action == 'register') {

            // count reserved members
            if (reserved_team_members($package->id) >= $package->allocation) {
                return redirect()->back()->with('error', 'Not enough space to add a member.');
            }

            if (! $package_member) {
                $data['leader_id']       = auth()->user()->id;
                $data['team_package_id'] = $package->id;
                $data['member_id']       = $user->id;

                TeamPackageMember::insert($data);

                // enroll member to course
                $enroll['course_id']       = $package->course_id;
                $enroll['user_id']         = $user->id;
                $enroll['enrollment_type'] = 'team_package';
                $enroll['entry_date']      = strtotime('now');
                if ($package->expiry_type == 'limited') {
                    $enroll['expiry_date'] = $package->expiry_date;
                }
                if (! $user_enrollment) {
                    Enrollment::insert($enroll);
                } else {
                    if (ctype_digit($user_enrollment->expiry_date) && $package->expiry_type == 'limited') {
                        $expiry = max($user_enrollment->expiry_date, $package->expiry_date);
                        $user_enrollment->update(['expiry_date' => $expiry]);
                    }
                }

                Session::flash('success', get_phrase('Member has been added to team.'));
            } else {
                Session::flash('error', get_phrase('Member already exists in the team.'));
            }
        } elseif ($action == 'remove') {
            if ($package_member) {
                $package_member->delete();

                // remove enrolled student
                Enrollment::where('course_id', $package->course_id)->where('user_id', $user->id)->delete();

                Session::flash('success', get_phrase('Member has been removed to team.'));
            } else {
                Session::flash('error', get_phrase('Member not found in the team.'));
            }
        }

        return redirect()->back();
    }

    public function purchase($id)
    {
        $package = TeamTrainingPackage::find($id);

        // check package owner
        if ($package->user_id == auth()->user()->id) {
            Session::flash('error', get_phrase('You own this item.'));
            return redirect()->back();
        }

        // check item is purchased or not
        if (TeamPackagePurchase::where('user_id', auth()->user()->id)->where('package_id', $id)->where('status', 1)->exists()) {
            Session::flash('error', get_phrase('Item is already purchased.'));
            return redirect()->back();
        }

        // check any offline processing data
        $processing_payments = OfflinePayment::where([
            'user_id'   => auth()->user()->id,
            'items'     => $package->id,
            'item_type' => 'team_package',
            'status'    => 0,
        ])
            ->first();

        if ($processing_payments) {
            Session::flash('warning', get_phrase('Your request is in process.'));
            return redirect()->back();
        }

        // prepare team package payment data
        $payment_details = [
            'items'          => [
                [
                    'id'             => $package->id,
                    'title'          => $package->title,
                    'subtitle'       => '',
                    'price'          => $package->price,
                    'discount_price' => '',
                ],
            ],

            'custom_field'   => [
                'item_type' => 'package',
                'pay_for'   => get_phrase('Team Training Package'),
            ],

            'success_method' => [
                'model_name'    => 'TeamPackagePurchase',
                'function_name' => 'purchase_team_package',
            ],

            'payable_amount' => round($package->price, 2),
            'tax'            => 0,
            'cancel_url'     => route('team.package.details', $package->slug),
            'success_url'    => route('payment.success', ''),
        ];

        Session::put(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }

    public function invoice($id)
    {
        $page_data['package'] = TeamPackagePurchase::join('team_training_packages', 'team_package_purchases.package_id', 'team_training_packages.id')
            ->join('users', 'team_package_purchases.user_id', 'users.id')
            ->select('team_package_purchases.*', 'team_training_packages.title', 'team_training_packages.slug', 'users.name as user_name')
            ->where('team_package_purchases.user_id', auth()->user()->id)
            ->where('team_package_purchases.id', $id)
            ->first();

        return view('frontend.default.student.my_team_packages.print_invoice', $page_data);
    }
}
