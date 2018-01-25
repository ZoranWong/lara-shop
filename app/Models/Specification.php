<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Specification
 *
 * @property int $id
 * @property string $name 规格名称
 * @property array $value JSON格式：{"红色":"红色"}
 * @property string $type 规格类型
 * @property string $note 备注说明
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specification whereValue($value)
 * @mixin \Eloquent
 */
class Specification extends Model
{
    //
    use ModelTrait;

    protected $table = 'specification';

    protected $casts = [
        'value' => 'array'
    ];

    protected $fillable = [
        'name',
        'value',
        'note',
        'type'
    ];
}
