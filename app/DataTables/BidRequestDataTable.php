<?php

namespace App\DataTables;

use App\Models\BidRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BidRequestDataTable extends DataTable
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
            ->addColumn('action', 'admin.bidrequest.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BidRequest $model): QueryBuilder
    {
        $query = $model->newQuery();
    
        if ($this->request->has('created_at')) {
            $created_at = $this->request->get('created_at');
            if ($created_at) {
               
                $date = Carbon::parse($created_at)->toDateString();
                $query->whereDate('created_at', '=', $date);
            }
        }
        $query->with('auctiontype','project','user')->orderBy('id', 'desc');
        
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('bid_requests-table')
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
            Column::computed('user')
                   ->data('user.first_name')
                    ->title('Name'),
            Column::computed('user')
                    ->data('user.phone')
                     ->title('User Phone Number'),
            Column::computed('project')
                    ->data('project.name') 
                    ->title('Project'),
            Column::computed('auctiontype')
                    ->data('auctiontype.name') 
                    ->title('Auctiontype'),
            Column::make('deposit_amount')->title('Deposit Amount'),
            Column::make('status')->render('full[\'status\'] ? \'Approved\' : \'Decline\'')->addClass('text-center'),
            Column::make('created_at'),
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
        return 'BidRequest_' . date('YmdHis');
    }
}
