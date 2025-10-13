<?php

namespace App\Exports;

use App\Models\ChatMessage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ChatMessagesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $messages;

    public function __construct($messages)
    {
        $this->messages = $messages;
    }

    public function collection()
    {
        return $this->messages;
    }

    public function headings(): array
    {
        return [
            'STT',
            'Tên người dùng',
            'Nội dung tin nhắn',
            'Trạng thái',
            'Từ khóa bị chặn',
            'Thời gian gửi',
            'Ngày tạo',
            'Ngày cập nhật'
        ];
    }

    public function map($message): array
    {
        return [
            $message->id,
            $message->username,
            $message->message,
            $message->is_blocked ? 'Bị chặn' : 'Hoạt động',
            $message->is_blocked ? implode(', ', $message->blocked_keywords ?? []) : '',
            $message->sent_at ? $message->sent_at->format('d/m/Y H:i:s') : '',
            $message->created_at ? $message->created_at->format('d/m/Y H:i:s') : 'N/A',
            $message->updated_at ? $message->updated_at->format('d/m/Y H:i:s') : 'N/A'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // STT
            'B' => 20,  // Tên người dùng
            'C' => 50,  // Nội dung tin nhắn
            'D' => 15,  // Trạng thái
            'E' => 30,  // Từ khóa bị chặn
            'F' => 20,  // Thời gian gửi
            'G' => 20,  // Ngày tạo
            'H' => 20,  // Ngày cập nhật
        ];
    }
}
