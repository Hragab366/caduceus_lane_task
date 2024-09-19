<?php

namespace App\Filters;

class BooksFilter extends Filter
{
    public array $filters=['author','title','description'];
    public array $verified_methods=['author','title','description'];

    public function author()
    {
        $data =$this->validateInput([
            'author'=>'required|exists:users,id'
        ]);

        $this->query->where('user_id', $data['author']);
    }

    public function title()
    {
        $data =$this->validateInput([
            'title'=>'required'
        ]);

        $this->query->where('title', 'like', "%{$data['title']}%");

    }
    public function description()
    {
        $data =$this->validateInput([
            'description'=>'required'
        ]);

        $this->query->where('description', 'like', "%{$data['description']}%");

    }

}
