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
        return (new EloquentDataTable($query))
            ->addColumn('#', function () {
                static $count = 0;
                $count++;
                return $count;
            })
            ->addColumn('action', 'admin.projects.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Project $model): QueryBuilder
    {
        $query = $model->newQuery();
        if ($this->request->has('created_at')) {
            $created_at = $this->request->get('created_at');
            if ($created_at) {
                $query->whereDate('created_at', '=', $created_at);
            }
        }
        $query->with('auctiontype');
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
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
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
            Column::computed('image_path')->render('full[\'image_path\'] ? "<img src=\'' . asset("img/projects/\" + full[\"image_path\"] + \"") . '\' width=\'50\'>" : "<img src=\'' . asset("img/noimage.jpg") . '\' width=\'50\'>"')->addClass('text-center'),
            Column::make('start_date_time')->title('Start Date & Time'),
            Column::computed('auctiontype')
                   ->data('auctiontype.name') 
                   ->title('Auctiontype'),
            Column::make('status')->render('full[\'status\'] ? \'Active\' : \'Inactive\'')->addClass('text-center'),
            Column::make('is_trending')->render('full[\'is_trending\'] ? \'Yes\' : \'No\'')->addClass('text-center'),
            Column::make('buyers_premium'),
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
