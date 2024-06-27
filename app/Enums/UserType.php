<?php

namespace App\Enums;
use Kongulov\Traits\InteractWithEnum;

enum UserType: string {
  use InteractWithEnum;

  case ADMIN = 'admin';
  case STAFF = 'staff';
}