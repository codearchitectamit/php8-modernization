<?php
declare(strict_types=1);

/**
 * Handling Errors & Exceptions
 *
 * @category   php8-modernization
 * @package    Code Architect Amit
 * @author     Amit Joshi <codearchitectamit@gmail.com>
 * @license    https://opensource.org MIT License
 * @version    1.0.0
 * @since      2026-11-20 IST
 */

/**
 * Handling UnhandledMatchEror for Match expression
 */

try {
    echo match (5) { 1 => "one", 2 => "two" };
} catch (\UnhandledMatchError $e) {
    echo "Exceptions Triggered: UnhandledMatchError \n";
    echo "\nException message: ". $e->getmessage();
    echo "No match found";
}

// Tricky Question: Guess what will be output of $e->getCode();