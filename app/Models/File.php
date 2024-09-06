<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'gemiso_se.files';  // 스키마와 함께 테이블 이름을 지정
    protected $primaryKey = 'id';          // 기본 키
    public $incrementing = true;           // 자동 증가 키
    protected $keyType = 'int';            // 기본 키 타입
    public $timestamps = false;            // timestamps 사용 안 함

    protected $fillable = [
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'board_id',
        'upload_date'
    ];
}