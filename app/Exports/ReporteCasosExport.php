<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

/**
 * Genera el reporte de casos en .xlsx con el mismo look del PDF.
 * Uso: (new ReporteCasosExport($casos))->build()
 */
class ReporteCasosExport
{
    // Paleta tomada del PDF
    private const NAVY   = '0F172A';
    private const BLUE   = '2563EB';
    private const SOFT   = 'EFF6FF';
    private const SOFT_B = 'DBEAFE';
    private const GRAY   = '64748B';
    private const LINE   = 'E2E8F0';

    // Alto del logo en píxeles. Sube o baja este número para agrandarlo o reducirlo.
    // Las filas 1-3 miden ~96 px en total, así que no pases de ~90 sin subir sus alturas.
    private const LOGO_ALTO = 88;

    public function __construct(
        private Collection $casos,
        private ?string $logoPath = null,   // ruta absoluta del logo (png/jpg)
    ) {}

    /**
     * Recibe una colección de App\Models\CaseFile (con la relación moderator cargada).
     * Solo estas 5 columnas (igual que el PDF): sin descripción ni usuario.
     */
    private function filas(): Collection
    {
        return $this->casos->map(fn ($c) => [
            'numero'    => $c->case_number,                      // VS-2026-0501
            'tema'      => match ($c->type) {                    // igual que el PDF
                'SUICIDIO'     => 'Suicidio',
                'ABUSO_SEXUAL' => 'Abuso sexual',
                default        => $c->type,
            },
            'estado'    => $c->status,                           // Abierto | En seguimiento | Cerrado
            'moderador' => $c->moderator
                ? $c->moderator->first_name . ' ' . $c->moderator->last_name
                : 'No asignado',
            'fecha'     => $c->created_at,                       // Carbon
        ]);
    }

    public function build(): Spreadsheet
    {
        $filas = $this->filas();
        $n = $filas->count();

        $ss = new Spreadsheet();
        $ss->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);

        $ws = $ss->getActiveSheet();
        $ws->setTitle('Reporte de casos');
        $ws->setShowGridlines(false);

        // Anchos pensados para que las 3 tarjetas resumen midan casi lo mismo:
        // tarjeta 1 = A:B (34), tarjeta 2 = C:D (38), tarjeta 3 = E (36)
        foreach (['A' => 17, 'B' => 17, 'C' => 16, 'D' => 22, 'E' => 36] as $col => $w) {
            $ws->getColumnDimension($col)->setWidth($w);
        }

        // ───────── Encabezado institucional ─────────
        $ws->mergeCells('A1:A3');

        $ws->mergeCells('B1:C1');
        $ws->setCellValue('B1', 'UMG Xela');
        $ws->getStyle('B1')->getFont()->setBold(true)->setSize(20)->getColor()->setRGB(self::NAVY);

        $ws->mergeCells('D1:E1');
        $ws->setCellValue('D1', 'REPORTE DE CASOS');
        $ws->getStyle('D1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB(self::NAVY);
        $ws->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $ws->mergeCells('B2:E2');
        $ws->setCellValue('B2', 'Plataforma informática preventiva y de orientación');
        $ws->getStyle('B2')->getFont()->setSize(9)->getColor()->setRGB(self::GRAY);

        $ws->mergeCells('D3:E3');
        $ws->setCellValue('D3', 'Fecha de emisión: ' . now()->format('d/m/Y H:i'));
        $ws->getStyle('D3')->getFont()->setSize(9)->setBold(true)->getColor()->setRGB(self::NAVY);
        $ws->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $ws->mergeCells('A4:E4');
        $ws->setCellValue('A4', 'Dirección: 6ta. calle 22-39 Zona 3, Quetzaltenango, Guatemala');
        $ws->mergeCells('A5:E5');
        $ws->setCellValue('A5', 'Teléfono: 5523-6036  |  Correo: umgpsicologia26@gmail.com');
        $ws->getStyle('A4:A5')->getFont()->setSize(9)->getColor()->setRGB(self::GRAY);

        // Línea azul (fila delgada rellena)
        $ws->getStyle('A6:E6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::BLUE);

        $ws->getRowDimension(1)->setRowHeight(34);
        $ws->getRowDimension(2)->setRowHeight(19);
        $ws->getRowDimension(3)->setRowHeight(19);
        $ws->getRowDimension(6)->setRowHeight(4);
        $ws->getStyle('A1:E3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Logo: se pasa desde el controlador (mismo archivo que usa el PDF)
        $logo = $this->logoPath ?? public_path('images/logo-umg.png');
        if (is_file($logo)) {
            $img = new Drawing();
            $img->setPath($logo);
            $img->setHeight(self::LOGO_ALTO);   // mantiene la proporción
            $img->setCoordinates('A1');
            $img->setOffsetX(8);
            $img->setOffsetY(4);
            $img->setWorksheet($ws);
        }

        // ───────── Título de sección ─────────
        $ws->mergeCells('A8:E8');
        $ws->setCellValue('A8', 'Reporte de Casos Administrativos');
        $ws->getStyle('A8')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB(self::NAVY);
        $ws->getRowDimension(8)->setRowHeight(24);

        // ───────── Tarjetas resumen ─────────
        $abiertos = $filas->where('estado', 'Abierto')->count();
        $cerrados = $filas->where('estado', 'Cerrado')->count();

        // Tres tarjetas que ocupan todo el ancho de la tabla (como en el PDF)
        $tarjetas = [
            ['A', 'B', $n,        'Total de casos'],
            ['C', 'D', $abiertos, 'Casos abiertos'],
            ['E', 'E', $cerrados, 'Casos cerrados'],
        ];
        foreach ($tarjetas as [$c1, $c2, $valor, $etiqueta]) {
            if ($c1 !== $c2) {
                $ws->mergeCells("{$c1}10:{$c2}10");
                $ws->mergeCells("{$c1}11:{$c2}11");
            }
            $ws->setCellValue("{$c1}10", $valor);
            $ws->setCellValue("{$c1}11", $etiqueta);

            $ws->getStyle("{$c1}10:{$c2}11")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::SOFT]],
                'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => self::SOFT_B]]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $ws->getStyle("{$c1}10")->getFont()->setBold(true)->setSize(20)->getColor()->setRGB(self::BLUE);
            $ws->getStyle("{$c1}11")->getFont()->setSize(9)->getColor()->setRGB(self::GRAY);
        }

        // Separación entre tarjetas: borde blanco grueso en los bordes internos
        $blanco = ['borderStyle' => Border::BORDER_THICK, 'color' => ['rgb' => 'FFFFFF']];
        $ws->getStyle('A10:B11')->getBorders()->getRight()->applyFromArray($blanco);
        $ws->getStyle('C10:D11')->getBorders()->getLeft()->applyFromArray($blanco);
        $ws->getStyle('C10:D11')->getBorders()->getRight()->applyFromArray($blanco);
        $ws->getStyle('E10:E11')->getBorders()->getLeft()->applyFromArray($blanco);

        $ws->getRowDimension(10)->setRowHeight(34);
        $ws->getRowDimension(11)->setRowHeight(18);

        // ───────── Tabla ─────────
        $hdr = 13;
        foreach (['A' => 'Número de caso', 'B' => 'Tema', 'C' => 'Estado', 'D' => 'Moderador', 'E' => 'Fecha'] as $col => $t) {
            $ws->setCellValue("{$col}{$hdr}", $t);
        }
        $ws->getStyle("A{$hdr}:E{$hdr}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::NAVY]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_LEFT, 'indent' => 1],
        ]);
        $ws->getRowDimension($hdr)->setRowHeight(24);

