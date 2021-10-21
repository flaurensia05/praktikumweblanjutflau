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
					"required" => "{field} Harus Diisi!",
				]
			],
			"slug" => [
				"label" => "Slug",
				"rules" => "required|is_unique[posts.slug]",
				"errors" => [
					"required" => "{field} Harus Diisi!",
					"is_unique" => "{field} Sudah ada!",
				]
			],
			"kategori" => [
				"label" => "Kategori",
				"rules" => "required",
				"errors" => [
					"required" => "{field} Harus Diisi!",
				]
			],
			"author" => [
				"label" => "Author",
				"rules" => "required",
				"errors" => [
					"required" => "{field} Harus Diisi!",
				]
			],
			"deskripsi" => [
				"label" => "Deskripsi",
				"rules" => "required",
				"errors" => [
					"required" => "{field} Harus Diisi!",
				]
			]
		]);
		// dd($valid);
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
			return redirect()->to(base_url('admin/posts/index'));
		} else {
			return redirect()->to(base_url('admin/posts/create'))->withInput()->with(
				'validation',
				$this->validator
			);
		}
	}
}
