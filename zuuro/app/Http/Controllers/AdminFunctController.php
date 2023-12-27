<?php

namespace App\Http\Controllers;

use App\Repositories\FaqRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SupportRepository;
use App\Repositories\TermConditionsRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Country;
use Alert;
use App\Models\User;
use App\Models\MaxLimit;
use App\Models\LoanLimit;
use Illuminate\Support\Facades\Hash;
use App\Models\Operator;
use App\Models\OtherProduct;
use App\Models\Product;
use App\Models\ProductCategory;

class AdminFunctController extends Controller
{
    private $TermConditionsRepository;
    private $ProductRepository;
    private $SupportRepository;
    private $FaqRepository;

    public function __construct(
                ProductRepository $ProductRepository,
                SupportRepository $SupportRepository,
                TermConditionsRepository $TermConditionsRepository,
                FaqRepository $FaqRepository)
    {
        $this->middleware(['AlreadyLoggedAdmin']);
        $this->TermConditionsRepository = $TermConditionsRepository;
        $this->ProductRepository = $ProductRepository;
        $this->SupportRepository = $SupportRepository;
        $this->FaqRepository = $FaqRepository;
    }

        //GET FUNCTIONS ========================================================>>>>>>>>>>>>>>>>>>>>>>
    public function isLoan($id) : JsonResponse {
        $isLoan = Country::where('country_code', $id)->first();
        if($isLoan->is_loan==1)
        {
            Country::where('country_code', $id)->update(['is_loan'=>0]);
            return response()->json([
                'message' => 'Operation Succeeded'
            ]);
            // Alert::success('Success', 'Operation succeeded');
            // return back();
        }
        else
        {
            Country::where('country_code', $id)->update(['is_loan'=>1]);
            return response()->json([
                'message' => 'Operation Succeeded'
            ]);
        }
    }
    
    public function activateRepay($id) : JsonResponse {
        $isLoan = LoanLimit::whereId($id)->first();
        if($isLoan->status==1)
        {
            LoanLimit::whereId($id)->update(['status'=>0]);
            return response()->json([
                'message' => 'Operation Succeeded'
            ]);
            // Alert::success('Success', 'Operation succeeded');
            // return back();
        }
        else
        {
            LoanLimit::where('id', $id)->update(['status'=>1]);
            return response()->json([
                'message' => 'Operation Succeeded'
            ]);
        }
    }
    
    public function isLoanlimit($id) : JsonResponse {
        $isLoan = LoanLimit::whereId($id)->first();
        if($isLoan->status==true)
        {
            LoanLimit::whereId($id)->update(['status'=>0]);
            return response()->json([
                'message' => 'Operation Succeeded'
            ]);
        }
        else
        {
            LoanLimit::whereId($id)->update(['status'=>1]);
            return response()->json([
                'message' => 'Operation Succeeded'
            ]);
        }
    }


    public function toggle_countryStatus($id) {
        $isLoan = Country::whereId($id)->first();
        if($isLoan->status==1)
        {
            Country::whereId($id)->update(['status'=>0]);
            Alert::success('Success', 'Operation succeeded');
            return back();
        }
        else
        {
            Country::whereId($id)->update(['status'=>1]);
            Alert::success('Success', 'Operation succeeded');
            return back();
        }
    }

    public function delete_country($id) {
        $delete = Country::whereId($id)->delete();
        Alert::success('Success', 'Operation succeeded');
        return back();
    }

    // ----------------------------------NETWORK OPERATORS ----------------------------------

    public function toggle_NetworkStatus($id) {
        $isLoan = Operator::where('operator_code', $id)->first();
        if($isLoan->status==1)
        {
            Operator::whereId($id)->update(['status'=>0]);
            Alert::success('Success', 'Operation succeeded');
            return back();
        }
        else
        {
            Operator::where('operator_code', $id)->update(['status'=>1]);
            Alert::success('Success', 'Operation succeeded');
            return back();
        }
    }
    public function make_admin_page($id)
    {
        # code...
        $disable_admin = User::whereId($id)->update([ 'role'=>1 ]);
        if($disable_admin)
        {
            Alert::success("Success!", "User Has Been Assigned A Role Of Admin ...");
            return back();
        }
    }
    public function delete_network($id) {
        $delete = Operator::where('operator_code', $id)->delete();
        Alert::success('Success', 'Operation succeeded');
        return back();
    }
    
    
    
