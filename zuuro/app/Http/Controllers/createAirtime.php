//: JsonResponse
{
    $uid = Auth::user()->id;
    $repayment = date('Y-m-d');
    // dd($request->all());
    // GLNG | MTNG | ZANG | ETNG
    $network = "";
    if($request->network_operator == 'MTNG'){ $network = 1;}
    elseif($request->network_operator == 'ZANG'){ $network = 2;}
    elseif($request->network_operator == 'GLNG'){ $network = 3;}
    elseif($request->network_operator == 'ETNG'){ $network = 4;}
    else{ $network = $request->network_operator; }

    foreach($request->data_plan as $value){
        $data_arr = explode(',', $value);
        $data_plan = $data_arr[1];
        $skuCode = $data_arr[0];
    }
    
    // dd($data_plan);
            // Tri Validation Mode !!!!
            if($request->top_up == 1){
                $request->validate([
                    'top_up'            =>  'required',
                    'country'           =>  'required',
                    'phoneNumber'       =>  'required',
                    'network_operator'  =>  'required',
                    'data_plan'         =>  'required'
                ]);
                // Processing Nigeria Data
                if($request->country == 'NG'){
                    $phoneNumber = str_replace('234', '0', $request->phoneNumber);
                    // dd($data_plan);
                    $DataDetails = [
                        'network'       => $network, //1
                        'amount'        => 100,//$data_plan,//6,
                        'mobile_number' => $phoneNumber, //"09037346247",
                        'Ported_number' => true,
                        'airtime_type'  => 'VTU'
                    ];
                    // Store returned data in DB
                    return $this->AirtimeRepository->createNgAirtime($DataDetails);

                }else{
                    $DataDetails = [
                        'SkuCode'           => $skuCode,
                        'SendValue'         => $data_plan,
                        'SendCurrencyIso'   => 'USD',
                        'AccountNumber'     => $request->phoneNumber, 
                        'DistributorRef'    => $request->DistributorRef,
                        'ValidateOnly'      => false,
                        'RegionCode'        => $network
                    ];
                    $response = $this->AirtimeRepository->createIntAirtime($DataDetails);
                    // return $response;
                    if($response['ResultCode'] ==1){
                        $HistoryDetails = [
                            'user_id'               =>  $uid,
                            'plan'                  =>  $data_plan,
                            'purchase'              =>  'Airtime',
                            'country_code'          =>  $request->country,
                            'operator_code'         =>  $network,
                            'product_code'          =>  $skuCode,
                            'transfer_ref'          =>  $response['TransferRecord']['TransferId']['TransferRef'],
                            'phone_number'          =>  $request->phoneNumber,
                            'distribe_ref'          =>  $response['TransferRecord']['TransferId']['DistributorRef'],
                            'selling_price'         =>  '',
                            'receive_value'         =>  $response['TransferRecord']['Price']['ReceiveValue'],
                            'send_value'            =>  $response['TransferRecord']['Price']['SendValue'],
                            'receive_currency'      =>  $response['TransferRecord']['Price']['SendCurrencyIso'],
                            'commission_applied'    =>  $response['TransferRecord']['CommissionApplied'],
                            'startedUtc'            =>  $response['TransferRecord']['StartedUtc'],
                            'completedUtc'          =>  $response['TransferRecord']['CompletedUtc'],
                            'processing_state'      =>  $response['TransferRecord']['ProcessingState'],
                        ];
                        $query = $this->HistoryRepository->createHistory($HistoryDetails);
                        if($query){
                            return back()->with('success', 'Succeeded !');
                        }else{
                            return back()->with('fail', 'Transaction Failed !!!');
                        }
                        
                    }
                }


            }elseif($request->top_up ==2){
                $request->validate([
                    'top_up'    =>  'required',
                    'country'   =>  'required',
                    'phoneNumber'=> 'required',
                    'network_operator'=>    'required',
                    'data_plan'  =>    'required',
                    'loan_term'  =>     'required'
                ]);

                // Processing Loan Nigeria Data
                if($request->country == 'NG'){
                    $phoneNumber = str_replace('234', '0', $request->phoneNumber);
                    // dd($data_plan);
                    $DataDetails = [
                        'network'       => $network, //1
                        'amount'        => 100,//$data_plan,//6,
                        'mobile_number' => $phoneNumber, //"09037346247",
                        'Ported_number' => true,
                        'airtime_type'  => 'VTU'
                    ];
                    // Store returned data in DB
                    return $this->AirtimeRepository->createNgAirtime($DataDetails);

                }else{
                    $DataDetails = [
                        'SkuCode'           => $skuCode,
                        'SendValue'         => $data_plan,
                        'SendCurrencyIso'   => 'USD',
                        'AccountNumber'     => $request->phoneNumber, 
                        'DistributorRef'    => $request->DistributorRef,
                        'ValidateOnly'      => false,
                        'RegionCode'        => $network
                    ];
                    $response = $this->AirtimeRepository->createIntAirtime($DataDetails);
                    // return $response;
                    if($response['ResultCode'] ==1){
                        $HistoryDetails = [
                            'user_id'               =>  $uid,
                            'plan'                  =>  $data_plan,
                            'purchase'              =>  'Airtime',
                            'country_code'          =>  $request->country,
                            'operator_code'         =>  $network,
                            'product_code'          =>  $skuCode,
                            'transfer_ref'          =>  $response['TransferRecord']['TransferId']['TransferRef'],
                            'phone_number'          =>  $request->phoneNumber,
                            'distribe_ref'          =>  $response['TransferRecord']['TransferId']['DistributorRef'],
                            'selling_price'         =>  '',
                            'receive_value'         =>  $response['TransferRecord']['Price']['ReceiveValue'],
                            'send_value'            =>  $response['TransferRecord']['Price']['SendValue'],
                            'receive_currency'      =>  $response['TransferRecord']['Price']['SendCurrencyIso'],
                            'commission_applied'    =>  $response['TransferRecord']['CommissionApplied'],
                            'startedUtc'            =>  $response['TransferRecord']['StartedUtc'],
                            'completedUtc'          =>  $response['TransferRecord']['CompletedUtc'],
                            'processing_state'      =>  $response['TransferRecord']['ProcessingState'],
                            'repayment'             =>  $repayment,
                            'payment_status'        =>  'pending',
                            'due_date'              =>  $request->loan_term
                        ];
                        $query = $this->LoanHistoryRepository->createLoanHistory($HistoryDetails);
                        if($query){
                            return back()->with('success', 'Succeeded !');
                        }else{
                            return back()->with('fail', 'Transaction Failed !!!');
                        }
                        
                    }
                }
            }else{
                return "Invalid Selection";
            }



}