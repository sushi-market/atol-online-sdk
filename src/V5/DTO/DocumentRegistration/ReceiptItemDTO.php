<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

use DF\AtolOnline\V5\Enums\MarkProcessingMode;
use DF\AtolOnline\V5\Enums\Measure;
use DF\AtolOnline\V5\Enums\PaymentMethod;
use DF\AtolOnline\V5\Enums\PaymentObject;
use DF\AtolOnline\V5\Enums\PlannedStatus;

final readonly class ReceiptItemDTO
{
    public function __construct(
        public string $name,
        public float $price,
        public float $quantity,
        public Measure $measure,
        public float $sum,
        public PaymentMethod $payment_method,
        public PaymentObject $payment_object,
        public VatDTO $vat,
        public ?string $user_data = null,
        public ?float $excise = null,
        public ?string $country_code = null,
        public ?string $declaration_number = null,
        public ?MarkQuantityDTO $mark_quantity = null,
        public ?MarkProcessingMode $mark_processing_mode = null,

        /** @var SectoralItemPropDTO[] $sectoral_item_props */
        public ?array $sectoral_item_props = null,
        public ?MarkCodeDTO $mark_code = null,
        public ?AgentInfoDTO $agent_info = null,
        public ?SupplierInfoDTO $supplier_info = null,
        public ?bool $wholesale = null,
        public ?PlannedStatus $planned_status = null,
    ) {}
}