    // ------------------------------------ DELETE PRODUCT CATEGORY --------------------------------------------
    public function delete_productCat($id) {
        ProductCategory::where('category_code', $id)->delete();
        Alert::success('Success', 'Operation succeeded');
        return back();
    }
    // ------------------------------------ DELETE PRODUCT  --------------------------------------------
    public function delete_product($id) {
        Product::where('product_code', $id)->delete();
        Alert::success('Success', 'Operation succeeded');
        return back();
    }
    public function delete_faq($id)
    {
        $this->FaqRepository->deleteFaq($id);
        Alert::success('Success', 'FAQ Deleted !!!');
        return back();
    }
    public function deleteSsupportPage($id)
    {
        $delSupp = $this->SupportRepository->deleteSupportRecord($id);

        Alert::success('Success', 'Selected Support Info Deleted !!!');
        return back();
    }
    public function delete_terms($id)
    {
        $delSupp = $this->TermConditionsRepository->deleteTermCondition($id);

        Alert::success('Success', 'Selected Support Info Deleted !!!');
        return back();
    }





    // POST FUNCTIONS ======================================================>>>>>>>>>>>>>>>>>>>>

    public function manage_networks(Request $request) {
        // dd($request->all());
        $request->validate([
            'operatorCode'   => ['required', 'string'],
            'productCat'    => ['required', 'string'],
        ]);


        $operatorCode = $request->operatorCode;
        $categoryCode = $operatorCode.'_'.$request->productCat;
        $categoryName = $request->productCat;

        $sql = ProductCategory::where('category_code', $categoryCode)->first();
        if( $sql != null)
        {
            ProductCategory::where('category_code', $categoryCode)->update([ 'operator_code'=>$operatorCode, 'category_code'=>$categoryCode, 'category_name'=>$categoryName ]);
            Alert::success('Success', 'Operation succeeded');
            return back();
        }
        else
        {
            ProductCategory::create([ 'operator_code'=>$operatorCode, 'category_code'=>$categoryCode, 'category_name'=>$categoryName ]);
            Alert::success('Success', 'Operation succeeded');
            return back();
        }
    }

    public function add_product(Request $request) {
        
        
        $request->validate([
            'countryName' => ['required', 'string'],
            'operator'    => ['required', 'string'],
            'productCat'  => ['required', 'string'],
            'product'     => ['required', 'string'],
            'productCode' => ['required', 'string'],
            'price'       => ['required', 'string'],
            'loanprice'   => ['required', 'string'],
            'validity'    => ['required', 'string'],
        ]);
        
        
        

        $countryName    = $request->countryName;
        $operator       = $request->operator;
        $productCat     = $request->productCat;
        $product        = $request->product;
        $productCode    = $request->productCode;
        $price          = $request->price;
        $loanprice      = $request->loanprice;
        $validity       = $request->validity;

        $sql = Product::where('product_code', $productCode)->first();
        
        // dd($sql);
        
        if( $sql == null)
        {
            
            Product::create([
                'category_code'     => $productCat,
                'country_code'      => $countryName,
                'operator_code'     => $operator,
                'product_code'      => $productCode,
                'product_name'      => $product,
                'product_price'     => $price,
                'loan_price'        => $loanprice,
                'send_value'        => $product,
                'send_currency'     => $product,
                'receive_value'     => $product,
                'receive_currency'  => 'NGN',
                'commission_rate'   => 0,
                'uat_number'        => '2.34E+12',
                'validity'          => $validity,
                'status'            => 1
            ]);
            
            if($prd){
                        
                return response()->json([
                    'success'       => true,
                    'statusCode'    => 200,
                    'message'       => 'Operation succeeded'
                ]);
                            
            }else{
                
                return response()->json([
                    'success'       => false,
                    'statusCode'    => 500,
                    'message'       => 'An Error Occured While Processing Your Request  !!!'
                ]);
                
            }

            
        }
        else
        {
            
            $prd = Product::where('product_code', $productCode)
                    ->update([
                        'category_code'     => $productCat,
                        'country_code'      => $countryName,
                        'operator_code'     => $operator,
                        'product_code'      => $productCode,
                        'product_name'      => $product,
                        'product_price'     => $price,
                        'loan_price'        => $loanprice
                    ]);
                    if($prd){
                        
                        return response()->json([
                            'success'       => true,
                            'statusCode'    => 200,
                            'message'       => 'Operation succeeded'
                        ]);
                                    
                    }else{
                        
                        return response()->json([
                            'success'       => false,
                            'statusCode'    => 500,
                            'message'       => 'An Error Occured While Processing Your Request  !!!'
                        ]);
                        
                    }
                    
        }
    }

