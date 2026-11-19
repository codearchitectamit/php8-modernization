<?php
declare(strict_types=1);

/**
 * Switch Statement Inentional Fall-throgh in php and its use cases 
 *
 * @category   php8-modernization
 * @package    Code Architect Amit
 * @author     Amit Joshi <codearchitectamit@gmail.com>
 * @license    https://opensource.org MIT License
 * @version    1.0.0
 * @since      2026-11-19 IST
 */

/**
 * Intentional fall-through in PHP 8: switch vs match
 *
 * match  -> evaluates exactly ONE arm, strict (===) comparison, returns a value, no fall-through.
 * switch -> loose (==) comparison, falls into the next case unless you break/return.
 *
 */

/* ---------------------------------------------------------------
 * 1. GROUPING conditions that share the same logic 
 * 2. And still gives you power to add multiple statement and condition if particular case need one
 * --------------------------------------------------------------- */
function dayType(string $day): string
{
    $day = readline("switch statement: Please Enter the Day : ");
    switch (strtolower($day)) {
        case 'sat':
        case 'sun':
            return 'Weekend';
        case 'mon':
        case 'tue':
        case 'wed':
        case 'thu':
        case 'fri':
            return "$day Weekday";
        default:
            throw new InvalidArgumentException("Unknown day: $day");
    }
}

// match equivalent for grouping (comma-separated conditions, no fall-through needed)
function dayTypeMatch(string $day): string
{
    $day = readline("match expression: Please Enter the Day  : ");
    return match (strtolower($day)) {
        'sat', 'sun'                    => 'Weekend',
        'mon', 'tue', 'wed', 'thu', 'fri' => 'Weekday',
        default => throw new InvalidArgumentException("Unknown day: $day"),
    };
}

/* ---------------------------------------------------------------
 * 2. SEQUENTIAL logic: higher tiers inherit lower-tier features
 * --------------------------------------------------------------- */
function featuresForPlan(string $plan): array
{
    $features = [];
    $plan = readline("Please choose your plan (enterprise, pro, basic) : ");
    switch ($plan) {
        case 'enterprise':
            $features[] = 'SSO';
            $features[] = 'Audit logs';
            // fall through
        case 'pro':
            $features[] = 'API access';
            $features[] = 'Priority support';
            // fall through
        case 'basic':
            $features[] = 'Dashboard';
            break;
        default:
            throw new InvalidArgumentException("Unknown plan: $plan");
    }

    return $features;
}

/* ---------------------------------------------------------------
 * 3. MATHEMATICAL logic: cumulative calculations
 * --------------------------------------------------------------- */

// 3a. Total XP earned up to a level (each level adds on top of the lower ones)
function totalXp(int $level): int
{
    $xp = 0;
    $level = readline("Tell your level for earned points : ");
    switch ($level) {
        case 5: $xp += 500; // fall through
        case 4: $xp += 400; // fall through
        case 3: $xp += 300; // fall through
        case 2: $xp += 200; // fall through
        case 1: $xp += 100; break;
        case 0: break;
        default: throw new InvalidArgumentException('Level must be 0-5');
    }

    return $xp;
}

// 3b. Day of the year: add the lengths of all completed months
function dayOfYear(int $year, int $month, int $day): int
{
    $isLeap = ($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0;
    $total  = $day;

    switch ($month - 1) {          // number of fully completed months
        case 11: $total += 30; // Nov, fall through
        case 10: $total += 31; // Oct
        case 9:  $total += 30; // Sep
        case 8:  $total += 31; // Aug
        case 7:  $total += 31; // Jul
        case 6:  $total += 30; // Jun
        case 5:  $total += 31; // May
        case 4:  $total += 30; // Apr
        case 3:  $total += 31; // Mar
        case 2:  $total += $isLeap ? 29 : 28; // Feb
        case 1:  $total += 31; // Jan
        case 0:  break;
        default: throw new InvalidArgumentException('Month must be 1-12');
    }

    return $total;
}

// 3c. Stacked discounts: higher tier gets its own discount AND the lower ones
function finalPrice(float $price, string $tier): float
{
    $price = readline("Enter Price (INR): ");
    $day = readline("Enter your tier (platinum,gold,silver,none) : ");
    switch ($tier) {
        case 'platinum':
            $price *= 0.90; // extra 10% off
            // fall through
        case 'gold':
            $price *= 0.95; // 5% off
            // fall through
        case 'silver':
            $price *= 0.98; // 2% off
            break;
        case 'none':
            break;
        default:
            throw new InvalidArgumentException("Unknown tier: $tier");
    }

    return round($price, 2);
}

/* ---------------------------------------------------------------
 * 4. Range logic: match(true) vs switch(true)
 * --------------------------------------------------------------- */
function grade(int $score): string
{
    $score = readline("Enter your score : ");
    return match (true) {
        $score >= 90 => 'A',
        $score >= 80 => 'B',
        $score >= 70 => 'C',
        default      => 'F',
    };
}

/* ---------------------------------------------------------------
 * 5. Fall-through used for permissions (bit of everything)
 * --------------------------------------------------------------- */
function permissions(string $role): array
{
    $perms = [];
    $role = readline("Your role (admin,editor,viewer) : ");
    switch ($role) {
        case 'admin':
            $perms[] = 'delete';
            $perms[] = 'manage_users';
            // fall through
        case 'editor':
            $perms[] = 'write';
            // fall through
        case 'viewer':
            $perms[] = 'read';
            break;
        default:
            // unknown role -> no permissions
    }

    return $perms;
}

/* ---------------------------------------------------------------
 * 6. Why match can NOT do it: only one arm runs
 * --------------------------------------------------------------- */
function matchOnlyOne(int $level): int
{
    return match ($level) {
        3 => 300,   // returns 300 only; does NOT add 200 + 100
        2 => 200,
        1 => 100,
        default => 0,
    };
}

/* ---------------------------------------------------------------
 * Demo
 * --------------------------------------------------------------- */
echo dayType('Sat'), PHP_EOL;                                  // Weekend
echo dayTypeMatch('Mon'), PHP_EOL;                             // Weekday
echo implode(', ', featuresForPlan('pro')), PHP_EOL;           // API access, Priority support, Dashboard
echo totalXp(3), PHP_EOL;                                      // 600 (300+200+100)
echo dayOfYear(2024, 3, 15), PHP_EOL;                          // 75 (leap year)
echo dayOfYear(2024, 3, 1), PHP_EOL;                          // 75 (leap year)
echo finalPrice(100.0, 'platinum'), PHP_EOL;                   // 83.79 (100*0.9*0.95*0.98)
echo grade(85), PHP_EOL;                                       // B
echo implode(', ', permissions('admin')), PHP_EOL;             // delete, manage_users, write, read
echo matchOnlyOne(3), PHP_EOL;                                 // 300 (not 600)
