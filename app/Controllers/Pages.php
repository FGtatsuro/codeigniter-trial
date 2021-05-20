<?php

namespace App\Controllers;

class Pages extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function view($page = 'home')
	{
		if (!is_file(APPPATH . '/Views/pages/' . $page.'.php')) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}

		$data['title'] = ucfirst($page);

		echo view('templates/header', $data);
		echo view('pages/' . $page);
		echo view('templates/footer');
	}
}
