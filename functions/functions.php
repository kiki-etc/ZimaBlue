<?php
/**
 * Hash a password using bcrypt.
 *
 * @param string $password The password to hash.
 * @return string The hashed password.
 */
function hashPassword($password) {
    // Options for bcrypt
    $options = [
        'cost' => 12, // You can adjust the cost value based on your server's performance
    ];

    // Hash the password using bcrypt
    return password_hash($password, PASSWORD_BCRYPT, $options);
}

/**
 * Verify a password against a hash.
 *
 * @param string $password The password to verify.
 * @param string $hash The hash to verify against.
 * @return bool True if the password matches the hash, false otherwise.
 */
function verifyPassword($password, $hash) {
    // Verify the password against the hash
    return password_verify($password, $hash);
}