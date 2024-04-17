<?php

namespace App\Imports;

use App\Models\PagosMasivos;
use App\Rules\UniqueContactEmail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class PagosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{    
    private $insertedRows = 0;

    public function __construct()
    {
    }

    public function model(array $row)
    {
       
        // dd($row);

        $collaborator = new PagosMasivos([
            'solicituds_id' => $row['solicituds_id'],
            'tipo_pago' => $row['tipo_pago'],
            'monto_pago' => $row['monto_pago'],
            'cuentas_id' => $row['cuentas_id'],
            'referencia' => $row['referencia'],
            'observaciones' => $row['observaciones'],
            'fecha_pago' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_pago'])->format('Y/m/d')
        ]);

        if ($collaborator->save()) {
            $this->insertedRows++;
        }
    }

    public function insertedRowsCount()
    {
        return $this->insertedRows;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            '*.tipo_pago' => ['required', 'string', 'max:100'],
            '*.monto_pago' => ['required', 'numeric'],
            '*.fecha_pago' => ['required'],
            '*.solicituds_id' => ['required', 'int'],
            '*.referencia' => ['nullable', 'string', 'max:150'],
            '*.observaciones' => ['nullable', 'string', 'max:150']

        ];
    }

    public function customValidationAttributes()
    {
        return [
            'tipo_pago' => 'Tipo Pago',
            'monto_pago' => 'Monto Pago',
            'fecha_pago' => 'Fecha Pago',
            'solicituds_id' => 'ID Credito',
            'referencia' => 'Referencia',
            'observaciones' => 'Observaciones'
        ];
    }
}
