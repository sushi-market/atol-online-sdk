<?php

declare(strict_types=1);

namespace DF\AtolOnline\Exceptions;

use RuntimeException;

class InvalidCredentialsException extends RuntimeException implements AtolOnlineException {}
