<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Login request",
 *      description="Login request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class LoginRequestModel
{
    /**
     * @OA\Property(
     *      title="email",
     *      description="email of the user",
     *      example="super.admin@yopmail.com"
     * )
     */
    public string $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="password of the user",
     *      example="Password@123"
     * )
     */
    public string $password;
}
