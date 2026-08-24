<?php

namespace App;

enum UserRoles: string
{
    case Manager = 'manager';

    case HR = 'hr';

    case Developer = 'dev';

    case Engineer = 'eng';
}
