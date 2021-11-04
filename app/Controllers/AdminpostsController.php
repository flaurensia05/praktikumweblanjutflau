<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminpostsController extends BaseController
{
	public function index()
	{
		$PostsModel = model("PostsModel");
		$data = [
			'posts' => $PostsModel->findAll()
		];
		return view("posts/index", $data);
	}

	public function create()
	{
		session();
		$data = [
			'validation' => \Config\Services::validation(),
		];
		return view("posts/create", $data);
	}

	public function store()
	{
		$valid = $this->validate([
			"judul" => [
				"label" => "Judul",
				"rules" => "required",
				"errors" => [
					"required" => "{field} Harus Diisi!"
				]
			],
			"slug" => [
				"label" => "Slug",
				"rules" => "required|is_unique[posts.slug]",
				"errors" => [
					"required" => "{field} Harus Diisi!",
					"is_unique" => "{filed} sudah ada!"
				]
			],
			"kategori" => [
				"label" => "Kategori",
				"rules" => "required",
				"errors" => [
					"{field} Harus Diisi!"
				]
			],
			"author" => [
				"label" => "Author",
				"rules" => "required",
				"errors" => [
					"{field} Harus Diisi!"
				]
			],
			"deskripsi" => [
				"label" => "Deskripsi",
				"rules" => "required",
				"errors" => [
					"{field} Harus Diisi!"
				]
			]
		]);

		if ($valid) {
			$data = [
				'judul' => $this->request->getVar('judul'),
				'slug' => $this->request->getVar('slug'),
				'kategori' => $this->request->getVar('kategori'),
				'author' => $this->request->getVar('author'),
				'deskripsi' => $this->request->getVar('deskripsi'),
			];

			$PostsModel = model("PostsModel");
			$PostsModel->insert($data);
			return redirect()->to(base_url('/admin/posts/'));
		} else {
			return redirect()->to(base_url('/admin/posts/create'))->withInput()->with('validation', $this->validator);
		}
	}

	public function delete($slug)
	{
		$PostsModel = model("PostsModel");
		$PostsModel->where('slug', $slug)->delete();
		return redirect()->to(base_url('/admin/posts/'));
	}

	public function edit($slug)
	{
		session();
		$PostsModel = model("PostsModel");
		$data = [
			'validation' => \Config\Services::validation(),
			'post' => $PostsModel->where('slug', $slug)->first()
		];
		return view("posts/edit", $data);
	}


	public function update($slug)
	{
		$PostsModel = model("PostsModel");
		$data = $this->request->getPost();
		$PostsModel->update($slug, $data);
		return redirect()->to(base_url('/admin/posts/'));
	}
}
