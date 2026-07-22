<?php

class BookModel {
    private $table = 'books';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllBooks()
    {
        $this->db->query('
            SELECT books.*, 
                   categories.name as category_name, 
                   parent.name as parent_category_name 
            FROM books 
            JOIN categories ON books.category_id = categories.id 
            LEFT JOIN categories parent ON categories.parent_id = parent.id 
            ORDER BY books.created_at DESC
        ');
        return $this->db->resultSet();
    }
    
    public function getLatestBooks($limit = 4)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id ORDER BY books.created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getPopularBooks($limit = 4)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id ORDER BY books.views DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getPromoBooks()
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id WHERE books.old_price > books.price ORDER BY (books.old_price - books.price) DESC, books.created_at DESC');
        return $this->db->resultSet();
    }

    public function getBookById($id)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id WHERE books.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getBestSellerBooks($limit = 4)
    {
        $this->db->query('
            SELECT books.*, categories.name as category_name, parent.name as parent_category_name, COALESCE(SUM(order_items.quantity), 0) as total_sold
            FROM ' . $this->table . '
            JOIN categories ON books.category_id = categories.id
            LEFT JOIN categories parent ON categories.parent_id = parent.id
            LEFT JOIN order_items ON books.id = order_items.book_id
            GROUP BY books.id
            ORDER BY total_sold DESC, books.views DESC, books.created_at DESC
            LIMIT :limit
        ');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getDistinctAuthors($limit = 6)
    {
        $this->db->query('
            SELECT DISTINCT author
            FROM ' . $this->table . '
            WHERE author IS NOT NULL AND author != ""
            LIMIT :limit
        ');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function searchBooks($keyword)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id WHERE title LIKE :keyword OR author LIKE :keyword ORDER BY created_at DESC');
        $this->db->bind(':keyword', "%$keyword%");
        return $this->db->resultSet();
    }

    public function getBooksByAuthorName($author_name)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id WHERE books.author LIKE :author_name ORDER BY books.created_at DESC');
        $this->db->bind(':author_name', "%$author_name%");
        return $this->db->resultSet();
    }

    public function getBooksByCategory($category_id)
    {
        $this->db->query('SELECT books.*, categories.name as category_name, parent.name as parent_category_name FROM ' . $this->table . ' JOIN categories ON books.category_id = categories.id LEFT JOIN categories parent ON categories.parent_id = parent.id WHERE category_id = :category_id OR categories.parent_id = :category_id ORDER BY books.created_at DESC');
        $this->db->bind(':category_id', $category_id);
        return $this->db->resultSet();
    }

    public function addBook($data)
    {
        $query = "INSERT INTO books (title, author, category_id, isbn, price, old_price, image, synopsis, pages, weight, publication_year) 
                  VALUES (:title, :author, :category_id, :isbn, :price, :old_price, :image, :synopsis, :pages, :weight, :publication_year)";
        
        $this->db->query($query);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':isbn', !empty($data['isbn']) ? $data['isbn'] : null);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':old_price', !empty($data['old_price']) ? $data['old_price'] : 0);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':synopsis', !empty($data['synopsis']) ? $data['synopsis'] : null);
        $this->db->bind(':pages', !empty($data['pages']) ? $data['pages'] : null);
        $this->db->bind(':weight', !empty($data['weight']) ? $data['weight'] : null);
        $this->db->bind(':publication_year', !empty($data['publication_year']) ? $data['publication_year'] : null);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateBook($data)
    {
        $query = "UPDATE books SET 
                    title = :title, 
                    author = :author, 
                    category_id = :category_id, 
                    isbn = :isbn, 
                    price = :price, 
                    old_price = :old_price, 
                    image = :image,
                    synopsis = :synopsis,
                    pages = :pages,
                    weight = :weight,
                    publication_year = :publication_year
                  WHERE id = :id";
        
        $this->db->query($query);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':isbn', !empty($data['isbn']) ? $data['isbn'] : null);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':old_price', !empty($data['old_price']) ? $data['old_price'] : 0);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':synopsis', !empty($data['synopsis']) ? $data['synopsis'] : null);
        $this->db->bind(':pages', !empty($data['pages']) ? $data['pages'] : null);
        $this->db->bind(':weight', !empty($data['weight']) ? $data['weight'] : null);
        $this->db->bind(':publication_year', !empty($data['publication_year']) ? $data['publication_year'] : null);
        $this->db->bind(':id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteBook($id)
    {
        $this->db->query('DELETE FROM books WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
