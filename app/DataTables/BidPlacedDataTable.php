<?php

namespace App\DataTables;

use App\Models\BidPlaced;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BidPlacedDataTable extends DataTable
{
    /**
     * بناء DataTable.
     */
   

        public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($row) {
                return $row->id;
            })
            ->addColumn('user', function ($row) {
                return $row->user ? $row->user->first_name : 'N/A';
            })
            ->addColumn('project', function ($row) {
                return $row->project ? $row->project->name : 'N/A';
            })
            ->addColumn('product', function ($row) {
                return $row->product ? $row->product->title : 'N/A';
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge bg-success">Approved</span>';
                } elseif ($row->status == 2) {
                    return '<span class="badge bg-danger">Rejected</span>';
                } else {
                    return '<span class="badge bg-warning">Pending</span>';
                }
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($row) {
                return view('admin.bid_placed.action', ['id' => $row->id])->render(); // استدعاء ملف العرض للأزرار
            })
         
            ->rawColumns(['status', 'action']) // السماح بعرض HTML في هذه الأعمدة
            ->setRowId('id');
    }

    /**
     * استعلام البيانات.
     */
 
    public function query(BidPlaced $model): QueryBuilder
    {
        return $model->with(['user', 'project', 'product', 'auctiontype'])
                    ->orderBy('created_at', 'desc') // ترتيب البيانات بناءً على تاريخ الإنشاء بشكل تنازلي
                    ->newQuery();
    }


    /**
     * خيارات HTML.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('bid_placed-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
    }

    /**
     * أعمدة الجدول.
     */
 
    public function getColumns(): array
    {
        return [
            Column::make('#')->title('#'),
            Column::make('user')->title('User Name'),
            Column::make('project')->title('Project Name'),
            Column::make('product')->title('Product Name'),
            Column::make('bid_amount')->title('Bid Amount'),
            Column::make('status')->title('Status'),
            Column::make('created_at')->title('Created At'),
            // تعليق عمود الأكشن مؤقتًا
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }
    
    /**
     * اسم الملف للتصدير.
     */
    protected function filename(): string
    {
        return 'BidPlaced_' . date('YmdHis');
    }
}
