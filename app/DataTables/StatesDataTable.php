<?php

namespace App\DataTables;

use App\Models\State;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StatesDataTable extends DataTable
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
            ->addColumn('action', 'admin.states.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(State $model): QueryBuilder
    {
        return $model->newQuery()->with('country');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('states-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        // Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('print'),
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
            Column::computed('image')->render('full[\'image\'] ? "<img src=\''.asset("img/states/\" + full[\"image\"] + \"").'\' width=\'50\'>" : "<img src=\''.asset("img/noimage.jpg").'\' width=\'50\'>"' )->addClass('text-center'),
            Column::make('country.name')->title('Country')->data('country.name')->addClass('text-center'),
            Column::make('name'),
            Column::make('status')->render('full[\'status\'] ? \'Active\' : \'Inactive\'')->addClass('text-center'),
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
        return 'States_' . date('YmdHis');
    }
}