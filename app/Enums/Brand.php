<?php

namespace App\Enums;
use Kongulov\Traits\InteractWithEnum;

enum Brand: string {
  use InteractWithEnum;

  case TSG = 'TSG';
  case TGIF = 'TGIF';
  case SHG = 'SHG';
  case VAR = 'VAR';
}