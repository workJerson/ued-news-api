<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update request",
 *      description="Update request data",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateUserRequestModel extends StoreUserRequestModel
{
    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password of the new user",
     *      example="Password@123"
     * )
     */
    public string $password;
    /**
     * @OA\Property(
     *      title="Status",
     *      description="Status of the new user",
     *      example="1 or 0"
     * )
     */
    public string $status;
}
