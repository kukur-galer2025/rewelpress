<?php

class CategoryModel {
    private $table = 'categories';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllCategories()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function getCategoriesWithBookCount()
    {
        $this->db->query('
            SELECT categories.id, categories.name, categories.slug, categories.parent_id, COUNT(books.id) as book_count
            FROM categories 
            LEFT JOIN books ON categories.id = books.category_id 
            GROUP BY categories.id 
            ORDER BY categories.name ASC
        ');
        return $this->db->resultSet();
    }

    public function getCategoryById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getCategoryByIdOrSlug($identifier)
    {
        if (is_numeric($identifier)) {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
            $this->db->bind(':id', $identifier);
        } else {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE slug = :slug');
            $this->db->bind(':slug', $identifier);
        }
        return $this->db->single();
    }

    public function addCategory($data)
    {
        $query = "INSERT INTO categories (name, slug, parent_id) VALUES (:name, :slug, :parent_id)";
        $this->db->query($query);
        $this->db->bind(':name', $data['name']);
        
        // Generate slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));
        $this->db->bind(':slug', $slug);
        
        $parent_id = !empty($data['parent_id']) ? $data['parent_id'] : null;
        $this->db->bind(':parent_id', $parent_id);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateCategory($data)
    {
        $query = "UPDATE categories SET name = :name, slug = :slug, parent_id = :parent_id WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':name', $data['name']);
        
        // Generate slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));
        $this->db->bind(':slug', $slug);
        
        $parent_id = !empty($data['parent_id']) ? $data['parent_id'] : null;
        $this->db->bind(':parent_id', $parent_id);
        $this->db->bind(':id', $data['id']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteCategory($id)
    {
        // Check if there are physical books using this category
        $this->db->query('SELECT count(*) as count FROM books WHERE category_id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        
        if($result['count'] > 0) {
            return -1; // Specific code for "has books"
        }

        // Check if there are ebooks using this category
        $this->db->query('SELECT count(*) as count FROM ebooks WHERE category_id = :id');
        $this->db->bind(':id', $id);
        $resultEbook = $this->db->single();

        if($resultEbook['count'] > 0) {
            return -1; 
        }

        // Check if it's a parent category that has child categories with books
        $this->db->query('SELECT count(*) as count FROM books JOIN categories ON books.category_id = categories.id WHERE categories.parent_id = :id');
        $this->db->bind(':id', $id);
        $childResult = $this->db->single();

        if($childResult['count'] > 0) {
            return -1;
        }

        // Check if it's a parent category that has child categories with ebooks
        $this->db->query('SELECT count(*) as count FROM ebooks JOIN categories ON ebooks.category_id = categories.id WHERE categories.parent_id = :id');
        $this->db->bind(':id', $id);
        $childResultEbook = $this->db->single();

        if($childResultEbook['count'] > 0) {
            return -1;
        }

        $this->db->query('DELETE FROM categories WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // Helper to build hierarchy
    public function getHierarchicalCategories()
    {
        $allCategories = $this->getAllCategories();
        $tree = [];
        $mapped = [];

        foreach ($allCategories as $cat) {
            $mapped[$cat['id']] = $cat;
            $mapped[$cat['id']]['children'] = [];
        }

        foreach ($mapped as $id => &$cat) {
            if ($cat['parent_id'] != null && isset($mapped[$cat['parent_id']])) {
                $mapped[$cat['parent_id']]['children'][] = &$cat;
            } else {
                $tree[] = &$cat;
            }
        }

        // Urutkan kategori utama sesuai standar Unsoed Press
        $customOrder = [
            'Sosial & Humaniora' => 1,
            'Sains & Teknologi' => 2,
            'Kesehatan & Kedokteran' => 3,
            'Agro & Fauna' => 4
        ];
        usort($tree, function($a, $b) use ($customOrder) {
            $orderA = isset($customOrder[$a['name']]) ? $customOrder[$a['name']] : 999;
            $orderB = isset($customOrder[$b['name']]) ? $customOrder[$b['name']] : 999;
            if ($orderA === $orderB) {
                return strcmp($a['name'], $b['name']);
            }
            return $orderA <=> $orderB;
        });

        // Urutkan sub-kategori secara alfabetis berdasarkan nama
        foreach ($tree as &$cat) {
            if (!empty($cat['children'])) {
                usort($cat['children'], function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
            }
        }

        return $tree;
    }
}
