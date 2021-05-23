<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Controller;

class News extends Controller
{
	public function index()
	{
		$model = new NewsModel();

		$data['news'] = $model->getNews();
		$data['title'] = 'News archive';

		echo view('templates/header', $data);
		echo view('news/overview', $data);
		echo view('templates/footer');
	}

	public function view($slug)
	{
		$model = new NewsModel();

		$data['news'] = $model->getNews($slug);
		if (empty($data['news']))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Page Not Found: '.$slug);
		}
		$data['title'] = $data['news']['title'];

		echo view('templates/header', $data);
		echo view('news/view', $data);
		echo view('templates/footer');
	}

	public function create()
	{
		$model = new NewsModel();

		if ($this->request->getMethod() === 'post' && $this->validate([
			'title' => 'required|min_length[3]|max_length[255]',
			'body' => 'required',
		]))
		{
			$model->save([
				'title' => $this->request->getPost('title'),
				'slug' => url_title($this->request->getPost('title'), '-', TRUE),
				'body' => $this->request->getPost('body'),
			]);
			echo view('templates/header', ['title' => 'Successful creation']);
			echo view('news/success');
			echo view('templates/footer');
		}
		else
		{
			echo view('templates/header', ['title' => 'Create a new item']);
			echo view('news/create');
			echo view('templates/footer');
		}
	}
}
