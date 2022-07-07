<?php

namespace Rapidez\AmastyLabel\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

trait CastAmastyLabel
{
    protected $variableRegex = '/(?<={)[a-zA-Z0-9_:]+(?=})/';

    protected function amastyLabel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
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

                                $labels[$key]->{$typeLabel} = $this->parseVariables($labels[$key]->{$typeLabel}, $type, $var);
                            }
                        }
                    }
                }

                return $labels;
            },
            set: fn ($value) => $value,
        );
    }

    protected function parseVariables($text, $type, $var)
    {
        return match($type) {
            'flat' => str_replace("{{$var}}", price($this->{strtolower($var)}), $text),
            'amount' => str_replace("{{$var}}", price($this->price - $this->special_price), $text),
            'percent' => str_replace("{{$var}}", floor(($this->special_price / $this->price) * 100) . '%', $text),
        };
    }


}
