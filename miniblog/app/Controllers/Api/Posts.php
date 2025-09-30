<?php namespace App\Controllers\Api;
use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class Posts extends BaseController {
    public function index(){
        $db = Config::connect();
        $page = max(1, (int)($this->request->getGet('page') ?? 1));
        $perPage = min(12, (int)($this->request->getGet('perPage') ?? 6));
        $offset = ($page - 1) * $perPage;

        $builder = $db->table('posts p')
            ->select('p.id, p.title, p.summary, p.image, p.created_at, p.author, c.name AS category_name')
            ->join('categories c','c.id = p.category_id')
            ->orderBy('p.created_at','DESC');

        $data = $builder->get($perPage, $offset)->getResultArray();

        return $this->response->setJSON([
            'status' => 'ok',
            'page' => $page,
            'perPage' => $perPage,
            'data' => $data
        ]);
    }

    public function show($id = null){
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID requerido']);
        $db = Config::connect();
        $post = $db->table('posts p')
            ->select('p.*, c.name AS category_name')
            ->join('categories c','c.id=p.category_id')
            ->where('p.id',$id)
            ->get()
            ->getRowArray();
        if (!$post) return $this->response->setStatusCode(404)->setJSON(['status'=>'error','message'=>'No encontrado']);
        return $this->response->setJSON($post);
    }
}
