<?php

ini_set('max_execution_time', -1);

// 19391 x 37199 = 721325809
// 999331 x 199933 = 199799244823
// 253969 x 623717 = 158404782773
// 624469 x 894391 = 558519453379
// 123123541 x 7123321841 = 877048608746558981
$target = gmp_init('158404782773');
//$target = gmp_init('1522605027922533360535618378132637429718068114961380688657908494580122963258952897654000350692006139');

$sqrt = gmp_sqrt($target);
$rand_min = gmp_div($sqrt, 10);
$rand_max = gmp_mul($sqrt, 10);

//assert(gmp_cmp($rand_min, 123123541) < 0);
//assert(gmp_cmp($rand_max, 7123321841) > 0);

echo "Searching for $target..." . PHP_EOL;

global $attempts;
global $chunks;
global $tick;

$tick = time();
$attempts = 0;
$chunks = 0;
$start_time = microtime(TRUE);

while (!fact($target, $rand_min, $rand_max)) {
  $chunks++;
}

$end_time = microtime(TRUE);

echo PHP_EOL;
echo "..." . PHP_EOL;
echo "Elapsed Time: " . number_format($end_time - $start_time, 1) . 's' . PHP_EOL;

function fact(GMP $target, GMP $rand_min, GMP $rand_max) {
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
      echo "Attempts " . number_format($attempts, 0) . " | Chunks: " . number_format($chunks, 0) . "\r";
    }
    $running = TRUE;
    switch (gmp_cmp($x, $target)) {
      case 0:
        echo "Found it! $a x $b = $x";
        return TRUE;
      case -1:
        $a = gmp_nextprime($a);
        break;
      case 1:
        $running = FALSE;
        break;
    }
  } while ($running);
}
