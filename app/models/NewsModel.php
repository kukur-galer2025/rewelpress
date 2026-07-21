<?php

class NewsModel {
    private $table = 'news';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllNews()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getLatestNews($limit = 3)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getNewsById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getNewsBySlug($slug)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE slug = :slug');
        $this->db->bind(':slug', $slug);
        return $this->db->single();
    }

    public function addNews($data)
    {
        $query = "INSERT INTO " . $this->table . " (title, slug, content, image) 
                  VALUES (:title, :slug, :content, :image)";
        
        $this->db->query($query);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':image', $data['image']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateNews($data)
    {
        if (isset($data['image']) && !empty($data['image'])) {
            $query = "UPDATE " . $this->table . " SET 
                        title = :title, 
                        slug = :slug, 
                        content = :content, 
                        image = :image
                      WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(':image', $data['image']);
        } else {
            $query = "UPDATE " . $this->table . " SET 
                        title = :title, 
                        slug = :slug, 
                        content = :content
                      WHERE id = :id";
            $this->db->query($query);
        }
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $data['slug']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteNews($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
