public function verifyWebhookPaystack(Request $request)
    {
        $body = $request->all();
        logger(['Data Receieved' => $body]);    
        $response = json_encode($body);
        $data = json_decode($response);
        if ($data->event == "charge.success") {

            if ($data->data->status = "success") {

                $deposit = Deposit::where('txn_ref', $data->data->reference)->first();

                if ($deposit == null) {

                    $user = User::where('email', $data->data->customer->email)->first();

                    if ($user) {
                        //Deposit Payment amount to Deposit
                        $DepositDetails['user_id'] = $user->id;
                        $DepositDetails['txn_ref'] = $data->data->reference;
                        $DepositDetails['amount'] = $data->data->amount / 100 - 50;
                        $DepositDetails['fee'] = 0;
                        $DepositDetails['hash'] = mt_rand(100000, 999999);
                        $DepositDetails['type'] = "P";
                        $DepositDetails['narration'] = "Payment From Paystack";
                        $this->depositService->CreateDeposit($DepositDetails);
                        $walletBal = $this->walletService->getUserBal($user->id);
                        $newWalletDetails['balance'] = $data->data->amount / 100 - 50 + $walletBal->balance;
                        $this->walletService->updateWallet($user->id, $newWalletDetails);

                        // logger(['user_id' => $user->id]);

                        http_response_code(200);
                    }
                }
            } else {
                http_response_code(200);
            }
        }
        http_response_code(200);
    }