    public function change_user_password(Request $request)
    {
        # code...
        // dd( $request->all() );
        $request->validate([
            'user_id'   => ['required', 'numeric'],
            'password'  => ['required', 'string', 'max:200']
        ]);
   
        $id = $request->user_id;
        $password = Hash::make($request->password);
        $make_admin = User::whereId($id)->update([ 'password'=>$password]);
        if($make_admin)
        {
            Alert::success("Success!", "User Password Successfully Changed To :".$request->password);
            return back();
        }
    }

    public function add_country(Request $request) {
        $request->validate([
            'countryName' => ['required', 'string'],
            'shortcode' => ['required', 'string'],
            'phonecode'    => ['required', 'string'],
            'capital'  => ['required', 'string'],
            'currency'     => ['required', 'string'],
            'currency_name' => ['required', 'string'],
        ]);


        $countryName = $request->countryName;
        $shortcode = $request->shortcode;
        $phonecode = $request->phonecode;
        $capital = $request->capital;
        $currency = $request->currency;
        $currency_name = $request->currency_name;

        $sql = Country::where('country_code', $shortcode)->first();
        if( $sql != null)
        {
            Country::where('country_code', $productCode)
                            ->update([
                                'country_name'=>$countryName,
                                'country_code'=>$shortcode,
                                'is_loan'=>0,
                                'phone_code'=>$phonecode,
                            ]);
                            Alert::success('Success', 'Operation succeeded');
                            return back();
        }
        else
        {
            Country::create([
                'country_name'=>$countryName,
                'country_code'=>$shortcode,
                'is_loan'=>0,
                'phone_code'=>$phonecode,
            ]);
            Alert::success('Success', 'Operation succeeded');
            return back();
        }
    }

    public function add_faq(Request $request){
        $request->validate([
            'question'  => ['required', 'string'],
            'answer'    => ['required', 'string'],
        ]);
        $FaqDetails = [
            'question'  => $request->question,
            'answer'    => $request->answer
        ];
        $insFaq = $this->FaqRepository->createFaq($FaqDetails);
        if($insFaq)
        {
            Alert::success('Success', 'New Faq Added');
            return back();
        }
        else
        {
            Alert::error('Oops!', 'An Error Occured Whil Processing Your Request');
            return back();
        }
    }

    public function supportPage(Request $request)
    {
        $request->validate([
            'page'          => ['required', 'string', 'max:255'],
            'page_name'    => ['required', 'string', 'max:255'],
            'page_link'    => ['required', 'string', 'max:255'],
            'page_icon'    => ['required', 'string', 'max:255'],
        ]);
        $SupportDetails = [
            'page_type'    => $request->page,
            'page_name'    => $request->page_name,
            'page_link'    => $request->page_link,
            'page_icon'    => $request->page_icon,
        ];
        $insSupp = $this->SupportRepository->createSupport($SupportDetails);
        if($insSupp)
        {
            Alert::success('Success', 'New Support Added');
            return back();
        }
        else
        {
            Alert::error('Oops!', 'An Error Occured Whil Processing Your Request');
            return back();
        }
    }

    public function terms(Request $request)
    {
        $request->validate([
            'termOfUse'          => ['required', 'string'],
        ]);
        $SupportDetails = [
            'write_up'    => $request->termOfUse,
            'admin'    => session('LoggedAdmin'),
        ];
        $insSupp = $this->TermConditionsRepository->createTermCondition($SupportDetails);
        if($insSupp)
        {
            Alert::success('Success', 'New Support Added');
            return back();
        }
        else
        {
            Alert::error('Oops!', 'An Error Occured Whil Processing Your Request');
            return back();
        }
    }

