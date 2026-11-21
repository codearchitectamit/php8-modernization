<?php
declare(strict_types=1);

/**
 * Loop Control
 *
 * @category   php8-modernization
 * @package    Code Architect Amit
 * @author     Amit Joshi <codearchitectamit@gmail.com>
 * @license    https://opensource.org MIT License
 * @version    1.0.0
 * @since      2026-11-21 IST
 */

declare(strict_types=1);

$tasks = ['clean', 'skip_me', 'cook', 'stop_now', 'laundry'];

foreach ($tasks as $task) {
    switch ($task) {
        case 'skip_me':
            echo "Skipping: $task\n";
            // GOTCHA: We MUST use 'continue 2' to skip the outer foreach loop!
            // If we just used 'continue', it would act like 'break' and print the next line.
            continue 2; 
            
        case 'stop_now':
            echo "Stopping entirely at: $task\n";
            // 'break 2' exits the switch AND the foreach loop completely.
            break 2; 
            
        default:
            echo "Processing: $task\n";
            // Standard 'break' just exits the switch.
            break; 
    }
    
    // This line is skipped if 'skip_me' or 'stop_now' is hit.
    echo "--- End of loop iteration for: $task ---\n";
}