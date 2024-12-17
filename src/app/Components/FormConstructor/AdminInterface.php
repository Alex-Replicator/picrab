<?php
namespace Picrab\Components\FormConstructor;

use Picrab\Components\Database\Database;

class AdminInterface
{
    private FormModel $model;

    public function __construct(Database $db)
    {
        $this->model = new FormModel($db);
    }

    public function getGroups(): array
    {
        return $this->model->getGroupsForPage(0,0);
    }

    public function createGroup(string $title): void
    {
        $db = $this->getDb();
        $db->execute("INSERT INTO hGtv_form_groups (title) VALUES (?)", [$title]);
    }

    public function deleteGroup(int $id): void
    {
        $db = $this->getDb();
        $db->execute("DELETE FROM hGtv_form_groups WHERE id = ?", [$id]);
    }

    public function createField(int $groupId, string $name, string $label, string $type, array $settings = []): void
    {
        $db = $this->getDb();
        $db->execute("INSERT INTO hGtv_form_fields (group_id, name, label, type, settings) VALUES (?,?,?,?,?)", [$groupId, $name, $label, $type, json_encode($settings)]);
    }

    public function deleteField(int $id): void
    {
        $db = $this->getDb();
        $db->execute("DELETE FROM hGtv_form_fields WHERE id = ?", [$id]);
    }

    public function attachGroupToPage(int $pageId, int $pageTypeId, int $groupId): void
    {
        $db = $this->getDb();
        $db->execute("INSERT INTO hGtv_form_page_relations (page_id, pagetype_id, group_id) VALUES (?,?,?)", [$pageId, $pageTypeId, $groupId]);
    }

    public function detachGroupFromPage(int $relationId): void
    {
        $db = $this->getDb();
        $db->execute("DELETE FROM hGtv_form_page_relations WHERE id = ?", [$relationId]);
    }

    private function getDb()
    {
        $class = new \ReflectionClass($this->model);
        $prop = $class->getProperty('db');
        $prop->setAccessible(true);
        return $prop->getValue($this->model);
    }
}