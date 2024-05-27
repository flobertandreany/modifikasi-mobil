<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueCarEngine implements Rule
{
    protected $data;
    protected $currentKey;

    public function __construct($data, $currentKey)
    {
        $this->data = $data;
        $this->currentKey = $currentKey;
    }

    public function passes($attribute, $value)
    {
        $index = substr($attribute, strrpos($attribute, '-') + 1);

        $modelKey = 'car_model_id-' . $index;
        $yearKey = 'car_year-' . $index;
        $engineKey = 'car_engine_id-' . $index;

        if (isset($this->data[$modelKey]) && isset($this->data[$yearKey]) && isset($this->data[$engineKey])) {
            foreach ($this->data as $key => $val) {
                if ($key !== $attribute && strpos($key, 'car_engine_id-') === 0) {
                    $otherIndex = substr($key, strrpos($key, '-') + 1);
                    $otherModelKey = 'car_model_id-' . $otherIndex;
                    $otherYearKey = 'car_year-' . $otherIndex;
                    $otherEngineKey = 'car_engine_id-' . $otherIndex;

                    if (
                        isset($this->data[$otherModelKey]) && isset($this->data[$otherYearKey]) && isset($this->data[$otherEngineKey]) &&
                        $this->data[$modelKey] === $this->data[$otherModelKey] &&
                        $this->data[$yearKey] === $this->data[$otherYearKey] &&
                        $value === $this->data[$otherEngineKey]
                    ) {
                        // Tampilkan error hanya jika indeks saat ini lebih besar dari indeks lain yang ditemukan
                        if ($index > $otherIndex) {
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
