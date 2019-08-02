<?php
namespace App\Http\Resources\testing;
use App\Extensions\Http\Resources\Json\JsonResource;
class testResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            //'self' => $this->name,
            //'value' => $this->value,
            //'display_order' => $this->display_order,
            //'parent_group_id' => $this->parent_group_id,
           // 'parent_value' => $this->parent_value,
            //'group' => $this->group
        ];
    }
}