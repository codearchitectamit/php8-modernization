<?php
declare(strict_types=1);

/**
 * Switch is a STETEMENT and Match is an EXPRESSION
 *
 * @category   php8-modernization
 * @package    Code Architect Amit
 * @author     Amit Joshi <https://github.com/codearchitectamit>
 * @license    https://opensource.org MIT License
 * @version    1.0.0
 * @since      2026-11-18 IST
 */
 

// ❌ SYNTAX ERROR! 
// You cannot assign a 'switch' statement to a variable.
$statusLabel = switch ($status) {
    case 'active': 'Active User';
    case 'pending': 'Pending Review';
    default: 'Unknown';
};

// ✅ WORKS PERFECTLY!
// Because 'match' evaluates to a value, we can assign it directly.
$statusLabel = match ($status) {
    'active' => 'Active User',
    'pending' => 'Pending Review',
    default => 'Unknown',
};