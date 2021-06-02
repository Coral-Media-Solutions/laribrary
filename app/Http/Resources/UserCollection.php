<?php

namespace App\Http\Resources;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class UserCollection
 * @package App\Http\Resources
 *
 * @property int id
 * @property string name
 * @property string email
 * @property DateTimeInterface created_at
 * @property DateTimeInterface updated_at
 */
class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
