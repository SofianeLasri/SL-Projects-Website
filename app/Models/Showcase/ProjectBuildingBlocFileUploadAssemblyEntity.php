<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectBuildingBlocFileUploadAssemblyEntity extends Model
{
    public $timestamps = false;

    protected $table = 'pbb_fu_assemblies_ent';

    protected $fillable = [
        'file_upload_assembly_id',
        'file_upload_id',
        'name_translation_id',
        'description_translation_id',
    ];
}
