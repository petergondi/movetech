<?php
      $url="https://sms.movesms.co.ke/api/portalcompose?";
            $username ="ellywanjiku";
            $apikey = "EoyO2JzvVQrx7amX6snCyfw8C3lZr1XjkvqS0cB3H1LZBWTbBb";
            $senderid = "SMARTLINK";
            $message="hi how are you?";
            $phonenumber=725272888;

            $postData = array(
                'username' => $username,
                'api_key' => $apikey,
                'sender' => $senderid,
                'to' => $phonenumber,
                'message' => $message,
                'msgtype' => 5,
                'dlr' => 0,
            );


            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData

            ));

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $output = curl_exec($ch);

            if (curl_errno($ch)) {
                // echo 'error:' . curl_error($ch);
                $output = curl_error($ch);
            }

            curl_close($ch);