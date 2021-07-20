<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store User request",
 *      description="Store User request data",
 *      type="object",
 *      required={"name"}
 * )
 */
class StoreUserRequestModel
{
    /**
     * @OA\Property(
     *      title="first name",
     *      description="first name of the new user",
     *      example="First"
     * )
     */
    public string $first_name;
    /**
     * @OA\Property(
     *      title="last name",
     *      description="last name of the new user",
     *      example="Last"
     * )
     */
    public string $last_name;
    /**
     * @OA\Property(
     *      title="middle name",
     *      description="middle name of the new user",
     *      example="Middle"
     * )
     */
    public string $middle_name;
    /**
     * @OA\Property(
     *      title="Birth date",
     *      description="Birth date of the new user",
     *      example="12/16/2004"
     * )
     */
    public string $birth_date;
    /**
     * @OA\Property(
     *      title="Contact Number",
     *      description="Contact Number of the new user",
     *      example="+639162330655"
     * )
     */
    public string $contact_number;
    /**
     * @OA\Property(
     *      title="Full Address",
     *      description="Full Address of the new user",
     *      example="Barangay Labas, City of Santa Rosa Laguna, Philippines 4026"
     * )
     */
    public string $full_address;
    /**
     * @OA\Property(
     *      title="Avatar Path",
     *      description="Avatar Path of the new user",
     *      example="data:image/jpeg;base64,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"
     * )
     */
    public string $avatar_path;
    /**
     * @OA\Property(
     *      title="Email Address",
     *      description="Email Address of the new user",
     *      example="test.user@yopmail.com"
     * )
     */
    public string $email;
    /**
     * @OA\Property(
     *      title="Account Type",
     *      description="Account Type of the new user",
     *      example="Admin or ContentWriter"
     * )
     */
    public string $account_type;
}