    public function product_price_perc(Request $request)
    {
        # code...
        $request->validate([
            'product_price' => ['required', 'numeric'],
            'product_id'    => ['required', 'numeric', 'max:1'],
            'loan_perc'     => ['required', 'numeric'],
        ]);

        $sql = OtherProduct::where('name', 'airtime')->first();

        if($sql != null)
        {
            $id = $request->product_id;
            $update_price = OtherProduct::whereId($id)->update([ 'variation_amount'=>$request->product_price, 'loan_perc'=>$request->loan_perc  ]);

            if($update_price ){
                Alert::success('Success', 'Airtime Price Updated');
                return back();
            }else{
                Alert::error('Success', 'Unable To Add Price');
                return back();
            }
        }
        else{
            $update_price = OtherProduct::create([ 'variation_amount'=>$request->product_price, 'loan_perc'=>$request->loan_perc  ]);
            if($update_price ){
                Alert::success('Success', 'Airtime Price Updated');
                return back();
            }else{
                Alert::error('Success', 'Unable To Add Price');
                return back();
            }
        }

    }

    
    public function product_price_data(Request $request)
    {
        # code...
        // dd($request->all());
        $request->validate([
            'product_price' => ['required', 'numeric'],
            'product_id'    => ['required', 'numeric'],
        ]);

        $sql = OtherProduct::where('name', 'data')->first();

        if($sql != null)
        {
            $id = $request->product_id;
            $update_price = OtherProduct::whereId($id)->update([ 'variation_amount'=>$request->product_price]);

            if($update_price ){
                Alert::success('Success', 'Data Price Updated');
                return back();
            }else{
                Alert::error('Success', 'Unable To Add Price');
                return back();
            }
        }
        else{
            $update_price = OtherProduct::create([ 'variation_amount'=>$request->product_price]);
            if($update_price ){
                Alert::success('Success', 'Data Price Updated');
                return back();
            }else{
                Alert::error('Success', 'Unable To Add Price');
                return back();
            }
        }

    }
    
    public function add_loanLimit(Request $request){
        $request->validate([
            'labelName'     => ['required', 'string'],
            'Percentage'    => ['required', 'string']
        ]);

        $labelName = $request->labelName;
        $percentage = $request->Percentage;

        $Loanlimit = LoanLimit::where('labelName', $labelName)->first();

        if( $Loanlimit == null)
        {
            LoanLimit::create([ 'labelName'=> $labelName, 'percentage'=> $percentage, 'status'=>true ]);
            Alert::success("Success!", "Operation Completed !!!");
            return back();
        }
        else
        {
            LoanLimit::where( 'labelName', $labelName)->update([ 'labelName'=> $labelName, 'percentage'=> $percentage, 'status'=>true ]);
            Alert::success("Success!", "Operation Completed !!!");
            return back();
        }
    }

    
    public function set_productLimit(Request $request)
    {
        # code...
        // dd($request->all());
        $request->validate([
            'product_price' => ['required', 'numeric'],
            'product_id'    => ['required', 'numeric'],
        ]);
        $productId = $request->product_id;
        $productPrice = $request->product_price;
        $admin = session('LoggedAdmin');

        $sql = MaxLimit::whereId($productId)->first();

        if($sql != null)
        {
            $update_price = MaxLimit::whereId($productId)->update([ 'limit_value'=>$productPrice, 'admin'=>$admin ]);

            if($update_price ){
                Alert::success('Success!', 'Operation Successful');
                return back();
            }else{
                Alert::error('Error!', 'Unable To Process The Request');
                return back();
            }
        }
        else{
            $update_price = OtherProduct::create([ 'limit_value'=>$productPrice, 'admin'=>$admin ]);
            if($update_price ){
                Alert::success('Success!', 'Operation Successful');
                return back();
            }else{
                Alert::error('Error!', 'Unable To Process The Request');
                return back();
            }
        }

    }
    
    public function update(Request $request)
    // : JsonResponse
    {
        $ProductId = $request->product_code;
        $request->validate([
            'product_code'  => ['required', 'string', 'max:255'],
            'operator_code' => ['required', 'string', 'max:255'],
            'productCat'    => ['required', 'string', 'max:255'],
            'product_name'  => ['required', 'string', 'max:255'],
            'validity'      => ['required', 'string', 'max:255'],
            'loan_price'    => ['required', 'string', 'max:255'],
            'product_price' => ['required', 'string', 'max:255'],
            'status'        => ['required', 'numeric', 'max:2'],
        ]);

        $ProductDetails = [
            'product_name'      =>  $request->product_name,
            'loan_price'        =>  $request->loan_price,
            'product_price'     =>  $request->product_price,
            'validity'          =>  $request->validity,
            'status'            =>  $request->status,
        ];

        $data = $this->ProductRepository->updateProduct($ProductId, $ProductDetails);
        if($data)
        {

            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'message'       => 'Record Successfully Updated'
            ]);


        }
        else
        {
            
            return response()->json([
                'success'       => false,
                'statusCode'    => 500,
                'message'       => 'An Error Occured While Processing Your Request !!!'
            ]);            
      
        }

    }


    public function delete_loanLimit($id)
    {
        $delSupp = LoanLimit::destroy($id);
        Alert::success('Success', 'Selected Limit Info Deleted !!!');
        return back();
    }





}
