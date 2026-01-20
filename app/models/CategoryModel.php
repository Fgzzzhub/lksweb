<?php

class CategoryModel extends BaseModel
{
    public function all($orderBy = 'id', $direction = 'ASC')
    {
        $orderBy = $orderBy === 'name' ? 'name' : 'id';
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $stmt = $this->pdo->query('SELECT id, name, slug FROM categories ORDER BY ' . $orderBy . ' ' . $direction);
        return $stmt->fetchAll();
    }

    public function findBySlug($slug)
    {
        $stmt = $this->pdo->prepare('SELECT id, name, slug FROM categories WHERE slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT id, name, slug FROM categories WHERE id = ?');
        $stmt->execute([(int) $id]);
        return $stmt->fetch();
    }

    public function create($name, $slug)
    {
        $stmt = $this->pdo->prepare('INSERT INTO categories (name, slug) VALUES (?, ?)');
        $stmt->execute([$name, $slug]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update($id, $name, $slug)
    {
        $stmt = $this->pdo->prepare('UPDATE categories SET name = ?, slug = ? WHERE id = ?');
        $stmt->execute([$name, $slug, (int) $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([(int) $id]);
    }

    public function isInUse($id)
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM destinations WHERE category_id = ?');
        $stmt->execute([(int) $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function slugExists($slug, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM categories WHERE slug = ? AND id <> ?');
            $stmt->execute([$slug, (int) $excludeId]);
        } else {
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM categories WHERE slug = ?');
            $stmt->execute([$slug]);
        }

        return (int) $stmt->fetchColumn() > 0;
    }

    public function makeUniqueSlug($baseSlug, $excludeId = null)
    {
        $slug = $baseSlug;
        $counter = 2;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
