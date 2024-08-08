<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

use App\DTO\DTO;

class EnotCreatRedirectUrlDTO extends DTO {
    public int $o; // ID платежа в нашей системе
    public float $oa; // Сумма к оплате.  (Если в сумме есть копейки, то отправляйте их с разделителем "." Пример: 10.28)
    public string $cr = "RUB"; // валюта
    public ?string $p; // способ оплаты
}
