<?php

require_once __DIR__ . '/../../core/database.php';

class EventModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->connect(); // PDO Connection
    }
    public function getAllEvents()
    {
        $stmt = $this->conn->query("SELECT * FROM events ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch single event by ID
    public function getEventById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert new event
    public function insertEvent($name, $link, $image)
    {
        $stmt = $this->conn->prepare("INSERT INTO events (event_name, event_link, event_image) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $link, $image]);
    }

    // Update event
    public function updateEvent($id, $name, $link, $image)
    {
        $stmt = $this->conn->prepare("UPDATE events SET event_name=?, event_link=?, event_image=? WHERE id=?");
        return $stmt->execute([$name, $link, $image, $id]);
    }

    // Delete event
    public function deleteEvent($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM events WHERE id=?");
        return $stmt->execute([$id]);
    }
}