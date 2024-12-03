<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $currentPage = request()->input('start') / request()->input('length') + 1;
        return (new EloquentDataTable($query))
             ->addColumn('#', function ()use ($currentPage)  {
                static $count = 0;
                 $count++;
                    return $count + ($currentPage - 1) * request()->input('length');
             })
            
            ->addColumn('action', 'admin.products.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        $query = $model->newQuery();
    
        // $lang = 'en';
        // if (isset($this->request->input('columns')[2]['search']['value'])) {
        //     $lang = $this->request->input('columns')[2]['search']['value'];
        // }
    
        $query = $query->orderBy('created_at', 'desc')
        ->with('category','subcategory','auctiontype','project');
        return $query;
    }

   
    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(9)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('#'),
            Column::make('lot_no')->title('Lot No'),
            Column::make('title')->title('Title'),
            Column::computed('auctiontype')
                   ->data('auctiontype.name') 
                   ->title('Auctiontype'),
            Column::computed('project')
                   ->data('project.name') 
                   ->title('Project'),
            Column::make('auction_end_date')->title('Auction End Date'),
            Column::make('reserved_price')->title('Reserved Price'),
            Column::make('minsellingprice')->title('Min Selling Price'),
            Column::make('created_at')->render('new Date(full[\'created_at\']).toLocaleString()' ),
            Column::make('is_popular')->render('full[\'is_popular\'] ? \'Yes\' : \'No\'')->addClass('text-center'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
