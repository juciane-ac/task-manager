<?php

namespace App\Enums;

enum TaskPriority: string
{
    case low = 'Baixa';
    case medium = 'Média';
    case high = 'Alta';
}
