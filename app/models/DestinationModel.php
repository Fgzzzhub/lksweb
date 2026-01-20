<?php

class DestinationModel extends BaseModel
{
    public function featured($limit = 6)
    {
        $stmt = $this->pdo->prepare('SELECT d.*, c.name AS category_name, c.slug AS category_slug FROM destinations d JOIN categories c ON c.id = d.category_id WHERE d.is_featured = 1 ORDER BY d.created_at DESC LIMIT ?');
        $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function latest($limit = 6)
    {
        $stmt = $this->pdo->prepare('SELECT d.*, c.name AS category_name, c.slug AS category_slug FROM destinations d JOIN categories c ON c.id = d.category_id ORDER BY d.created_at DESC LIMIT ?');
        $stmt->bindValue(1, (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function search(array $filters, $limit, $offset)
    {
        $q = trim($filters['q'] ?? '');
        $categoryId = (int) ($filters['category_id'] ?? 0);
        $location = trim($filters['location'] ?? '');
        $tag = trim($filters['tag'] ?? '');
        $sort = $filters['sort'] ?? 'created_at';
        $order = strtolower($filters['order'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';

        $sortMap = [
            'created_at' => 'd.created_at',
            'name' => 'd.name',
            'views' => 'd.views',
        ];
        $orderBy = $sortMap[$sort] ?? 'd.created_at';

        $where = [];
        $params = [];

        if ($q !== '') {
            $where[] = '(d.name LIKE :q1 OR d.slug LIKE :q2 OR d.short_desc LIKE :q3)';
            $params[':q1'] = '%' . $q . '%';
            $params[':q2'] = '%' . $q . '%';
            $params[':q3'] = '%' . $q . '%';
        }

        if ($categoryId > 0) {
            $where[] = 'd.category_id = :category_id';
            $params[':category_id'] = $categoryId;
        }

        if ($location !== '') {
            $where[] = 'd.location = :location';
            $params[':location'] = $location;
        }

        if ($tag !== '') {
            $where[] = '(d.short_desc LIKE :tag1 OR d.content LIKE :tag2)';
            $params[':tag1'] = '%' . $tag . '%';
            $params[':tag2'] = '%' . $tag . '%';
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $totalStmt = $this->pdo->prepare('SELECT COUNT(*) FROM destinations d ' . $whereSql);
        foreach ($params as $key => $value) {
            $totalStmt->bindValue($key, $value);
        }
        $totalStmt->execute();
        $total = (int) $totalStmt->fetchColumn();

        $query = 'SELECT d.*, c.name AS category_name, c.slug AS category_slug FROM destinations d JOIN categories c ON c.id = d.category_id ' . $whereSql . ' ORDER BY ' . $orderBy . ' ' . $order . ' LIMIT :limit OFFSET :offset';
        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();

        return [
            'total' => $total,
            'items' => $items,
        ];
    }

    public function getLocations()
    {
        $stmt = $this->pdo->query("SELECT DISTINCT location FROM destinations WHERE location <> '' ORDER BY location");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findBySlug($slug)
    {
        $stmt = $this->pdo->prepare('SELECT d.*, c.name AS category_name, c.slug AS category_slug FROM destinations d JOIN categories c ON c.id = d.category_id WHERE d.slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function incrementViews($id)
    {
        $stmt = $this->pdo->prepare('UPDATE destinations SET views = views + 1 WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function related($categoryId, $excludeId, $limit = 3)
    {
        $stmt = $this->pdo->prepare('SELECT d.*, c.name AS category_name FROM destinations d JOIN categories c ON c.id = d.category_id WHERE d.category_id = ? AND d.id <> ? ORDER BY d.created_at DESC LIMIT ?');
        $stmt->bindValue(1, (int) $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, (int) $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(3, (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listByCategory($categoryId, $q, $sort, $order)
    {
        $orderBy = $sort === 'name' ? 'd.name' : 'd.created_at';
        $orderDir = $sort === 'name' ? 'ASC' : 'DESC';
        if (strtolower($order) === 'asc') {
            $orderDir = 'ASC';
        }
        if (strtolower($order) === 'desc') {
            $orderDir = 'DESC';
        }

        $params = [':category_id' => $categoryId];
        $where = 'WHERE d.category_id = :category_id';

        if ($q !== '') {
            $where .= ' AND (d.name LIKE :q1 OR d.short_desc LIKE :q2)';
            $params[':q1'] = '%' . $q . '%';
            $params[':q2'] = '%' . $q . '%';
        }

        $stmt = $this->pdo->prepare('SELECT d.* FROM destinations d ' . $where . ' ORDER BY ' . $orderBy . ' ' . $orderDir);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listAdmin($q = '')
    {
        $where = '';
        $params = [];
        if ($q !== '') {
            $where = 'WHERE d.name LIKE :q1 OR d.slug LIKE :q2';
            $params[':q1'] = '%' . $q . '%';
            $params[':q2'] = '%' . $q . '%';
        }

        $stmt = $this->pdo->prepare('SELECT d.*, c.name AS category_name FROM destinations d JOIN categories c ON c.id = d.category_id ' . $where . ' ORDER BY d.created_at DESC');
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM destinations WHERE id = ?');
        $stmt->execute([(int) $id]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO destinations (category_id, name, slug, location, short_desc, content, thumbnail, is_featured, views, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW())');
        $stmt->execute([
            (int) $data['category_id'],
            $data['name'],
            $data['slug'],
            $data['location'],
            $data['short_desc'],
            $data['content'],
            $data['thumbnail'],
            (int) $data['is_featured'],
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update($id, array $data)
    {
        $stmt = $this->pdo->prepare('UPDATE destinations SET category_id = ?, name = ?, slug = ?, location = ?, short_desc = ?, content = ?, thumbnail = ?, is_featured = ? WHERE id = ?');
        $stmt->execute([
            (int) $data['category_id'],
            $data['name'],
            $data['slug'],
            $data['location'],
            $data['short_desc'],
            $data['content'],
            $data['thumbnail'],
            (int) $data['is_featured'],
            (int) $id,
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM destinations WHERE id = ?');
        $stmt->execute([(int) $id]);
    }

    public function getGallery($destinationId, $direction = 'ASC')
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $stmt = $this->pdo->prepare('SELECT file_name FROM destination_images WHERE destination_id = ? ORDER BY id ' . $direction);
        $stmt->execute([(int) $destinationId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function addGallery($destinationId, array $files)
    {
        $stmt = $this->pdo->prepare('INSERT INTO destination_images (destination_id, file_name, created_at) VALUES (?, ?, NOW())');
        foreach ($files as $fileName) {
            $stmt->execute([(int) $destinationId, $fileName]);
        }
    }

    public function deleteGallery($destinationId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM destination_images WHERE destination_id = ?');
        $stmt->execute([(int) $destinationId]);
    }

    public function slugExists($slug, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM destinations WHERE slug = ? AND id <> ?');
            $stmt->execute([$slug, (int) $excludeId]);
        } else {
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM destinations WHERE slug = ?');
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
