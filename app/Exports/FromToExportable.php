<?php

namespace App\Exports;


class FromToExportable
{
    public ?string $from_date;
    public ?string $to_date;
    public string $table;

    public function __construct(string $table, ?string $from_date, ?string $to_date)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->table = $table;
    }

    public function applyFromToOn($model)
    {
        if (!is_null($this->from_date)) {
            $model->where($this->table . '.created_at', '>=', $this->from_date);
        }

        if (!is_null($this->to_date)) {
            $model->where($this->table . '.created_at', '<=', $this->to_date);
        }

        return $model;
    }
}
