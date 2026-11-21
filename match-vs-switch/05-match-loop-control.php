<?php
declare(strict_types=1);

/**
 * Match Expression Loop Control
 *
 * @category   php8-modernizaiton
 * @package    Code Architect Amit
 * @author     Amit Joshi <codearchitectamit@gmail.com>
 * @license    https://opensource.org MIT License
 * @version    1.0.0
 * @since      2026-11-21 IST
 */

declare(strict_types=1);

$tasks = ['clean', 'skip_me', 'cook', 'stop_now', 'laundry'];

foreach ($tasks as $task) {
    // 1. The match expression returns a 'signal' string
    $action = match ($task) {
        'skip_me'  => 'continue',
        'stop_now' => 'break',
        default    => 'process',
    };

    // 2. We use standard if-statements to control the outer loop
    if ($action === 'continue') {
        echo "Skipping: $task\n";
        continue; // Standard continue works perfectly here!
    }
    
    if ($action === 'break') {
        echo "Stopping entirely at: $task\n";
        break; // Standard break works perfectly here!
    }

    // 3. Default processing
    echo "Processing: $task\n";
    echo "--- End of loop iteration for: $task ---\n";
}