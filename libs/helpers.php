<?php

/**
 * Sanitize input data.
 *
 * @param string $value The input value to sanitize.
 * @return string The sanitized value.
 */
function sanitize($value)
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate required fields.
 *
 * @param string $value The input value.
 * @return bool True if the field is not empty, false otherwise.
 */
function validateRequired($value)
{
    return !empty(trim($value));
}

/**
 * Validate email format.
 *
 * @param string $email The email address to validate.
 * @return bool True if the email is valid, false otherwise.
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
