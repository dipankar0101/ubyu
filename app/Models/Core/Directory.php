<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Kyslik\ColumnSortable\Sortable;

class Directory extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = ['directories_id','directories_name'];

    public function directories($request){
      $data = Directory::sortable()
        ->LeftJoin('image_categories', function ($join) {
            $join->on('image_categories.image_id', '=', 'directories.image')
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
        })
        ->select('directories.*','image_categories.path as image_path')
        ->where('directories.is_delete',0);

      if ($request->parameter) {
        $data->where('directories.directories_name', 'LIKE', '%'.$request->parameter.'%')
        ->orwhere('directories.location', 'LIKE', '%'.$request->parameter.'%');
      }

      $directories = $data->orderBy('directories.directories_order','ASC')
        ->paginate(10);
        
            
      return $directories;
    }

    public function directoryList(){
        $directories = DB::table('directories')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'directories.image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
            })
            ->select('directories.*','image_categories.path as image_path')
            ->where('directories.is_delete',0)
            ->where('directories.status',1)
            ->orderBy('directories.directories_id','DESC')
            ->get();
        return $directories;
    }

    public function insert($request)
        {
          $uploadImage = $request->image_id;
          $insert = DB::table('directories')->insertGetId([
              'directories_name'   =>   $request->directory_name,
              'image'   => $uploadImage,
              'status'  => $request->directory_status,
              // 'location'  => $request->location,
              // 'directory_tags' => $request->directory_tags,
              'created_at'   =>  date('Y-m-d H:i:s'),
          ]);

          DB::table('directories')->where('directories_id', $insert)->update(
            [
                'directories_order'   =>   $insert,
            ]);
          return $insert;
        }

}
