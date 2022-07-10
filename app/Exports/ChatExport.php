<?php

namespace App\Exports;

use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    ShouldAutoSize,
    WithColumnFormatting,
    WithHeadings,
    WithMapping,
};
use PhpOffice\PhpSpreadsheet\{
    Shared\Date,
    Style\NumberFormat,
};

class ChatExport implements
    FromQuery,
    WithHeadings,
    ShouldAutoSize,
    WithMapping,
    WithColumnFormatting
{
  private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function query(): Builder
    {
      return Message::where('student_id', $this->id)->with('user');
    }

    public function map($message): array
    {
        return [
            $message->id,
            $message->user->name,
            $message->body,
            Date::dateTimeToExcel($message->sent_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Unique ID',
            'Teacher Name',
            'Message',
            'Sent At',
        ];
    }

    public function columnFormats(): array
    {
        return [
          'D' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
