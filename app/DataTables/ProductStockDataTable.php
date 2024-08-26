<?php

namespace App\DataTables;

use App\Enums\StockTypeEnum;
use App\Helpers\EnumHelper;
use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductStockDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', 'console.product-stocks.action')
            ->editColumn('product', function ($stock) {
                return "{$stock->product->name} ({$stock->product->id})";
            })
            ->editColumn('type', function ($stock) {
                if ($stock->type == EnumHelper::getKey(StockTypeEnum::class, 'IN')) {
                    return '<span style="color: white; background-color: green; padding: 5px; border-radius: 3px;">' . 'IN' . '</span>';
                } else {
                    return '<span style="color: white; background-color: red; padding: 5px; border-radius: 3px;">' . 'OUT' . '</span>';
                }
            })
            ->editColumn('updated_at', fn($stock) => $stock->updated_at->format('l, d F Y'))
            ->filterColumn('product', function ($query, $keyword) {
                $query->whereHas('product', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%")
                        ->orWhere('id', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['action', 'type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductStock $model): QueryBuilder
    {
        return $model->newQuery()->with(['product']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        // Konfigurasi DOM untuk DataTables
        $dom = '<"row mx-1"' .
            '<"col-sm-12 col-md-3 mt-5 mt-md-0" l>' .
            '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-4"f>B>>' .
            '>t' .
            '<"row mx-2"' .
            '<"col-sm-12 col-md-6"i>' .
            '<"col-sm-12 col-md-6"p>' .
            '>';

        // Konfigurasi bahasa untuk DataTables
        $language = [
            'sLengthMenu' => 'Show _MENU_',
            'search' => '',
            'searchPlaceholder' => 'Search Products',
            'paginate' => [
                'next' => '<i class="ri-arrow-right-s-line"></i>',
                'previous' => '<i class="ri-arrow-left-s-line"></i>'
            ]
        ];
        // Konfigurasi tombol
        $buttons = [
            [
                'text' => '<i class="ri-add-line me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add Product</span>',
                'className' => 'add-new btn btn-primary mb-5 mb-md-0 me-3 waves-effect waves-light',
                'init' => 'function (api, node, config) {
                    $(node).removeClass("btn-secondary");
                }',
                'action' => 'function (e, dt, node, config) {
                    window.location = "' . route('stocks.create') . '";
                }'
            ],
            [
                'text' => '<i class="ri-refresh-line me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Reload</span>',
                'className' => 'btn btn-secondary mb-5 mb-md-0 me-3 waves-effect waves-light',
                'action' => 'function (e, dt, node, config) {
                    dt.ajax.reload();
                    $("#products-table_filter input").val("").keyup();
                }'
            ]
        ];

        $columnExport = [0, 1, 2, 3, 4];
        $buttons[] = [
            [
                'extend' => 'collection',
                'text' => '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Export</span>',
                'buttons' => [
                    [
                        'extend' => 'copy',
                        'exportOptions' => [
                            'columns' => $columnExport
                        ],
                    ],
                    [
                        'extend' => 'excel',
                        'exportOptions' => [
                            'columns' => $columnExport
                        ],
                    ],
                    [
                        'extend' => 'csv',
                        'exportOptions' => [
                            'columns' => $columnExport
                        ],
                    ],
                    [
                        'extend' => 'pdf',
                        'exportOptions' => [
                            'columns' => $columnExport
                        ],
                    ],
                    [
                        'extend' => 'print',
                        'exportOptions' => [
                            'columns' => $columnExport,
                        ],
                    ]
                ],
                'className' => 'btn btn-secondary buttons-collection dropdown-toggle btn-outline-secondary waves-effect waves-light',
                'init' => 'function (api, node, config) {
                    $(node).removeClass("btn-secondary");
                }',
            ],
        ];

        return $this->builder()
            ->setTableId('stocks-table')
            ->columns($this->getColumns())
            ->parameters([
                'order' => [[0, 'desc']], // Urutan default
                'dom' => $dom, // Struktur DOM
                'language' => $language, // Bahasa
                'buttons' => $buttons, // Tombol
                'responsive' => true, // Responsif
                'autoWidth' => false, // AutoWidth
            ])
            ->ajax([
                'url'  => route('stocks.index'),
                'type' => 'GET',
                'data' => "function(d){
                    d.product_id = $('select[name=product_filter]').val();
                    d.type = $('select[name=type_filter]').val();
                }",
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->orderable(false)->searchable(false),
            Column::make('product')->title('Product (ID Product)'),
            Column::make('type')->title('Type')->searchable(false),
            Column::make('quantity')->title('Quantity')->searchable(false),
            Column::make('updated_at')->title('Last Updated')->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title('Action'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'product-stocks_' . date('YmdHis');
    }
}
