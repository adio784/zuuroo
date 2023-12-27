<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use App\Interfaces\PaymentRepositoryInterface;
use App\Interfaces\HistoryRepositoryInterface;
use App\Interfaces\FaqRepositoryInterface;
use App\Interfaces\SupportRepositoryInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\LoanLimit;
use App\Models\LoanHistory;
use App\Models\OtherProduct;
use App\Repositories\UserBankDetailsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Twilio\Rest\Client;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    private PaymentRepositoryInterface $PaymentRepository;
    private HistoryRepositoryInterface $HistoryRepository;
    private FaqRepositoryInterface $FaqRepository;
    private SupportRepositoryInterface $SupportRepository;
    private NotificationRepositoryInterface $NotificationRepository;
    private UserRepositoryInterface $UserRepository;
    private $UserBankDetailsRepository;

    public function __construct(PaymentRepositoryInterface $PaymentRepository,
                                HistoryRepositoryInterface $HistoryRepository,
                                FaqRepositoryInterface $FaqRepository,
                                SupportRepositoryInterface $SupportRepository,
                                NotificationRepositoryInterface $NotificationRepository,
                                UserRepositoryInterface $UserRepository,
                                UserBankDetailsRepository $UserBankDetailsRepository)
    {
        $this->PaymentRepository = $PaymentRepository;
        $this->HistoryRepository = $HistoryRepository;
        $this->FaqRepository = $FaqRepository;
        $this->SupportRepository = $SupportRepository;
        $this->NotificationRepository = $NotificationRepository;
        $this->UserRepository = $UserRepository;
        $this->UserBankDetailsRepository = $UserBankDetailsRepository;
    }
    // Data view page
    public static function getToken(){
        $DataDetails = [
            'client_id'=> '919c366c-4645-46f8-80cc-35c77040014b',
            'client_secret' => '71apN0bg3CXO7ACVWe9mjjaibZu6sd4uC0VA2rH10GI=',
            'grant_type' => 'client_credentials'
        ];
        $response = Http::asForm()->post('https://idp.ding.com/connect/token', $DataDetails);
        return $response['access_token'];
    }

    public function faqs() {
        $data = [
            'dt' => 0,
            'Record'=>$this->FaqRepository->getAllFaqs()
        ];
        return view('app.user.faqs', $data);
    }

    public function loans() {
        $data = array(
            'LoanInfo' => DB::table('loan_histories')
                            ->get()
        );
        return view('app.user.loans', $data);
    }
    public function user_loan_receipt($id){
        $data = array(
            'Info' => LoanHistory::distinct()
                                ->join('users', 'users.id', 'loan_histories.user_id')
                                ->join('countries', 'countries.country_code', 'loan_histories.country_code')
                                ->where('loan_histories.transfer_ref', $id)
                                ->where('repayment', '<=', NOW())
                                // ->groupBy('loan_histories.transfer_ref')
                                ->first()
         );
        return view('app.user.user_loan_receipt', $data);
    }
    public function supports() {
        $data = [
            'dt' => 0,
            'Record'=>$this->SupportRepository->getAllSupports()
        ];
        return view('app.user.supports', $data);
    }

    public function abts() {
        $UserId = Auth::user()->email;
        $data = [
            'Record' => $this->UserBankDetailsRepository->getDetailsById($UserId)
        ];
        return view('app.user.abt', $data);
    }

    public function pay_outstanding()
    {
        # code...
        $data = array(
            'LoanInfo' => DB::table('loan_histories')
                            ->get()
        );
        return view('app.user.pay_outstanding', $data);
    }
    public function datas() {
        $data = [
            'dt' => 0,
            'LoanInfo' => LoanLimit::where('status', 1)->get()
        ];
        return view('app.user.datas', $data); 
        
    }
    public function airtimes() {
        $data = [
            'Info' => OtherProduct::where('name', 'airtime')->first(),
            'LoanInfo' => LoanLimit::where('status', 1)->get()
        ];
        return view('app.user.airtimes', $data); }
    public function funds() { return view('app.user.funds'); }
    public function mobile_view() { return view('auth.mobile'); }
    public function view_mverify() { return view('auth.input_verifymobile'); }
    public function pin() { return view('auth.create_pin'); }
    public function country() { Alert::info('Welcome!', 'All information provided are secured, and will not be expose/use for any other purpose other than which it is provided for'); return view('auth.country'); }

    public function fund_histories(){
        $UserId = Auth::user()->email;
        $data = [
            'Record' => $this->PaymentRepository->getPaymentsById($UserId)
        ];
        return view('app.user.fund_histories', $data);
    }
    public function transactions()
    {
        $UserId = Auth::user()->id;
        $data = [
            'Record' => $this->HistoryRepository->getAllHistoryByUser($UserId),
        ];
        return view('app.user.transactions', $data);
    }
    public function airtime_transactions()
    {
        $Purchase = 'Airtime';
        $UserId = Auth::user()->id;
        $data = [
            'AirtimeRecord' => $this->HistoryRepository->getPurchaseHistoryByUser($Purchase, $UserId),
        ];
        return view('app.user.airtime_transactions', $data);
    }
    public function data_transactions()
    {
        $Purchase = 'Data';
        $UserId = Auth::user()->id;
        $data = [
            'DataRecord' => $this->HistoryRepository->getPurchaseHistoryByUser($Purchase, $UserId),
        ];
        return view('app.user.data_transactions', $data);
    }

    public function userProfile(){
        if( Auth::user()->id ){
            $data = [
                'LoggedUserInfo'=> User::where('id', '=', Auth::user()->id )->first()
            ];
        }
        return view('app.user.user_profile', $data);
    }

    public function notifications(){
        $UserId = Auth::user()->id;
        $data = array(
            'Record' => $this->NotificationRepository->getNotificationByUser($UserId)
        );
        return view('app.user.notifications', $data);
    }

    public function update_password(Request $request)
    {
        $uid = Auth::user()->id;
        $data = $request->validate([
            'password'  => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $UserDetails = [
            'password' => Hash::make($request->password)
        ];
        $user = $this->UserRepository->updateUser($uid, $UserDetails);
        if($user){
            Alert::success('success', 'You have succesfully change your password, please login to confirm');
            return back();
        }else{
            Alert::danger('fail', 'Sorry, Your Request Could Not Be Completed');
            return back();
        }
    }

    public function update_phoneNumber(Request $request)
    {
        $uid = Auth::user()->id;
        $data = $request->validate([
            'phoneNumber'  => ['required', 'numeric']
        ]);

        $UserDetails = [
            'mobile' => $request->phoneNumber,
            'number_verify_at' => ''
        ];
        $user = $this->UserRepository->updateUser($uid, $UserDetails);
        if($user){
            Alert::success('success', 'Phone Number Update Successfully');
            return back();
        }else{
            Alert::danger('fail', 'Sorry, Your Request Could Not Be Completed');
            return back();
        }
    }





    public function mobile(Request $request){
        $data = $request->validate([
            'phone_number' => ['required', 'numeric']
        ]);
        $token = "45e91947eed926fba68e4e3d87af7809";//getenv("TWILIO_AUTH_TOKEN");
        // dd($token);
        $twilio_sid = "ACbdceb8c3ded8f464238cd6be5766c70a";//getenv("TWILIO_SID");
        $twilio_verify_sid = "VAda769523e66ca165a866f5f240da407e";//getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create($request['phone_number'], "sms");

            return redirect('verify_mobile')->with(['phone_number' => $data['phone_number']]);
    }

    protected function verify_otp(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);

            //$pin = $this->UserRepository->updateUser($uid, $UserDetails);
        /* Get credentials from .env */
        $token = "45e91947eed926fba68e4e3d87af7809";
        $twilio_sid = "ACbdceb8c3ded8f464238cd6be5766c70a";
        $twilio_verify_sid = "VAda769523e66ca165a866f5f240da407e";
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
                        ->verificationChecks
                        ->create([
                            "to" => $data['phone_number'],
                            "code" => $data['verification_code']
                            ]
                        );
        // return ($verification->status);
        if ($verification->valid) {
            $uid = Auth::user()->id;
            $UserDetails = [
                'updated_at' => NOW(),
                'number_verify_at' => NOW()
            ];
            $user = tap($this->UserRepository->updateUser($uid, $UserDetails));
            /* Authenticate user */
            if($user){return redirect()->route('home')->with(['message' => 'Phone number verified']);}
            else{return redirect()->route('home')->with(['message' => 'Verification process completed']);}
        }else{
            return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
        }

    }


    public function data_products(){
        // $data = array (
        //     'Products' => Http::withHeaders([
        //                 'Authorization' => 'Bearer'. $this->getToken(),
        //                 'Content-Type' => 'application/json'
        //                 ])->get('https://api.dingconnect.com/api/V1/GetProducts?benefits=data'),
        //     'count' => 0
        //     );
        // return view('app.user.data_products')->with($data);
        $token = 'Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IjNBRDlFQjE2OEE3MzhGMTRDQ0M4OEE4NjIyQjczQUE1MzZDOTM5Q0FSUzI1NiIsInR5cCI6ImF0K2p3dCIsIng1dCI6Ik90bnJGb3B6anhUTXlJcUdJcmM2cFRiSk9jbyJ9.eyJuYmYiOjE2NzYxNDIzNDQsImV4cCI6MTY3NjE0NDE0NCwiaXNzIjoiaHR0cHM6Ly9pZHAuZGluZy5jb20iLCJhdWQiOiJkaW5nY29ubmVjdGFwaSIsImNsaWVudF9pZCI6IjkxOWMzNjZjLTQ2NDUtNDZmOC04MGNjLTM1Yzc3MDQwMDE0YiIsImp0aSI6IjIxNThBRkE1OENFODIwNEVBRkUyRTdGQzU3NEYyNUMzIiwiaWF0IjoxNjc2MTQyMzQ0LCJzY29wZSI6WyJ0b3B1cGFwaSJdfQ.Gf8dc2aFqa8Dhp5j5teFVK7yyUP9fWU4pNrGTOxU6Xvp4UepwZwRRgZS9RKr24xGts89TpyMr-02B-kHBTwbjrbu5EgulmCKscw0rHMs3950E3h5pILfzldNMEge5N1UOCBKJlDGGCzg5K4qJGbcFoDYWnjxHV36RArpwvjNDcV8FbnwlgdXPM5RST-8AxWWALcZaUyxtKW8FC_D1AL6LhQU-QybVJtT7PLc7NEKc2YupuMhTYjp2fR8j3o5YxNYZTMIF4SZAv7zly127bA5i0BZ5vfdHesmEPBxYGZBGn2j290-uDRADSUnCbF3xPUzABiiS-xJZEGDqACJDv3QEGmAaYeMVs-m4N9U1Jy4JARE0KwvtJLQ1NfqG7kgaO3NQlLmZFrNpnmrW1cZVzQN8vL3t37ZgFd5S458T3sMi5R__sMjuox7c_g-W75OfziXWW100vdrGIUBh7mQMFSijIM_rKD0u50og5YeFdHUdcSkQyACE0lad0gKTlQ2tFuMVX8wX63GFBKVkYy-MD4sBTB9tKSVF8S8XXJornZq0lZi3fLuEEujdVAL37VBTRnpRB2uimQwnoXO-0mznXaq5iGUpiuH2vJYyRFCN-Lojd26rJGhK1mNUOPvepNm9a-46gjgTDjzepU_AS3XCFWMXug2NGkXFcgDnqmSkT5G9Kk';
        $nm = 2347035743427;
        $data = array(
            'Products' => Http::withHeaders([
                'Authorization' => 'Bearer '. $this->getToken(),
                'Content-Type' => 'application/json'
            ])->get('https://api.dingconnect.com/api/V1/GetProducts?benefits=data'),
            'count' => 0
            );

        return view('app.user.data_products')->with($data);
    }

    public function airtime_products(){
        $nm = 2347035743427;
        $data = array(
            'Products' => Http::withHeaders([
                'Authorization' => 'Bearer '. $this->getToken(),
                'Content-Type' => 'application/json'
            ])->get('https://api.dingconnect.com/api/V1/GetProducts?benefits=mobile'),
            'count' => 0
            );

        return view('app.user.airtime_products')->with($data);
    }
    public function create_pin(Request $request)
    {
        $request->validate([
            'pin' => ['required', 'string', 'max:4', 'confirmed'],
        ]);

        $sql = User::where('id', '=', Auth::user()->id)->first();

        if($sql->create_pin != "")
        {
            $uid = Auth::user()->id;
            $UserDetails = [
                'create_pin' => Hash::make($request['pin']),
                'updated_at' => NOW()
            ];
            $pin = $this->UserRepository->updateUser($uid, $UserDetails);
            // User::where('id', Auth::user()->id)
            //             ->update([
            //                 'create_pin' => Hash::make($request['pin']),
            //             ]);
            return back()->with('success', 'PIN successfully updated');
        }else{
            $uid = Auth::user()->id;
            $UserDetails = [
                'create_pin' => Hash::make($request['pin']),
                'updated_at' => NOW()
            ];
            $pin = $this->UserRepository->updateUser($uid, $UserDetails);

            if($pin){
                return back()->with('success', 'PIN successfully created');
            }else{
                return back()->with('fail', 'Error occured, try later');
            }
        }

    }



}
