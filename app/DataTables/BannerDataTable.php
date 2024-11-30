<?php

namespace App\DataTables;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BannerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function () {
                static $count = 0;
                $count++;
                return $count;
            })
            ->addColumn('action', 'admin.banners.action')
            ->setRowId('id');
    }
    
    /**
     * Get the query source of dataTable.
     */
    // public function query(Banner $model): QueryBuilder
    // {
    //     $query = $model->newQuery();
    
    //     if ($this->request->has('created_at')) {
    //         $created_at = $this->request->get('created_at');
    //         if ($created_at) {
    //             $query->whereDate('created_at', '=', $created_at);
    //         }
    //     }
    
    //     return $query;
    // }
    public function query(Banner $model): QueryBuilder
    {
        $query = $model->newQuery();
        $lang = 'en';
        if(isset($this->request->input('columns')[2]['search']['value'])){
            $lang = $this->request->input('columns')[2]['search']['value'];
        }
        $query = $query->where('lang_id', $lang);
        return $query;
    }

    
    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('banner-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('title'),
            Column::make('lang_id')->hidden(),
            Column::computed('image_path')->render('full[\'image_path\'] ? "<img src=\'' . asset("img/users/\" + full[\"image_path\"] + \"") . '\' width=\'50\'>" : "<img src=\'' . asset("img/noimage.jpg") . '\' width=\'50\'>"')->addClass('text-center'),
            // Column::make('description')
            //         ->title('Description')
            //         ->render('data?.replace(/<[^>]*>/g, \'\').split(\' \').slice(0, 20).join(\' \')'),
            Column::make('status')->render('full[\'status\'] ? \'Active\' : \'Inactive\'')->addClass('text-center'),
            Column::make('created_at')->render('new Date(full[\'created_at\']).toLocaleString()'),
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
        return 'Banner_' . date('YmdHis');
    }
}
