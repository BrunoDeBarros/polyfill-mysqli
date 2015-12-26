<?php
/*
 * This file provides a MySQLi polyfill for PHP installations that don't have it installed.
 *
 * (c) Bruno De Barros <bruno@terraduo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!function_exists('mysqli_connect')) {
    # Define all needed classes.
    include 'mysqli.php';
}