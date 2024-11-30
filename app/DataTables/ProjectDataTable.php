<?php

namespace App\DataTables;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProjectDataTable extends DataTable
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
                ->addColumn('action', 'admin.projects.action')
                ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Project $model): QueryBuilder
    {
        $query = $model->newQuery()
        ->orderBy('created_at', 'desc')
        ->with('auctiontype','category');
        // $lang = 'en';
        // if(isset($this->request->input('columns')[2]['search']['value'])){
        //     $lang = $this->request->input('columns')[2]['search']['value'];
        // }
        $query = $query;
        return $query;
    }
    

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('project-table')
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
            Column::make('name'),
            // Column::make('lang_id')->hidden(),
            Column::computed('image')->render('full[\'image_path\'] ? "<img src=\'' . asset("img/projects/\" + full[\"image_path\"] + \"") . '\' width=\'50\'>" : "<img src=\'' . asset("img/noimage.jpg") . '\' width=\'50\'>"')->addClass('text-center'),
            Column::make('start_date_time')->title('Start Date & Time'),
            Column::computed('auctiontype')
                   ->data('auctiontype.name') 
                   ->title('Auction Type'),
            Column::computed('category_name')
                   ->data('category.name') 
                  ->title('Category'),
            Column::make('status')->render('full[\'status\'] ? \'Active\' : \'Inactive\'')->addClass('text-center'),
            Column::make('is_trending')->render('full[\'is_trending\'] ? \'Yes\' : \'No\'')->addClass('text-center'),
            // Column::make('buyers_premium'),
            // Column::make('deposit_amount'),
            Column::make('created_at')->render('new Date(full[\'created_at\']).toLocaleString()' ),
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
        return 'Project_' . date('YmdHis');
    }
}
