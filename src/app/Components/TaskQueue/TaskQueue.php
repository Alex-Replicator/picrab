<?php
namespace Picrab\Components\TaskQueue;

use Picrab\Components\Database\Database;

class TaskQueue {
    private Database $db;

    public function __construct($config = []) {
        $this->db = Database::getInstance($config);
    }

    public function addTask(string $type, array $payload = []) {
        $this->db->execute("INSERT INTO hGtv_worker_tasks (type, status, payload) VALUES (?, ?, ?)", [$type, 'pending', json_encode($payload)]);
    }

    public function getPendingTasks(): array {
        return $this->db->query("SELECT * FROM hGtv_worker_tasks WHERE status='pending' ORDER BY id ASC");
    }

    public function updateTaskStatus(int $id, string $status) {
        $this->db->execute("UPDATE hGtv_worker_tasks SET status=? WHERE id=?", [$status, $id]);
    }
}