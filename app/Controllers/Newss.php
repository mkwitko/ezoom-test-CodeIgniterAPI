<?php

namespace App\Controllers;

use App\Models\News;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
header('Access-Control-Allow-Origin: *');

class Newss extends ResourceController
{
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $model = new News();
        $data = $model->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new News();
        $data = $model->find($id);
        if(empty($data))
        {
            return $this->failNotFound('Item não encontrado');
        } 
        else 
        {
            return $this->respond($data);
        }

    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = [
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'link' => 'required',
            'image' => 'required',
            'creatorId' => 'required'       
        ];

        if(!$this->validate($rules))
        {
            return $this->fail($this->validator->getErrors());
        } 
        else 
        {
            $data = [
                'title' => $this->request->getVar('title'),
                'subtitle' => $this->request->getVar('subtitle'),
                'description' => $this->request->getVar('description'),
                'link' => $this->request->getVar('link'),
                'image' => $this->request->getVar('image'),
                'creatorId' => $this->request->getVar('creatorId')
            ];

            $model = new News();
            $model->save($data);
            return $this->respondCreated($data);
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $rules = [
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'link' => 'required',
            'creatorId' => 'required'       
        ];

        if(!$this->validate($rules))
        {
            return $this->fail($this->validator->getErrors());
        } 
        else 
        {
            $model = new News();
            $userFound = $model->find($id);

            if(empty($userFound))
            {
                return $this->failNotFound('Item não encontrado');
            } 
            else 
            {
                $data = [
                    'title' => $this->request->getVar('title'),
                    'subtitle' => $this->request->getVar('subtitle'),
                    'description' => $this->request->getVar('description'),
                    'link' => $this->request->getVar('link'),
                    'image' => $this->request->getVar('image'),
                    'creatorId' => $this->request->getVar('creatorId')
                ];

                $model->update($id, $data);
                return $this->respondCreated($data);
            }
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new News();
        $userFound = $model->find($id);

        if(empty($userFound))
        {
            return $this->failNotFound('Item não encontrado');
        } 
        else 
        {
            $model->delete($id);
        }
    }
}
