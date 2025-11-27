<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class ClientDTO
{
    public function __construct(
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $name = null,
        public ?string $inn = null,
        public ?string $birthdate = null,
        public ?string $citizenship = null,
        public ?string $document_code = null,
        public ?string $document_data = null,
        public ?string $address = null,
    ) {}
}
