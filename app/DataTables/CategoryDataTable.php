<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') = ?", [$keyword]);
            })
            ->addColumn('action', 'admin.categories.action')
            ->setRowId('id');
    }
  
    /**
     * Get the query source of dataTable.
     */
    // public function query(Category $model): QueryBuilder
    // {
    //     return $model->newQuery();
    // }

    public function query(Category $model): QueryBuilder
    {
        $query = $model->newQuery();
    // if (isset($this->request->input('columns')[2]['search']['value'])) {
    //     $lang = $this->request->input('columns')[2]['search']['value'];
    // }
   
    // $query = $query->where('lang_id', $lang);
    return $query;
    }

    public function applyNameFilter($name)
    {
        if ($name) {
            $this->builder()->where(function ($query) use ($name) {
                $query->where('name', 'LIKE', "%$name%");
            });
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(4)
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
            // Column::make('slug'),
            Column::make('status')->render('full[\'status\'] ? \'Published\' : \'Draft\'')->addClass('text-center'),
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
        return 'Category_' . date('YmdHis');
    }
}
