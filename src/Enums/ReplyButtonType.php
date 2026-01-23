<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot\Enums;

final class ReplyButtonType
{
    const Message = 'message';
    const UserGeoLocation = 'user_geo_location';
    const UserContact = 'user_contact';

    private function __construct() {}
}
