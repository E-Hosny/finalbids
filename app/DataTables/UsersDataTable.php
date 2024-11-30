<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // dd($query->toSql());
        $currentPage = request()->input('start') / request()->input('length') + 1;
        return (new EloquentDataTable($query))
            ->addColumn('#', function ()use ($currentPage)  {
                static $count = 0;
                $count++;
                return $count + ($currentPage - 1) * request()->input('length');
    
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') = ?", [$keyword]);
            })
            ->addColumn('action', 'admin.users.action')
            // ->addIndexColumn()
            ->setRowId('id');
    }

 
    public function query(User $model): QueryBuilder
    {
        $query = $model->whereRole(2)->where('is_otp_verify',1)->newQuery();    
        return $query;
    }
    
    /**
     * Get the query source of dataTable.
     */
    // public function query(User $model): QueryBuilder
    // {
    //     return $model->whereRole(2)->newQuery();
    // }

    public function applyEmailFilter($email)
    {
        if ($email) {
            $this->builder()->where('email', 'LIKE', "%$email%");
        }
    }
    public function applyNameFilter($name)
    {
        if ($name) {
            $this->builder()->where(function ($query) use ($name) {
                $query->where('first_name', 'LIKE', "%$name%")
                    ->orWhere('last_name', 'LIKE', "%$name%");
            });
        }
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->addIndex()
            ->minifiedAjax()
           //->dom('Bfrtip')
            ->orderBy(6)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::computed('#'),
            Column::computed('profile_image')->render('full[\'profile_image\'] ? "<img src=\'' .("\" + full[\"profile_image\"] + \"") . '\' width=\'50\'>" : "<img src=\'' . asset("img/noimage.jpg") . '\' width=\'50\'>"')->addClass('text-center'),
            Column::make('name')->data('full_name')->name('first_name'),
            Column::make('email'),
            Column::make('mobile')->data('mobile')->name('phone'),
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
        return 'Users_' . date('YmdHis');
    }
}