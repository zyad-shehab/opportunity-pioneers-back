<?php
namespace App\Traits;
trait ApiResponses {

    protected function success($message,$data=[],$statusCode){
        return response()->json([
            'message'=>$message,
            'status'=>$statusCode,
            'data'=>$data,
        ],$statusCode);
    }
    protected function error($message,$statusCode){
        return response()->json([
            'message'=> $message,
            'status'=>$statusCode
        ],$statusCode);

    }
}
