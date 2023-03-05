# PHP Semiprime Factorization

> A semiprime is a natural number that is the product of exactly two prime numbers.

[What is a semiprime?](https://en.wikipedia.org/wiki/Semiprime)

### Overview

This script is designed to find the prime factors of a semiprime.  
It is simple in nature is for educational purposes mostly.

### Dependencies

Requires the [PHP GMP extension](https://www.php.net/manual/en/book.gmp.php) for large numbers.

### Usage

```bash
php factor.php 721325809
```

```
Searching for 721325809...
Attempts: 2,853
Solution: 37199 x 19391 = 721325809
Duration: 0.3s
```

### Performance

Performance is a bit random in nature, but will largely depend on your CPU. You can run multiple scripts in parallel to try and find a solution.

Est. time to factor:

* 721325809: ~1 sec
* 158404782773: < 1 min
* 199799244823: < 1 min
* 558519453379: < 2 min
* 877048608746558981: < 10 min
* 1522605027922533360535618378132637429718068114961380688657908494580122963258952897654000350692006139: ~100 trillion years
