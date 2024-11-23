<?php

require_once '../repository/ArticleRepository.php';

class ArticleService {
    private $articleRepo;

    public function __construct($database) {
        $this->articleRepo = new ArticleRepository($database);
    }

    public function handleRequest($body) {
        if (!isset($body['action'])) {
            throw new Exception('La acción es requerida.');
        }

        switch ($body['action']) {
            case 'list':
                return $this->listArticles();
            case 'view':
                return $this->viewArticle($body);
            case 'save':
                return $this->saveArticle($body);
            case 'delete':
                return $this->deleteArticle($body);
            default:
                throw new Exception('Acción no válida.');
        }
    }

    private function listArticles() {
        $articles = $this->articleRepo->getAllArticles();
        return [
            'success' => true,
            'data' => $articles,
        ];
    }

    private function viewArticle($body) {
        if (!isset($body['id']) || empty($body['id'])) {
            throw new Exception('El ID del artículo es obligatorio.');
        }

        $article = $this->articleRepo->getArticleById($body['id']);

        if ($article) {
            return [
                'success' => true,
                'data' => $article,
            ];
        } else {
            throw new Exception('No se encontró el artículo con el ID especificado.');
        }
    }

    private function saveArticle($body) {
        if (!isset($body['codigo'], $body['nombre'], $body['precio'], $body['stock'], $body['categoria'])) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        $data = [
            'id' => $body['id'] ?? null,
            'codigo' => $body['codigo'],
            'nombre' => $body['nombre'],
            'precio' => $body['precio'],
            'stock' => $body['stock'],
            'categoria' => $body['categoria']
        ];

        if (empty($data['id'])) {
            $result = $this->articleRepo->createArticle($data);
            if ($result) {
                return ['success' => 'Artículo creado correctamente.'];
            } else {
                throw new Exception('Error al crear el artículo.');
            }
        } else {
            $result = $this->articleRepo->updateArticle($data);
            if ($result) {
                return ['success' => 'Artículo actualizado correctamente.'];
            } else {
                throw new Exception('Error al actualizar el artículo.');
            }
        }
    }

    private function deleteArticle($body) {
        if (!isset($body['id']) || empty($body['id'])) {
            throw new Exception('El ID del artículo es obligatorio.');
        }

        $id = intval($body['id']);
        $result = $this->articleRepo->deleteArticleById($id);

        if ($result) {
            return ['success' => 'Artículo eliminado correctamente.'];
        } else {
            throw new Exception('No se pudo borrar el artículo. Verifica si el ID es válido.');
        }
    }
}
