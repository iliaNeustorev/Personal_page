<?php

namespace App\Enums;

enum Roles: string 
{
    case USER = 'user';
    case MODERATOR = 'moderator'; 
    case ADMIN = 'admin';
    case DEVELOPER = 'dev';
}