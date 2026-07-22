<?php

class AuthorModel {
    private $table = 'authors';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllAuthors()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function getFeaturedAuthors($limit = 6)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY id ASC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getAuthorById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getAuthorByName($name)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE name = :name LIMIT 1');
        $this->db->bind(':name', $name);
        return $this->db->single();
    }

    public function addAuthor($data)
    {
        $query = "INSERT INTO authors (name, photo, affiliation, bio) VALUES (:name, :photo, :affiliation, :bio)";
        $this->db->query($query);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':photo', !empty($data['photo']) ? $data['photo'] : 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&h=400&q=80');
        $this->db->bind(':affiliation', !empty($data['affiliation']) ? $data['affiliation'] : '');
        $this->db->bind(':bio', !empty($data['bio']) ? $data['bio'] : '');

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateAuthor($data)
    {
        $query = "UPDATE authors SET name = :name, photo = :photo, affiliation = :affiliation, bio = :bio WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':photo', !empty($data['photo']) ? $data['photo'] : 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&h=400&q=80');
        $this->db->bind(':affiliation', !empty($data['affiliation']) ? $data['affiliation'] : '');
        $this->db->bind(':bio', !empty($data['bio']) ? $data['bio'] : '');
        $this->db->bind(':id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteAuthor($id)
    {
        $this->db->query('DELETE FROM authors WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function addAuthorIfNotExists($name)
    {
        $name = trim($name);
        if (empty($name)) return;
        
        $this->db->query('SELECT id FROM ' . $this->table . ' WHERE name = :name LIMIT 1');
        $this->db->bind(':name', $name);
        $existing = $this->db->single();
        
        if (!$existing) {
            $query = "INSERT INTO authors (name, photo, affiliation, bio) VALUES (:name, :photo, :affiliation, :bio)";
            $this->db->query($query);
            $this->db->bind(':name', $name);
            $this->db->bind(':photo', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&h=400&q=80');
            $this->db->bind(':affiliation', 'Penulis Eksternal');
            $this->db->bind(':bio', 'Biografi belum tersedia.');
            $this->db->execute();
        }
    }
}
