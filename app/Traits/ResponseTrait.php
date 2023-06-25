<?php
namespace App\Traits;

/**
 * Response Trait
 */
trait ResponseTrait
{
    private $successStatus = TRUE;
    private $failedStatus = FALSE;

    /**
     * Prepare Successful Response
     *
     * @param [type] $message
     * @param [type] $data
     * @return void
     */
    public function successResponse($message, $data = null)
    {
        return response()->json( [
            'status' => $this->successStatus,
            'messages' => $message,
            'data' => $data
        ], 200 );
    }

    /**
     * Prepare Failed Response
     *
     * @param [type] $message
     * @param [type] $errors
     * @param [type] $data
     * @return void
     */
    public function failedResponse($message, $code = 422, $e = null, $errors = null)
    {
        return response()->json( [
            'status' => $this->failedStatus,
            'messages' => $message,
            'exceptionMessage' =>  (app()->environment('local') && $e instanceof \Exception) ? $e->getMessage(): null, // Message only on local environment. Please check .env file
            'errors' => $errors
        ], $code );
    }
}
