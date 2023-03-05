<?php
/**
 * @copyright Copyright (C) 2023 Daniel J. Pepin
 * @license MIT
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the MIT License.
 *
 * Requires GMP extension.
 * https://www.php.net/manual/en/book.gmp.php
 *
 * Usage: php factor.php <number>
 *   Where <number> is a semiprime number you want to factor.
 *   A semiprime number is the product of two prime numbers.
 *
 * Example: php factor.php 721325809
 */
ini_set('max_execution_time', -1);

// Examples of semiprimes you can try to factor:

// 19391 x 37199 = 721325809
// 253969 x 623717 = 158404782773
// 999331 x 199933 = 199799244823
// 624469 x 894391 = 558519453379
// 123123541 x 7123321841 = 877048608746558981
// A x B = 1522605027922533360535618378132637429718068114961380688657908494580122963258952897654000350692006139

if (empty($argv[1])) {
  echo "Usage: php factor.php <number>" . PHP_EOL;
  exit;
}

// We'll keep track of how many attempts we make.
global $attempts;
$attempts = 0;

// Keep track of the current second, used for output.
global $tick;
$tick = time();

$target = gmp_init($argv[1]);

// Our algorithm is based on trying to guess two prime number to multiply.
// We need to set a range for our guesses.
// Our middle-ground is the square root of the target number.
$sqrt = gmp_sqrt($target);
$rand_min = gmp_div($sqrt, 10);
$rand_max = gmp_mul($sqrt, 10);

echo "Searching for $target..." . PHP_EOL;

$start_time = microtime(TRUE);

// Main program loop.
while (!fact($target, $rand_min, $rand_max)) {
  // We keep on loopin'
}

$end_time = microtime(TRUE);

echo PHP_EOL;
echo "Duration: " . number_format($end_time - $start_time, 1) . 's' . PHP_EOL;

/**
 * Pick new starting prime number to try factoring.
 *
 * @param \GMP $target
 * @param \GMP $rand_min
 * @param \GMP $rand_max
 *
 * @return bool
 */
function fact(GMP $target, GMP $rand_min, GMP $rand_max): bool {
  global $attempts;
  global $chunks;
  global $tick;

  // Get two random numbers we can multiply.
  $b = gmp_nextprime(gmp_random_range($rand_min, $rand_max));
  $a = gmp_nextprime(gmp_sub(gmp_div($target, $b), 25));

  do {
    $attempts++;
    $x = gmp_mul($a, $b);

    if (time() !== $tick) {
      $tick = time();
      echo "Attempts: " . number_format($attempts, 0) . "\r";
    }

    switch (gmp_cmp($x, $target)) {
      case 0:
        echo PHP_EOL . "Solution: $a x $b = $x";
        return TRUE;
      case -1:
        // Increment $a to the next prime for testing.
        $a = gmp_nextprime($a);
        break;
      case 1:
        // Break out of the loop and we'll fact() again.
        break 2;
    }
  } while (TRUE);

  return FALSE;
}
