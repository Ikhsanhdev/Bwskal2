<?php

namespace AyatKyo\Klorovel\Core\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $name
 * @property array $value
 * @property bool|null $autoload
 * @method static \Illuminate\Database\Eloquent\Builder|Setting hasId($id)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting table($field = null, $prefix = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting tableAs($nama, $prefix = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereAutoload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    use HasFactory, ModelTrait;

    public $timestamps = false;
    
    protected $casts = [
        'value'    => 'json',
        'autoload' => 'boolean'
    ];
}