        $fila = $hdr + 1;
        if ($n === 0) {
            $ws->mergeCells("A{$fila}:E{$fila}");
            $ws->setCellValue("A{$fila}", 'No hay casos registrados.');
            $ws->getStyle("A{$fila}")->getFont()->setItalic(true)->getColor()->setRGB(self::GRAY);
            $ws->getStyle("A{$fila}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $ultima = $fila;
        } else {
            foreach ($filas as $f) {
                $ws->setCellValue("A{$fila}", $f['numero']);
                $ws->setCellValue("B{$fila}", $f['tema']);
                $ws->setCellValue("C{$fila}", $f['estado']);
                $ws->setCellValue("D{$fila}", $f['moderador']);

                if ($f['fecha']) {
                    // Fecha real de Excel (ordenable/filtrable), no texto
                    $ws->setCellValue("E{$fila}", Date::PHPToExcel($f['fecha']));
                    $ws->getStyle("E{$fila}")->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                }

                $ws->getStyle("A{$fila}")->getFont()->setBold(true)->getColor()->setRGB(self::BLUE);

                // Colores de estado iguales a los del PDF
                $colorEstado = match ($f['estado']) {
                    'Abierto'        => 'C2410C',
                    'En seguimiento' => '1D4ED8',
                    'Cerrado'        => '475569',
                    default          => '1F2937',
                };
                $ws->getStyle("C{$fila}")->getFont()->setBold(true)->getColor()->setRGB($colorEstado);

                // Fila par con fondo suave, como el PDF
                if (($fila - $hdr) % 2 === 0) {
                    $ws->getStyle("A{$fila}:E{$fila}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
                }

                $ws->getRowDimension($fila)->setRowHeight(22);
                $fila++;
            }
            $ultima = $fila - 1;
        }

        $ws->getStyle("A" . ($hdr + 1) . ":E{$ultima}")->applyFromArray([
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_LEFT, 'indent' => 1],
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => self::LINE]]],
        ]);
        $ws->getStyle("A" . ($hdr + 1) . ":E{$ultima}")->getBorders()->getInside()
            ->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB(self::LINE);

        // Columna Fecha centrada (es la más ancha y así se ve equilibrada)
        $ws->getStyle("E{$hdr}:E{$ultima}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)->setIndent(0);

        if ($n > 0) {
            $ws->setAutoFilter("A{$hdr}:E{$ultima}");
        }

        // ───────── Pie ─────────
        $pie = $ultima + 2;
        $ws->mergeCells("A{$pie}:E{$pie}");
        $ws->setCellValue("A{$pie}", 'UMG Xela — Reporte administrativo de casos generado automáticamente');
        $ws->getStyle("A{$pie}")->applyFromArray([
            'font' => ['size' => 9, 'color' => ['rgb' => '94A3B8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['top' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => self::LINE]]],
        ]);

        // ───────── Impresión ─────────
        $ws->getPageSetup()
            ->setPaperSize(PageSetup::PAPERSIZE_LETTER)
            ->setOrientation(PageSetup::ORIENTATION_PORTRAIT)
            ->setFitToPage(true)
            ->setFitToWidth(1)
            ->setFitToHeight(0)
            ->setPrintArea("A1:E{$pie}");
        $ws->getPageMargins()->setLeft(0.5)->setRight(0.5)->setTop(0.6)->setBottom(0.6);
        $ws->getPageSetup()->setHorizontalCentered(true);
        // Si el reporte ocupa varias hojas, la cabecera de la tabla se repite en cada una
        $ws->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($hdr, $hdr);

        $ss->setActiveSheetIndex(0);
        $ws->setSelectedCell('A12');   // celda vacía: evita el recuadro verde sobre el logo

        return $ss;
    }
}