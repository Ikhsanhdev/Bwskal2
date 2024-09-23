<?php

namespace AyatKyo\Klorovel\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Str;

class UniqSlug implements Rule, ValidatorAwareRule
{
    protected $model;
    protected $column;
    protected $ignore;

    protected $validator;

    public function __construct($model, $column = null, $ignore = null)
    {
        $this->model = $model;
        $this->column = $column ?? 'slug';
        $this->ignore = $ignore;
    }

    public function passes($attribute, $value)
    {
        $slug = Str::slug($value);
        $query = call_user_func("App\Models\\{$this->model}::query");
        $query = $query->where($this->column, $slug);

        if (isset($this->ignore)) {
            $ignoreData = [];
            if ($this->ignore[0] == '@') {
                $ignoreData[] = data_get($this->validator->getData(), substr($this->ignore, 1));
            } else {
                $ignoreData = $this->ignore;
            }
            $query = $query->whereNotIn('id', $ignoreData);
        }

        return $query->count() === 0;
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }


    public function message()
    {
        return 'Sudah digunakan';
    }
}
