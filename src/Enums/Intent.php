<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Enums;

final class Intent
{
    const Positive = 'positive';
    const Negative = 'negative';
    const Default = 'default';

    private function __construct() {}
}
