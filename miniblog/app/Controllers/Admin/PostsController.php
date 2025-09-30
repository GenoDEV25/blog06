<?php namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;

class PostsController extends BaseController {
    protected $postModel;
    protected $catModel;

    public function __construct(){
        $this->postModel = new PostModel();
        $this->catModel = new CategoryModel();
    }

    public function index(){
        $posts = $this->postModel->orderBy('created_at','DESC')->findAll();
        return view('admin/posts/list', ['posts'=>$posts]);
    }

    public function create(){
        $categories = $this->catModel->findAll();
        return view('admin/posts/form', ['post'=>null, 'categories'=>$categories]);
    }

    public function store(){
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'created_at' => 'required',
            'summary' => 'required',
            'category_id' => 'required|is_not_unique[categories.id]'
        ];
        if (!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        }

        $img = $this->request->getFile('image');
        $imagePath = null;

        if ($img && $img->isValid()){
            $allowed = ['image/png','image/jpeg','image/jpg','image/webp'];
            if (!in_array($img->getMimeType(), $allowed)){
                return redirect()->back()->withInput()->with('errors',['image'=>'Tipo de imagen no permitido (png/jpeg/webp)']);
            }
            $imageName = $img->getRandomName();
            $img->move(FCPATH.'uploads', $imageName);
            $imagePath = '/uploads/'.$imageName;
        } else {
            return redirect()->back()->withInput()->with('errors',['image'=>'Imagen requerida']);
        }

        $this->postModel->insert([
            'title' => $this->request->getPost('title'),
            'summary' => $this->request->getPost('summary'),
            'content' => $this->request->getPost('content'),
            'image' => $imagePath,
            'category_id' => $this->request->getPost('category_id'),
            'created_at' => $this->request->getPost('created_at'),
            'author' => session('user')['name'] ?? 'Admin'
        ]);

        return redirect()->to('/admin/posts')->with('success','Post creado');
    }

    public function edit($id = null){
        $post = $this->postModel->find($id);
        if (!$post) return redirect()->to('/admin/posts')->with('error','Post no encontrado');
        $categories = $this->catModel->findAll();
        return view('admin/posts/form', ['post'=>$post, 'categories'=>$categories]);
    }

    public function update($id = null){
        $post = $this->postModel->find($id);
        if (!$post) return redirect()->to('/admin/posts')->with('error','Post no encontrado');

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'created_at' => 'required',
            'summary' => 'required',
            'category_id' => 'required|is_not_unique[categories.id]'
        ];
        if (!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $img = $this->request->getFile('image');
        if ($img && $img->isValid()){
            $allowed = ['image/png','image/jpeg','image/jpg','image/webp'];
            if (!in_array($img->getMimeType(), $allowed)){
                return redirect()->back()->withInput()->with('errors',['image'=>'Tipo de imagen no permitido']);
            }
            $imageName = $img->getRandomName();
            $img->move(FCPATH.'uploads', $imageName);

            // borrar viejo si existe
            if ($post['image']){
                $old = FCPATH . ltrim($post['image'],'/');
                if (is_file($old)) @unlink($old);
            }
            $post['image'] = '/uploads/'.$imageName;
        }

        $this->postModel->update($id, [
            'title' => $this->request->getPost('title'),
            'summary' => $this->request->getPost('summary'),
            'content' => $this->request->getPost('content'),
            'image' => $post['image'],
            'category_id' => $this->request->getPost('category_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/posts')->with('success','Post actualizado');
    }

    public function delete($id = null){
        $post = $this->postModel->find($id);
        if ($post && $post['image']){
            $file = FCPATH . ltrim($post['image'],'/');
            if (is_file($file)) @unlink($file);
        }
        $this->postModel->delete($id);
        return redirect()->to('/admin/posts')->with('success','Post eliminado');
    }
}
