<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Product;
use App\Models\StartBid;
use Illuminate\Support\Facades\Log;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $results = StartBid::whereStatus(1)->get();

        foreach($results as $entity){
            $productCount = Product::where('project_id', $entity->project_id)
                        ->where(function($query) {
                            $query->whereDoesntHave('bidPlace', function ($query) {
                                $query->where('status', 2);
                            })
                            ->orWhereDoesntHave('bidPlace');
                        })
                        ->count();
            if($productCount <= 1){
                
            } else {
                $product = Product::where('project_id', $entity->project_id)
                            ->where('id', '>', $entity->product_id)
                            ->where(function($query) {
                                $query->whereDoesntHave('bidPlace', function ($query) {
                                    $query->where('status', 2);
                                })
                                ->orWhereDoesntHave('bidPlace');
                            })
                            ->first();
                if(!empty($product))
                {
                    $entity->product_id = $product->id;
                    $entity->save();
                } else {
                    $product = Product::where('project_id', $entity->project_id)
                            ->where(function($query) {
                                $query->whereDoesntHave('bidPlace', function ($query) {
                                    $query->where('status', 2);
                                })
                                ->orWhereDoesntHave('bidPlace');
                            })
                            ->first();
                    if(!empty($product)){
                        $entity->product_id = $product->id;
                        $entity->save();
                    } else {
                        $entity->status = 0;
                        $entity->save();
                    }
                }
            }
        }

        $projects = Project::where('auction_type_id', 2)->get();

        foreach ($projects as $project) {

            // Check if the project start date is in the past
            if (now() == $project->start_date_time) {
                $startBid = StartBid::where('project_id', $project->id)->first();

                // If start bid doesn't exist, create a new one
                $product = Product::where('project_id', $project->id)
                    ->where(function($query) {
                        $query->whereDoesntHave('bidPlace', function ($query) {
                            $query->where('status', 2);
                        })
                        ->orWhereDoesntHave('bidPlace');
                    })
                    ->first();
                if(!empty($product))
                {
                    StartBid::create([
                        'product_id' => $product->id,
                        'project_id' => $project->id,
                        'status' => 1,
                    ]);
                }
            }
            if(now() == $project->end_date_time)
            {
                StartBid::where('project_id', $project->id)->update(['status' => 0]);
            }
        }

    }
}
