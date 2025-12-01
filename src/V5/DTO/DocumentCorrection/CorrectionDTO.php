<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentCorrection;

use DF\AtolOnline\V5\DTO\DocumentRegistration\AdditionalUserPropsDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\CashlessPaymentDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\ClientDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\CompanyDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\OperatingCheckPropsDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\PaymentDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\ReceiptItemDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\SectoralCheckPropDTO;
use DF\AtolOnline\V5\DTO\DocumentRegistration\VatDTO;
use DF\AtolOnline\V5\Enums\Timezone;

final readonly class CorrectionDTO
{
    public function __construct(
        public CompanyDTO $company,
        public CorrectionInfoDTO $correction_info,

        /** @var ReceiptItemDTO[] */
        public array $items,

        /** @var PaymentDTO[] $payments */
        public array $payments,
        public float $total,

        public ?ClientDTO $client = null,

        /** @var VatDTO[] $vats */
        public ?array $vats = null,
        public ?string $cashier_inn = null,
        public ?string $additional_check_props = null,
        public ?AdditionalUserPropsDTO $additional_user_props = null,
        public ?OperatingCheckPropsDTO $operating_check_props = null,

        /** @var SectoralCheckPropDTO[] $vats */
        public ?array $sectoral_check_props = null,
        public ?string $device_number = null,
        public ?bool $internet = null,

        /** @var CashlessPaymentDTO[] $cashless_payments */
        public ?array $cashless_payments = null,
        public ?Timezone $timezone = null,
    ) {}
}
