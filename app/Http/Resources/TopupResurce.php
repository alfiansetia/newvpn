<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopupResurce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $bank = $this->whenLoaded('bank');
        $user = $this->whenLoaded('user');
        $bank_name = $bank->name ?? '';
        $bank_acc_name = $bank->acc_name ?? '';
        $bank_acc_number = $bank->acc_number ?? '';
        $amount = $this->amount;
        $amount_parse = hrg($amount);
        $email = $user->email ?? '';
        $number = $this->number;

        return [
            'id'            => $this->id,
            'DT_RowId'      => $this->id,
            'date'          => $this->date,
            'number'        => $number,
            'amount'        => $amount,
            'status'        => $this->status,
            'image'         => $this->image,
            'desc'          => $this->desc,
            'user_id'       => $this->user_id,
            'bank_id'       => $this->bank_id,
            'user'          => new UserResource($user),
            'bank'          => new BankResource($bank),
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'message'       => "Please Transfer $amount_parse To : $bank_name $bank_acc_number ($bank_acc_name)..",
            'confirm_url'   => "https://api.whatsapp.com/send?phone=6282324129752&text=Halo, Saya dengan email $email ingin konfirmasi Topup Saldo sebesar RP. $amount_parse melalui $bank_name $bank_acc_name ($bank_acc_number), ID TRX : $number.",
            'type'          => $this->type,
            'link'          => $this->link,
            'callback_status'   => $this->callback_status,
            'cost'          => $this->cost,
            'reference'     => $this->reference,
            'paid_at'       => $this->paid_at,
            'expired_at'    => $this->expired_at,
            'qris_image'    => $this->qris_image,
        ];
    }
}
