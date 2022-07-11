<?php

namespace Rapidez\AmastyLabel\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Rapidez\Core\Models\Model;
use Illuminate\Support\Collection;

class CastAmastyLabelVariables implements CastsAttributes
{
    protected $variableRegex = '/(?<={)[a-zA-Z0-9_:]+(?=})/';

    public function get($model, string $key, $value, array $attributes) : Collection
    {
        $labels = collect(json_decode($value));
        if (!$labels->count()) {
            return $labels;
        }

        foreach ($labels as $key=>$label) {
            foreach (['prod_txt', 'cat_txt'] as $typeLabel) {
                preg_match_all($this->variableRegex, $label->{$typeLabel}, $variables);
                if (!empty(array_merge(...$variables))) {
                    foreach (array_merge(...$variables) as $var) {
                        $type = config('amastylabel.'.$var);
                        if (!$type) {
                            continue;
                        }

                        $labels[$key]->{$typeLabel} = $this->parseVariables($labels[$key]->{$typeLabel}, $type, $var, $model);
                    }
                }
            }
        }

        return $labels;
    }

    protected function parseVariables(string $text, string $type, string $var, Model $model) : string
    {
        return match($type) {
            'flat' => str_replace("{{$var}}", price($model->{strtolower($var)}), $text),
            'amount' => str_replace("{{$var}}", price($model->price - $model->special_price), $text),
            'percent' => str_replace("{{$var}}", (100 - floor(($model->special_price / $model->price) * 100)) . '%', $text),
        };
    }

    public function set($model, string $key, $value, array $attributes) : string
    {
        return $value;
    }
}
