<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentInfo;

final readonly class PayloadDTO
{
    /** @param MarkResultDTO[]|null $marks_result */
    public function __construct(
        public int $fiscal_receipt_number,
        public int $shift_number,
        public string $receipt_datetime,
        public float $total,
        public string $fn_number,
        public string $ecr_registration_number,
        public int $fiscal_document_number,
        public int $fiscal_document_attribute,
        public string $fns_site,
        public ?string $ofd_inn = null,
        public ?string $ofd_receipt_url = null,

        public ?array $marks_result = null,
    ) {}
}
