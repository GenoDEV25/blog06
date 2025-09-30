<?php namespace App\Models;
use CodeIgniter\Model;

class PostModel extends Model {
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title','summary','content','image','category_id','created_at','updated_at','author'];
    protected $useTimestamps = false;
}
